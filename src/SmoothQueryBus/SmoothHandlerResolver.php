<?php

namespace SmoothCodes\SmoothQueryBus;

use Psr\Container\ContainerInterface;
use SmoothCodes\SmoothQueryBus\Exception\ServiceNotFoundException;

/**
 * Class SmoothHandlerResolver
 * @package SmoothCodes\SmoothQueryBus
 */
class SmoothHandlerResolver implements HandlerResolverInterface {

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var HandlerResolvingStrategy
     */
    protected $handlerResolvingStrategy;

    /**
     * SmoothHandlerResolver constructor.
     * @param ContainerInterface $container
     * @param HandlerResolvingStrategy $handlerResolvingStrategy
     */
    public function __construct(ContainerInterface $container, HandlerResolvingStrategy $handlerResolvingStrategy = null)
    {
        $this->container = $container;
        $this->handlerResolvingStrategy = !empty($handlerResolvingStrategy)
            ? $handlerResolvingStrategy
            : new class implements HandlerResolvingStrategy {
                public function getHandlerClassName(QueryInterface $query)
                {
                    return preg_replace('#Query\\\\#', 'Handler\\', get_class($query)) . 'Handler';
                }
            };
    }

    /**
     * @param QueryInterface $query
     * @return mixed
     * @throws \ReflectionException
     * @throws \Exception
     */
    public function resolve(QueryInterface $query)
    {
        $handlerClass = $this->getHandlerClassName($query);
        $reflection = new \ReflectionClass($handlerClass);

        $handlerParams = [];
        foreach ($reflection->getConstructor()->getParameters() as $parameter) {
            if (!$this->getContainer()->has($parameter->getClass()->getName())) {
                throw new ServiceNotFoundException($parameter->getClass()->getName());
            }
            $handlerParams[] = $this->getContainer()->get($parameter->getClass()->getName());
        }

        /** @var QueryHandlerInterface $handler */
        $handler = $reflection->newInstance(...$handlerParams);

        return $handler->{$this->getMethodName()}($query);
    }

    /**
     * @return mixed|string
     */
    public function getMethodName()
    {
        return '__invoke';
    }

    /**
     * @param QueryInterface $query
     * @return mixed|string
     */
    public function getHandlerClassName(QueryInterface $query)
    {
        return $this->handlerResolvingStrategy->getHandlerClassName($query);
    }

    /**
     * @return ContainerInterface
     */
    public function getContainer()
    {
        return $this->container;
    }
}
