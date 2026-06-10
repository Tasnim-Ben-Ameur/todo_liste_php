-- ============================================
--  WebTodo - Base de données
--  À importer via phpMyAdmin ou MySQL CLI
-- ============================================

CREATE DATABASE IF NOT EXISTS webtodo CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE webtodo;

-- Table des catégories
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    couleur VARCHAR(7) DEFAULT '#6C63FF',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table des tâches
CREATE TABLE IF NOT EXISTS taches (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    description TEXT,
    statut ENUM('en_attente', 'en_cours', 'terminee') DEFAULT 'en_attente',
    priorite ENUM('basse', 'normale', 'haute') DEFAULT 'normale',
    categorie_id INT,
    date_echeance DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (categorie_id) REFERENCES categories(id) ON DELETE SET NULL
);

-- Données de démonstration
INSERT INTO categories (nom, couleur) VALUES
('Travail', '#FF6B6B'),
('Personnel', '#4ECDC4'),
('Études', '#45B7D1'),
('Maison', '#96CEB4');

INSERT INTO taches (titre, description, statut, priorite, categorie_id, date_echeance) VALUES
('Préparer la présentation MVC', 'Slides pour le projet noté du vendredi 8 mai', 'en_cours', 'haute', 3, '2026-05-08'),
('Réviser HTML/CSS', 'Revoir les bases du responsive design', 'en_attente', 'normale', 3, '2026-05-07'),
('Faire les courses', 'Lait, pain, fruits', 'en_attente', 'basse', 2, NULL),
('Appeler le médecin', 'Prendre rendez-vous contrôle annuel', 'terminee', 'normale', 2, '2026-05-01');
