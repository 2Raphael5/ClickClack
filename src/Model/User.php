<?php

namespace ClickClack\ClickClack\Model;

use ClickClack\ClickClack\Tool\Database;

class User
{
    public ?int $idUtilisateur = null;
    public ?string $pseudo = null;
    public ?string $motDePasse = null;
    public ?string $photoProfile = null;

    public function __construct(?int $idUtilisateurParam = null, ?string $pseudoParam = null, ?string $motDePasseParam = null, ?string $photoProfileParam = null)
    {
        $this->idUtilisateur = $idUtilisateurParam;
        $this->pseudo = $pseudoParam;
        $this->motDePasse = $motDePasseParam;
        $this->photoProfile = $photoProfileParam;
    }

    /**
     * Crée un utilisateur dans la base de données
     */
    public static function create(string $pseudo, string $motDePasse, string $photoProfile): int
    {
        $sql = "INSERT INTO Utilisateur (pseudo, motDePasse, photoProfile) 
            VALUES(:pseudo, :motDePasse, :photoProfile)";

        $params = [
            ":pseudo" => $pseudo,
            ":motDePasse" => password_hash($motDePasse, PASSWORD_DEFAULT),
            ":photoProfile" => $photoProfile,
        ];

        Database::run($sql, $params);
        return Database::db()->lastInsertId();
    }

    /**
     * Sélectionne tous les utilisateurs
     */
    public static function selectAll()
    {
        $sql = "SELECT idUtilisateur, pseudo, motDePasse, photoProfile FROM Utilisateur";
        return Database::run($sql)->fetchAll();
    }

    /**
     * Recherche un utilisateur par pseudo
     */
    public static function findByPseudo(string $pseudo): User|false
    {
        $sql = "SELECT idUtilisateur, pseudo, motDePasse, photoProfile
                FROM Utilisateur
                WHERE pseudo = :pseudo";

        $params = [":pseudo" => $pseudo];
        $data = Database::run($sql, $params)->fetch();

        if ($data !== false) {
            $user = new User();
            $user->idUtilisateur = $data["idUtilisateur"];
            $user->pseudo = $data["pseudo"];
            $user->motDePasse = $data["motDePasse"];
            $user->photoProfile = $data["photoProfile"];
            return $user;
        }

        return false;
    }

    /**
     * Recherche un utilisateur par ID
     */
    public static function findById(int $idUtilisateur): User|false
    {
        $sql = "SELECT idUtilisateur, pseudo, motDePasse, photoProfile
                FROM Utilisateur
                WHERE idUtilisateur = :idUtilisateur";

        $params = [":idUtilisateur" => $idUtilisateur];
        $data = Database::run($sql, $params)->fetch();

        if ($data !== false) {
            $user = new User();
            $user->idUtilisateur = $data["idUtilisateur"];
            $user->pseudo = $data["pseudo"];
            $user->motDePasse = $data["motDePasse"];
            $user->photoProfile = $data["photoProfile"];
            return $user;
        }

        return false;
    }

    /**
     * Crée une publication
     */
    public function createPublication(string $image, ?string $text = null)
    {
        $sql = "INSERT INTO Publication (image, text, idUtilisateur)
                VALUES(:image, :text, :idUtilisateur)";

        $params = [
            ":image" => $image,
            ":text" => $text,
            ":idUtilisateur" => $this->idUtilisateur,
        ];

        Database::run($sql, $params);
    }

    /**
     * Crée un message
     */
    public function createMessage(string $text, int $idDiscussion)
    {
        $sql = "INSERT INTO Message (text, idDiscussion, idUtilisateur)
                VALUES(:text, :idDiscussion, :idUtilisateur)";

        $params = [
            ":text" => $text,
            ":idDiscussion" => $idDiscussion,
            ":idUtilisateur" => $this->idUtilisateur,
        ];

        Database::run($sql, $params);
    }

    /**
     * Crée une discussion
     */
    public function createDiscussion(string $titre)
    {
        $sql = "INSERT INTO Discussion (titre, idUtilisateur)
                VALUES(:titre, :idUtilisateur)";

        $params = [
            ":titre" => $titre,
            ":idUtilisateur" => $this->idUtilisateur,
        ];

        Database::run($sql, $params);
    }

    /**
     * Connecte un utilisateur (pseudo et mot de passe)
     */
    public static function login(string $pseudo, string $motDePasse): User|false
    {
        $sql = "SELECT idUtilisateur, pseudo, motDePasse, photoProfile
            FROM Utilisateur
            WHERE pseudo = :pseudo";

        $params = [":pseudo" => $pseudo];
        $data = Database::run($sql, $params)->fetch();

        // Aucun utilisateur
        if ($data === false) {
            return false;
        }

        // Vérification du mot de passe
        if (!password_verify($motDePasse, $data["motDePasse"])) {
            return false;
        }

        // Création et retour de l'objet User
        return new User(
            $data["idUtilisateur"],
            $data["pseudo"],
            $data["motDePasse"],
            $data["photoProfile"]
        );
    }
}