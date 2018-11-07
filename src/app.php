<?php

use BCSample\Tax\Provider\TaxEstimateServiceProvider;
use Silex\Application;
use Silex\Provider\AssetServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\TwigServiceProvider;

$app = new Application();
// default middleware
$app->register(new ServiceControllerServiceProvider());
$app->register(new AssetServiceProvider());
$app->register(new TwigServiceProvider());
$app->register(new HttpFragmentServiceProvider());

$app->register(new MonologServiceProvider(), array(
    'monolog.logfile' => 'php://stderr',
    'monolog.level' => \Monolog\Logger::INFO,
));



// app specific dependencies
$app->register(new TaxEstimateServiceProvider());

$app['twig'] = $app->extend('twig', function ($twig) {
    return $twig;
});

return $app;
