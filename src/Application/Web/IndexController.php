<?php
namespace StoreApp\Application\Web;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

/**
 * Class IndexController
 * @package StoreApp\Application\Web
 */
class IndexController
{
    /**
     *
     */
    public function viewIndex() : ResponseInterface
    {
        return new Response(200, [] , file_get_contents(__DIR__ . '/../../../cra-test/build/index.html'));
    }
}