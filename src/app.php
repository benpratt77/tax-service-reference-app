<?php

use BCSample\Tax\Provider\TaxServiceProvider;
use Monolog\Logger;
use Silex\Application;
use Silex\Provider\AssetServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\TwigServiceProvider;

$app = new Application();
// Default middleware.
$app->register(new ServiceControllerServiceProvider());
$app->register(new AssetServiceProvider());
$app->register(new TwigServiceProvider());
$app->register(new HttpFragmentServiceProvider());

$app->register(new MonologServiceProvider(), array(
    'monolog.logfile' => 'php://stderr',
    'monolog.level' => Logger::INFO,
));



// App specific dependencies.
$app->register(new TaxServiceProvider());

$app['twig'] = $app->extend('twig', function ($twig) {
    return $twig;
});

return $app;
