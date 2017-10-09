<?php

namespace Acclimate\Container;

use Acclimate\Container\Exception\NotFoundException;
use Interop\Container\ContainerInterface;

/**
 * Class EmptyContainer
 *
 * An immutable container which has no elements.
 * @package Acclimate\Container
 */
final class EmptyContainer implements ContainerInterface
{
    private static $instance;

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function get($id)
    {
        throw NotFoundException::fromPrevious($id);
    }

    /**
     * {@inheritdoc}
     */
    public function has($id)
    {
        return false;
    }

    public static function instance()
    {
        if (self::$instance === null) {
            self::$instance = new EmptyContainer();
        }
        return self::$instance;
    }
}