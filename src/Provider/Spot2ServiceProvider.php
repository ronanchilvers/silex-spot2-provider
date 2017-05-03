<?php

namespace Ronanchilvers\Silex\Spot2\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Spot\Config;
use Spot\Locator;

/**
 * Service provider for the Spot2 ORM.
 *
 * Spot2 is a lightweight data mapper based ORM. This provider wires it up to the
 * Silex application container as a service.
 *
 * @see https://github.com/vlucas/spot2
 *
 * @author Ronan Chilvers <ronan@d3r.com>
 */
class Spot2ServiceProvider implements ServiceProviderInterface
{
    /**
     * Register this provider.
     *
     * The spot2.connections array can have an arbitrary number of connections in
     * it. The array should use the following format:
     *
     * <code>
     * $connections = [
     *      'my_sqlite' => 'sqlite://path/to/my_database.sqlite',
     *      'my_sqlite' => [
     *          'dbname'   => 'my_database',
     *          'user'     => 'username',
     *          'password' => 'sshhh-secret',
     *          'host'     => 'localhost',
     *          'drivers'  => 'pdo_mysql'
     *      ]
     * ];
     * </code>
     *
     * @param Pimple\Container $container
     *
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function register(Container $container)
    {
        $container['spot2.connections']         = [];
        $container['spot2.connections.default'] = null;
        $container['spot2.config'] = function (Container $container) {
            $config = new Config();
            foreach ($container['spot2.connections'] as $name => $data) {
                $default = ($container['spot2.connections.default'] === $name) ? true : false ;
                $config->addConnection($name, $data, $default);
            }

            return $config;
        };
        $container['spot2.locator'] = function (Container $container) {
            return new Locator($container['spot2.config']);
        };
    }

    /**
     * Boot the provider.
     *
     * @param Pimple\Container $container
     *
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function boot(Container $container)
    {
    }
}
