<?php
namespace StoreApp\Infrastructure;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

/**
 * Class EntityManagerFactory
 * @package StoreApp\Infrastructure
 */
class EntityManagerFactory
{
    const CONFIG_DIR = __DIR__ . "/../../config/db/doctrine";

    /**
     * @return EntityManager
     * @throws \Doctrine\ORM\ORMException
     * @throws \InvalidArgumentException
     */
    static public function getEntityManager(): EntityManager
    {
        // Create a simple "default" Doctrine ORM configuration for Annotations
        $isDevMode = true;
        // or if you prefer yaml or XML - scieżka musi być konkretnie do plików doktryny
        // jak podam do nadrzędnego katalogu to nie zadziałą
        $config = Setup::createYAMLMetadataConfiguration([self::CONFIG_DIR], $isDevMode);

        // database configuration parameters
        $conn = [
            'dbname' => 'local',
            'user' => 'dev',
            'password' => 'dev',
            // patrz config dockera

            'host' => 'db',
            'driver' => 'pdo_mysql',
        ];

        // obtaining the entity manager
        return EntityManager::create($conn, $config);
    }
}