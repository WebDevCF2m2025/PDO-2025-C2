<?php
# index.php | Contrôleur frontal

// on appelle le fichier config-prod.php (requis une seule fois).
require_once "config-dev.php";
// on se connecte à la DB 'pdo_c2' via PDO
try{
   
    $db = new PDO(
        // en utilisant les constantes de connexion
        // en utilisant un try / catch
        DB_CONNECT_TYPE.":host=".DB_CONNECT_HOST.";dbname=".DB_CONNECT_NAME.";port=".DB_CONNECT_PORT.";charset=".DB_CONNECT_CHARSET,
        DB_CONNECT_USER,
        DB_CONNECT_PWD,
    );

}catch(Exception $e){
    // arrêt du script avec die(), et affichage de la méthode se trouvant dans l'instance de 'Exception' via $e
    die($e->getMessage());
}


// on effectue une requête où on prend les 20 derniers articles
// par `thearticle`.`thearticledate` descendant avec query()
$requestTheArticle = $db->query("
        SELECT a.`idthearticle` as id,
               a.`thearticledate` as `date` -- alias externes (sortie)
            FROM `thearticle` a -- alias interne (la table)
        ORDER BY a.`thearticledate` DESC
        LIMIT 20;");

// transformation en tableau associatif (fetchAll)
$resultTheArticle = $requestTheArticle->fetchAll();

// fermeture de la requête
$requestTheArticle->closeCursor();
// fermeture de connexion
$db = null;

// appel de la vue
include"accueilView.php";