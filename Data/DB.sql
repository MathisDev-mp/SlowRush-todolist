-- Créer la base de données
CREATE DATABASE IF NOT EXISTS slowrush CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Utiliser la base
USE slowrush;

-- Créer la table des tâches (avec la colonne terminee)
CREATE TABLE IF NOT EXISTS taches (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    priorite VARCHAR(50) NOT NULL,
    date DATE NOT NULL,
    duree INT NOT NULL,
    etat VARCHAR(50) NOT NULL,
    terminee BOOLEAN DEFAULT FALSE
);

-- Index pour améliorer les performances
CREATE INDEX idx_taches_date ON taches(date);
CREATE INDEX idx_taches_etat ON taches(etat);
CREATE INDEX idx_taches_terminee ON taches(terminee);
