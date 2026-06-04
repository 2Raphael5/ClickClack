<?php

namespace ClickClack\ClickClack\Model;

use ClickClack\ClickClack\Tool\Database;

class Discussion
{
    public int $idDiscussion;
    public string $titre;
    public string $nomUtilisateur;
    public int $idUtilisateur;

    public function __construct(int $idDiscussion, string $titre, string $nomUtilisateur, int $idUtilisateur)
    {
        $this->idDiscussion = $idDiscussion;
        $this->titre = $titre;
        $this->nomUtilisateur = $nomUtilisateur;
        $this->idUtilisateur = $idUtilisateur;
    }

    /**
     * selectAllPublic - Sélectionne toutes les discussions publiques
     * @return array
     */
    public static function selectAllPublic()
    {
        $sql = "SELECT d.idDiscussion, d.titre, d.isPrivate, u.pseudo ,d.idUtilisateur FROM Discussion d JOIN Utilisateur u on u.idUtilisateur  = d.idUtilisateur AND d.isPrivate = 0";
        $dataDiscussions = Database::run($sql)->fetchAll();

        $result = [];

        foreach ($dataDiscussions as $key => $dataDiscussion) {
            array_push($result, new Discussion($dataDiscussion["idDiscussion"], $dataDiscussion["titre"], $dataDiscussion["pseudo"], $dataDiscussion["idUtilisateur"]));
        }

        return $result;
    }

    /**
     * selectAllAutorizePrivate - Sélectionne toutes les discussions privées accessibles par un utilisateur
     * @param int $id
     * @return array
     */
    public static function selectAllAutorizePrivate(int $id)
    {
        $sql = "SELECT d.idDiscussion, d.titre, d.isPrivate, u.pseudo, d.idUtilisateur, du.idUtilisateur as duUser
FROM Discussion d 
LEFT JOIN Utilisateur u ON u.idUtilisateur = d.idUtilisateur
INNER JOIN Discussion_Utilisateur du ON du.idDiscussion = d.idDiscussion 
    AND du.idUtilisateur = :id
WHERE d.isPrivate = 1";
        $param = [
            ":id" => $id
        ];

        $dataDiscussions = Database::run($sql, $param)->fetchAll();

        $result = [];

        foreach ($dataDiscussions as $key => $dataDiscussion) {
            array_push($result, new Discussion($dataDiscussion["idDiscussion"], $dataDiscussion["titre"], $dataDiscussion["pseudo"], $dataDiscussion["idUtilisateur"]));
        }

        return $result;
    }

    /**
     * add - Ajoute une discussion et l'associe à l'utilisateur si elle est privée
     * @param string $title
     * @param int $isPrivate
     * @return void
     */
    public static function add(string $title, int $isPrivate)
    {
        $sql = "INSERT INTO Discussion(titre, idUtilisateur, isPrivate) VALUE(:title, :idCreateur, :isPrivate)";
        $param = [
            ":title" => $title,
            ":idCreateur" => $_SESSION["User"]["idUtilisateur"],
            ":isPrivate" => $isPrivate,
        ];
        Database::run($sql, $param);

        if ($isPrivate == 1) {
            $sql = "INSERT INTO Discussion_Utilisateur (idDiscussion, idUtilisateur) SELECT :idDiscussion, :idUtilisateur WHERE NOT EXISTS (SELECT 1 FROM Discussion_Utilisateur WHERE idDiscussion = :idDiscussion2 AND idUtilisateur = :idUtilisateur2)";
            $param = [
                ":idDiscussion" =>intval(Database::lastInsertId()),
                ":idUtilisateur" => $_SESSION["User"]["idUtilisateur"],
                ":idDiscussion2" =>intval(Database::lastInsertId()),
                ":idUtilisateur2" => $_SESSION["User"]["idUtilisateur"],
            ];
            Database::run($sql, $param);
        }
    }

    /**
     * addConnection - Ajoute un utilisateur dans une discussion privée s'il n'y est pas déjà
     * @param int $idDiscussion
     * @param int $idUtilisateur
     * @return void
     */
    public static function addConnection(int $idDiscussion, int $idUtilisateur)
    {
        $sql = "INSERT INTO Discussion_Utilisateur (idDiscussion, idUtilisateur) SELECT :idDiscussion, :idUtilisateur WHERE NOT EXISTS (SELECT 1 FROM Discussion_Utilisateur WHERE idDiscussion = :idDiscussion2 AND idUtilisateur = :idUtilisateur2)";
        $param = [
            ":idDiscussion" => $idDiscussion,
            ":idUtilisateur" => $idUtilisateur,
            ":idDiscussion2" => $idDiscussion,
            ":idUtilisateur2" => $idUtilisateur,
        ];
        Database::run($sql, $param);
    }

    /**
     * selectById - Sélectionne une discussion par son ID
     * @param int $id
     * @return Discussion
     */
    public static function selectById(int $id)
    {
        $sql = "SELECT d.idDiscussion, d.titre, d.idUtilisateur FROM Discussion d WHERE d.idDiscussion = :id";
        $param = [
            ":id" => $id,
        ];

        $result = Database::run($sql, $param)->fetch();
        return new Discussion($result["idDiscussion"], $result["titre"], "", $result["idUtilisateur"]);
    }

    /**
     * selectConnection - Sélectionne toutes les associations discussion-utilisateur
     * @return array
     */
    public static function selectConnection()
    {
        $sql = "SELECT idDiscussion, idUtilisateur FROM Discussion_Utilisateur";
        return Database::run($sql)->fetchAll();
    }
}