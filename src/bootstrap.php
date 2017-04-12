<?php
/**
 * Created by PhpStorm.
 * User: mmalawski
 * Date: 05/02/2017
 * Time: 18:30
 */

use Doctrine\ORM\EntityManager;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use StoreApp\Infrastructure\HttpMiddleware\RoutingMiddleware;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Routing\Loader\YamlFileLoader;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Router;
use \Symfony\Component\DependencyInjection\Loader\YamlFileLoader as DIYamlLoader;

use Neomerx\Cors\Strategies\Settings;
use Neomerx\Cors\Analyzer;

require_once __DIR__ . "/../vendor/autoload.php";

//services

$container = new ContainerBuilder();
$loader = new DIYamlLoader($container, new FileLocator(__DIR__ . '/../config/di'));
$loader->load('services.yml');

/** @var EntityManager $entityManager */
$entityManager = $container->get('entity_manager');
//routing
$locator = new FileLocator([__DIR__ . '/../config/routing']);

$request = Request::createFromGlobals();

$requestContext = new RequestContext();
$requestContext->fromRequest($request);

$router = new Router(
    new YamlFileLoader($locator), 'routes.yml', ['cache_dir' => __DIR__ . '/../cache'], $requestContext
);

$psr7Factory = new \Symfony\Bridge\PsrHttpMessage\Factory\DiactorosFactory();
$psrRequest = $psr7Factory->createRequest($request);

$settings = new Settings();
$settings->setServerOrigin(
    [
        'scheme' => 'http',
        'host' => 'localhost',
        'port' => '8080'
    ]
);
$settings->setRequestAllowedOrigins(
    [
        'http://localhost:8083' => '*'
    ]
);
$settings->setRequestAllowedMethods(['GET', 'POST', 'OPTIONS', 'DELETE', 'PUT']);
$settings->setPreFlightCacheMaxAge(3600);

$analyzer = Analyzer::instance($settings);

//Create the logger
$logger = new Logger('access');
$logger->pushHandler(new StreamHandler(fopen('./../var/logs/access-log.txt', 'r+')));

$loggerRouting = new Logger('routing');
$loggerRouting->pushHandler(new StreamHandler(fopen('./../var/logs/routing-log.txt', 'r+')));

$dispatcher = new \StoreApp\Infrastructure\MiddlewareDispatcher(
    [
        new Middlewares\AccessLog($logger),
        new Middlewares\Cors($analyzer),
        new Middlewares\ContentType(),
        new Middlewares\JsonPayload(),
        new RoutingMiddleware($router, $container, $loggerRouting)
    ]
);

$response = $dispatcher->process($psrRequest);

$httpFoundationFactory = new HttpFoundationFactory();
$symfonyResponse = $httpFoundationFactory->createResponse($response);

$symfonyResponse->send();
