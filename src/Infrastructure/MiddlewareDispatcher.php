<?php
namespace StoreApp\Infrastructure;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class MiddlewareDispatcher
 * @package StoreApp\Infrastructure
 */
class MiddlewareDispatcher implements DelegateInterface
{
    /**
     * @var MiddlewareInterface[]
     */
    private $middlewares;

    /**
     * @var int
     */
    private $currentMiddleware = 0;

    /**
     * MiddlewareDispatcher constructor.
     * @param MiddlewareInterface[] $middlewares
     */
    public function __construct(array $middlewares)
    {
        $this->middlewares = $middlewares;
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request)
    {
        $current = $this->currentMiddleware;
        $this->currentMiddleware++;
        return $this->middlewares[$current]->process($request, $this);
    }


}