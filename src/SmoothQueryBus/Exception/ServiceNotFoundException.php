<?php

namespace SmoothCodes\SmoothQueryBus\Exception;

use Throwable;

class ServiceNotFoundException extends \Exception {
    public function __construct($serviceName, $code = 0, Throwable $previous = null)
    {
        parent::__construct(sprintf('Service with alias %s not found in dependency container.', $serviceName), $code, $previous);
    }
}
