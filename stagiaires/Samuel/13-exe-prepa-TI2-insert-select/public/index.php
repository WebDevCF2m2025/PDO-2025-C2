<?php
# public/index.php

/*
 * Contrôleur frontal
 */

# chargement des constantes de connexion en mode prod
require_once "../config.php";
# chargement du modèle (fonctions)
require_once "../model/MessagesModel.php";


# connexion à PDO
try{
    // nouvelle instance de PDO
    $db = new PDO(DB_DSN, DB_CONNECT_USER, DB_CONNECT_PWD,
        // tableau d'options
        [
            // par défaut les résultats sont en tableau associatif
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            // Afficher les exceptions
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]
    );
}catch(Exception $e){
    // arrêt du script et affichage du code erreur, et du message
    die("Code : {$e->getCode()} <br> Message : {$e->getMessage()}");
}

# ici notre code de traitement de la page

// si on a envoyé le formulaire avec les bons champs
if(isset($_POST['surname'],$_POST['email'],$_POST['message'])) {

    // On tente l'insertion car on a protégé avec addMessage()
    $insert = addMessage($db, $_POST['surname'],$_POST['email'],$_POST['message']);

    if($insert === true){
        $success = "Nous vous remercions pour votre commentaire";
    }else{
        $error = $insert;
    }
}

// on veut récupérer tous les messages de la table `article`
$messages = getMessagesOrderByDateDesc($db);




# chargement de la vue
require_once "../view/homepage.view.php";

# bonne pratique
# fermeture de connexion
$db = null;