<?php
namespace ClickClack\ClickClack\Controller;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use DateTime;
use Slim\Views\PhpRenderer;
use ClickClack\ClickClack\Model\Discussion;

class DiscussionController
{
    public function afficherPagePrincipale(Request $request, Response $response, array $args): Response
    {
        $renderer = new PhpRenderer("../view");
        $renderer->setLayout("layout.php");

        if (empty($_SESSION["User"]) || $_SESSION["User"] == false) {
            return $response
                ->withHeader("Location", "/")
                ->withStatus(302);
        }
        $data = [
            "discussions" => Discussion::selectAll()
        ];
        return $renderer->render($response, 'discussion.php', $data);
        
    }

    public function verifierDiscussion(Request $request, Response $response, array $args): Response
    {
        $renderer = new PhpRenderer("../view");
        $renderer->setLayout("layout.php");

        if (empty($_SESSION["User"]) || $_SESSION["User"] == false) {
            return $response
                ->withHeader("Location", "/")
                ->withStatus(302);
        }
        else {
            var_dump($_SESSION["User"]);
        }
        return $renderer->render($response, 'discussion.php', []);
        
    }
}