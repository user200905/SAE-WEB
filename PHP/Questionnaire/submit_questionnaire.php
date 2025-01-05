<?php

date_default_timezone_set('Europe/Paris');
require 'BddConnect.php';

$bdd = new BddConnect();
$pdo = $bdd->connexion();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_user = $_GET['idUser'];
    $responses = $_POST['response'] ?? [];
      foreach ($responses as $id_question => $response) {
        if (is_array($response)) {
            foreach ($response as $id_option) {
                $query = $pdo->prepare("INSERT INTO Reponse (id_option, id_user, id_question, date_reponse) VALUES (?, ?, ?, ?)");
                $query->execute([$id_option, $id_user, $id_question, date("Y-m-d H:i:s")]);
            }
        } else {
            $query = $pdo->prepare("INSERT INTO Reponse (texte_reponse, id_user, id_question, date_reponse) VALUES (?, ?, ?, ?)");
            $query->execute([$response, $id_user, $id_question, date("Y-m-d H:i:s")]);
        }
    }

    // Rediriger vers la confirmation
    header("Location: confirmation.php");
    exit();
}
?>