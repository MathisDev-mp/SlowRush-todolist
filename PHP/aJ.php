<?php
require "back.php";

$sql = "SELECT * FROM taches ORDER BY date ASC";
$stmt = $pdo->query($sql);
$taches = $stmt->fetchAll(PDO::FETCH_ASSOC);

header("Content-Type: application/json");
echo json_encode($taches);
?>
