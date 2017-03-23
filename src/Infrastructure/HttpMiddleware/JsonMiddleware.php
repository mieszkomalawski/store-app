<?php
namespace StoreApp\Infrastructure\HttpMiddleware;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class JsonMiddleware
 * @package StoreApp\Infrastructure\HttpMiddleware
 */
class JsonMiddleware implements MiddlewareInterface
{
    /**
     * @param ServerRequestInterface $request
     * @param DelegateInterface $delegate
     * @return ResponseInterface
     * @throws \InvalidArgumentException
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate) : ResponseInterface
    {
        $encodedJson = $request->getBody()->getContents();
        $request = $request->withParsedBody(json_decode($encodedJson, true));

        $response = $delegate->process($request);

        return $response->withHeader('Content-Type', 'application/json');
    }

}