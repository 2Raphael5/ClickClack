<?php
namespace ClickClack\ClickClack\Controller;
use ClickClack\ClickClack\Model\Message;
use ClickClack\ClickClack\Model\User;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use DateTime;
use Slim\Views\PhpRenderer;
use ClickClack\ClickClack\Model\Discussion;

class DiscussionController
{
    /**
     * Affiche la page principale des discussions
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function afficherPagePrincipale(Request $request, Response $response, array $args): Response
    {
        $renderer = new PhpRenderer("../view");
        $renderer->setLayout("layout.php");
        $privee = [];
        if (!empty($_SESSION["User"])) {
            $privee = Discussion::selectAllAutorizePrivate($_SESSION["User"]["idUtilisateur"]);
        }
        $public = Discussion::selectAllPublic();
        $data = [
            "discussionsPublic" => $public,
            "discussionsPrivate" => $privee,
        ];
        return $renderer->render($response, 'discussions.php', $data);

    }

    /**
     * Vérifie l'accès à la page d'ajout de discussion
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function verifierDiscussion(Request $request, Response $response, array $args): Response
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

    /**
     * Affiche la page d'ajout d'une discussion
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
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

    /**
     * Vérifie les données et ajoute une discussion
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
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
        $isPrivate = 0;
        if (!empty($data['isPrivate'])) {
            $isPrivate = 1;
        }
        Discussion::add($title, $isPrivate);
        return $response
            ->withHeader("Location", "/discussion")
            ->withStatus(302);
    }

    /**
     * Affiche les messages d'une discussion
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function afficherPageMessage(Request $request, Response $response, array $args): Response
    {
        $renderer = new PhpRenderer("../view");
        $renderer->setLayout("layout.php");
        $data = [];
        $publics = Discussion::selectAllPublic();

        $isGood = false;
        foreach ($publics as $key => $public) {
            if ($public->idDiscussion == $args["idDiscussion"]) {
                $isGood = true;
            }
        }

        if (!$isGood && !empty($_SESSION["User"]["idUtilisateur"])) {
            $connections = Discussion::selectConnection();
            foreach ($connections as $key => $connection) {
                if ($connection["idUtilisateur"] == $_SESSION["User"]["idUtilisateur"] && $connection["idDiscussion"] == $args["idDiscussion"]) {
                    $isGood = true;
                }
            }
        }
        if (intval($args["idDiscussion"]) != 0 && $isGood) {
            $messages = Message::selectAll(intval($args["idDiscussion"]));
            $discussion = Discussion::selectById(intval($args["idDiscussion"]));

            $data = [
                "messages" => $messages,
                "discussion" => $discussion,
            ];
        } else {
            return $response
                ->withHeader("Location", "/discussion")
                ->withStatus(302);
        }
        return $renderer->render($response, 'message.php', $data);
    }

    /**
     * Ajoute un message dans une discussion
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function ajouterMessage(Request $request, Response $response, array $args): Response
    {
        $renderer = new PhpRenderer("../view");
        $renderer->setLayout("layout.php");
        $data = [];
        if (empty($_SESSION["User"]) || $_SESSION["User"] == false) {
            return $response
                ->withHeader("Location", "/discussion/" . $args["idDiscussion"])
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

    /**
     * Affiche la page de recherche d'utilisateurs
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function afficherPageRecherchePersonne(Request $request, Response $response, array $args): Response
    {
        $renderer = new PhpRenderer("../view");
        $renderer->setLayout("layout.php");
        $data = [
            "users" => User::selectAll(),
            "discussion" => $args["idDiscussion"]
        ];
        return $renderer->render($response, 'searchUser.php', $data);
    }

    /**
     * Ajoute une discussion privée
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function ajouterDiscussionPerso(Request $request, Response $response, array $args): Response
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
        $isPrivate = 0;
        if ($data['isPrivate'] != null) {
            $isPrivate = 1;
        }

        Discussion::add($title, $isPrivate);
        return $response
            ->withHeader("Location", "/discussion")
            ->withStatus(302);

    }

    /**
     * Ajoute un utilisateur à une discussion
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function verifierAjoutPersonne(Request $request, Response $response, array $args): Response
    {
        $renderer = new PhpRenderer("../view");
        $renderer->setLayout("layout.php");

        if (intval($args["idDiscussion"]) != 0 && intval($args["idUtilisateur"]) != 0) {
            Discussion::addConnection(intval($args["idDiscussion"]), intval($args["idUtilisateur"]));
        }

        return $response
            ->withHeader("Location", "/discussion")
            ->withStatus(302);
    }
}