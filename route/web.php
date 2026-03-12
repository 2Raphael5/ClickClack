<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use ClickClack\ClickClack\Controller\AccueilController;
use ClickClack\ClickClack\Controller\DiscussionController;
use ClickClack\ClickClack\Controller\UserController;
use ClickClack\ClickClack\Controller\PublicationController;

$app->get('/', [AccueilController::class, 'afficherPagePrincipale']);
$app->post('/', [AccueilController::class, 'afficherPagePrincipale']);

$app->get('/discussion', [DiscussionController::class, 'afficherPagePrincipale']);
$app->post('/discussion', [DiscussionController::class, 'verifierDiscussion']);

$app->get('/login', [UserController::class, 'afficherPageConnexion']);
$app->post('/login', [UserController::class, 'login']);

$app->get('/register', [UserController::class, 'afficherPageInscription']);
$app->post('/register', [UserController::class, 'register']);

$app->get('/logout', [UserController::class, 'logout']);

$app->get('/discussion/add', [DiscussionController::class, 'ajouterDiscussion']);
$app->post('/discussion/add', [DiscussionController::class, 'verifierAjout']);

$app->get('/discussion/{idDiscussion}', [DiscussionController::class, 'afficherPageMessage']);
$app->post('/discussion/{idDiscussion}', [DiscussionController::class, 'ajouterMessage']);

$app->get('/publication/add', [PublicationController::class, 'afficherPageAjoutPublication']);
$app->post('/publication/add', [PublicationController::class, 'verifierPageAjoutPublication']);

$app->get('/profil', [UserController::class, 'afficherProfil']);
$app->get('/profil/edit', [UserController::class, 'afficherEditionProfil']);
$app->post('/profil/edit', [UserController::class, 'updateProfil']);