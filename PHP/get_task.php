<?php
require "back.php";

header("Content-Type: application/json");

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    http_response_code(400);
    echo json_encode(["success" => false, "erreur" => "ID manquant ou invalide"]);
    exit;
}

$id = (int)$_GET['id'];

try {
    $sql = "SELECT * FROM taches WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([":id" => $id]);
    $tache = $stmt->fetch();

    if (!$tache) {
        http_response_code(404);
        echo json_encode(["success" => false, "erreur" => "Tâche non trouvée"]);
        exit;
    }

    // Ajouter le champ terminee si nécessaire
    if (!isset($tache['terminee'])) {
        $tache['terminee'] = ($tache['etat'] === 'TERMINER');
    } else {
        $tache['terminee'] = (bool)$tache['terminee'];
    }

    echo json_encode($tache);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["success" => false, "erreur" => "Erreur lors de la récupération : " . $e->getMessage()]);
}
