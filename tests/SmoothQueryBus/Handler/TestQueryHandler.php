<?php

namespace Tests\SmoothQueryBus\Handler;

use Tests\SmoothQueryBus\Query\TestQuery;
use SmoothCodes\SmoothQueryBus\QueryHandlerInterface;
use Tests\SmoothQueryBus\TestService;

class TestQueryHandler implements QueryHandlerInterface {

    private $testService;

    public function __construct(TestService $testService)
    {
        $this->testService = $testService;
    }

    public function __invoke(TestQuery $query)
    {
        return $this->testService->doSomething($query);
    }
}
