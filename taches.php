<?php
/**
 * controllers/taches.php
 * Contrôleur principal — gère toutes les actions CRUD sur les tâches
 */
session_start();
require_once __DIR__ . '/../models/Tache.php';
require_once __DIR__ . '/../models/Categorie.php';

$tacheModel    = new Tache();
$categorieModel = new Categorie();

// ─── Récupération de l'action demandée ──────────────────────────────────────
$action = $_POST['action'] ?? $_GET['action'] ?? 'liste';
$id     = isset($_GET['id']) ? (int)$_GET['id'] : (isset($_POST['id']) ? (int)$_POST['id'] : 0);

// ─── Dispatch des actions ───────────────────────────────────────────────────
switch ($action) {

    // ── CRÉER ────────────────────────────────────────────────────────────────
    case 'creer':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (empty(trim($_POST['titre'] ?? ''))) {
                $_SESSION['erreur'] = "Le titre est obligatoire.";
            } else {
                if ($tacheModel->create($_POST)) {
                    $_SESSION['succes'] = "✅ Tâche ajoutée avec succès !";
                } else {
                    $_SESSION['erreur'] = "Erreur lors de l'ajout.";
                }
            }
        }
        header('Location: ../index.php');
        exit;

    // ── MODIFIER ─────────────────────────────────────────────────────────────
    case 'modifier':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (empty(trim($_POST['titre'] ?? ''))) {
                $_SESSION['erreur'] = "Le titre est obligatoire.";
            } else {
                if ($tacheModel->update($id, $_POST)) {
                    $_SESSION['succes'] = "✏️ Tâche modifiée avec succès !";
                } else {
                    $_SESSION['erreur'] = "Erreur lors de la modification.";
                }
            }
            header('Location: ../index.php');
            exit;
        }
        // Afficher le formulaire de modification
        $tache      = $tacheModel->getById($id);
        $categories = $categorieModel->getAll();
        if (!$tache) {
            $_SESSION['erreur'] = "Tâche introuvable.";
            header('Location: ../index.php');
            exit;
        }
        require_once __DIR__ . '/../views/form_modifier.php';
        break;

    // ── CHANGER STATUT (toggle rapide) ───────────────────────────────────────
    case 'statut':
        if ($id && !empty($_POST['statut'])) {
            $tacheModel->updateStatut($id, $_POST['statut']);
        }
        header('Location: ../index.php');
        exit;

    // ── SUPPRIMER ────────────────────────────────────────────────────────────
    case 'supprimer':
        if ($id) {
            if ($tacheModel->delete($id)) {
                $_SESSION['succes'] = "🗑️ Tâche supprimée.";
            } else {
                $_SESSION['erreur'] = "Erreur lors de la suppression.";
            }
        }
        header('Location: ../index.php');
        exit;

    // ── LISTE (défaut) ───────────────────────────────────────────────────────
    default:
        header('Location: ../index.php');
        exit;
}
