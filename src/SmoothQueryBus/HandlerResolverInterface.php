<?php


namespace SmoothCodes\SmoothQueryBus;


use Psr\Container\ContainerInterface;

/**
 * Interface HandlerResolverInterface
 * @package SmoothCodes\SmoothQueryBus
 */
interface HandlerResolverInterface
{
    /**
     * @param QueryInterface $query
     * @return mixed
     */
    public function resolve(QueryInterface $query);

    /**
     * @return mixed
     */
    public function getMethodName();

    /**
     * @param QueryInterface $query
     * @return mixed
     */
    public function getHandlerClassName(QueryInterface $query);

    /**
     * @return ContainerInterface
     */
    public function getContainer();
}
