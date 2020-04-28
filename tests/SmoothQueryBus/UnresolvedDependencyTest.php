<?php

namespace Tests\SmoothQueryBus;

use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use SmoothCodes\SmoothQueryBus\Exception\ServiceNotFoundException;
use SmoothCodes\SmoothQueryBus\QueryBusInterface;
use SmoothCodes\SmoothQueryBus\QueryInterface;
use SmoothCodes\SmoothQueryBus\SmoothHandlerResolver;
use SmoothCodes\SmoothQueryBus\SmoothQueryBus;
use Tests\SmoothQueryBus\Query\UnresolvedQuery;

class UnresolvedDependencyTest extends TestCase {

    /**
     * @param QueryBusInterface $queryBus
     * @param QueryInterface $query
     * @param $exceptionClass
     * @dataProvider provide
     */
    public function testNotExistingServiceThrowsException(QueryBusInterface $queryBus, QueryInterface $query, $exceptionClass) {
        $this->expectException($exceptionClass);
        $queryBus->query($query);
    }

    public function provide() {
        $container = new class implements ContainerInterface {
            public function get($id)
            {
                if ($id == TestService::class) {
                    return new TestService();
                }

                throw new \Exception();
            }

            public function has($id)
            {
                if ($id == TestService::class) {
                    return true;
                }

                return false;
            }

        };

        $queryBus = new SmoothQueryBus(
            new SmoothHandlerResolver($container)
        );


        return [
            [$queryBus, new UnresolvedQuery(), ServiceNotFoundException::class]
        ];
    }
}
