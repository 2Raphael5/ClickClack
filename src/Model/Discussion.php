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

    public static function selectAll()
    {
        $sql = "SELECT d.idDiscussion, d.titre, u.pseudo ,d.idUtilisateur FROM Discussion d JOIN Utilisateur u on u.idUtilisateur  = d.idUtilisateur";
        $dataDiscussions = Database::run($sql)->fetchAll();

        $result = [];

        foreach ($dataDiscussions as $key => $dataDiscussion) {
            array_push($result, new Discussion($dataDiscussion["idDiscussion"], $dataDiscussion["titre"], $dataDiscussion["pseudo"], $dataDiscussion["idUtilisateur"]));
        }

        return $result;
    }
}