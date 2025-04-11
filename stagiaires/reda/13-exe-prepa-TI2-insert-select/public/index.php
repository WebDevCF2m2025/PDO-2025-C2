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
try {
  $db = new PDO(
    DB_CONNECT_TYPE . ":host=" . DB_CONNECT_HOST . ";dbname=" . DB_CONNECT_NAME . ";port=" . DB_CONNECT_PORT . ";charset=" . DB_CONNECT_CHARSET,
    DB_CONNECT_USER,
    DB_CONNECT_PWD,
    [
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]
  );
} catch (Exception $e) {
  // arrêt du script et affichage du code erreur, et du message
  die("Code : {$e->getCode()} <br> Message : {$e->getMessage()}");
}

# ici notre code de traitement de la page
// // si on a envoyé le formulaire avec les bons champs

if (isset($_POST['surname'], $_POST['email'], $_POST['message'])) {

  $insert = addMessage($db, $_POST['surname'], $_POST['email'], $_POST['message']);

  if ($insert === true) {
    $recue = "Votre message a bien été envoyé";
  } else {
    $error = $insert;
  }
}



// // on veut récupérer tous les messages de la table `article`
$messages = getAllMessagesOrderByDateDesc($db);





# chargement de la vue
require_once "../view/homepage.view.php";

# bonne pratique
# fermeture de connexion
$db = null;
