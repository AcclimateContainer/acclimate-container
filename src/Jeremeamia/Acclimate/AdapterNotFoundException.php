<?php

namespace Jeremeamia\Acclimate;

class AdapterNotFoundException extends \RuntimeException
{
    public static function fromContainer($container)
    {
        $type = is_object($container) ? get_class($container) : gettype($container);

        return new self("There is no container adapter registered to handle containers of the type \"{$type}\".");
    }
}
