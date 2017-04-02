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
        //@todo zrobić to jakoś mądrzej
        return new Response(200, [] , file_get_contents(__DIR__ . '/../../../web/web-app/build/index.html'));
    }
}