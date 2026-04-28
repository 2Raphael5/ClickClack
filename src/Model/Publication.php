<?php

namespace ClickClack\ClickClack\Model;

use ClickClack\ClickClack\Tool\Database;

class Publication
{
    public int $idPublication;
    public string $img;
    public ?string $text;
    public int $idUtilisateur;
    public ?string $pseudoUtilisateur;

    public function __construct(int $idPublication, string $img, ?string $text, int $idUtilisateur, ?string $pseudoUtilisateur)
    {
        $this->idPublication = $idPublication;
        $this->img = $img;
        $this->text = $text;
        $this->idUtilisateur = $idUtilisateur;
        $this->pseudoUtilisateur = $pseudoUtilisateur;
    }

    public static function addPublication(string $img, string $text)
    {
        $sql = "INSERT INTO Publication(image, text, idUtilisateur) VALUE(:image, :text, :idUtilisateur)";
        $param = [
            ":image" => $img,
            ":text" => $text,
            ":idUtilisateur" => $_SESSION["User"]["idUtilisateur"],
        ];
        Database::run($sql, $param);
    }

    public static function getAllPublication()
    {
        $sql = "SELECT 
                p.idPublication, 
                p.image, 
                p.text, 
                p.idUtilisateur,
                u.pseudo AS pseudoUtilisateur
            FROM Publication p
            INNER JOIN Utilisateur u 
                ON p.idUtilisateur = u.idUtilisateur";

        $data = Database::run($sql)->fetchAll();
        $result = [];

        foreach ($data as $publication) {
            $result[] = new Publication((int) $publication["idPublication"], $publication["image"], $publication["text"], (int) $publication["idUtilisateur"], $publication["pseudoUtilisateur"]);
        }

        return $result;
    }

    public static function deletePublication(int $id)
    {
        $sql = "DELETE FROM Publication WHERE idPublication = :id";
        $param = [
            ":id" => $id
        ];
        Database::run($sql, $param);
    }

    public static function getById(int $id)
    {
        $sql = "SELECT idPublication, image, text, idUtilisateur FROM Publication WHERE idPublication = :id";
        $param = [
            ":id" => $id,
        ];
        $publication = Database::run($sql, $param)->fetch();

        return new Publication($publication["idPublication"], $publication["image"], $publication["text"], $publication["idUtilisateur"], null);
    }
}