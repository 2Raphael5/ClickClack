<?php
namespace ClickClack\ClickClack\Controller;
use ClickClack\ClickClack\Model\Publication;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use ClickClack\ClickClack\Model\User;
use DateTime;
use Slim\Views\PhpRenderer;
use ClickClack\ClickClack\Model\Aime;

class AccueilController
{
    //Affiche l'accueil
    public function afficherPagePrincipale(Request $request, Response $response, array $args): Response
    {
        $renderer = new PhpRenderer("../view");
        $renderer->setLayout("layout.php");
        $data = [
            "publications" => Publication::getAllPublication(),
        ];

        return $renderer->render($response, 'index.php', $data);
    }

    public function like(Request $request, Response $response, array $args): Response
    {
        if (!isset($_SESSION["User"])) {
            return $response->withHeader("Location", "/login")->withStatus(302);
        }

        $idPublication = $args["id"];
        $idUtilisateur = $_SESSION["User"]["idUtilisateur"];

        Aime::toggle($idUtilisateur, $idPublication);

        return $response
            ->withHeader("Location", "/")
            ->withStatus(302);
    }
}