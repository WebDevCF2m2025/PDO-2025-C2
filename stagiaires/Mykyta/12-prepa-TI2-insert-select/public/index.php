<?php
# public/index.php

/*
 * Contrôleur frontal
 */

# chargement des constantes de connexion en mode dev
require_once "../config.dev.php";
# chargement du modèle
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

if (isset($_POST["name"], $_POST["email"], $_POST["message"])) {
    $name = strip_tags($_POST['name']);
    $name = htmlspecialchars($name, ENT_QUOTES);
    $name = trim($name);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

    $message = strip_tags($_POST['message']);
    $message = htmlspecialchars($message, ENT_QUOTES);
    $message = trim($message);


    //vérivication ultime avant d'appeler l'insertion
    if (!empty($name) && $email !== false && !empty($message)) {
        $insert = addMessage($db, $name, $email, $message);
    } else {
        $error = "Erreur dans le formulaire !";
    }
}

//on veut récupérer tous les messages de la base de données
$allMessages = getAllMessagesOrderByDateDesk($db);

if(is_string($allMessages)){
    $h2 = $allMessages;
    $messages = "aucun";
}else{
    $countMessages = count($allMessages);
    $h2 = ($countMessages === 1)
    ? "Il y a 1 message"
    : "Il y a $countMessages messages";
    $messages = $allMessages;
}
# bonne pratique
# fermeture de connexion
$db = null;

# chargement de la vue
require_once "../view/homepage.view.php";