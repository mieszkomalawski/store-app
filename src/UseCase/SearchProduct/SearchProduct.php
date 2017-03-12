<?php
namespace StoreApp\UseCase\SearchProduct;

use StoreApp\Domain\Product\ProductRepository;

/**
 * Class SearchProduct
 * @package StoreApp\UseCase\SearchProduct
 */
class SearchProduct
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

    public function execute(SearchProductRequest $searchProductRequest) : SearchProductResponse
    {
        //@todo add search feature to repo
        $products = $this->productRepository->getProducts();
        $searchProductResponse = new SearchProductResponse([]);
        foreach($products as $product){
            $searchProductResponse->addProduct(new SingleSearchProductResponse(
                $product->getId(),
                $product->getName(),
                $product->getPrice()
                                               ));
        }
        return $searchProductResponse;
    }
}