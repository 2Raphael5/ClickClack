<?php

namespace ClickClack\ClickClack\Model;

use ClickClack\ClickClack\Tool\Database;

class Aime
{
    public static function isLiked(int $idUtilisateur, int $idPublication): bool
    {
        $sql = "SELECT 1 FROM Aime WHERE idUtilisateur = :u AND idPublication = :p";
        $param = [
            ":u" => $idUtilisateur,
            ":p" => $idPublication
        ];

        return (bool) Database::run($sql, $param)->fetch();
    }

    public static function like(int $idUtilisateur, int $idPublication): void
    {
        $sql = "INSERT IGNORE INTO Aime (idUtilisateur, idPublication)
                VALUES (:u, :p)";
        $param = [
            ":u" => $idUtilisateur,
            ":p" => $idPublication
        ];

        Database::run($sql, $param);
    }

    public static function unlike(int $idUtilisateur, int $idPublication): void
    {
        $sql = "DELETE FROM Aime WHERE idUtilisateur = :u AND idPublication = :p";
        $param = [
            ":u" => $idUtilisateur,
            ":p" => $idPublication
        ];

        Database::run($sql, $param);
    }

    public static function toggle(int $idUtilisateur, int $idPublication): void
    {
        if (self::isLiked($idUtilisateur, $idPublication)) {
            self::unlike($idUtilisateur, $idPublication);
        } else {
            self::like($idUtilisateur, $idPublication);
        }
    }

    public static function countByPublication(int $idPublication): int
    {
        $sql = "SELECT COUNT(*) as total FROM Aime WHERE idPublication = :p";
        $param = [":p" => $idPublication];

        return (int) Database::run($sql, $param)->fetch()["total"];
    }
}
