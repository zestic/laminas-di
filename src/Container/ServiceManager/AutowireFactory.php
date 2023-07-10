<?php

declare(strict_types=1);

namespace Laminas\Di\Container\ServiceManager;

use Laminas\Di\Container\AutowireFactory as GenericAutowireFactory;
use Laminas\ServiceManager\Factory\AbstractFactoryInterface;
use Psr\Container\ContainerInterface;

/**
 * Create instances with autowiring
 *
 * This class is purely for compatibility with Laminas\ServiceManager interface which requires container-interop
 */
class AutowireFactory implements AbstractFactoryInterface
{
    private GenericAutowireFactory $factory;

    public function __construct(?GenericAutowireFactory $factory = null)
    {
        $this->factory = $factory ? : new GenericAutowireFactory();
    }

    /**
     * Check creatability of the requested name
     *
     * @param string $requestedName
     * @return bool
     */
    public function canCreate(ContainerInterface $container, string $requestedName): bool
    {
        return $this->factory->canCreate($container, $requestedName);
    }

    /**
     * Make invokable and implement the laminas-service factory pattern
     *
     * @psalm-suppress RedundantCastGivenDocblockType
     * @param string $requestedName
     * @return object
     */
    public function __invoke(ContainerInterface $container, string $requestedName, ?array $options = null): mixed
    {
        return $this->factory->create($container, (string) $requestedName, $options);
    }
}
