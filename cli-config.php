<?php

require_once __DIR__ . "/vendor/autoload.php";

$entityManager = \StoreApp\Infrastructure\EntityManagerFactory::getEntityManager();

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);