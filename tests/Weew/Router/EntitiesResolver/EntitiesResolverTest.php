<?php

namespace Tests\Weew\Router\EntitiesResolver;

use PHPUnit_Framework_TestCase;
use Tests\Weew\Router\EntitiesResolver\Stubs\FakeEntity;
use Tests\Weew\Router\EntitiesResolver\Stubs\FakeRepository;
use Weew\Container\Container;
use Weew\Http\HttpRequestMethod;
use Weew\Router\ContainerAware\Router;
use Weew\Router\EntitiesResolver\EntitiesResolver;
use Weew\Router\EntitiesResolver\Exceptions\InvalidRepositoryClassException;
use Weew\Router\EntitiesResolver\Exceptions\RepositoryClassNotFoundException;
use Weew\Router\IRoute;
use Weew\Url\Url;

class EntitiesResolverTest extends PHPUnit_Framework_TestCase {
    public function test_resolve_with_missing_repository_class() {
        $router = new Router(new Container());
        $resolver = new EntitiesResolver($router);

        $this->setExpectedException(RepositoryClassNotFoundException::class);
        $resolver->resolve('foo', 'foo');
    }

    public function test_resolve_with_invalid_repository_class() {
        $router = new Router(new Container());
        $resolver = new EntitiesResolver($router);

        $this->setExpectedException(InvalidRepositoryClassException::class);
        $resolver->resolve('foo', self::class);
    }

    public function test_resolves_entities_properly() {
        $router = new Router(new Container());
        $resolver = new EntitiesResolver($router);

        $resolver->resolve('fake', FakeRepository::class);

        $router->get('{fake}', function() {});
        $route = $router->match(HttpRequestMethod::GET, new Url('foo'));

        $this->assertTrue($route instanceof IRoute);
        $entity = $route->getParameter('fake');

        $this->assertTrue($entity instanceof FakeEntity);
        /** @var FakeEntity $entity */
        $this->assertEquals('foo', $entity->id);
    }
}
