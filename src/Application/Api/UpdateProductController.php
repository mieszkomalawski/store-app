<?php
namespace StoreApp\Application\Api;

use League\Fractal\Resource\Item;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use StoreApp\UseCase\CreateProduct\CreateProduct;
use StoreApp\UseCase\CreateProduct\CreateProductRequest;
use StoreApp\UseCase\UpdateProduct\UpdateProduct;
use StoreApp\UseCase\UpdateProduct\UpdateProductRequest;
use StoreApp\UseCase\UpdateProduct\UpdateProductResponse;

/**
 * Class UpdateProductController
 * @package StoreApp\Application\Api
 */
class UpdateProductController extends ApiController
{
    /**
     * @var UpdateProduct
     */
    private $updateProduct;

    /**
     * @param UpdateProduct $updateProduct
     */
    public function setUpdateProduct(UpdateProduct $updateProduct)
    {
        $this->updateProduct = $updateProduct;
    }

    /**
     * @param ServerRequestInterface $serverRequest
     * @return ResponseInterface
     */
    public function createProduct(ServerRequestInterface $serverRequest): ResponseInterface
    {
        $body = $serverRequest->getParsedBody();
        $serverRequest->getAttribute('id');
        $createProductRequest = new UpdateProductRequest($id, $body['name'], $body['price']);

        $createProductResponse = $this->updateProduct->execute($createProductRequest);

        $resource = new Item($createProductResponse, $this->transformer);

        return $this->createResponse($resource, 200);
    }

}