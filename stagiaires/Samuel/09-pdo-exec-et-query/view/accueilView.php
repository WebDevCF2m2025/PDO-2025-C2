<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Accueil</title>
</head>
<body>
<?php include "inc/menu.php"; ?>
<h1>Accueil</h1>
<p>Bienvenue sur notre site !</p>
<p>Voici les 10 derniers articles :</p>
<?php
// Affichage des articles
foreach ($articles as $article):
?>

<h2><?= $article['title'] ?> | <small>Par <?=$article['fullname']?></small></h2>
<p><?=nl2br($article['text'])?></p>
<p>Publié le <strong><?=$article['article_date_create']?></strong></p>
<hr>

<?php
endforeach;
//var_dump($articles);
?>
</body>
</html>