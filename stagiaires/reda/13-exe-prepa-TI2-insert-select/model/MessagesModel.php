<?php
# fonctions en lien avec la table article

function getAllMessagesOrderByDateDesc(PDO $connection): array
{
  // requête de sélectio
  $sql = "SELECT * FROM `article` ORDER BY `article`. `create_date` DESC";
  // préparation de la requête
  $stmt = $connection->prepare($sql);

  try {
    // exécution de la requête
    $stmt->execute();

    return $stmt->fetchAll();
  } catch (Exception $e) {
    // erreur de requête SQL
    die($e->getMessage());
  }
}

function addMessage(PDO $con, string $surname, string $email, string $text): bool|string
{
  $erreur = "";

  // Vérification du nom
  $nameVerif = strip_tags($surname);
  $nameVerif = htmlspecialchars($nameVerif, ENT_QUOTES);
  $nameVerif = trim($nameVerif);
  if (empty($nameVerif)) {
    $erreur .= "Votre nom est incorrect. <br>";
  } elseif (strlen($nameVerif) > 100) {
    $erreur .= "Votre nom est trop long. <br>";
  }


  // Vérification de l'email
  $email = filter_var($email, FILTER_VALIDATE_EMAIL);
  if ($email === false) {
    $erreur .= "Email incorrect. <br>";
  }
  // Vérification du message
  $text = trim(htmlspecialchars(strip_tags($text), ENT_QUOTES));
  if (empty($text) || strlen($text) > 600) {
    $erreur .= "Message incorrect. <br>";
  }
  // Si il y a une erreur
  if (!empty($erreur)) return $erreur;


  // Préparation de la requête
  $sql = $con->prepare("INSERT INTO `article` (`surname`, `email`, `message`) VALUES (?, ?, ?)");
  try {
    // Exécution de la requête
    $sql->execute([$nameVerif, $email, $text]);
    return true;
  } catch (Exception $e) {
    die($e->getMessage());
  }
}
