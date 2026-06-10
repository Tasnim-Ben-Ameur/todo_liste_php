<?php
/**
 * Model/Database.php
 * Connexion à la base de données via PDO (Singleton)
 */
class Database {
    private static $instance = null;
    private $pdo;

    // ⚙️ Modifier ces paramètres selon votre configuration
    private $host     = 'localhost';
    private $dbname   = 'webtodo';
    private $username = 'root';
    private $password = '';
    private $charset  = 'utf8mb4';

    private function __construct() {
        $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset={$this->charset}";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        try {
            $this->pdo = new PDO($dsn, $this->username, $this->password, $options);
        } catch (PDOException $e) {
            die('<div style="font-family:monospace;color:red;padding:20px;">
                <strong>Erreur de connexion :</strong> ' . htmlspecialchars($e->getMessage()) . '
                <br><small>Vérifiez vos paramètres dans models/Database.php</small>
            </div>');
        }
    }

    public static function getInstance(): Database {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getPDO(): PDO {
        return $this->pdo;
    }
}
