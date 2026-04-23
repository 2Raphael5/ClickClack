<?php
namespace ClickClack\ClickClack\Controller;
use ClickClack\ClickClack\Model\Message;
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
        $data = [
            "discussions" => Discussion::selectAll()
        ];
        return $renderer->render($response, 'discussions.php', $data);

    }

    public function verifierDiscussion(Request $request, Response $response, array $args): Response
    {
        $renderer = new PhpRenderer("../view");
        $renderer->setLayout("layout.php");

        if (empty($_SESSION["User"]) || $_SESSION["User"] == false) {
            return $response
                ->withHeader("Location", "/")
                ->withStatus(302);
        } else {
            var_dump($_SESSION["User"]);
        }
        return $renderer->render($response, 'ajoutDiscussion.php', []);

    }
    public function ajouterDiscussion(Request $request, Response $response, array $args): Response
    {
        $renderer = new PhpRenderer("../view");
        $renderer->setLayout("layout.php");
        if (empty($_SESSION["User"]) || $_SESSION["User"] == false) {
            return $response
                ->withHeader("Location", "/")
                ->withStatus(302);
        }
        return $renderer->render($response, 'ajoutDiscussion.php', []);

    }
    public function verifierAjout(Request $request, Response $response, array $args): Response
    {
        $renderer = new PhpRenderer("../view");
        $renderer->setLayout("layout.php");

        if (empty($_SESSION["User"]) || $_SESSION["User"] == false) {
            return $response
                ->withHeader("Location", "/")
                ->withStatus(302);
        }
        $data = $request->getParsedBody();
        $title = $data['discussion'];
        Discussion::add($title);
        return $response
            ->withHeader("Location", "/discussion")
            ->withStatus(302);
    }
    public function afficherPageMessage(Request $request, Response $response, array $args): Response
    {
        $renderer = new PhpRenderer("../view");
        $renderer->setLayout("layout.php");
        $data = [];

        if (intval($args["idDiscussion"]) != 0) {
            $messages = Message::selectAll(intval($args["idDiscussion"]));
            $discussion = Discussion::selectById(intval($args["idDiscussion"]));

            $data = [
                "messages" => $messages,
                "discussion" => $discussion,
            ];
        } else {
            die();
        }
        return $renderer->render($response, 'message.php', $data);
    }

    public function ajouterMessage(Request $request, Response $response, array $args): Response
    {
        $renderer = new PhpRenderer("../view");
        $renderer->setLayout("layout.php");
        $data = [];
        if (empty($_SESSION["User"]) || $_SESSION["User"] == false) {
            return $response
                ->withHeader("Location", "/discussion/".$args["idDiscussion"])
                ->withStatus(302);
        }
        $message = filter_input(INPUT_POST, "messageText", FILTER_SANITIZE_SPECIAL_CHARS);
        if (intval($args["idDiscussion"]) != 0 && $message != "") {

            Message::add($message, intval($args["idDiscussion"]), $_SESSION["User"]["idUtilisateur"]);
        }
        return $response
            ->withHeader("Location", "/discussion/" . intval($args["idDiscussion"]))
            ->withStatus(302);
    }

}