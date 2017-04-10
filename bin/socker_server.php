<?php
/**
 * Created by PhpStorm.
 * User: mmalawski
 * Date: 09/04/2017
 * Time: 11:39
 */

require dirname(__DIR__) . '/vendor/autoload.php';

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

//services

$container = new ContainerBuilder();
$loader = new DIYamlLoader($container, new FileLocator(__DIR__ . '/../config/di'));
$loader->load('services.yml');

/** @var EntityManager $entityManager */
$entityManager = $container->get('entity_manager');
//routing
$locator = new FileLocator([__DIR__ . '/../config/routing']);

$requestContext = new RequestContext();
$request = Request::createFromGlobals();
$requestContext->fromRequest($request);

$router = new Router(
    new YamlFileLoader($locator),
    'routes.yml',
    ['cache_dir' => __DIR__.'/../cache']
);

$server1 = new StoreApp\Application\Socket\Server(
    $router, $container
);
echo 'starting server...';
$server = \Ratchet\Server\IoServer::factory(
    $server1,
    8084
);

echo 'server started';
$server->run();
