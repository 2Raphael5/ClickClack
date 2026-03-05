<?php
namespace ClickClack\ClickClack\Controller;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use ClickClack\ClickClack\Model\User;
use DateTime;
use Slim\Views\PhpRenderer;

class PublicationController
{
    //Affiche l'accueil
    public function afficherPageAjoutPublication(Request $request, Response $response, array $args): Response
    {
        $renderer = new PhpRenderer("../view");
        $renderer->setLayout("layout.php");
        return $renderer->render($response, 'index.php', []);
        
    }
}