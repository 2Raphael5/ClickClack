<?php

namespace ClickClack\ClickClack\Model;

use ClickClack\ClickClack\Tool\Database;

class Publication
{
    public int $idPublication;
    public string $img;
    public ?string $text;
    public int $idUtilisateur;

    public function __construct(int $idPublication, string $img, ?string $text, int $idUtilisateur)
    {
        $this->idPublication = $idPublication;
        $this->img = $img;
        $this->text = $text;
        $this->idUtilisateur = $idUtilisateur;
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
        $sql = "SELECT idPublication, image, text, idUtilisateur FROM Publication";
        $data = Database::run($sql)->fetchAll();
        $result = [];

        foreach ($data as $key => $publication) {
            array_push($result, new Publication($publication["idPublication"], $publication["image"], $publication["text"], $publication["idUtilisateur"]));
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

        return new Publication($publication["idPublication"], $publication["image"], $publication["text"], $publication["idUtilisateur"]);
    }
}