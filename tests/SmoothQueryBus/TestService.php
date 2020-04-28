<?php

namespace Tests\SmoothQueryBus;

use SmoothCodes\SmoothQueryBus\QueryInterface;

class TestService {
    public function __construct()
    {
    }

    public function doSomething(QueryInterface $query) {
        return $query->id;
    }
}
