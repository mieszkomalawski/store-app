<?php
/**
 * Created by PhpStorm.
 * User: mmalawski
 * Date: 05/02/2017
 * Time: 18:30
 */

use Doctrine\ORM\EntityManager;
use StoreApp\Infrastructure\Product\ProductRepositoryDB;
use StoreApp\UseCase\CreateProduct\CreateProduct;
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

$controller = $container->get($match['service']);

$method = $match['method'];
echo $controller->$method();
