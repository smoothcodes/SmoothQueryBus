<?php

namespace SmoothCodes\SmoothQueryBus\Handler;

use SmoothCodes\SmoothQueryBus\Query\TestQuery;
use SmoothCodes\SmoothQueryBus\QueryHandlerInterface;
use SmoothCodes\SmoothQueryBus\QueryInterface;

class TestQueryHandler implements QueryHandlerInterface {
    public function __construct()
    {
    }

    public function __invoke(TestQuery $query)
    {
        return $query->id;
    }
}
