<?php
require "back.php";

header("Content-Type: application/json");

try {
    // Récupérer toutes les tâches (triées par date)
    $sql = "SELECT * FROM taches ORDER BY date ASC";
    $stmt = $pdo->query($sql);
    $taches = $stmt->fetchAll();

    // Normaliser le champ 'terminee' (colonne booléenne OU déduit de 'etat')
    foreach ($taches as &$tache) {
        if (isset($tache['terminee'])) {
            $tache['terminee'] = (bool)$tache['terminee'];
        } else {
            $tache['terminee'] = ($tache['etat'] === 'TERMINER');
        }
    }
    unset($tache);

    echo json_encode($taches);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["success" => false, "erreur" => "Erreur lors de la récupération des tâches : " . $e->getMessage()]);
}
