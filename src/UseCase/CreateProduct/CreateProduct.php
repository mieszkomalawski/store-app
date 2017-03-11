<?php
namespace StoreApp\UseCase\CreateProduct;

use StoreApp\Domain\Product\Product;
use StoreApp\Domain\Product\ProductRepository;

/**
 * Class CreateProduct
 * @package StoreApp\UseCase\CreateProduct
 */
class CreateProduct
{
    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * CreateProduct constructor.
     * @param ProductRepository $productRepository
     */
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @param CreateProductRequest $createProductRequest
     * @return CreateProductResponse
     */
    public function execute(CreateProductRequest $createProductRequest): CreateProductResponse
    {
        $product = new Product($createProductRequest->getName(), $createProductRequest->getPrice());
        $this->productRepository->addProduct($product);

        return new CreateProductResponse($product->getId(), $product->getName(), $product->getPrice());
    }
}