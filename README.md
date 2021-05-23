# PHP Event Manager

[![Build Status](https://travis-ci.org/benliev/event.svg?branch=master)](https://travis-ci.org/benliev/event)

Implementation of [PSR-14 Event Manager](https://github.com/php-fig/fig-standards/blob/master/proposed/event-manager.md).

## Requirements

PHP >= 7.1

## Installation

composer require benvens/event

## Usage example

```php
$manager = new EventManager();
$manager->attach('posts.create', function(EventInterface $event) {
    echo "Post {$event->getParam('title')} was created";
});
$event = new Event('posts.create', $this, ['title' => 'Lorem ipsum']);
$manager->trigger('posts.create');
```
