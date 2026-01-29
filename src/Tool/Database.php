<?php
namespace Raphaelahmn\Jardinier\Tool;
require_once "data.php";
class Database
{
    private static ?\PDO $pdo = null;
    // Empêche l'instanciation (pattern Singleton)
    private function __construct() {}
    /**
     * Retourne une instance PDO (connexion unique)
     */
    public static function db(): \PDO
    {
        if (self::$pdo === null) {
            try {
                self::$pdo = new \PDO(
                    "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
                    DB_USER,
                    DB_PASSWORD,
                    [
                        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                        \PDO::ATTR_EMULATE_PREPARES => false,
                    ]
                );
            } catch (\PDOException $e) {
                die("Erreur de connexion : " . $e->getMessage());
            }
        }
        return self::$pdo;
    }
    /**
     * Méthode utilitaire pour exécuter une requête préparée
     */
    public static function run(string $sql, array $params = []): \PDOStatement
    {
        $stmt = self::db()->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
}
