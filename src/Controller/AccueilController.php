<?php
namespace Raphaelahmn\ClickClack\Controller;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use DateTime;
use Slim\Views\PhpRenderer;

class AccueilController
{
    //Affiche l'accueil
    public function afficherPagePrincipale(Request $request, Response $response, array $args): Response
    {
        $renderer = new PhpRenderer("../view");
        $renderer->setLayout("layout.php");
        
        return $renderer->render($response, 'index.php', []);

    }
}