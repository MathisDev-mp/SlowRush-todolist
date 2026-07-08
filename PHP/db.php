<?php
require "back.php";

// Vérifier que la requête est de type POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    die("Méthode non autorisée.");
}

// Récupérer et valider les données
$titre = $_POST['titre'] ?? '';
$description = $_POST['des'] ?? '';
$priorite = $_POST['priorite'] ?? '';
$date = $_POST['date'] ?? '';
$duree = $_POST['jour'] ?? '';
$etat = $_POST['etat'] ?? '';

// Validation
$erreurs = [];

if (empty($titre)) $erreurs[] = "Le champ 'TITRE' est obligatoire.";
if (empty($description)) $erreurs[] = "Le champ 'DESCRIPTION' est obligatoire.";
if (empty($priorite) || $priorite === "Veuillez choisir une Grandeur de priorité pour cette tache") {
    $erreurs[] = "Veuillez choisir une priorité valide.";
}
if (empty($date)) $erreurs[] = "Le champ 'DATE' est obligatoire.";
if (!is_numeric($duree) || $duree <= 0) $erreurs[] = "Le champ 'DURÉE' doit contenir un nombre valide supérieur à 0.";
if (empty($etat)) $erreurs[] = "Le champ 'ÉTAT' est obligatoire.";

if (!empty($erreurs)) {
    // Retourner les erreurs au format JSON (pour une future API)
    header("Content-Type: application/json");
    http_response_code(400);
    echo json_encode(["success" => false, "erreurs" => $erreurs]);
    exit;
}
try {
    // Insertion dans la base de données
    $sql = "INSERT INTO taches (titre, description, priorite, date, duree, etat)
            VALUES (:titre, :description, :priorite, :date, :duree, :etat)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ":titre" => $titre,
        ":description" => $description,
        ":priorite" => $priorite,
        ":date" => $date,
        ":duree" => $duree,
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
?>