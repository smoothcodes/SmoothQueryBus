<?php

namespace Tests\SmoothQueryBus;

use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use SmoothCodes\SmoothQueryBus\HandlerResolvingStrategy;
use SmoothCodes\SmoothQueryBus\QueryHandlerInterface;
use SmoothCodes\SmoothQueryBus\QueryInterface;
use SmoothCodes\SmoothQueryBus\SmoothHandlerResolver;
use SmoothCodes\SmoothQueryBus\SmoothQueryBus;

/**
 * Class ResolvingHandlerDependenciesTest
 * @package Tests\SmoothQueryBus
 *
 *
 */
class CustomHandlerResolvingStrategyTest extends TestCase {

    /**
     * @dataProvider provider
     * @param SmoothQueryBus $queryBus
     * @param QueryInterface $query
     * @param $expected
     */
    public function testHandlerResolvedProperly($queryBus, $query, $expected)
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
        $query = new class($expected) implements QueryInterface {
            public $id;

            public function __construct($id)
            {
                $this->id = $id;
            }
        };

        $queryHandler = new class implements QueryHandlerInterface {

            public function __construct()
            {

            }

            public function __invoke(QueryInterface $query)
            {
                return $query->id;
            }
        };

        $namingResolver = new class($queryHandler) implements HandlerResolvingStrategy {
            private $queryHandler;

            public function __construct(QueryHandlerInterface $handler)
            {
                $this->queryHandler = $handler;
            }

            public function getHandlerClassName(QueryInterface $query)
            {
                return get_class($this->queryHandler);
            }
        };

        $queryBus = new SmoothQueryBus(
            new SmoothHandlerResolver($container, $namingResolver)
        );

        return [
            [$queryBus, $query, $expected],
        ];
    }
}
