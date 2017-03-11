<?php
/**
 * Created by PhpStorm.
 * User: mmalawski
 * Date: 11/03/2017
 * Time: 12:05
 */

require __DIR__.'/../vendor/autoload.php';

use Symfony\Component\Console\Application;

$application = new Application();

$entityManager = \StoreApp\Infrastructure\EntityManagerFactory::getEntityManager();

$application->add(new \StoreApp\Application\CommandLine\CreateProductCommand($entityManager));

// ... register commands

$application->run();