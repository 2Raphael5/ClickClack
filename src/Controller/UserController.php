<?php
namespace ClickClack\ClickClack\Controller;

use ClickClack\ClickClack\Model\User;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\PhpRenderer;

class UserController
{
    // Afficher page de connexion
    public function afficherPageConnexion(Request $request, Response $response, array $args): Response
    {
        $renderer = new PhpRenderer("../view");
        $renderer->setLayout("layout.php");

        return $renderer->render($response, 'login.php', [
            'error' => $_SESSION['error_login'] ?? null
        ]);
    }

    // Afficher page d'inscription
    public function afficherPageInscription(Request $request, Response $response, array $args): Response
    {
        $renderer = new PhpRenderer("../view");
        $renderer->setLayout("layout.php");

        return $renderer->render($response, 'register.php', [
            'error' => $_SESSION['error_register'] ?? null
        ]);
    }

    // POST d'inscription
    public function register(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();
        $pseudo = trim($data['pseudo'] ?? '');
        $motDePasse = trim($data['motDePasse'] ?? '');
        $photoProfile = trim($data['photoProfile'] ?? '');

        if ($pseudo === '' || $motDePasse === '' || $photoProfile === '') {
            $_SESSION['error_register'] = "Tous les champs sont obligatoires.";
            return $response
                ->withHeader('Location', '/register')
                ->withStatus(302);
        }

        // Vérification pseudo existant
        if (User::findByPseudo($pseudo) !== false) {
            $_SESSION['error_register'] = "Ce pseudo est déjà utilisé.";
            return $response
                ->withHeader('Location', '/register')
                ->withStatus(302);
        }

        // Création de l’utilisateur
        User::create($pseudo, $motDePasse, $photoProfile);

        // Redirection vers connexion
        return $response
            ->withHeader('Location', '/login')
            ->withStatus(302);
    }

    // POST de connexion
    public function login(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();
        $pseudo = trim($data['pseudo'] ?? '');
        $motDePasse = trim($data['motDePasse'] ?? '');

        if ($pseudo === '' || $motDePasse === '') {
            $_SESSION['error_login'] = "Pseudo et mot de passe sont obligatoires.";
            return $response
                ->withHeader('Location', '/login')
                ->withStatus(302);
        }
        $user = User::login($pseudo, $motDePasse);
        if ($user === false) {
            $_SESSION['error_login'] = "Identifiants incorrects.";
            return $response
                ->withHeader('Location', '/login')
                ->withStatus(302);
        }

        // Enregistrer infos utilisateur
        $_SESSION['User'] = [
            'idUtilisateur' => $user->idUtilisateur,
            'pseudo' => $user->pseudo,
            'motDePasse' => $user->motDePasse,
            'photoProfile' => $user->photoProfile,
        ];
        // Rediriger vers l’accueil
        return $response
            ->withHeader('Location', '/')
            ->withStatus(302);
    }

    // Déconnexion
    public function logout(Request $request, Response $response, array $args): Response
    {
        session_destroy();

        return $response->withHeader('Location', '/login')->withStatus(302);
    }

    // Voir profil
    public function afficherProfil(Request $request, Response $response, array $args): Response
    {
        if (empty($_SESSION['User'])) {
            return $response->withHeader('Location', '/login')->withStatus(302);
        }

        $renderer = new PhpRenderer("../view");
        $renderer->setLayout("layout.php");

        $user = User::findById((int) $_SESSION['User']['idUtilisateur']);

        return $renderer->render($response, 'profil.php', [
            'user' => $user,
        ]);
    }

    // Formulaire de modification
    public function afficherEditionProfil(Request $request, Response $response, array $args): Response
    {
        if (empty($_SESSION['User'])) {
            return $response->withHeader('Location', '/login')->withStatus(302);
        }

        $renderer = new PhpRenderer("../view");
        $renderer->setLayout("layout.php");

        $user = User::findById((int) $_SESSION['User']['idUtilisateur']);

        return $renderer->render($response, 'profil_edit.php', [
            'user' => $user,
            'error' => $_SESSION['error_profil'] ?? null
        ]);
    }

    // Modification profil
    public function updateProfil(Request $request, Response $response, array $args): Response
    {
        if (empty($_SESSION['User'])) {
            return $response->withHeader('Location', '/login')->withStatus(302);
        }

        $data = $request->getParsedBody();
        $pseudo = trim($data['pseudo'] ?? '');
        $motDePasse = trim($data['motDePasse'] ?? ''); // optionnel
        $photoProfile = trim($data['photoProfile'] ?? '');

        if ($pseudo === '' || $photoProfile === '') {
            $_SESSION['error_profil'] = "Pseudo et photo de profil sont obligatoires.";
            return $response->withHeader('Location', '/profil/edit')->withStatus(302);
        }

        $idUtilisateur = (int) $_SESSION['User']['idUtilisateur'];
        $user = User::findById($idUtilisateur);

        if ($user === false) {
            $_SESSION['error_profil'] = "Utilisateur introuvable.";
            return $response->withHeader('Location', '/login')->withStatus(302);
        }

        // Vérifier unicité du pseudo
        $userAvecCePseudo = User::findByPseudo($pseudo);
        if ($userAvecCePseudo !== false && $userAvecCePseudo->idUtilisateur !== $idUtilisateur) {
            $_SESSION['error_profil'] = "Ce pseudo est déjà utilisé.";
            return $response->withHeader('Location', '/profil/edit')->withStatus(302);
        }

        $user->update($pseudo, $motDePasse === '' ? null : $motDePasse, $photoProfile);

        $_SESSION['User']['pseudo'] = $pseudo;
        $_SESSION['User']['photoProfile'] = $photoProfile;

        return $response->withHeader('Location', '/profil')->withStatus(302);
    }

}