<?php
# public/index.php

/*
 * Contrôleur frontal
 */

# chargement des constantes de connexion en mode dev
require_once "../config.php";
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

// Si on a envoyé le formulaire
if(isset($_POST['name'], $_POST['email'], $_POST['message'])) {
    // traitement des champs

    # On retire les balises HTML
    $name = strip_tags($_POST['name']);
    # Encodage des caractères dangereux en HTML(' et " compris)
    $name = htmlspecialchars($name, ENT_QUOTES);
    # On retire les espaces vides avant et après la variable
    $name = trim($name);

    # Traitement d'un mail 
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

    # Protection d'un message
    $message = trim(htmlspecialchars(strip_tags($_POST['message']), ENT_QUOTES));

    // Vérification ultime avant d'appeler l'insertion
    if(!empty($name) && $email !== false && !empty($message)) {
        $insert = addMessage($db, $name, $email, $message);

    } else {
        $error = "Certains champs ne sont pas valides";
    }

}  

// On veut récuperer tous les messages de la table `messages`
$allMessages = getAllMessagesOrderByDateDesc($db);

// Si c'est une chaîne de caractère, nous n'avons pas de résultat
if(is_string($allMessages)) {
    // Nous allons afficher dans la vue
    $h2 = $allMessages;
    $messages = "aucun";
// C'est un tableau indéxé
} else {
    // On compte le nombre de lignes
    $countMessages = count($allMessages);
    // Si on a un seul message
    $h2 = $countMessages === 1 ? "Il y a 1 message." : "Il y a $countMessages messages.";
    $messages = $allMessages;
}

# chargement de la vue
require_once "../view/homepage.view.php";

# bonne pratique
# fermeture de connexion
$db = null;
