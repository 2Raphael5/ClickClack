<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use ClickClack\ClickClack\Controller\AccueilController;
use ClickClack\ClickClack\Controller\DiscussionController;
use ClickClack\ClickClack\Controller\UserController;


$app->get('/', [AccueilController::class, 'afficherPagePrincipale']);
$app->post('/', [AccueilController::class, 'afficherPagePrincipale']);

$app->get('/login', [UserController::class, 'afficherPageConnexion']);
$app->post('/login', [UserController::class, 'afficherPageConnexion']);

$app->get('/discussion', [DiscussionController::class, 'afficherPagePrincipale']);
$app->post('/discussion', [DiscussionController::class, 'verifierDiscussion']);