<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$app->get('/', function () use ($app) {
    return $app['twig']->render(
        'index.html.twig',
        []
    );
})->bind('homepage');

$app->get('/samplerequest', function () use ($app) {
    return $app['twig']->render(
        'samplerequest.html.twig',
        []
    );
})->bind('sampleRequest');

$app->get('/sampleresponse', function () use ($app) {
    return $app['twig']->render(
        'sampleresponse.html.twig',
        []
    );
})->bind('sampleResponse');

$app->get('/todo', function () use ($app) {
    return $app['twig']->render(
        'todo.html.twig',
        []
    );
})->bind('todo');

$app->error(function (\Exception $e, Request $request, $code) use ($app) {
    if ($app['debug']) {
        return;
    }

    // 404.html, or 40x.html, or 4xx.html, or error.html
    $templates = [
        'errors/'.$code.'.html.twig',
        'errors/'.substr($code, 0, 2).'x.html.twig',
        'errors/'.substr($code, 0, 1).'xx.html.twig',
        'errors/default.html.twig',
    ];

    return new Response($app['twig']->resolveTemplate($templates)->render(['code' => $code]), $code);
});
