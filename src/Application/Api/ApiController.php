<?php
namespace StoreApp\Application\Api;

use GuzzleHttp\Psr7\Response as Psr7Response;
use League\Fractal\Manager;

/**
 * Class ApiController
 * @package StoreApp\Application\Api
 */
class ApiController
{

    /**
     * @param $resource
     * @param int $code
     * @return Psr7Response
     */
    protected function getResponse($resource, int $code): Psr7Response
    {
        $data = (new Manager())->createData($resource)->toJson();

        return new Psr7Response($code, [], $data);
    }
}