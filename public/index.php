<?php
namespace Raphaelahmn\Jardinier;
use Slim\Factory\AppFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
require '../vendor/autoload.php';

$app = AppFactory::create();
$app->addErrorMiddleware(true, true, true);

require '../route/web.php';
$app->run();
