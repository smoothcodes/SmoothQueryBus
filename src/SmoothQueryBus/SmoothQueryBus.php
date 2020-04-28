<?php

namespace SmoothCodes\SmoothQueryBus;

/**
 * Class SmoothQueryBus
 * @package SmoothCodes\SmoothQueryBus
 */
class SmoothQueryBus implements QueryBusInterface {

    /** @var HandlerResolverInterface */
    protected $handlerResolver;

    /**
     * SmoothQueryBus constructor.
     * @param HandlerResolverInterface $handlerResolver
     */
    public function __construct(
        HandlerResolverInterface $handlerResolver
    ) {
        $this->handlerResolver = $handlerResolver;
    }

    /**
     * @param QueryInterface $query
     * @return mixed
     */
    public function query(QueryInterface $query)
    {
        return $this->handlerResolver->resolve($query);
    }


}
