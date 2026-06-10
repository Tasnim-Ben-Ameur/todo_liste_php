# 📋 WebTodo — Application de suivi des tâches

Projet MVC en PHP/MySQL — Développement Web

---

## 🗂 Structure du projet

```
webtodo/
├── index.php                ← Point d'entrée (charge modèles + vue)
├── database.sql             ← Script SQL (à importer)
│
├── models/                  ← Couche Données
│   ├── Database.php         ← Connexion PDO (Singleton)
│   ├── Tache.php            ← CRUD tâches
│   └── Categorie.php        ← CRUD catégories
│
├── views/                   ← Couche Présentation
│   ├── layout.php           ← Interface principale
│   └── form_modifier.php    ← Formulaire de modification
│
├── controllers/             ← Couche Contrôle
│   ├── taches.php           ← Actions CRUD tâches
│   └── categories.php       ← Actions CRUD catégories
│
└── assets/
    └── css/
        └── style.css        ← Styles (Dark mode moderne)
```

---

## ⚙️ Installation

### Prérequis
- PHP 8.0+
- MySQL 5.7+ / MariaDB
- Serveur local : XAMPP, WAMP, Laragon, ou MAMP

### Étapes

1. **Copier le dossier** dans `htdocs/` (XAMPP) ou `www/` (WAMP) :
   ```
   htdocs/webtodo/
   ```

2. **Créer la base de données** :
   - Ouvrir phpMyAdmin → `http://localhost/phpmyadmin`
   - Cliquer sur **Importer**
   - Sélectionner le fichier `database.sql`
   - Cliquer sur **Exécuter**

3. **Configurer la connexion** dans `models/Database.php` :
   ```php
   private $host     = 'localhost';
   private $dbname   = 'webtodo';
   private $username = 'root';
   private $password = '';  // Votre mot de passe MySQL
   ```

4. **Lancer l'application** :
   ```
   http://localhost/webtodo/
   ```

---

## ✨ Fonctionnalités

| Fonctionnalité | Description |
|---|---|
| ➕ Créer | Ajouter une tâche avec titre, description, statut, priorité, catégorie et date |
| ✏️ Modifier | Éditer tous les champs d'une tâche existante |
| ✅ Toggle statut | Marquer une tâche terminée/non terminée en un clic |
| 🗑️ Supprimer | Supprimer une tâche avec confirmation |
| 🔍 Filtrer | Filtrer par statut ET par priorité |
| 📁 Catégories | Créer et supprimer des catégories colorées |
| 📊 Statistiques | Tableau de bord avec compteurs en temps réel |

---

## 🏗 Architecture MVC

```
Utilisateur
     │
     ▼
index.php ──────── Controllers (taches.php / categories.php)
     │                       │
     ▼                       ▼
Views (layout.php)    Models (Tache.php / Categorie.php)
                             │
                             ▼
                       Base de données MySQL
```

---

## 🎨 Aperçu

- Design **Dark mode** moderne
- Typographie : Syne + DM Sans (Google Fonts)
- Responsive (mobile-friendly)
- Animations CSS subtiles
- Groupement des tâches par statut

---

*Projet réalisé dans le cadre du cours de Développement Web*
