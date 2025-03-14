<?php
# index.php | Contrôleur frontal

// on appelle le fichier config-prod.php (requis une seule fois).
require_once "../../07-3-tables/config-prod.php";

// en utilisant un try / catch
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

// suivant l'existence de certaines variables get
if(!empty($_GET)) {
    // effectuez la requête SQL propre à chaque page, puis appelez les vues vers les pages
    if (isset($_GET['articles'])) {
        $articles = $db->query("SELECT * FROM `thearticle` ORDER BY `thearticledate` DESC LIMIT 30");
        include "../view/articles.view.php";
        $articles->closeCursor();

    } elseif (isset($_GET['rubriques'])) {
        $rubriques = $db->query("SELECT * FROM `thesection` ORDER BY `idthesection` ASC");
        include "../view/rubriques.view.php";
        $rubriques->closeCursor();

    } elseif (isset($_GET['users'])) {
        $users = $db->query("SELECT * FROM `theuser` ORDER BY `theuserlogin` ASC");
        include "../view/users.view.php";
        $users->closeCursor();
    }   

}else{
    // appel de la vue de l'accueil
    include "../view/accueil.view.php";
}



// fermeture de connexion
$db = null;