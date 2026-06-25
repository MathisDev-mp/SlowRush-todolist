-- Créer la base de données
CREATE DATABASE slowrush CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Utiliser la base
USE slowrush;

-- Créer la table des tâches
CREATE TABLE taches (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    priorite VARCHAR(50) NOT NULL,
    date DATE NOT NULL,
    duree INT NOT NULL,
    etat VARCHAR(50) NOT NULL
);
