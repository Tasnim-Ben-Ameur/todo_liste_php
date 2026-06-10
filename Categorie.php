<?php
/**
 * Model/Categorie.php
 * Gestion des catégories
 */
require_once __DIR__ . '/Database.php';

class Categorie {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance()->getPDO();
    }

    public function getAll(): array {
        $stmt = $this->pdo->query("SELECT * FROM categories ORDER BY nom ASC");
        return $stmt->fetchAll();
    }

    public function create(array $data): bool {
        $stmt = $this->pdo->prepare(
            "INSERT INTO categories (nom, couleur) VALUES (:nom, :couleur)"
        );
        return $stmt->execute([
            ':nom'     => trim($data['nom']),
            ':couleur' => $data['couleur'] ?? '#6C63FF',
        ]);
    }

    public function delete(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM categories WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
