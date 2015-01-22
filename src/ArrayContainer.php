<?php

namespace Acclimate\Container;

use Interop\Container\ContainerInterface;
use Acclimate\Container\Exception\ContainerException;
use Acclimate\Container\Exception\NotFoundException;

/**
 * The Array Container is a simple container that follows both the `ContainerInterface` and `ArrayAccess` interface.
 * The container can be seeded with an array or array-like object. The "get" functionality will evaluate closures and
 * cache results.
 */
class ArrayContainer implements ContainerInterface, \ArrayAccess
{
    /**
     * @var array|\ArrayAccess The container data
     */
    protected $data;
    
    /**
     * @var ContainerInterface The container that will be used for dependency lookups
     */
    protected $delegateLookupContainer;

    /**
     * @param array|\ArrayAccess|\Traversable $data Data for the container
     * @param ContainerInterface $delegateLookupContainer The container that will be used for dependency lookups.
     *
     * @throws \InvalidArgumentException if the provided data is not an array or array-like object
     */
    public function __construct($data = array(), $delegateLookupContainer = null)
    {
        if (is_array($data) || $data instanceof \ArrayAccess) {
            $this->data = $data;
        } elseif ($data instanceof \Traversable) {
            $this->data = iterator_to_array($data, true);
        } else {
            throw new \InvalidArgumentException('The ArrayContainer requires either an array or an array-like object');
        }
        $this->delegateLookupContainer = $delegateLookupContainer ?: $this;
    }

    public function get($id)
    {
        if (isset($this->data[$id])) {
            try {
                if ($this->data[$id] instanceof \Closure) {
                    $this->data[$id] = call_user_func($this->data[$id], $this->delegateLookupContainer);
                }
            } catch (\Exception $prev) {
                throw ContainerException::fromPrevious($id, $prev);
            }
            return $this->data[$id];
        } else {
            throw NotFoundException::fromPrevious($id);
        }
    }

    public function has($identifier)
    {
        return isset($this->data[$identifier]);
    }

    public function offsetExists($offset)
    {
        return isset($this->data[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    public function offsetSet($offset, $value)
    {
        $this->data[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->data[$offset]);
    }
}
