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

// Récupérer les champs à mettre à jour
$champs = [];
$params = [":id" => $id];

if (isset($_POST['titre']) && trim($_POST['titre']) !== '') {
    $champs[] = "titre = :titre";
    $params[":titre"] = trim($_POST['titre']);
}
if (isset($_POST['description']) && trim($_POST['description']) !== '') {
    $champs[] = "description = :description";
    $params[":description"] = trim($_POST['description']);
}
if (isset($_POST['priorite']) && trim($_POST['priorite']) !== '') {
    $champs[] = "priorite = :priorite";
    $params[":priorite"] = trim($_POST['priorite']);
}
if (isset($_POST['date']) && trim($_POST['date']) !== '') {
    $champs[] = "date = :date";
    $params[":date"] = trim($_POST['date']);
}
if (isset($_POST['duree']) && is_numeric($_POST['duree']) && $_POST['duree'] > 0) {
    $champs[] = "duree = :duree";
    $params[":duree"] = (int)$_POST['duree'];
}
if (isset($_POST['etat']) && trim($_POST['etat']) !== '') {
    $etat = trim($_POST['etat']);
    $champs[] = "etat = :etat";
    $params[":etat"] = $etat;
    // On garde la colonne 'terminee' synchronisée avec 'etat' si elle existe.
    $champs[] = "terminee = :terminee";
    $params[":terminee"] = ($etat === 'TERMINER');
}

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

    // Si la colonne 'terminee' n'existe pas dans la table, on retire ce champ pour éviter une erreur SQL
    if (!array_key_exists('terminee', $tache)) {
        $champs = array_values(array_filter($champs, fn($c) => strpos($c, 'terminee') === false));
        unset($params[":terminee"]);
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
