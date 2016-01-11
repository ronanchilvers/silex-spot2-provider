<?php

namespace Ronanchilvers\Silex\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Spot\Config;
use Spot\Locator;

class Spot2ServiceProvider implements ServiceProviderInterface
{
    /**
     * Register this provider
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
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function register(Application $app)
    {
        $app['spot2.connections']    = [];
        $app['spot2.config'] = $app->share(function(Application $app){
            $config = new Config();
            foreach ($app['spot2.connections'] as $name => $data) {
                $config->addConnection($name, $data);
            }

            return $config;
        });
        $app['spot2.locator'] = $app->share(function(Application $app){
            return new Locator($app['spot2.config']);
        });
    }

    public function boot(Application $app)
    {
    }
}
