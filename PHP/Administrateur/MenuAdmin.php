<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PageContact</title>
    <link rel="stylesheet" href="interfaceAdmin.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="tab-container">
    <input type="radio" name="tab" id="tab1" class="tab tab--1" <?php if (isset($_GET['tab']) && $_GET['tab'] == 1) echo 'checked="checked"'; ?> />
    <label class="tab_label" for="tab1" onclick="window.location.href='listeInscription.php?tab=1'">Admission</label>

    <input type="radio" name="tab" id="tab2" class="tab tab--2" <?php if (isset($_GET['tab']) && $_GET['tab'] == 2) echo 'checked="checked"'; ?> />
    <label class="tab_label" for="tab2" onclick="window.location.href='listeAdherent.php?tab=2'">Team</label>

    <input type="radio" name="tab" id="tab3" class="tab tab--3" <?php if (isset($_GET['tab']) && $_GET['tab'] == 3) echo 'checked="checked"'; ?> />
    <label class="tab_label" for="tab3" onclick="window.location.href='../../PageContact.html?tab=3'">Stat</label>

    <input type="radio" name="tab" id="tab4" class="tab tab--4" <?php if (isset($_GET['tab']) && $_GET['tab'] == 4) echo 'checked="checked"'; ?> />
    <label class="tab_label" for="tab4" onclick="window.location.href='../Questionnaire/questionnaire.php?tab=4'">Questionnaire</label>

    <input type="radio" name="tab" id="tab5" class="tab tab--5" <?php if (isset($_GET['tab']) && $_GET['tab'] == 5) echo 'checked="checked"'; ?> />
    <label class="tab_label" for="tab5">View table</label>

    <input type="radio" name="tab" id="tab6" class="tab tab--6" <?php if (isset($_GET['tab']) && $_GET['tab'] == 6) echo 'checked="checked"'; ?> />
    <label class="tab_label" for="tab6" onclick="window.location.href='../../PageContact.html?tab=6'">Log Out</label>

    <div class="indicator"></div>
</div>

</body>
</html>
