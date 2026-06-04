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
     * create - Crée un utilisateur dans la base de données
     * @param string $pseudo
     * @param string $motDePasse
     * @param string $photoProfile
     * @return int
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
     * selectAll - Sélectionne tous les utilisateurs
     * @return array
     */
    public static function selectAll()
    {
        $sql = "SELECT idUtilisateur, pseudo, motDePasse, photoProfile FROM Utilisateur";
        return Database::run($sql)->fetchAll();
    }

    /**
     * selectAllNotInPrivate - Sélectionne tous les utilisateurs n'étant pas dans la discussion
     * @param int $id
     * @return array
     */
    public static function selectAllNotInPrivate(int $id)
    {
        $sql = "SELECT u.idUtilisateur, u.pseudo, u.motDePasse, u.photoProfile 
                FROM Utilisateur u
                WHERE u.idUtilisateur NOT IN (
                    SELECT d.idUtilisateur
                    FROM Discussion_Utilisateur d
                    WHERE d.idDiscussion = :id
                );";
        $param = [
            "id" => $id,
        ];
        return Database::run($sql, $param)->fetchAll();
    }

    /**
     * findByPseudo - Recherche un utilisateur par pseudo
     * @param string $pseudo
     * @return User|false
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
     * findById - Recherche un utilisateur par ID
     * @param int $idUtilisateur
     * @return User|false
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
     * createPublication - Crée une publication
     * @param string $image
     * @param string|null $text
     * @return void
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
     * createMessage - Crée un message
     * @param string $text
     * @param int $idDiscussion
     * @return void
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
     * createDiscussion - Crée une discussion
     * @param string $titre
     * @return void
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
     * login - Connecte un utilisateur (pseudo et mot de passe)
     * @param string $pseudo
     * @param string $motDePasse
     * @return User|false
     */
    public static function login(string $pseudo, string $motDePasse): User|false
    {
        $sql = "SELECT idUtilisateur, pseudo, motDePasse, photoProfile
            FROM Utilisateur
            WHERE pseudo = :pseudo;
            ";

        $params = [":pseudo" => $pseudo];
        $data = Database::run($sql, $params)->fetch();

        if ($data === false) {
            return false;
        }

        if (!password_verify($motDePasse, $data["motDePasse"])) {
            return false;
        }

        return new User(
            $data["idUtilisateur"],
            $data["pseudo"],
            $data["motDePasse"],
            $data["photoProfile"]
        );
    }

    /**
     * update - Modifie un utilisateur (pseudo, mot de passe, image)
     * @param string $pseudo
     * @param string|null $motDePasse
     * @param string $photoProfile
     * @return void
     */
    public function update(string $pseudo, ?string $motDePasse, string $photoProfile): void
    {
        if ($motDePasse === null || $motDePasse === '') {
            $sql = "UPDATE Utilisateur
                    SET pseudo = :pseudo,
                        photoProfile = :photoProfile
                    WHERE idUtilisateur = :idUtilisateur";

            $params = [
                ':pseudo' => $pseudo,
                ':photoProfile' => $photoProfile,
                ':idUtilisateur' => $this->idUtilisateur,
            ];
        } else {
            $sql = "UPDATE Utilisateur
                    SET pseudo = :pseudo,
                        motDePasse = :motDePasse,
                        photoProfile = :photoProfile
                    WHERE idUtilisateur = :idUtilisateur";

            $params = [
                ':pseudo' => $pseudo,
                ':motDePasse' => password_hash($motDePasse, PASSWORD_DEFAULT),
                ':photoProfile' => $photoProfile,
                ':idUtilisateur' => $this->idUtilisateur,
            ];
        }

        Database::run($sql, $params);
    }
}