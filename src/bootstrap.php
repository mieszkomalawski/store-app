<?php
/**
 * Created by PhpStorm.
 * User: mmalawski
 * Date: 05/02/2017
 * Time: 18:30
 */

use StoreApp\Infrastructure\EntityManagerFactory;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\YamlFileLoader;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Router;

require_once __DIR__ . "/../vendor/autoload.php";

$entityManager = EntityManagerFactory::getEntityManager();

//routing
$locator = new FileLocator([__DIR__ . '/../config/routing']);

$requestContext = new RequestContext();
$requestContext->fromRequest(Request::createFromGlobals());

$router = new Router(
    new YamlFileLoader($locator),
    'routes.yml',
    ['cache_dir' => __DIR__.'/../cache'],
    $requestContext
);
$match = $router->match($requestContext->getPathInfo());
var_dump($match);die();
