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
    // Vérifier que la tâche existe
    $sql = "SELECT * FROM taches WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([":id" => $id]);
    $tache = $stmt->fetch();

    if (!$tache) {
        http_response_code(404);
        echo json_encode(["success" => false, "erreur" => "Tâche non trouvée"]);
        exit;
    }

    // Supprimer la tâche
    $sql = "DELETE FROM taches WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([":id" => $id]);

    echo json_encode(["success" => true]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["success" => false, "erreur" => "Erreur lors de la suppression : " . $e->getMessage()]);
}
?>