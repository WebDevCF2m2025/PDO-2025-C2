<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// on récupère avec un query le section_title et section_slug pour faire le menu qui sera sur toutes les pages
$menurequest = $db->query("SELECT section_title, section_slug FROM section");
$menu = $menurequest->fetchAll();
$menurequest->closeCursor();

// si la variable $_GET['p'] existe
if(isset($_GET['p'])) {
    if($_GET['p'] == "insert") {

        // requête pour insérer un article au hasard à la date du jour

        $caracteres = '0123456789 abcdefghijkl mnopqrstuv wxyzABCDEFGHI JKLMNOPQR STUVWXYZ';
        $nCaracteres = strlen($caracteres); // nombres de caractères

        $title = '';
        for($i=0; $i<25; $i++){
            $title .= $caracteres[rand(0, $nCaracteres-1)];
        }
        $text = '';
        for($i=0; $i<300; $i++){
            $text .= $caracteres[rand(0, $nCaracteres-1)];
        }
        
        // Insertion de l'article
        $title_slug = strtolower(str_replace(' ', '-', $title));
        $insertArticle = $db->exec("INSERT INTO article (`title`, `title_slug`, `text`, `user_id`, `article_date_create`, `published`) VALUES ('$title', '$title_slug', '$text', 211, NOW(), 1)");
        
        $lastId = $db->lastInsertId();
        // on va inclure le fichier insertView.php
        include "../view/insertView.php";
    } elseif ($_GET['p'] == "update") {
        // requête qui va mettre 3 articles au hasard à la date du jour (article_date_create)
        $updateArticle = $db->exec("UPDATE article SET article_date_create = NOW() ORDER BY RAND() LIMIT 3");

        // on va inclure le fichier updateView.php
        include "../view/updateView.php";
    }
} else {
    // sur l'accueil, on va récupérer les 10 derniers articles publiés par date de création DESC
    $sql = "SELECT a.id , a.title , a.title_slug , a.text, a.article_date_create, u.fullname
            FROM article a
            JOIN user u ON a.user_id = u.id
            WHERE a.published = 1
            ORDER BY a.article_date_create DESC
            LIMIT 10";
    // on va faire une requête avec le PDO
    $requestTheArticle = $db->query($sql);
    // on va récupérer les résultats
    $articles = $requestTheArticle->fetchAll();
    // on va fermer le curseur
    $requestTheArticle->closeCursor();
    // on va fermer la connexion
    $db = null;

    // appel de la vue accueilView.php
    include "../view/accueilView.php";
}