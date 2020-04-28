<?php

namespace Tests\SmoothQueryBus\Handler;

use SmoothCodes\SmoothQueryBus\QueryHandlerInterface;
use Tests\SmoothQueryBus\UnresolvedServiceInterface;

class UnresolvedQueryHandler implements QueryHandlerInterface {
    public function __construct(UnresolvedServiceInterface $service)
    {
    }

    public function __invoke()
    {
        // TODO: Implement __invoke() method.
    }
}
