<?php
namespace StoreApp\Application\Socket;

use Guzzle\Http\Message\RequestInterface;
use Guzzle\Http\Message\Response;
use Interop\Container\ContainerInterface;
use Interop\Http\ServerMiddleware\DelegateInterface;
use MMal\HttpToPsr\MessageFactory;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Http\HttpServerInterface;
use Ratchet\MessageComponentInterface;
use StoreApp\Infrastructure\HttpMiddleware\HtmlMiddleware;
use StoreApp\Infrastructure\HttpMiddleware\JsonMiddleware;
use Symfony\Bridge\PsrHttpMessage\Factory\DiactorosFactory;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Router;

/**
 * Class Server
 * @package StoreApp\Application\Socket
 */
class Server implements HttpServerInterface
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
     * Server constructor.
     * @param Router $router
     * @param ContainerInterface $container
     */
    public function __construct(Router $router, Container $container)
    {
        $this->router = $router;
        $this->container = $container;
    }


    public function onOpen(ConnectionInterface $conn, RequestInterface $request = null)
    {
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $factory = new MessageFactory();
        echo 'creating request' . "\r\n";
        $request = $factory->requestFrom($msg);

        echo 'matching route' . "\r\n";
        $psr7Factory = new \Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory();
        $symfonyRequest = $psr7Factory->createRequest($request);
        $match = $this->router->matchRequest($symfonyRequest);

        echo 'fetching controller' . "\r\n";
        $controller = $this->container->get($match['service']);

        $method = $match['method'];

        $format = $match['format'];
        $middleware = $format == 'json' ? new JsonMiddleware() : new HtmlMiddleware();
        echo 'processing request' . "\r\n";
        $response = $middleware->process($request, new class($controller, $method) implements DelegateInterface {

            private $controller;
            private $method;

            /**
             *  constructor.
             * @param $controller
             * @param $method
             */
            public function __construct($controller, $method)
            {
                $this->controller = $controller;
                $this->method = $method;
            }

            /**
             * @param ServerRequestInterface $request
             * @return ResponseInterface
             */
            public function process(ServerRequestInterface $request) : ResponseInterface
            {
                $method = $this->method;
                return $this->controller->$method($request);
            }
        });

        echo 'emiiting response' . "\r\n";

        $from->send($factory->messageFrom($response));

        $from->close();
    }

    public function onClose(ConnectionInterface $conn) {
        $conn->close();
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        $conn->close();
    }
}