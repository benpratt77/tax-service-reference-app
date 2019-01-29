<?php

use BCSample\Tax\Domain\Tax\TaxAPIController;

$api = $app['controllers_factory'];

$api->post('/estimate', TaxAPIController::class.':getEstimate');
$api->post('/commit', TaxAPIController::class. ':commit');
$api->post('/adjust', TaxAPIController::class. ':adjust');

$app->mount('/sample-tax-service/', $api);
