<?php

namespace ClickClack\ClickClack\Model;

use ClickClack\ClickClack\Tool\Database;

class Message
{
    public int $idMessage;
    public string $text;
    public int $idDiscussion;
    public string $pseudoCreateur;
    
    public function __construct(int $idMessage, string $text, int $idDiscussion, string $pseudoCreateur)
    {
        $this->idMessage = $idMessage;
        $this->text = $text;
        $this->idDiscussion = $idDiscussion;
        $this->pseudoCreateur = $pseudoCreateur;
    }

        public static function selectAll(int $idDiscussion)
    {
        $sql = "SELECT m.idMessage, m.text, m.idDiscussion, m.idUtilisateur, u.pseudo  FROM Message m JOIN Utilisateur u ON u.idUtilisateur = m.idUtilisateur WHERE m.idDiscussion = :idDiscussion ORDER BY m.idMessage ASC;";
        $param = [":idDiscussion"=> $idDiscussion];
        $dataMessages = Database::run($sql, $param)->fetchAll();
        $result = [];

        foreach ($dataMessages as $key => $message) {
            array_push($result, new Message($message["idMessage"], $message["text"], $message["idDiscussion"], $message["pseudo"]));
        }

        return $result;
    }

        public static function add(string $text, int $idDiscussion,int $idUtilisateur,){
        $sql = "INSERT INTO Message(text, idDiscussion ,idUtilisateur) VALUE(:text, :idDiscussion, :idCreateur)";
        $param = [
            ":text"=>$text,
            ":idDiscussion" => $idDiscussion,
            ":idCreateur" => $idUtilisateur,
        ];
        
        $dataMessages = Database::run($sql, $param);
    }
        
}