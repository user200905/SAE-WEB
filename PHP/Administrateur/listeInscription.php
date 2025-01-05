<?php
require "../Bd/BddConnect.php";

// Connexion à la base de données
$bdd = new BddConnect();
$pdo = $bdd->connexion();

// Récupérer toutes les inscriptions en attente
$sql = "SELECT * FROM inscriptionattente";
$stmt = $pdo->query($sql);
$inscriptions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau des inscriptions</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: center;
        }
        th {
            background - color: #f2f2f2;
        }
        .button-container button {
            padding: 6px 12px;
            font-size: 14px;
            cursor: pointer;
            margin: 5px;
        }
        .accept-button {
            background - color: #4CAF50; /* Vert */
            color: white;
            border: none;
        }
        .reject-button {
            background - color: #f44336; /* Rouge */
            color: white;
            border: none;
        }
    </style>
</head>
<body>
<h1>Inscriptions en attente</h1>


<?php if (!empty($inscriptions)): ?>
    <table>
        <thead>
        <tr>
            <th>Prénom</th>
            <th>Nom</th>
            <th>Email</th>
            <th>Age</th>
            <th>Région</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody class="tabVerification">
        <!-- Boucle pour afficher chaque ligne d'inscription -->
        <?php foreach ($inscriptions as $inscription): ?>
            <tr>
                <td><?= htmlspecialchars($inscription['firstname']) ?></td>
                <td><?= htmlspecialchars($inscription['lastname']) ?></td>
                <td><?= htmlspecialchars($inscription['email']) ?></td>
                <td><?= htmlspecialchars($inscription['age']) ?></td>
                <td><?= htmlspecialchars($inscription['region']) ?></td>
                <td>
                    <form method="post" action="action.php?idInscription=<?= $inscription['id_user'] ?>">
                        <button type="submit" name="button" value="1" style="color: green;">Accepter</button>
                    </form>
                    <form method="post" action="action.php?idInscription=<?= $inscription['id_user'] ?>"">
                        <button type="submit" name="button" value="0" style="color: red;">Rejeter</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Aucune inscription en attente.</p>
<?php endif; ?>
</body>
</html>
