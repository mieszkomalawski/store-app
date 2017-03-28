<?php
namespace StoreApp\Application\Api;

use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use StoreApp\UseCase\CreateProduct\CreateProduct;
use StoreApp\UseCase\CreateProduct\CreateProductRequest;
use StoreApp\UseCase\SearchProduct\SearchProduct;
use StoreApp\UseCase\SearchProduct\SearchProductRequest;

/**
 * Class ProductController
 * @package StoreApp\Application\Api
 */
class SearchProductController extends ApiController
{
    /**
     * @var SearchProduct
     */
    private $searchProduct;

    /**
     * @param SearchProduct $searchProduct
     */
    public function setSearchProduct(SearchProduct $searchProduct)
    {
        $this->searchProduct = $searchProduct;
    }

    /**
     * @param ServerRequestInterface $serverRequest
     * @return ResponseInterface
     */
    public function searchProduct(ServerRequestInterface $serverRequest): ResponseInterface
    {
        $searchProductRequest = new SearchProductRequest();

        $searchProductResponse = $this->searchProduct->execute($searchProductRequest);
        $resource = new Collection($searchProductResponse->getProducts(), $this->transformer);
        return $this->createResponse($resource, 200);
    }

}