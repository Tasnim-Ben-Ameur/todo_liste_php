<?php
/**
 * index.php — Point d'entrée de l'application WebTodo
 * Architecture MVC : charge les modèles et affiche la vue principale
 */
session_start();
require_once __DIR__ . '/models/Tache.php';
require_once __DIR__ . '/models/Categorie.php';

$tacheModel     = new Tache();
$categorieModel = new Categorie();

// Récupération des filtres depuis l'URL
$filtreStatut  = $_GET['statut']   ?? 'tous';
$filtrePriorite = $_GET['priorite'] ?? 'tous';

// Données pour la vue
$taches     = $tacheModel->getAll($filtreStatut, $filtrePriorite);
$categories = $categorieModel->getAll();
$stats      = $tacheModel->getStats();

// Séparation par statut pour l'affichage groupé
$tachesParStatut = [
    'en_attente' => [],
    'en_cours'   => [],
    'terminee'   => [],
];
foreach ($taches as $t) {
    $tachesParStatut[$t['statut']][] = $t;
}

// Messages flash
$succes = $_SESSION['succes'] ?? null;
$erreur = $_SESSION['erreur'] ?? null;
unset($_SESSION['succes'], $_SESSION['erreur']);

// Chargement de la vue
require_once __DIR__ . '/views/layout.php';
?>
