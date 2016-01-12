# Silex Provider for the Spot2 ORM

Spot2 is a simple ORM for [Silex](http://silex.sensiolabs.org/) projects based on the data mapper pattern. You can read more about it [on the github page](https://github.com/vlucas/spot2) or the [documentation site](http://phpdatamapper.com/).

This project comprises a service provider and utility for hooking Spot2 up to your Silex app.

## Installation

The easiest mechanism is via composer. Add the provider to your composer.json:

```json
{
    "require": {
        "ronanchilvers/silex-spot2-provider": "^1.0"
    }
}
```

## Usage

To register the service provider you can do something like this:

```php
$app->register(new \Ronanchilvers\Silex\Provider\Spot2ServiceProvider(), [
    'spot2.connections' => [
        'default' => 'sqlite://path/to/my_database.sqlite'
    ]
]);

$app->get('/things', function() use ($app) {
    $mapper = $app['spot2.locator']->mapper('Entity\Thing');
    
    $this->render('things.twig', [ 
        'things' => $mapper->all() 
    ]);
});
```

## Utility trait
If you want to use the utility trait, just include it in your subclassed application.

```php
class Application extends Silex\Application
{
    use \Ronanchilvers\Silex\Application\Spot2Trait;
}
```

You then get the following convenience methods.

### mapper()
This method is a shortcut for getting a mapper out for a particular entity.

```php
$app->get('/things', function() use ($app) {
    $mapper = $this->mapper('Entity\Thing');
    
    return $this->render('things.twig', [
        'things' => $mapper->all()
    ]);
});
```
### spot2()
This method is a shortcut for getting the spot2 locator object. Most of the time you won't use this method (you'll probably use mapper() instead). It exists just to allow easy access to the locator if required.

```php
$app->get('/things', function() use ($app) {
    $mapper = $this->spot2()->mapper('Entity\Thing');
    
    return $this->render('things.twig', [
        'things' => $mapper->all()
    ]);
});
```

## Services Exposed
The Spot2ServiceProvider exposes the following services.

- `spot2.connections` - an array of connection DSNs or DBAL style configuration arrays
- `spot2.connections.default` - the name of the default connection to use. Spot2 will take the first defined one as the default if you don't set one explicitly.
- `spot2.config`- the Spot2 config object
- `spot2.locator` - the Spot2 locator object