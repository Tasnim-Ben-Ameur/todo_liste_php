<?php
/**
 * Model/Tache.php
 * Gestion des tâches - Opérations CRUD
 */
require_once __DIR__ . '/Database.php';

class Tache {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance()->getPDO();
    }

    // ─── READ ───────────────────────────────────────────────────────────────

    /** Récupère toutes les tâches avec le nom de leur catégorie */
    public function getAll(string $filtre = 'tous', string $priorite = 'tous'): array {
        $sql = "SELECT t.*, c.nom AS categorie_nom, c.couleur AS categorie_couleur
                FROM taches t
                LEFT JOIN categories c ON t.categorie_id = c.id
                WHERE 1=1";
        $params = [];

        if ($filtre !== 'tous') {
            $sql .= " AND t.statut = :statut";
            $params[':statut'] = $filtre;
        }
        if ($priorite !== 'tous') {
            $sql .= " AND t.priorite = :priorite";
            $params[':priorite'] = $priorite;
        }

        $sql .= " ORDER BY FIELD(t.priorite,'haute','normale','basse'), t.date_echeance ASC, t.id DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /** Récupère une tâche par son ID */
    public function getById(int $id): array|false {
        $stmt = $this->pdo->prepare(
            "SELECT t.*, c.nom AS categorie_nom
             FROM taches t LEFT JOIN categories c ON t.categorie_id = c.id
             WHERE t.id = :id"
        );
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    /** Statistiques pour le tableau de bord */
    public function getStats(): array {
        $stmt = $this->pdo->query(
            "SELECT
                COUNT(*) AS total,
                SUM(statut = 'terminee') AS terminees,
                SUM(statut = 'en_cours') AS en_cours,
                SUM(statut = 'en_attente') AS en_attente,
                SUM(priorite = 'haute' AND statut != 'terminee') AS urgentes
             FROM taches"
        );
        return $stmt->fetch();
    }

    // ─── CREATE ─────────────────────────────────────────────────────────────

    /** Ajoute une nouvelle tâche */
    public function create(array $data): bool {
        $stmt = $this->pdo->prepare(
            "INSERT INTO taches (titre, description, statut, priorite, categorie_id, date_echeance)
             VALUES (:titre, :description, :statut, :priorite, :categorie_id, :date_echeance)"
        );
        return $stmt->execute([
            ':titre'        => trim($data['titre']),
            ':description'  => trim($data['description'] ?? ''),
            ':statut'       => $data['statut'] ?? 'en_attente',
            ':priorite'     => $data['priorite'] ?? 'normale',
            ':categorie_id' => !empty($data['categorie_id']) ? (int)$data['categorie_id'] : null,
            ':date_echeance'=> !empty($data['date_echeance']) ? $data['date_echeance'] : null,
        ]);
    }

    // ─── UPDATE ─────────────────────────────────────────────────────────────

    /** Modifie une tâche existante */
    public function update(int $id, array $data): bool {
        $stmt = $this->pdo->prepare(
            "UPDATE taches SET
                titre        = :titre,
                description  = :description,
                statut       = :statut,
                priorite     = :priorite,
                categorie_id = :categorie_id,
                date_echeance= :date_echeance
             WHERE id = :id"
        );
        return $stmt->execute([
            ':id'           => $id,
            ':titre'        => trim($data['titre']),
            ':description'  => trim($data['description'] ?? ''),
            ':statut'       => $data['statut'],
            ':priorite'     => $data['priorite'],
            ':categorie_id' => !empty($data['categorie_id']) ? (int)$data['categorie_id'] : null,
            ':date_echeance'=> !empty($data['date_echeance']) ? $data['date_echeance'] : null,
        ]);
    }

    /** Change uniquement le statut d'une tâche (toggle rapide) */
    public function updateStatut(int $id, string $statut): bool {
        $stmt = $this->pdo->prepare("UPDATE taches SET statut = :statut WHERE id = :id");
        return $stmt->execute([':statut' => $statut, ':id' => $id]);
    }

    // ─── DELETE ─────────────────────────────────────────────────────────────

    /** Supprime une tâche */
    public function delete(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM taches WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
