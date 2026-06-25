<?php
$host = "localhost";
$user = "root";   // ton utilisateur MySQL
$pass = "";       // ton mot de passe MySQL
$dbname = "slowrush";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>
