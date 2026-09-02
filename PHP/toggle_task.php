<?php
require "back.php";

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(["success" => false, "erreur" => "Méthode non autorisée"]);
    exit;
}

if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
    http_response_code(400);
    echo json_encode(["success" => false, "erreur" => "ID manquant ou invalide"]);
    exit;
}

$id = (int)$_POST['id'];

try {
    // Récupérer la tâche actuelle
    $sql = "SELECT * FROM taches WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([":id" => $id]);
    $tache = $stmt->fetch();

    if (!$tache) {
        http_response_code(404);
        echo json_encode(["success" => false, "erreur" => "Tâche non trouvée"]);
        exit;
    }

    // BUG CORRIGÉ : avant, seule la colonne utilisée (terminee OU etat) était mise à jour,
    // ce qui pouvait laisser les deux colonnes en désaccord (ex. terminee=1 mais etat="COMMENCE").
    // On calcule le nouvel état "terminée" une seule fois, puis on synchronise les deux colonnes.
    $etaitTerminee = isset($tache['terminee'])
        ? (bool)$tache['terminee']
        : ($tache['etat'] === 'TERMINER');

    $estTerminee = !$etaitTerminee;
    $nouvelEtat = $estTerminee ? 'TERMINER' : 'COMMENCE';

    if (isset($tache['terminee'])) {
        $sql = "UPDATE taches SET terminee = :terminee, etat = :etat WHERE id = :id";
        $params = [":terminee" => $estTerminee, ":etat" => $nouvelEtat, ":id" => $id];
    } else {
        $sql = "UPDATE taches SET etat = :etat WHERE id = :id";
        $params = [":etat" => $nouvelEtat, ":id" => $id];
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    echo json_encode(["success" => true, "terminee" => $estTerminee]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["success" => false, "erreur" => "Erreur lors de la mise à jour : " . $e->getMessage()]);
}
