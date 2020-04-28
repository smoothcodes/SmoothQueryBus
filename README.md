# SmoothQueryBus

This simple package will help you to implement CQRS in your project. Easy to integrate with Laravel, Symfony or raw PHP project.

##Installation

```bash
$ composer require smoothcodes/smooth-query-bus
```

##Usage

This package is using Psr\ContainerInterface to resolve dependencies injected to Query Handlers. Symfony and Laravel Dependency Container is implementing ContainerInterface so it's really easy to implement SmoothQueryBus in your Symfony/Laravel Project.

By default this package provides HandlerResolver called ` SmoothCodes\SmoothQueryBus\SmoothHandlerResolver` and it requires project structure for your queries and handlers like this:
```
app
│   ...    
│
└───Query
│   │   GetUserByIdQuery.php
│   │   ...
│   
└───Handler
    │   GetUserByIdQueryHandler.php
    |   ...
```

Each `Query` should implement `SmoothCodes\SmoothQueryBus\QueryInterface` and each `Handler` should implement 
`SmoothCodes\SmoothQueryBus\QueryHandlerInterface`.

Now you're ready to dispatch your queries like that:

```php
$queryBus = new SmoothQueryBus(
    new SmoothHandlerResolver($container)
);

$result = $queryBus->query(new GetUserByIdQuery(...));
```

If you want you can implement your own Query Handler Resolving Strategy by providing class implementing `SmoothCodes\SmoothQueryBus\HandlerResolvingStrategy` to `SmoothHandlerResolver` instance eg. like that:

```bash
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

```

instead default handler resolving strategy will be used.

That's very simple package which is fully customizable. Report any issues, give feedbacks or do some feature requests.
