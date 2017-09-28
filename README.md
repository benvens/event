# PHP Event Manager

Implementation of [PSR-14 Event Manager](https://github.com/php-fig/fig-standards/blob/master/proposed/event-manager.md).

## Requirements

PHP >= 7.1

## Installation

composer require benliev/event

## Usage example

```php
$manager = new EventManager();
$manager->attach('posts.create', function(EventInterface $event) {
    echo "Post {$event->getParam('title')} was created";
});
$event = new Event('posts.create', $this, ['title' => 'Lorem ipsum']);
$manager->trigger('posts.create');
```
