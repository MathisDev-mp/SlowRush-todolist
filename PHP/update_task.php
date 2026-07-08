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

// Récupérer les champs à mettre à jour
$champs = [];
$params = [":id" => $id];

if (isset($_POST['titre'])) { $champs[] = "titre = :titre"; $params[":titre"] = $_POST['titre']; }
if (isset($_POST['description'])) { $champs[] = "description = :description"; $params[":description"] = $_POST['description']; }
if (isset($_POST['priorite'])) { $champs[] = "priorite = :priorite"; $params[":priorite"] = $_POST['priorite']; }
if (isset($_POST['date'])) { $champs[] = "date = :date"; $params[":date"] = $_POST['date']; }
if (isset($_POST['duree'])) { $champs[] = "duree = :duree"; $params[":duree"] = $_POST['duree']; }
if (isset($_POST['etat'])) { $champs[] = "etat = :etat"; $params[":etat"] = $_POST['etat']; }

if (empty($champs)) {
    http_response_code(400);
    echo json_encode(["success" => false, "erreur" => "Aucun champ à mettre à jour"]);
    exit;
}

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

    // Construire la requête UPDATE
    $sql = "UPDATE taches SET " . implode(", ", $champs) . " WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    echo json_encode(["success" => true]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["success" => false, "erreur" => "Erreur lors de la mise à jour : " . $e->getMessage()]);
}
?>