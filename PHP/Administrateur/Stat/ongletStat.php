<?php
// Connexion à la base de données
require '../../../Bd/BddConnect.php';

$bdd = new BddConnect();
$pdo = $bdd->connexion();

// Récupérer toutes les enquêtes disponibles
$query = $pdo->prepare("SELECT * FROM Enquete");
$query->execute();
$enquetes = $query->fetchAll(PDO::FETCH_ASSOC);

// Si un ID d'enquête est sélectionné, récupérer les stats
$stats = [];
if (isset($_POST['id_enquete']) && !empty($_POST['id_enquete'])) {
    $id_enquete = $_POST['id_enquete'];

    // Vérifier si des statistiques existent pour cette enquête
    $query_stats = $pdo->prepare("SELECT COUNT(*) AS total_participants FROM RealiserEnquete WHERE id_enquete = ?");
    $query_stats->execute([$id_enquete]);
    $stats = $query_stats->fetch(PDO::FETCH_ASSOC);

    if ($stats['total_participants'] == 0) {
        $message = "Aucun participant pour cette enquête.";
    } else {
        $message = "Statistiques disponibles pour cette enquête!";
    }
} else {
    $message = "Veuillez sélectionner une enquête pour voir les statistiques.";
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'Enquête</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f4f9;
            font-family: 'Arial', sans-serif;
            padding-top: 30px;
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
        }

        .card {
            background: #ffffff;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .card__header {
            text-align: center;
        }

        .card__title {
            font-size: 1.75rem;
            font-weight: bold;
            color: #343a40;
        }

        .card__subtitle {
            font-size: 1.1rem;
            color: #6c757d;
            margin-top: 10px;
        }

        .stat-card {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
            text-align: center;
        }

        .stat-card h3 {
            font-size: 1.5rem;
            color: #343a40;
        }

        .stat-card p {
            font-size: 1.2rem;
            color: #007bff;
        }

        .stat-card .message {
            font-size: 1.2rem;
            color: #dc3545;
        }

        .form-group {
            margin-bottom: 30px;
        }

        .select-enquete {
            width: 100%;
            padding: 12px;
            font-size: 1.1rem;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .btn-primary {
            width: 100%;
            padding: 12px;
        }

        .mt-4 {
            margin-top: 40px;
        }

        .message-container {
            margin-top: 30px;
        }

        .stat-card {
            margin-top: 30px;
        }

        /* Enlever toute bordure non désirée */
        .card, .stat-card {
            border: none !important;
        }
    </style>
</head>

<body>

<div class="container">
    <h2 class="text-center mb-5">Gestion des Enquêtes - Statistiques</h2>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Formulaire de sélection de l'enquête -->
            <div class="card">
                <div class="card__header">
                    <div class="card__title">Sélectionnez une enquête</div>
                    <div class="card__subtitle">Choisissez une enquête pour afficher ses statistiques.</div>
                </div>
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="id_enquete">Enquête :</label>
                        <select name="id_enquete" id="id_enquete" class="select-enquete">
                            <option value="">Sélectionnez une enquête</option>
                            <?php foreach ($enquetes as $enquete): ?>
                                <option value="<?= $enquete['id_enquete'] ?>"><?= $enquete['titre'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Voir les Statistiques</button>
                </form>
            </div>

            <!-- Affichage des statistiques -->
            <?php if (!empty($stats)): ?>
                <div class="stat-card">
                    <h3>Statistiques pour l'enquête sélectionnée</h3>
                    <p><strong>Total des participants :</strong> <?= $stats['total_participants'] ?></p>
                    <div class="message"><?= isset($message) ? $message : '' ?></div>
                </div>
            <?php elseif (!empty($message)): ?>
                <div class="stat-card">
                    <h3>Résultat</h3>
                    <p class="message"><?= $message ?></p>
                </div>
            <?php endif; ?>

            <!-- Inclure le fichier spécifique en dessous du formulaire -->
            <?php if (isset($id_enquete) && $id_enquete == 1): ?>
                <div class="stat-card">
                    <?php require "statEnquete1.php"; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
