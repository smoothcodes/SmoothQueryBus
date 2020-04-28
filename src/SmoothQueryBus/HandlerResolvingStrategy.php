<?php

namespace SmoothCodes\SmoothQueryBus;

interface HandlerResolvingStrategy {
    public function getHandlerClassName(QueryInterface $query);
}
