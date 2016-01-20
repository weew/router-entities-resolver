<?php

namespace Tests\Weew\Router\EntitiesResolver\Stubs;

use Doctrine\Common\Persistence\ObjectRepository;

class FakeRepository implements ObjectRepository {
    public function find($id) {
        return new FakeEntity($id);
    }
    public function findAll() {}
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null) {}
    public function findOneBy(array $criteria) {}
    public function getClassName() {}
}
