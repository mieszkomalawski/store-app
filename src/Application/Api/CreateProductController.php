<?php
namespace StoreApp\Application\Api;

use League\Fractal\Resource\Item;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use StoreApp\UseCase\CreateProduct\CreateProduct;
use StoreApp\UseCase\CreateProduct\CreateProductRequest;

/**
 * Class ProductController
 * @package StoreApp\Application\Api
 */
class CreateProductController extends ApiController
{
    /**
     * @var CreateProduct
     */
    private $createProduct;

    /**
     * @param CreateProduct $createProduct
     */
    public function setCreateProduct(CreateProduct $createProduct)
    {
        $this->createProduct = $createProduct;
    }

    /**
     * @param ServerRequestInterface $serverRequest
     * @return ResponseInterface
     */
    public function createProduct(ServerRequestInterface $serverRequest): ResponseInterface
    {
        $body = $serverRequest->getParsedBody();
        $createProductRequest = new CreateProductRequest($body['name'], $body['price']);

        $createProductResponse = $this->createProduct->execute($createProductRequest);

        $resource = new Item($createProductResponse, $this->transformer);

        return $this->createResponse($resource, 200);
    }

}