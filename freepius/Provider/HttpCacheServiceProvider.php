<?php

namespace Freepius\Provider;

use Freepius\Provider\HttpCache\HttpCacheListener;
use Freepius\Provider\HttpCache\MongoNoCache;
use Freepius\Provider\HttpCache\Store;
use Pimple\ServiceProviderInterface;
use Pimple\Container;
use Silex\Api\EventListenerProviderInterface;
use Silex\Provider\HttpCache\HttpCache;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Active http cache mechanisms when :
 *  -> debug is off
 *  -> user is not admin (through HttpCacheListener)
 */
class HttpCacheServiceProvider implements ServiceProviderInterface, EventListenerProviderInterface
{
    public function register(Container $app)
    {
        $app['http_cache.mongo.collection'] = function ($app) {
            return $app['mongo.database']->httpCache;
        };

        // When DEBUG is OFF
        if (! $app['debug'])
        {
            $app['http_cache.options'] = array();

            $app['http_cache'] = function ($app) {
                return new HttpCache($app, $app['http_cache.store'], null, $app['http_cache.options']);
            };

            $app['http_cache.store'] = function ($app) {
                return new Store($app['http_cache.cache_dir']);
            };
        }
        // When DEBUG is ON
        else
        {
            $app['http_cache.mongo'] = function ($app) {
                return new MongoNoCache($app['http_cache.mongo.collection']);
            };
        }
    }

    public function subscribe(Container $app, EventDispatcherInterface $dispatcher)
    {
        if (! $app['debug']) {
            $dispatcher->addSubscriber(new HttpCacheListener($app));
        }
    }
}
