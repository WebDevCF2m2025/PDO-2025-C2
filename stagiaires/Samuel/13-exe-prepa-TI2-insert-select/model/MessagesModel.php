<?php
# fonctions en lien avec la table article
function getMessagesOrderByDateDesc (PDO $connection): array
{

    // On prépare la requête
    $prepare = $connection->prepare("
        SELECT * FROM `article`
        ORDER BY `article`.`create_date` DESC
    ");

    // essai / erreur
    try{
        // On exécute la requête
        $prepare->execute();

        // On renvoie le tableau (array) indexé contenant l'ensemble des résultats (il peut être vide si on a pas de message)
        return $prepare->fetchAll();

    // Si on a une erreur SQL
    }catch (Exception $e) {
        // on affiche l'erreur de la requête SQL
        die($e->getMessage());
    }
}

// Création de la fonction pour insérer un message dans la table `article` en bloquant les diverses injections SQL
function addMessage(PDO $con, string $surname, string $email, string $commentary) : bool|string
{
    // erreur si vide au cas où
    $erreur = "";
    // Protection supplémentaire

    // Verification du nombre de caractères strlen() et la validité du nom
    $surnameProtection = strip_tags($surname); # Ici on retire les tags
    $surnameProtection = htmlspecialchars($surnameProtection, ENT_QUOTES); # Ici on se protège des caractères spéciaux (avec ' et ")
    $surnameProtection = trim($surnameProtection); # Et ici on retire les espaces avant/arrière de l'entrée utilisateur

    // Condition qui vérifie si le surname est vide
    if(empty($surnameProtection)) {
        $erreur .= "Votre surname est incorrect.<br>";

    // Ici on vérifie que le surname est pas plus long que ce qui est autorisé dans la db
    } elseif(strlen($surnameProtection)>60) {
        $erreur.= "Votre surname est trop long.<br>";
    }


    // Vérification de l'email
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    // Condition qui vérifie si le mail n'est pas correct
    if($email === false) {
        $erreur.= "Votre email est incorrect.<br>";
    }

    // Vérification du nombre de caractères strlen() et validité du message
    $commentary = trim(htmlspecialchars(strip_tags($commentary), ENT_QUOTES));
    if(empty($commentary) || strlen($commentary)>500) {
        $erreur .= "Votre commentaire dépasse la limite autorisé de caractères.<br>";
    }

    // Si on détecté au moins 1 erreur 
    if(!empty($erreur)) return $erreur;

    // Si pas d'érreur detectée
    $prepare = $con->prepare("
    INSERT INTO `article` (`surname`, `email`, `message`)
    VALUES (?,?,?)
    ");
    try{
        $prepare->execute([$surnameProtection,$email,$commentary]);
        return true;
    }catch(Exception$e){
        die($e->getMessage());
    }
}
