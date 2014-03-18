<?php

namespace Acclimate\Container\Adapter;

use Acclimate\Container\Exception\ContainerException as AcclimateContainerException;
use Acclimate\Container\Exception\NotFoundException as AcclimateNotFoundException;
use DI\Container as PhpDiContainerInterface;
use DI\NotFoundException as PhpDiNotFoundException;
use Interop\Container\ContainerInterface as AcclimateContainerInterface;

/**
 * An adapter from a PHP-DI Container to the standardized ContainerInterface
 */
class PHPDIContainerAdapter implements AcclimateContainerInterface
{
    /**
     * @var PhpDiContainerInterface A PHP-DI Container
     */
    private $container;

    /**
     * @param PhpDiContainerInterface $container A PHP-DI Container
     */
    public function __construct(PhpDiContainerInterface $container)
    {
        $this->container = $container;
    }

    public function get($id)
    {
        try {
            return $this->container->get($id);
        } catch (PhpDiNotFoundException $prev) {
            throw AcclimateNotFoundException::fromPrevious($id, $prev);
        } catch (\Exception $prev) {
            throw AcclimateContainerException::fromPrevious($id, $prev);
        }
    }

    public function has($id)
    {
        try {
            $this->container->get($id);
            return true;
        } catch (PhpDiNotFoundException $e) {
            return false;
        }
    }
}
