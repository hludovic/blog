<?php
try {
    $bdd = new PDO('mysql:host=localhost;dbname=test', 'root', 'caribou', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
$postId = 0;
if (isset($_GET['post']) and $_GET['post'] > 0 and $postId = (int)$_GET['post']) {
} else {
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon blog</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Mon super blog !</h1>
    <p><a href="index.php">Retour à la liste des billets</a></p>
    <?php 
    $request = $bdd->prepare('SELECT id, titre, contenu,DATE_FORMAT(date_creation,\'%d/%m/%Y à %Hh%imin%ss\')AS date_creation_fr FROM billets WHERE id = ?;');
    $request->execute([$postId]);
    $data = $request->fetch();
    ?>
    <div class="news">
        <h3>
            <?php echo $data['titre']; ?>
            <em>le <?php echo $data['date_creation_fr']; ?></em>
        </h3>
        <p><?php echo nl2br(htmlspecialchars($data['contenu'])); ?></p>
    </div>
    <h2>Poster un commentaire</h2>
    <form action="commentaires_post.php" method="post">
        <input type="hidden" name="postId" value="<?php echo $postId;?>">
        Pseudo : <input type="text" name="pseudo" id="pseudo">
        <br>
        <textarea name="commentaire" id="commentaire" cols="30" rows="10"></textarea>
        <br>
        <button type="submit">Envoyer</button>
    </form>    
    <h2>Commentaires</h2>
    <?php
    $request->closeCursor();
    $request = $bdd->prepare('SELECT id, auteur, commentaire,DATE_FORMAT(date_commentaire,\'%d/%m/%Y à %Hh%i\')AS date_commentaire_fr FROM commentaires WHERE id_billet=?;');
    $request->execute([$postId]);
    
    while ($data = $request->fetch()) {
        echo '<P>' . '<strong>' . $data['auteur'] . '</strong>' . ' le ' . $data['date_commentaire_fr'] . '<br>';
        echo  $data['commentaire'] . '</p>';
    }
    ?>
    <?php
    $request->closeCursor();
    ?>
</body>
</html>