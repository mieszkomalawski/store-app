<?php
namespace StoreApp\Application\Api;

use GuzzleHttp\Psr7\Response as Psr7Response;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use StoreApp\UseCase\CreateProduct\CreateProduct;
use StoreApp\UseCase\CreateProduct\CreateProductRequest;
use StoreApp\UseCase\CreateProduct\CreateProductResponse;
use StoreApp\UseCase\SearchProduct\SearchProductRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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

    /**
     * @param ServerRequestInterface $serverRequest
     * @return ResponseInterface
     */
    public function createProduct(ServerRequestInterface $serverRequest): ResponseInterface
    {
        $body = $serverRequest->getParsedBody();
        $createProductRequest = new CreateProductRequest($body['name'], $body['price']);

        $createProductResponse = $this->createProduct->execute($createProductRequest);

        $resource = new Item($createProductResponse, function (CreateProductResponse $createProductResponse) {
            return [
                'id' => $createProductResponse->getId(),
                'name' => $createProductResponse->getName(),
                'price' => $createProductResponse->getPrice()
            ];
        });

        $data = (new Manager())->createData($resource)->toJson();

        return new Psr7Response(200, [], json_encode($data));
    }
}