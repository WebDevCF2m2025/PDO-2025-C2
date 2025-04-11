<?php
// Contrôleur frontal

// on appelle le fichier config-prod.php (requis une seule fois).
require_once "config-prod.php";


// on se connecte à la DB 'pdo_c2' via PDO
// en utilisant les constantes de connexion
// en utilisant un try / catch
try {
  // instanciation avec PDO
  $db = new PDO(
    DB_CONNECT_TYPE . ":host=" . DB_CONNECT_HOST . ";dbname=" . DB_CONNECT_NAME . ";port=" . DB_CONNECT_PORT . ";charset=" . DB_CONNECT_CHARSET,
    DB_CONNECT_USER,
    DB_CONNECT_PWD,
  );
} catch (Exception $e) {
  die($e->getMessage());
}
// on effectue une requête où on prend les 20 derniers articles
// par `thearticle`.`thearticledate` descendant avec query()
$requestTheArticle = $db->query("
        SELECT a.`idthearticle` as id,
               a.`thearticletitle` as title,
               a.`thearticledate` as `date`  
            FROM `thearticle` a 
           ORDER BY `thearticledate` DESC LIMIT 20 ");
// transformation en tableau associatif (fetchAll)
$resultTheArticle = $requestTheArticle->fetchAll();
// fermeture de la requête
$requestTheArticle->closeCursor();
// fermeture de connexion
$db = null;
// appel de la vue (ligne finale)
include "accueilView.php";
