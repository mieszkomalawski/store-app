<?php
namespace StoreApp\UseCase\UpdateProduct;

use StoreApp\Domain\Product\ProductRepository;

/**
 * Class UpdateProduct
 * @package StoreApp\UseCase\UpdateProduct
 */
class UpdateProduct
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
     * @param CreateProductRequest $updateProductRequest
     * @return CreateProductResponse
     */
    public function execute(UpdateProductRequest $updateProductRequest): UpdateProductResponse
    {
        $product = $this->productRepository->getProductById($updateProductRequest->getId());
        if (null !== $updateProductRequest->getName()) {
            $product->changeName($updateProductRequest->getName());
        }
        if (null !== $updateProductRequest->getPrice()) {
            $product->changePrice($updateProductRequest->getPrice());
        }

        $this->productRepository->persist();
        $product = $this->productRepository->getProductById($updateProductRequest->getId());

        return new UpdateProductResponse($product->getId(), $product->getName(), $product->getPrice());
    }
}