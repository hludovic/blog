<?php
try {
    $bdd = new PDO('mysql:host=localhost;dbname=test', 'root', 'caribou', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
?>
<!-- Todo: trier par date les 5 derniers posts -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon blog</title>
</head>
<link rel="stylesheet" href="style.css">

<body>
    <h1>Mon super blog !</h1>
    <p>Derniers billets du blog :</p>

    <?php
    $request = $bdd->query('SELECT id, titre, contenu,DATE_FORMAT(date_creation,\'%d/%m/%Y à %Hh%imin%ss\')AS date_creation_fr FROM billets;');
    while ($data = $request->fetch()) {
        ?>
    <div class=news>
        <h3>
            <?php echo $data['titre']; ?>
            <em>le <?php echo htmlspecialchars($data['date_creation_fr']); ?> </em>
        </h3>

        <p>
            <?php echo nl2br(htmlspecialchars($data['contenu'])); ?>
            <br>
            <a href="commentaires.php?post=<?php echo $data['id']; ?>">Commentaires</a>
        </p>
    </div>
    <?php
    }
    $request->closeCursor();
    ?>
</body>

</html>