<?php
namespace StoreApp\UseCase\SearchProduct;

/**
 * Class SearchProductResponse
 * @package StoreApp\UseCase\SearchProduct
 */
class SearchProductResponse
{
    /**
     * @var SingleSearchProductResponse[]
     */
    private $products;

    /**
     * SearchProductResponse constructor.
     * @param SingleSearchProductResponse[] $products
     */
    public function __construct(array $products)
    {
        $this->products = $products;
    }

    /**
     * @param SingleSearchProductResponse $singleSearchProductResponse
     */
    public function addProduct(SingleSearchProductResponse $singleSearchProductResponse)
    {
        $this->products[] = $singleSearchProductResponse;
    }

    /**
     * @return SingleSearchProductResponse[]
     */
    public function getProducts(): array
    {
        return $this->products;
    }


}