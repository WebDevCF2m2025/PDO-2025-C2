<?php
# index.php | Contrôleur frontal

// on appelle le fichier config-prod.php (requis une seule fois).

// en utilisant un try / catch
// on se connecte à la DB 'pdo_c2' via PDO
// en utilisant les constantes de connexion
// et en activant les erreurs et le fetchAssoc par défaut

# Chargement des constantes de connexion
require_once "../config-prod.php";

# Instanciation de PDO avec gestion des erreurs

try{
    // instanciation avec PDO
    $db = new PDO(
        DB_CONNECT_TYPE.":host=".DB_CONNECT_HOST.";dbname=".DB_CONNECT_NAME.";port=".DB_CONNECT_PORT.";charset=".DB_CONNECT_CHARSET,
        DB_CONNECT_USER,
        DB_CONNECT_PWD,
    );
    // on va attribuer à la connexion la manière de gérer les données par PHP
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
// si erreur, instanciation de 'Exception' avec $e comme pointeur
}catch(Exception $e){
    // arrêt du script avec die(), et affichage de la méthode se trouvant dans l'instance de 'Exception' via $e
    echo $e->getCode();
    echo $e->getMessage();

    die($e->getMessage());
}



// on récupère les champs 'idthearticle', 'thearticletitle' et 'thearticledate' lorsque la date est supérieure à '2020-01-01 20:43:30'
$requestTheArticle = $db->query("
        SELECT * FROM `thearticle` ORDER BY `thearticledate` DESC LIMIT 20");
// récupération de toutes les données au format tableau indexé (fetchAll) contenant des tableaux associatifs ($db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);)
$resultTheArticle = $requestTheArticle->fetchAll();

// bonne pratique
$requestTheArticle->closeCursor();

// déconnexion (on a déjà récupéré les résultats)
include"view/accueil.view.php";
?>

<?php

// suivant l'existence de certaines variables get
if(!empty($_GET)) {
// effectuez la requête SQL propre à chaque page, puis appelez les vues vers les pages
 if (isset($_GET['articles'])) {
    $requestArticles = $db->query("SELECT * FROM `thearticle` ORDER BY `thearticledate` DESC LIMIT 30");
    $articles = $requestArticles -> fetchAll();
    include '../view/articles.view.php';
    $requestTheArticle->closeCursor();
 } else if(isset($_GET['users'])) {
    $requetUsers = $db->query("SELECT * FROM `theuser` ORDER BY `theuserlogin`");
    $users = $requetUsers -> fetchAll();
    include '../view/users.view.php';
    $requestTheArticle->closeCursor();
 } else if(isset($_GET['rubriques'])) {
    $requestRubriques = $db->query("SELECT * FROM `thesection`");
    $rubriques = $requestRubriques -> fetchAll();
    include '../view/rubriques.view.php';
    $requestTheArticle->closeCursor();
 }



}else{
    // appel de la vue de l'accueil
    include "../view/accueil.view.php";
}

$db = null;
// fermeture de la requête
// fermeture de connexion