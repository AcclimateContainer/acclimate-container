<?php

namespace Jeremeamia\Acclimate;

class ArrayContainer implements ContainerInterface, \ArrayAccess
{
    /**
     * @var array
     */
    protected $data;

    /**
     * @param array $data
     */
    public function __construct(array $data = array())
    {
        $this->data = $data;
    }

    public function get($name)
    {
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        } else {
            throw new \OutOfBoundsException("No item in the container for name \"{$name}\".");
        }
    }

    public function has($name)
    {
        return array_key_exists($name, $this->data);
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function remove($name)
    {
        unset($this->data[$name]);

        return $this;
    }

    /**
     * @param string $name
     * @param mixed $value
     *
     * @return $this
     */
    public function set($name, $value)
    {
        $this->data[$name] = $value;

        return $this;
    }

    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    public function offsetSet($offset, $value)
    {
        $this->set($offset, $value);
    }

    public function offsetUnset($offset)
    {
        $this->remove($offset);
    }
}
