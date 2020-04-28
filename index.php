<?php


use SmoothCodes\SmoothQueryBus\Query\TestQuery;
use SmoothCodes\SmoothQueryBus\SmoothHandlerResolver;
use SmoothCodes\SmoothQueryBus\SmoothQueryBus;

require 'vendor/autoload.php';

$container = new class implements Psr\Container\ContainerInterface {
    public function get($id)
    {
        // TODO: Implement get() method.
    }

    public function has($id)
    {
        return true;
    }

};


$queryBus = new SmoothQueryBus(
    new SmoothHandlerResolver($container)
);

echo $queryBus->query(new TestQuery('test'));
