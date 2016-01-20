# Doctrine entities resolver

[![Build Status](https://img.shields.io/travis/weew/php-router-entities-resolver.svg)](https://travis-ci.org/weew/php-router-entities-resolver)
[![Code Quality](https://img.shields.io/scrutinizer/g/weew/php-router-entities-resolver.svg)](https://scrutinizer-ci.com/g/weew/php-router-entities-resolver)
[![Test Coverage](https://img.shields.io/coveralls/weew/php-router-entities-resolver.svg)](https://coveralls.io/github/weew/php-router-entities-resolver)
[![Version](https://img.shields.io/packagist/v/weew/php-router-entities-resolver.svg)](https://packagist.org/packages/weew/php-router-entities-resolver)
[![Licence](https://img.shields.io/packagist/l/weew/php-router-entities-resolver.svg)](https://packagist.org/packages/weew/php-router-entities-resolver)

## Table of contents

- [Installation](#installation)
- [Introduction](#introduction)
- [Usage](#usage)

## Installation

`composer require weew/php-router-entities-resolver`

## Introduction

This package provides a convenient way to resolve doctrine entities in the [weew/php-router](https://github.com/weew/php-router) package.

## Usage

Pick an identifier for the entity to be referenced in the router and register a new resolver.

```php
$router = new Router(new Container());
$resolver = new EntitiesResolver($router);

$resolver
    ->resolve('user', UserRepository::class)
    ->resolve('role', RoleRepository::class);
```

Now you can resolve entities as with any regular parameter resolver.

```php
$router->get('api/v1/users/{user}', function(User $user) {
    // entitiy will be injected instead of a user id
});

// or

$route = $router->match(HttpRequestMethod::GET, new Url('api/v1/users/1'));
$user = $route->getParameter('user');
```
