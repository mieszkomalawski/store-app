<?php
namespace StoreApp\Infrastructure\Product\Presentation;

use League\Fractal\TransformerAbstract;
use StoreApp\UseCase\CreateProduct\CreateProductResponse;
use StoreApp\UseCase\SearchProduct\SearchProductResponse;
use StoreApp\UseCase\SearchProduct\SingleSearchProductResponse;

/**
 * Class CreateProductTransformer
 * @package StoreApp\Infrastructure\Product\Presentation
 */
class SearchProductTransformer extends TransformerAbstract
{
    /**
     * @param SingleSearchProductResponse $createProductResponse
     * @return array
     */
    public function transform(SingleSearchProductResponse $createProductResponse) : array
    {
        return [
            'id' => $createProductResponse->getId(),
            'name' => $createProductResponse->getName(),
            'price' => $createProductResponse->getPrice()
        ];
    }
}