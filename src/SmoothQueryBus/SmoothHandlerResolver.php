<?php

namespace SmoothCodes\SmoothQueryBus;

use Psr\Container\ContainerInterface;

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
     * SmoothHandlerResolver constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param QueryInterface $query
     * @return mixed
     * @throws \ReflectionException
     */
    public function resolve(QueryInterface $query)
    {
        $handlerClass = $this->getHandlerClassName($query);
        $reflection = new \ReflectionClass($handlerClass);

        $handlerParams = [];
        foreach ($reflection->getConstructor()->getParameters() as $parameter) {
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
        return preg_replace('#Query\\\\#', 'Handler\\', get_class($query)) . 'Handler';
    }

    /**
     * @return ContainerInterface
     */
    public function getContainer()
    {
        return $this->container;
    }
}
