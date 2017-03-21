<?php
namespace StoreApp\Application\Api;

use StoreApp\UseCase\CreateProduct\CreateProduct;
use StoreApp\UseCase\CreateProduct\CreateProductRequest;

/**
 * Class ProductController
 * @package StoreApp\Application\Api
 */
class ProductController
{
    /**
     * @var CreateProduct
     */
    private $createProduct;


    /**
     * ProductController constructor.
     * @param CreateProduct $createProduct
     */
    public function __construct(CreateProduct $createProduct)
    {
        $this->createProduct = $createProduct;
    }


    public function createProduct()
    {
        $createProductRequest = new CreateProductRequest('name', 10);

        $createProductResponse = $this->createProduct->execute($createProductRequest);

        return 'dupa';
    }
}