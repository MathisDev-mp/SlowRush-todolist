<?php
require "back.php";

header("Content-Type: application/json");

try {
    // Récupérer toutes les tâches (triées par date)
    $sql = "SELECT * FROM taches ORDER BY date ASC";
    $stmt = $pdo->query($sql);
    $taches = $stmt->fetchAll();

    // Ajouter le champ 'terminee' si la colonne existe, sinon le simuler via 'etat'
    foreach ($taches as &$tache) {
        if (isset($tache['terminee'])) {
            // Si la colonne existe, on l'utilise
            $tache['terminee'] = (bool)$tache['terminee'];
        } else {
            // Sinon, on simule via le champ 'etat'
            $tache['terminee'] = ($tache['etat'] === 'TERMINER');
        }
    }
    echo json_encode($taches);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["success" => false, "erreur" => "Erreur lors de la récupération des tâches : " . $e->getMessage()]);
}
?>