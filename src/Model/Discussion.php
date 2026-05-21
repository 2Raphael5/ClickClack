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
    public static function selectById(int $id)
    {
        $sql = "SELECT d.idDiscussion, d.titre, d.idUtilisateur FROM Discussion d WHERE d.idDiscussion = :id";
        $param = [
            ":id" => $id,
        ];

        $result = Database::run($sql, $param)->fetch();
        return new Discussion($result["idDiscussion"], $result["titre"], "", $result["idUtilisateur"]);
    }

    public static function selectConnection(){
        $sql = "SELECT idDiscussion, idUtilisateur FROM Discussion_Utilisateur";
        return Database::run($sql)->fetchAll();
    }
}