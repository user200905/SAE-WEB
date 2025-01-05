<?php

require 'BddConnect.php';

$bdd = new BddConnect();
$pdo = $bdd->connexion();

$id_enquete = 1;

// Récupérer les informations de l'enquête
$query_enquete = $pdo->prepare("SELECT * FROM Enquete WHERE id_enquete = ?");
$query_enquete->execute([$id_enquete]);
$enquete = $query_enquete->fetch(PDO::FETCH_ASSOC);


if (!$enquete) {
    die("Enquête introuvable !");
}

// Récupérer les questions de l'enquête
$query_questions = $pdo->prepare("SELECT * FROM Question WHERE id_enquete = :id_enquete");
$query_questions->bindParam(":id_enquete", $enquete['id_enquete']);
$query_questions->execute();
$questions = $query_questions->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../css/questionnaire.css">
    <title>Questionnaire - <?= $enquete['titre']; ?></title>
</head>
<body>
<div class="container">
    <header>
        <h1><?= $enquete['titre']; ?></h1>
        <p><?= $enquete['description']; ?></p>
    </header>
    <!--Permet d'envoyer l'id de de l'utilisateur au fichier submit-->
    <form method="post" action="submit_questionnaire.php?idUser=<?= $_GET['idUser']; ?>">
        <?php
        foreach ($questions as $question) {
            echo '<div class="question">';
            echo '<label>' . $question['texte_question'] . '</label>';

            if ($question['type_question'] === 'text') {
                echo '<input type="text" name="response[' . $question['id_question'] . ']" required>';
            } elseif ($question['type_question'] === 'textarea') {
                echo '<textarea name="response[' . $question['id_question'] . ']" rows="4" required></textarea>';
            } elseif ($question['type_question'] === 'choice' || $question['type_question'] === 'multiple_choice') {
                echo '<div class="options">';

                $query_options = $pdo->prepare("SELECT * FROM choix WHERE id_question = ?");
                $query_options->execute([$question['id_question']]);
                $options = $query_options->fetchAll(PDO::FETCH_ASSOC);

                foreach ($options as $option) {
                    echo '<label>';
                    echo '<input type="' . ($question['type_question'] === 'choice' ? 'radio' : 'checkbox') . '" ';
                    echo 'name="response[' . $question['id_question'] . '][]" ';
                    echo 'value="' . $option['id_option'] . '">';
                    echo $option['texte_option'];
                    echo '</label>';
                }

                echo '</div>';
            }

            echo '</div>';
        }
        ?>
        <button type="submit">Soumettre</button>
    </form>
</div>
</body>
</html>