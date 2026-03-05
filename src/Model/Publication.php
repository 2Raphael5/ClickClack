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

    public function addPublication(string $img, string $text, int $idUtilisateur)
    {
        $sql = "INSERT INTO Message(image, text, idUtilisateur) VALUE(:image, :text, :idUtilisateur)";
        $param = [
            ":img" => $img,
            ":text" => $text,
            ":idUtilisateur" => $idUtilisateur,
        ];
        Database::run($sql, $param);
    }
}