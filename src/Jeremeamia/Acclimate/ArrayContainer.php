<?php

namespace Jeremeamia\Acclimate;

class ArrayContainer implements ContainerInterface, \ArrayAccess
{
    /**
     * @var array|\ArrayAccess
     */
    protected $data;

    /**
     * @param array $data
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

    public function get($name)
    {
        return $this[$name];
    }

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
                return call_user_func($this->data[$offset], $this);
            } else {
                return $this->data[$offset];
            }
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
