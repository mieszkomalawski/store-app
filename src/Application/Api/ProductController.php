<?php
namespace StoreApp\Application\Api;

use GuzzleHttp\Psr7\Response as Psr7Response;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use StoreApp\UseCase\CreateProduct\CreateProduct;
use StoreApp\UseCase\CreateProduct\CreateProductRequest;

/**
 * Class ProductController
 * @package StoreApp\Application\Api
 */
class ProductController extends ApiController
{
    /**
     * @var CreateProduct
     */
    private $createProduct;

    /**
     * @var TransformerAbstract
     */
    private $transformer;

    /**
     * ProductController constructor.
     * @param CreateProduct $createProduct
     * @param TransformerAbstract $tranformer
     */
    public function __construct(CreateProduct $createProduct, TransformerAbstract  $tranformer)
    {
        $this->createProduct = $createProduct;
        $this->transformer = $tranformer;
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

        return $this->getResponse($resource, 200);
    }

}