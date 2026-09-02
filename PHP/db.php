<?php
require "back.php";

// Vérifier que la requête est de type POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    die("Méthode non autorisée.");
}

// Récupérer et valider les données
$titre = trim($_POST['titre'] ?? '');
$description = trim($_POST['des'] ?? '');
$priorite = trim($_POST['priorite'] ?? '');
$date = trim($_POST['date'] ?? '');
$duree = trim($_POST['jour'] ?? '');
$etat = trim($_POST['etat'] ?? '');

// Validation
$erreurs = [];

if ($titre === '') $erreurs[] = "Le champ 'TITRE' est obligatoire.";
if ($description === '') $erreurs[] = "Le champ 'DESCRIPTION' est obligatoire.";
if ($priorite === '') {
    $erreurs[] = "Veuillez choisir une priorité valide.";
}
if ($date === '') $erreurs[] = "Le champ 'DATE' est obligatoire.";
if (!is_numeric($duree) || $duree <= 0) $erreurs[] = "Le champ 'DURÉE' doit contenir un nombre valide supérieur à 0.";
if ($etat === '') $erreurs[] = "Le champ 'ÉTAT' est obligatoire.";

if (!empty($erreurs)) {
    header("Content-Type: application/json");
    http_response_code(400);
    echo json_encode(["success" => false, "erreurs" => $erreurs]);
    exit;
}

try {
    // Insertion dans la base de données (requête préparée -> protégé contre l'injection SQL)
    $sql = "INSERT INTO taches (titre, description, priorite, date, duree, etat)
            VALUES (:titre, :description, :priorite, :date, :duree, :etat)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ":titre" => $titre,
        ":description" => $description,
        ":priorite" => $priorite,
        ":date" => $date,
        ":duree" => (int)$duree,
        ":etat" => $etat
    ]);

    // Redirection vers la page principale
    header("Location: ../HTML/Slowrush.html");
    exit;
} catch (Exception $e) {
    header("Content-Type: application/json");
    http_response_code(500);
    echo json_encode(["success" => false, "erreur" => "Erreur lors de l'insertion : " . $e->getMessage()]);
    exit;
}
