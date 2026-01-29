<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Raphaelahmn\ClickClack\Controller\AccueilController;


$app->get('/', [AccueilController::class, 'afficherPagePrincipale']);
$app->post('/', [AccueilController::class, 'afficherPagePrincipale']);