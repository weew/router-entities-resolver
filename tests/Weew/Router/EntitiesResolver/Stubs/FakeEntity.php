<?php

namespace Tests\Weew\Router\EntitiesResolver\Stubs;

class FakeEntity {
    public $id;

    public function __construct($id) {
        $this->id = $id;
    }
}
