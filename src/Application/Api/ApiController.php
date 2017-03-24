<?php
namespace StoreApp\Application\Api;

use GuzzleHttp\Psr7\Response as Psr7Response;
use League\Fractal\Manager;
use League\Fractal\TransformerAbstract;

/**
 * Class ApiController
 * @package StoreApp\Application\Api
 */
class ApiController
{
    /**
     * @var TransformerAbstract
     */
    protected $transformer;

    /**
     * ProductController constructor.
     * @param TransformerAbstract $tranformer
     */
    public function __construct(TransformerAbstract  $tranformer)
    {
        $this->transformer = $tranformer;
    }

    /**
     * @param $resource
     * @param int $code
     * @return Psr7Response
     */
    protected function createResponse($resource, int $code): Psr7Response
    {
        $data = (new Manager())->createData($resource)->toJson();

        return new Psr7Response($code, [], $data);
    }
}