<?php

namespace Jeremeamia\Acclimate;

/**
 * The Array Container is a simple service container that follows both the ContainerInterface and ArrayAccess interface.
 * The container can be seeded with and array or any array-like object. The "get" functionality will evaluate closures
 * and cache results.
 */
class ArrayContainer implements ContainerInterface, \ArrayAccess
{
    /**
     * @var array|\ArrayAccess The service container data
     */
    protected $data;

    /**
     * @param array $data service container data
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($data = array())
    {
        if (is_array($data) || $data instanceof \ArrayAccess) {
            $this->data = $data;
        } elseif ($data instanceof \Traversable) {
            $this->data = iterator_to_array($data, true);
        } else {
            throw new \InvalidArgumentException('The ArrayContainer requires either an array or an array-like object');
        }
    }

    /**
     * Gets an item from the container
     *
     * @param string $name The name of an item in the container
     *
     * @return mixed
     */
    public function get($name)
    {
        return $this[$name];
    }

    /**
     * Checks if an item is in the container
     *
     * @param string $name The name of an item in the container
     *
     * @return bool
     */
    public function has($name)
    {
        return isset($this[$name]);
    }

    public function offsetExists($offset)
    {
        return isset($this->data[$offset]);
    }

    public function offsetGet($offset)
    {
        if (isset($this->data[$offset])) {
            if ($this->data[$offset] instanceof \Closure) {
                $this->data[$offset] = call_user_func($this->data[$offset], $this);
            }
            return $this->data[$offset];
        } else {
            throw ServiceNotFoundException::fromName($offset);
        }
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
