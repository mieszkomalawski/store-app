<?php
/**
 * Created by PhpStorm.
 * User: mmalawski
 * Date: 05/02/2017
 * Time: 18:30
 */

use Symfony\Component\Routing\Loader\YamlFileLoader;

use Symfony\Component\HttpFoundation\Request;

require_once __DIR__ . "/../vendor/autoload.php";

$entityManager = \StoreApp\Infrastructure\EntityManagerFactory::getEntityManager();

//routing
$locator = new \Doctrine\Common\Persistence\Mapping\Driver\SymfonyFileLocator([__DIR__ . '/../config/routing']);

$requestContext = new \Symfony\Component\Routing\RequestContext();
$requestContext->fromRequest(Request::createFromGlobals());

$router = new \Symfony\Component\Routing\Router(
    new YamlFileLoader($locator),
    'routes.yml',
    ['cache_dir' => __DIR__.'/../cache'],
    $requestContext
);
var_dump($requestContext->getPathInfo());die();
$match = $router->match($requestContext->getPathInfo());
