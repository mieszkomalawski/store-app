<?php
namespace StoreApp\Infrastructure\Product\Presentation;

use League\Fractal\TransformerAbstract;
use StoreApp\UseCase\CreateProduct\CreateProductResponse;

/**
 * Class CreateProductTransformer
 * @package StoreApp\Infrastructure\Product\Presentation
 */
class CreateProductTransformer extends TransformerAbstract
{
    /**
     * @param CreateProductResponse $createProductResponse
     * @return array
     */
    public function transform(CreateProductResponse $createProductResponse) : array
    {
        return [
            'id' => $createProductResponse->getId(),
            'name' => $createProductResponse->getName(),
            'price' => $createProductResponse->getPrice()
        ];
    }
}