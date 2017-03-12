<?php
namespace StoreApp\Infrastructure\Product;

use Doctrine\ORM\EntityRepository;
use StoreApp\Domain\Product\Product;
use StoreApp\Domain\Product\ProductRepository as ProductRepositoryInterface;

/**
 * Class ProductRepository
 * @package StoreApp\Infrastructure\Product
 */
class ProductRepository extends EntityRepository implements ProductRepositoryInterface
{

    /**
     * @param string $name
     * @return Product
     */
    public function getProductByName(string $name): Product
    {
        return $this->findOneBy([
            'name' => $name
        ]);
    }

    /**
     * @return Product[]
     */
    public function getProducts(): array
    {
        return $this->findAll();
    }

    /**
     * @param Product $product
     * @throws \Doctrine\ORM\ORMInvalidArgumentException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function addProduct(Product $product): void
    {
        $this->getEntityManager()->persist($product);
        $this->getEntityManager()->flush($product);
    }

}