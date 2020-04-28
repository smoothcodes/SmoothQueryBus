<?php

namespace SmoothCodes\SmoothQueryBus\Query;

use SmoothCodes\SmoothQueryBus\QueryInterface;

class TestQuery implements QueryInterface {
    public $id;

    public function __construct($id)
    {
        $this->id = $id;
    }
}
