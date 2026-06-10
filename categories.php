<?php
/**
 * controllers/categories.php
 * Contrôleur — gestion CRUD des catégories
 */
session_start();
require_once __DIR__ . '/../models/Categorie.php';

$categorieModel = new Categorie();
$action = $_POST['action'] ?? $_GET['action'] ?? '';
$id     = isset($_GET['id']) ? (int)$_GET['id'] : 0;

switch ($action) {
    case 'creer':
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty(trim($_POST['nom'] ?? ''))) {
            $categorieModel->create($_POST);
            $_SESSION['succes'] = "📁 Catégorie ajoutée !";
        }
        break;
    case 'supprimer':
        if ($id) {
            $categorieModel->delete($id);
            $_SESSION['succes'] = "📁 Catégorie supprimée.";
        }
        break;
}

header('Location: ../index.php');
exit;
