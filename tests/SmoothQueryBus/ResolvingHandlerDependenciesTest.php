<?php

namespace Tests\SmoothQueryBus;

use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use SmoothCodes\SmoothQueryBus\QueryInterface;
use SmoothCodes\SmoothQueryBus\SmoothHandlerResolver;
use SmoothCodes\SmoothQueryBus\SmoothQueryBus;
use Tests\SmoothQueryBus\Query\TestQuery;

/**
 * Class ResolvingHandlerDependenciesTest
 * @package Tests\SmoothQueryBus
 *
 *
 */
class ResolvingHandlerDependenciesTest extends TestCase {

    /**
     * @dataProvider provider
     * @param SmoothQueryBus $queryBus
     * @param QueryInterface $query
     * @param $expected
     */
    public function testHandlerDependencyIsResolved($queryBus, $query, $expected)
    {
        $this->assertEquals($expected, $queryBus->query($query));
    }

    /**
     * @return array
     */
    public function provider()
    {
        /** @var ContainerInterface $container */
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

        $expected = 'test';
        $query = new TestQuery($expected);

        $queryBus = new SmoothQueryBus(
            new SmoothHandlerResolver($container)
        );

        return [
          [$queryBus, $query, $expected],
        ];
    }
}
