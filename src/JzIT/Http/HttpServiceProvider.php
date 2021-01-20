<?php

declare(strict_types=1);

namespace JzIT\Http;

use Http\Factory\Diactoros\ResponseFactory;
use Di\Container;
use JzIT\Container\ServiceProvider\AbstractServiceProvider;
use League\Route\Router;
use League\Route\Strategy\JsonStrategy;
use League\Route\Strategy\StrategyInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Zend\Diactoros\ServerRequestFactory;
use Zend\HttpHandlerRunner\Emitter\SapiStreamEmitter;

class HttpServiceProvider extends AbstractServiceProvider
{
    /**
     * @param \Di\Container $container
     */
    public function register(Container $container): void
    {
        $this->registerRequest($container)
            ->registerRouter($container)
            ->registerEmitter($container);
    }

    /**
     * @param \Di\Container $container
     *
     * @return \JzIT\Http\HttpServiceProvider
     */
    protected function registerRequest(Container $container): HttpServiceProvider
    {
        $container->set(HttpConstants::SERVICE_NAME_REQUEST, function () {
            return ServerRequestFactory::fromGlobals();
        });

        return $this;
    }

    /**
     * @param \Di\Container $container
     *
     * @return \JzIT\Http\HttpServiceProvider
     */
    protected function registerRouter(Container $container): HttpServiceProvider
    {
        $self = $this;

        $container->set(HttpConstants::SERVICE_NAME_ROUTER, function () use ($self) {
            $router = new Router();

            $router->setStrategy($self->createStrategy());

            return $router;
        });

        return $this;
    }

    /**
     * @param \Di\Container $container
     *
     * @return \JzIT\Http\HttpServiceProvider
     */
    protected function registerEmitter(Container $container): HttpServiceProvider
    {
        $container->set(HttpConstants::SERVICE_NAME_EMITTER, function () {
            return new SapiStreamEmitter();
        });

        return $this;
    }

    /**
     * @return \League\Route\Strategy\StrategyInterface
     */
    protected function createStrategy(): StrategyInterface
    {
        return new JsonStrategy($this->createResponseFactory());
    }

    /**
     * @return \Psr\Http\Message\ResponseFactoryInterface
     */
    protected function createResponseFactory(): ResponseFactoryInterface
    {
        return new ResponseFactory();
    }
}
