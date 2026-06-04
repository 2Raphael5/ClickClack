<?php

namespace ClickClack\ClickClack\Model;

use ClickClack\ClickClack\Tool\Database;

class Aime
{
    /**
     * isLiked - Vérifie si une publication est likée par un utilisateur
     * @param int $idUtilisateur
     * @param int $idPublication
     * @return bool
     */
    public static function isLiked(int $idUtilisateur, int $idPublication): bool
    {
        $sql = "SELECT 1 FROM Aime WHERE idUtilisateur = :u AND idPublication = :p";
        $param = [
            ":u" => $idUtilisateur,
            ":p" => $idPublication
        ];

        return (bool) Database::run($sql, $param)->fetch();
    }

    /**
     * like - Ajoute un like sur une publication
     * @param int $idUtilisateur
     * @param int $idPublication
     * @return void
     */
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

    /**
     * unlike - Supprime un like sur une publication
     * @param int $idUtilisateur
     * @param int $idPublication
     * @return void
     */
    public static function unlike(int $idUtilisateur, int $idPublication): void
    {
        $sql = "DELETE FROM Aime WHERE idUtilisateur = :u AND idPublication = :p";
        $param = [
            ":u" => $idUtilisateur,
            ":p" => $idPublication
        ];

        Database::run($sql, $param);
    }

    /**
     * toggle - Ajoute ou supprime un like selon son état actuel
     * @param int $idUtilisateur
     * @param int $idPublication
     * @return void
     */
    public static function toggle(int $idUtilisateur, int $idPublication): void
    {
        if (self::isLiked($idUtilisateur, $idPublication)) {
            self::unlike($idUtilisateur, $idPublication);
        } else {
            self::like($idUtilisateur, $idPublication);
        }
    }

    /**
     * countByPublication - Retourne le nombre de likes d'une publication
     * @param int $idPublication
     * @return int
     */
    public static function countByPublication(int $idPublication): int
    {
        $sql = "SELECT COUNT(*) as total FROM Aime WHERE idPublication = :p";
        $param = [":p" => $idPublication];

        return (int) Database::run($sql, $param)->fetch()["total"];
    }
}