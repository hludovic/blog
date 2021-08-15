<?php
try {
    $bdd = new PDO('mysql:host=localhost;dbname=test', 'root', 'caribou', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
// Todo: trier par date les commentaires
$postID = -1;
if ($_POST['pseudo'] != '' and $_POST['commentaire'] != '' and isset($_POST['postId']) and $postID = (int)$_POST['postId'] and $_POST['postId'] > 0) {
    echo $_POST['postId'];
    $request = $bdd->prepare('INSERT INTO`test` .`commentaires`(`id_billet`,`auteur`,`commentaire`,`date_commentaire`)VALUES(?,?,?,NOW());');
    $request->execute([$postID, $_POST['pseudo'], $_POST['commentaire']]);
    header('Location: commentaires.php?post=' . $_POST['postId']);
}
header('Location: commentaires.php?post=' . $_POST['postId']);
?>