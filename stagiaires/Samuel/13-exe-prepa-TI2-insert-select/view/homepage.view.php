<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../public/css/style.css">
    <title>Exercice</title>
</head>
<body>
<h1>Accueil</h1>
<h2>Laissez-nous un message</h2>
<?php
// Si le message à été envoyé avec succès
if(isset($success)):
?>
    <h4 class="success"><?=$success?></h4>
<?php
endif;
// Si on a une erreur lors de l'insertion
if(isset($error)):
?>
    <h4 class="error"><?=$error?></h4>
<?php
endif;
?>
    <form action="" method="post">
        <label for="surname">Votre surnom:</label>
        <input type="text" name="surname" id="surname" required>
        <label for="email">Votre email:</label>
        <input type="email" name="email" id="email" required>
        <label for="message">Votre commentaire:</label>
        <textarea name="message" id="message" rows="10" required></textarea>
        <button type="submit">Envoyer</button>
    </form>
<hr>
<?php 
// S'il n'y a aucun commentaire (tableau vide)
if(empty($messages)):
?>

<div class="nocommentary">
    <h2>Il n'y a pas de commentaire</h2>
    <p>Veuillez revenir sur cette page plus tard</p>
</div>

<?php 
// Si le tableau contient un ou plusieurs commentaires
else:
    // On compte le nombre de commentaire
    $nbCommentary = count($messages);
    // On ajoute une variable pour le 's' de commentaire si nécéssaire
    $commentarys = $nbCommentary>1 ? "s" : "";
?>

<div class="commentary">

    <h2>Il y a <?=$nbCommentary?> commentaire<?=$commentarys?></h2> 
</div>
<div class="container-commentary">
<?php 
foreach ($messages as $message):
?>
    <div class="carte">
        <h3><?=$message['surname']?></h3>
        <p><?=$message['message']?></p>
        <p class="date"><?=$message['create_date']?></p>
    </div>
<?php 
endforeach;
?>
</div>
<?php 
endif;

?>
</body>
</html>