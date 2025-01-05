<?php
// Inclure la connexion à la base de données
require '../Bd/BddConnect.php';

$bdd = new BddConnect();
$pdo = $bdd->connexion();
// Vérifier si les données ont été envoyées
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Récupérer les données du formulaire
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Requête pour vérifier les informations de connexion
    $query = $pdo->prepare("SELECT * FROM Adherent WHERE username = :username AND password = :password");

    // Mettre les parametre à jour
    $query->bindParam(':username', $username);
    $query->bindParam(':password', $password);
    $query->execute();

    // Récupérer l'utilisateur et permet de voir si l'utilisateur est correct
    $user = $query->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Si c'est un administrateur, rediriger vers une page admin
        if ($user['is_admin']) {
            header("Location: admin.php?idUser=".$user['id_user']);
            exit();
        } else {
            // Sinon, rediriger vers une page utilisateur
            header("Location: questionnaire.php?idUser=".$user['id_user']);
            exit();
        }
    } else {
        // Rediriger vers la page de login avec un message d'erreur
        header("Location: login.php?error=Nom d'utilisateur ou mot de passe incorrect.");
        exit();
    }
} else {
    // Si la méthode n'est pas POST, rediriger vers la page initiale
    header("Location: login.php");
    exit();
}