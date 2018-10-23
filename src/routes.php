<?php

use BCSample\Tax\Domain\TaxEstimates\TaxEstimateAPIController;

$api = $app['controllers_factory'];

$api->post('/estimate', TaxEstimateAPIController::class.':getEstimate');

$app->mount('/sample-tax-service/', $api);
