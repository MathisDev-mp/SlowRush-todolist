<?php
require "back.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $sql = "INSERT INTO taches (titre, description, priorite, date, duree, etat)
            VALUES (:titre, :description, :priorite, :date, :duree, :etat)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ":titre" => $_POST['titre'],
        ":description" => $_POST['des'],
        ":priorite" => $_POST['priorite'],
        ":date" => $_POST['date'],
        ":duree" => $_POST['jour'],
        ":etat" => $_POST['etat']
    ]);

    header("Location: Slowrush.html");
    exit;
}
?>
