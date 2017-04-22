<?php
namespace StoreApp\Infrastructure\Product;

use \Doctrine\ORM\EntityManager;
use StoreApp\Domain\Product\Product;
use StoreApp\Domain\Product\ProductRepository;

/**
 * Class ProductRepositoryDB
 * @package StoreApp\Infrastructure\Product
 */
class ProductRepositoryDB implements ProductRepository
{
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $ormRepo;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * ProductRepositoryDB constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->ormRepo = $entityManager->getRepository('StoreApp\Domain\Product\Product');
    }

    /**
     * @param string $name
     * @return Product
     */
    public function getProductByName(string $name): Product
    {
        return $this->ormRepo->findOneBy([
            'name' => $name
        ]);
    }

    /**
     * @return Product[]
     */
    public function getProducts(): array
    {
        return $this->ormRepo->findAll();
    }

    /**
     * @param Product $product
     * @throws \Doctrine\ORM\ORMInvalidArgumentException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function addProduct(Product $product): void
    {
        $this->entityManager->persist($product);
        $this->entityManager->flush($product);
    }

    /**
     * @param int $id
     * @return Product
     */
    public function getProductById(int $id): Product
    {
        return $this->ormRepo->find($id);
    }

    /**
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function persist()
    {
        $this->entityManager->flush();
    }


}