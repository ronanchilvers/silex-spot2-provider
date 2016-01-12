<?php

namespace Ronanchilvers\Silex\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;
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
     * @param Silex\Application $app
     *
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function register(Application $app)
    {
        $app['spot2.connections']         = [];
        $app['spot2.connections.default'] = null;
        $app['spot2.config'] = $app->share(function (Application $app) {
            $config = new Config();
            foreach ($app['spot2.connections'] as $name => $data) {
                $default = ($app['spot2.connections.default'] === $name) ? true : false ;
                $config->addConnection($name, $data, $default);
            }

            return $config;
        });
        $app['spot2.locator'] = $app->share(function (Application $app) {
            return new Locator($app['spot2.config']);
        });
    }

    /**
     * Boot the provider.
     *
     * @param Silex\Application $app
     *
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function boot(Application $app)
    {
    }
}
