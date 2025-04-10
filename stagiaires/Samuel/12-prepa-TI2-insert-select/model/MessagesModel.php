<?php

// création d'une fonction qu va récupérer tous nos messages
function getAllMessagesOrderByDateDesc(PDO $connection): string|array
{   
    // Préparation de la requête 
    $prepare = $connection->prepare("
        SELECT * FROM `messages`
        ORDER BY `messages`.`created_at` DESC
        ");
    // essai / erreur
    try{
        // exécution de la requête
        $prepare->execute();
        // on compte le nombre de résultats
        $count = $prepare->rowCount();
        // si nous n'avons pas de résultats
        // on renvoie une chaîne de caractère (string)
        if ($count === 0) return "Pas encore de message.";

        // on renvoie le tableau indexé contenant tous les résultats
        return $prepare->fetchAll();

    // en cas d'erreur SQL 
    }catch (Exception $e) {
        // on renvoie l'exception (PDO Exception)
        die($e->getMessage());
    }
}

// Création d'une fonction qui insert un message dans la table `messages`
function addMessage(PDO $con, string $name, string $email, string $text) : bool 
{
    $prepare = $con->prepare("
        INSERT INTO `messages` (`name`, `email`, `message`)
        VALUES (?,?,?)
    ");

    try{
        $prepare->execute([$name, $email, $text]);
        return true;
    }catch(Exception $e) {
        die($e->getMessage());
    }
}
    