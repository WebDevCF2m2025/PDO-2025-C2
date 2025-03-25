<?php
# Contrôleur frontal
require_once "../config-prod.php"; // Appelle le fichier de configuration "config-prod.php" une seule fois
# Appelle le fichier de configuration "config-prod.php" une seule fois

# Utilisation d'un try/catch pour gérer les exceptions
# et connexion à la base de données
try{

    // on se connecte à la DB 'pdo_c2' via PDO
    $db = new PDO(
        // en utilisant les constantes de connexion
        DB_CONNECT_TYPE.":host=".DB_CONNECT_HOST.";dbname=".DB_CONNECT_NAME.";port=".DB_CONNECT_PORT.";charset=".DB_CONNECT_CHARSET,
        DB_CONNECT_USER,
        DB_CONNECT_PWD,
    );

    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

// et en activant les erreurs et le fetchAssoc par défaut
} catch(Exception $e) {

    // arrêt du script avec die(), et affichage de la méthode se trouvant dans l'instance de 'Exception' via $e
    die($e->getMessage());
}

/*
 * Attention !
 * appel d'un routeur se trouvant dans le dossier `controller`
 * Il fera les requêtes et affichera les résultats dans les vues
 * Regardez accueilView.php comme page par défaut
 */


include "../controller/routeController.php";