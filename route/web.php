<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Raphaelahmn\ClickClack\Controller\AccueilController;
use Raphaelahmn\ClickClack\Controller\UserController;


$app->get('/', [AccueilController::class, 'afficherPagePrincipale']);
$app->post('/', [AccueilController::class, 'afficherPagePrincipale']);

$app->get('/login', [UserController::class, 'afficherPageConnexion']);
$app->post('/login', [UserController::class, 'afficherPageConnexion']);