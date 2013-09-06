<?php

namespace Jeremeamia\Acclimate;

class ServiceNotFoundException extends \RuntimeException
{
    public static function fromName($name, \Exception $prev = null)
    {
        return new self("There is no item in the container for name \"{$name}\".", 0, $prev);
    }
}
