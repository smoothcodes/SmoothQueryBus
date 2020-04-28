<?php

namespace SmoothCodes\SmoothQueryBus;

/**
 * Interface QueryBusInterface
 * @package SmoothCodes\SmoothQueryBus
 */
interface QueryBusInterface {
    /**
     * @param QueryInterface $query
     * @return mixed
     */
    public function query(QueryInterface $query);
}
