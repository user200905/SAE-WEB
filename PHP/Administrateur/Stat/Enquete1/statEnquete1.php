<?php

require '../../Bd/BddConnect.php';

session_start();

// Connexion à la base de données
$bdd = new BddConnect();
$pdo = $bdd->connexion();

/**
 * Récupère le nombre total d'adhérents.
 */
function getTotalAdherents($pdo) {
    $query = $pdo->prepare("SELECT COUNT(*) AS total_adherents FROM Adherent");
    $query->execute();
    return $query->fetch(PDO::FETCH_ASSOC)['total_adherents'];
}

/**
 * Récupère le nombre de participants à une enquête donnée.
 */
function getNombreParticipants($pdo, $id_enquete) {
    $query = $pdo->prepare("
        SELECT COUNT(*) AS nombre_personnes
        FROM RealiserEnquete
        WHERE id_enquete = ?
    ");
    $query->execute([$id_enquete]);
    $result = $query->fetch(PDO::FETCH_ASSOC);
    return $result['nombre_personnes'] ?? 0;
}

/**
 * Récupère le nombre d'adhérents par région.
 */
function getParticipantsParRegion($pdo, $id_enquete) {
    $query = $pdo->prepare("
        SELECT region, COUNT(*) AS nombre_participants
        FROM RealiserEnquete
        JOIN Adherent ON RealiserEnquete.id_user = Adherent.id_user
        WHERE id_enquete = ?
        GROUP BY region
    ");
    $query->execute([$id_enquete]);
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Récupère les âges des participants à l'enquête.
 */
function getAgeDesParticipants($pdo, $id_enquete) {
    $query = $pdo->prepare("
        SELECT age AS age
        FROM RealiserEnquete
        JOIN Adherent ON RealiserEnquete.id_user = Adherent.id_user
        WHERE id_enquete = ? 
    ");
    $query->execute([$id_enquete]);
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

// Appel des fonctions
$id_enquete = 2; // Remplacez par l'ID de l'enquête active
$nombre_participants = getNombreParticipants($pdo, $id_enquete);
$total_adherents = getTotalAdherents($pdo);
$pourcentage = ($total_adherents > 0) ? intval(($nombre_participants / $total_adherents) * 100) : 0;

// Récupération des participants par région
$participants_par_region = getParticipantsParRegion($pdo, $id_enquete);

// Récupération des âges des participants
$ages = getAgeDesParticipants($pdo, $id_enquete);

// Organiser les âges en intervalles, y compris les moins de 18 ans
$age_intervals = [
    "Moins de 18" => 0,
    "18-25" => 0,
    "26-35" => 0,
    "36-45" => 0,
    "46-55" => 0,
    "56+" => 0
];

foreach ($ages as $age) {
    if ($age['age'] < 18) {
        $age_intervals["Moins de 18"]++;
    } elseif ($age['age'] >= 18 && $age['age'] <= 25) {
        $age_intervals["18-25"]++;
    } elseif ($age['age'] >= 26 && $age['age'] <= 35) {
        $age_intervals["26-35"]++;
    } elseif ($age['age'] >= 36 && $age['age'] <= 45) {
        $age_intervals["36-45"]++;
    } elseif ($age['age'] >= 46 && $age['age'] <= 55) {
        $age_intervals["46-55"]++;
    } elseif ($age['age'] >= 56) {
        $age_intervals["56+"]++;
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques Enquête</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="statistiquesEnquete1.js" type="module"></script>
    <script>
        var ageData = {
            'Moins de 18': <?= $age_intervals['Moins de 18'] ?>,
            '18-25': <?= $age_intervals['18-25'] ?>,
            '26-35': <?= $age_intervals['26-35'] ?>,
            '36-45': <?= $age_intervals['36-45'] ?>,
            '46-55': <?= $age_intervals['46-55'] ?>,
            '56+': <?= $age_intervals['56+'] ?>
        };
    </script>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        .card {
            background: #ffffff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            height: 350px; /* Ajustement de la taille de la carte */
        }

        .card__header {
            text-align: center;
        }

        .card__title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #343a40;
        }

        .card__subtitle {
            font-size: 1rem;
            color: #6c757d;
        }

        .card__stats {
            margin-top: 20px;
            text-align: center;
        }

        .card__stats-value {
            font-size: 2rem;
            font-weight: bold;
            color: #007bff;
        }

        .progress {
            height: 20px;
            border-radius: 10px;
            overflow: hidden;
            margin-top: 20px;
        }

        .progress-bar {
            height: 100%;
            transition: width 0.4s ease;
        }

        .card__footer {
            text-align: center;
            margin-top: 20px;
            font-size: 0.9rem;
            color: #6c757d;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .row {
            margin-top: 20px;
        }

        .stat-card {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            height: 350px; /* Taille uniforme pour chaque carte */
            margin-bottom: 20px;
        }

        .stat-card h3 {
            font-size: 1.5rem;
            color: #343a40;
        }

        .stat-card p {
            font-size: 1.1rem;
            color: #007bff;
        }

        .age-distribution {
            margin-top: 20px;
            text-align: center;
        }

        .list-group-item {
            padding-left: 10px;
            padding-right: 10px;
        }

        /* Centrage du graphique avec une taille fixe */
        #ageChart {
            max-width: 500px;
            margin: 0 auto;
            height: 350px;
        }

        @media (max-width: 768px) {
            .row {
                flex-direction: column;
                align-items: center;
            }

            .col-md-6,
            .col-md-12 {
                width: 100%;
            }

            .card {
                height: auto;
            }

            #ageChart {
                width: 100%;
                height: 300px; /* Adaptation pour petits écrans */
            }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <!-- Statistiques de l'enquête -->
            <div class="card">
                <div class="card__header">
                    <div class="card__title">Statistiques de l'enquête</div>
                    <div class="card__subtitle">Suivi des réponses des adhérents</div>
                </div>
                <div class="card__stats">
                    <div class="card__stats-value"><?= $nombre_participants ?> adherent(s)</div>
                    <div>ont répondu à l'enquête</div>
                </div>
                <div class="progress">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: <?= $pourcentage ?>%;
                            " aria-valuenow="<?= $pourcentage ?>" aria-valuemin="0" aria-valuemax="100">
                    </div>
                </div>
                <div class="card__footer">
                    <p>Total d'adhérents : <?= $total_adherents ?></p>
                    <p><?= $pourcentage ?>% ont répondu</p>
                </div>
            </div>

            <div class="card">
                <div class="card__header">
                    <div class="card__title">Nombre de participants par région</div>
                    <div class="card__subtitle">Répartition des participants par région</div>
                </div>
                <div class="card__stats">
                    <ul class="list-group">
                        <?php foreach ($participants_par_region as $region): ?>
                            <li class="list-group-item">
                                <strong><?= $region['region'] ?>:</strong> <?= $region['nombre_participants'] ?> participants
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

            <!-- Graphique circulaire pour la répartition des âges généré-->
            <div class="age-distribution">
                <h3>Répartition des âges des répondants</h3>
                <canvas id="ageChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
