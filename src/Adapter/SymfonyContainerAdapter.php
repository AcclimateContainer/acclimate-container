<?php

namespace Acclimate\Container\Adapter;

use Acclimate\Container\Exception\ContainerException as AcclimateContainerException;
use Acclimate\Container\Exception\NotFoundException as AcclimateNotFoundException;
use Interop\Container\ContainerInterface as AcclimateContainerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface as SymfonyContainerInterface;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException as SymfonyInvalidArgumentException;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException as SymfonyNotFoundException;

/**
 * An adapter from a Symfony Container to the standardized ContainerInterface
 */
class SymfonyContainerAdapter implements AcclimateContainerInterface
{
    /**
     * @var SymfonyContainerInterface A Symfony Container
     */
    private $container;

    /**
     * @param SymfonyContainerInterface $container A Symfony Container
     */
    public function __construct(SymfonyContainerInterface $container)
    {
        $this->container = $container;
    }

    public function get($id)
    {
        try {
            return $this->container->get($id);
        } catch (SymfonyNotFoundException $prev) {
            throw AcclimateNotFoundException::fromPrevious($id, $prev);
        } catch (SymfonyInvalidArgumentException $prev) {
            throw AcclimateNotFoundException::fromPrevious($id, $prev);
        } catch (\Exception $prev) {
            throw AcclimateContainerException::fromPrevious($id, $prev);
        }
    }

    public function has($id)
    {
        return $this->container->has($id);
    }
}
