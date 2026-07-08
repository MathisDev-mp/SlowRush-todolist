<?php
// Configuration de la base de données
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "slowrush";

// Connexion à MySQL avec options de sécurité
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); // Désactive l'émulation des requêtes préparées
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); // Retourne toujours des tableaux associatifs
} catch (Exception $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

// Démarrer la session (pour l'authentification future)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>