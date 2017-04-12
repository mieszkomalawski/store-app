<?php
namespace StoreApp\Infrastructure\HttpMiddleware;

use GuzzleHttp\Psr7\Response;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Router;

/**
 * Class RoutingMiddleware
 * @package StoreApp\Infrastructure\HttpMiddleware
 */
class RoutingMiddleware implements MiddlewareInterface
{
    /**
     * @var Router
     */
    private $router;

    /**
     * @var Container
     */
    private $container;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * RoutingMiddleware constructor.
     * @param Router $router
     * @param Container $container
     * @param LoggerInterface $logger
     */
    public function __construct(Router $router, Container $container, LoggerInterface $logger)
    {
        $this->router = $router;
        $this->container = $container;
        $this->logger = $logger;
    }


    /**
     * @param ServerRequestInterface $request
     * @param DelegateInterface $delegate
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate) : ResponseInterface
    {
        $this->logger->debug('Matching request: ' . $request->getUri()->getPath());

        $match = $this->router->match($request->getUri()->getPath());

        $this->logger->debug('Matched', $match);

        $controller = $this->container->get($match['service']);

        $method = $match['method'];

        return $controller->$method($request);
    }

}