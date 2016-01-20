<?php

namespace Weew\Router\EntitiesResolver;

interface IEntitiesResolver {
    /**
     * @param $name
     * @param $repositoryClass
     *
     * @return IEntitiesResolver
     */
    function resolve($name, $repositoryClass);
}
