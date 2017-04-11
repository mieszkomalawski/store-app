<?php
/**
 * Created by PhpStorm.
 * User: mmalawski
 * Date: 05/02/2017
 * Time: 18:30
 */

use Doctrine\ORM\EntityManager;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use StoreApp\Infrastructure\HttpMiddleware\HtmlMiddleware;
use StoreApp\Infrastructure\HttpMiddleware\JsonMiddleware;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Routing\Loader\YamlFileLoader;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Router;
use \Symfony\Component\DependencyInjection\Loader\YamlFileLoader as DIYamlLoader;

require_once __DIR__ . "/../vendor/autoload.php";

//services

$container = new ContainerBuilder();
$loader = new DIYamlLoader($container, new FileLocator(__DIR__ . '/../config/di'));
$loader->load('services.yml');

/** @var EntityManager $entityManager */
$entityManager = $container->get('entity_manager');

$controller = $container->get('create_product_repository_db');
//routing
$locator = new FileLocator([__DIR__ . '/../config/routing']);

$requestContext = new RequestContext();
$request = Request::createFromGlobals();
$requestContext->fromRequest($request);

$router = new Router(
    new YamlFileLoader($locator),
    'routes.yml',
    ['cache_dir' => __DIR__.'/../cache'],
    $requestContext
);
$match = $router->match($requestContext->getPathInfo());

$psr7Factory = new \Symfony\Bridge\PsrHttpMessage\Factory\DiactorosFactory();
$psrRequest = $psr7Factory->createRequest($request);

$controller = $container->get($match['service']);

$method = $match['method'];

$format = $match['format'];
$middleware = $format == 'json' ? new JsonMiddleware() : new HtmlMiddleware();
$controllerMiddleware = new class($controller, $method) implements \Interop\Http\ServerMiddleware\MiddlewareInterface
{

    private $controller;
    private $method;

    /**
     *  constructor.
     * @param $controller
     * @param $method
     */
    public function __construct($controller, $method)
    {
        $this->controller = $controller;
        $this->method = $method;
    }

    /**
     * @param ServerRequestInterface $request
     * @param DelegateInterface $delegate
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate): ResponseInterface
    {
        $method = $this->method;

        return $this->controller->$method($request);
    }
};

$dispatcher = new \StoreApp\Infrastructure\MiddlewareDispatcher([
    $middleware,
    $controllerMiddleware
                                                                ]);

$response = $dispatcher->process($psrRequest);

$httpFoundationFactory = new HttpFoundationFactory();
$symfonyResponse = $httpFoundationFactory->createResponse($response);

$symfonyResponse->send();
