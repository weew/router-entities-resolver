<?php

namespace Weew\Router\EntitiesResolver;

use Doctrine\Common\Persistence\ObjectRepository;
use Weew\Container\IContainer;
use Weew\Router\EntitiesResolver\Exceptions\InvalidRepositoryClassException;
use Weew\Router\EntitiesResolver\Exceptions\RepositoryClassNotFoundException;
use Weew\Router\IRouter;

class EntitiesResolver implements IEntitiesResolver {
    /**
     * @var IRouter
     */
    protected $router;

    /**
     * EntitiesResolver constructor.
     *
     * @param IRouter $router
     */
    public function __construct(IRouter $router) {
        $this->router = $router;
    }

    /**
     * @param $name
     * @param $repositoryClass
     *
     * @return $this
     * @throws InvalidRepositoryClassException
     * @throws RepositoryClassNotFoundException
     */
    public function resolve($name, $repositoryClass) {
        if ( ! class_exists($repositoryClass)) {
            throw new RepositoryClassNotFoundException(s(
                'Class "%s" not found.', $repositoryClass
            ));
        }

        if ( ! array_contains(class_implements($repositoryClass), ObjectRepository::class)) {
            throw new InvalidRepositoryClassException(s(
                'Class "%s" must implement interface "%s".',
                $repositoryClass,
                ObjectRepository::class
            ));
        }

        $this->router->addResolver($name, function($parameter, IContainer $container) use ($repositoryClass) {
            $repository = $container->get($repositoryClass);

            return $repository->find($parameter);
        });

        return $this;
    }
}
