<?php
namespace ClickClack\ClickClack\Controller;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use ClickClack\ClickClack\Model\User;
use DateTime;
use Slim\Views\PhpRenderer;

class AccueilController
{
    //Affiche l'accueil
    public function afficherPagePrincipale(Request $request, Response $response, array $args): Response
    {
        $renderer = new PhpRenderer("../view");
        $renderer->setLayout("layout.php");
        $_SESSION["User"] = User::findById(1);

        var_dump($_SESSION["User"]);
        return $renderer->render($response, 'index.php', []);
        
    }
}