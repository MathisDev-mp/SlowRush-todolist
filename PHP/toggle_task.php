<?php
require "back.php";

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(["success" => false, "erreur" => "Méthode non autorisée"]);
    exit;
}

if (!isset($_POST['id'])) {
    http_response_code(400);
    echo json_encode(["success" => false, "erreur" => "ID manquant"]);
    exit;
}

$id = $_POST['id'];

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

    // Basculer l'état "terminée"
    if (isset($tache['terminee'])) {
        // Si la colonne 'terminee' existe, on l'utilise
        $nouvelEtat = !$tache['terminee'];
        $sql = "UPDATE taches SET terminee = :terminee WHERE id = :id";
        $params = [":terminee" => $nouvelEtat, ":id" => $id];
        $estTerminee = $nouvelEtat;
    } else {
        // Sinon, on utilise le champ 'etat'
        $nouvelEtat = ($tache['etat'] === 'TERMINER') ? 'COMMENCE' : 'TERMINER';
        $sql = "UPDATE taches SET etat = :etat WHERE id = :id";
        $params = [":etat" => $nouvelEtat, ":id" => $id];
        $estTerminee = ($nouvelEtat === 'TERMINER');
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    echo json_encode(["success" => true, "terminee" => $estTerminee]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["success" => false, "erreur" => "Erreur lors de la mise à jour : " . $e->getMessage()]);
}
?>