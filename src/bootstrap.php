<?php

define('APP'  , __DIR__);
define('ROOT' , dirname(APP));
define('CACHE', ROOT.'/cache');
define('WEB'  , ROOT.'/web');

require APP.'/load-config.php';

$loader = require ROOT.'/vendor/autoload.php';

$loader->addPsr4('Freepius\\', ROOT.'/freepius');

$app = new \Freepius\Silex\Application();

/* Locale of the application */
\Locale::setDefault('fr_FR.UTF-8');

/* Locale of the current request : default = fr */
$app['locale'] = 'fr';

$app['debug'] = DEBUG;

/* MongoDB config */
$app['mongo.connection'] = new \MongoClient(MONGO_SERVER);
$app['mongo.database'] = $app['mongo.connection']->selectDB(MONGO_DB);

/* Paths and directories */
$app['path.cache']  = CACHE;


/*************************************************
 * Register services
 ************************************************/

/* session */
$app->register(new \Silex\Provider\SessionServiceProvider());

/* http cache */
$app->register(new \Freepius\Provider\HttpCacheServiceProvider(), [
    'http_cache.cache_dir' => CACHE.'/http',
]);

/* twig */
$app->register(new \Silex\Provider\TwigServiceProvider(), [
    'twig.path'    => [APP.'/Resources/views'],
    'twig.options' => ['cache' => DEBUG ? null : (CACHE.'/twig')],
]);

/* validator */
$app->register(new \Silex\Provider\ValidatorServiceProvider());

/* translator */
$app->register(new \Silex\Provider\TranslationServiceProvider());

/* security */
$app->register(new \Silex\Provider\SecurityServiceProvider());

/* freepius/php-asset */
$app->register(new \Freepius\Pimple\Provider\AssetServiceProvider(), [
    'asset.cdn.use'     => ! $app['debug'],
    'asset.config'      => [
        'base.url' => BASE_URL_FOR_ASSET,
        'leaflet.markercluster.css' => '<link href="/css/MarkerCluster.Default.css" rel="stylesheet">',
    ],
]);


/*************************************************
 * Twig extensions, global variables, filters and functions.
 ************************************************/

$app['twig'] = $app->extend('twig', function($twig, $app)
{
    // for 'shuffle' filter
    $twig->addExtension(new \Twig_Extensions_Extension_Array());

    // for 'localizeddate' filter
    $twig->addExtension(new \Twig_Extensions_Extension_Intl());

    //$twig->addGlobal('host', $app['request_stack']->getMasterRequest()->getUriForPath('/'));

    return $twig;
});


/*************************************************
 * Security configuration
 ************************************************/

$app['security.firewalls'] = [
    'all' => [
        'anonymous' => true,
        'pattern'   => '^/',
        'form'      => ['login_path' => '/login', 'check_path' => '/admin/login_check'],
        'logout'    => ['logout_path' => '/admin/logout'],
        'users'     => [
            'admin' => ['ROLE_ADMIN', ADMIN_PASSWORD],
        ],
    ],
];

$app['security.access_rules'] = [['^/(admin|register)', 'ROLE_ADMIN']];


/*************************************************
 * Add translation resources
 ************************************************/

$translator = $app['translator'];
$transDir   = APP.'/Resources/translations';
$locales    = ['fr', 'en'];
$resources  = ['messages', 'register'];

foreach ($locales as $locale) {
    foreach ($resources as $resource) {
        $translator->addResource('array', require "$transDir/$resource.$locale.php", $locale);
    }
}


/*************************************************
 * Register repositories
 ************************************************/

$app['model.repository.register'] = function ($app)
{
    return new \App\Model\Repository\Register(
        $app['mongo.database']->register,
        $app['twig'],
        WEB,
        $app['register.config']['cache_dir']
    );
};


/*************************************************
 * Register entity factories
 ************************************************/

$app['model.factory.register'] = function ($app)
{
    return new \App\Model\Factory\Register($app['validator']);
};


/*************************************************
 * Configuration for the "travel register"
 ************************************************/

$app['register.config'] =
[
    'cache_dir'         => 'cache/register',  // relative to web path
    'bing_maps_api_key' => BING_MAPS_API_KEY,
    'twilio.account'    => TWILIO_ACCOUNT_SID,
    'twilio.number'     => TWILIO_NUMBER,
];


/*************************************************
 * Define the routes
 ************************************************/

$app->mount('/'        , new \App\Controller\Base($app));
$app->mount('/register', new \App\Controller\Register($app));


return $app;
