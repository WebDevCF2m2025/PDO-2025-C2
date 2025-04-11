<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
    <title>Exercice</title>
</head>

<body>
    <h1>Exercice</h1>
    <h2>Laissez-nous un message</h2>
    <?php

    if (isset($recue)):
    ?>
        <h4 class='thanks'><?= $recue ?></h4>;
    <?php
    endif;
    // si on a une erreur lors de l'insertion
    if (isset($error)):
    ?>
        <h4 class="error"><?= $error ?></h4>
    <?php
    endif; ?>
    <pre>
    Le formulaire se trouve ici
    </pre>
    <form action="" method="post">
        <label for="surname">Nom</label>
        <input type="text" name="surname" id="name" required>
        <br>
        <label for="email">Email</label>
        <input type="email" name="email" id="email" required>
        <br>
        <label for="message">Message</label>
        <textarea name="message" id="message" cols="30" rows="10" required></textarea>
        <br>
        <button type="submit">Envoyer</button>

    </form>
    <hr>
    <?php $nombMessage = count($messages) ?>
    <pre>
Affichage du nombre de messages :
<?php
if ($nombMessage < 1):
?>
Pas de message : Pas encore de message
<?php
elseif ($nombMessage === 1):
?>
1 message : Il y a <?= $nombMessage ?> message

<?php
else:
?>
Plusieurs messages : Il y a <?= $nombMessage ?> messages
<?php
endif;
?>
</pre>
    <hr>
    <pre>
    <?php
    foreach ($messages as $message):
    ?>
Nos messages par date DESC

NOM: <h3 style="display: inline;"><?= $message['surname'] ?></h3><br>
TEXTE: <p style="display: inline;"><?= $message['message'] ?></p><br>
DATE: <p style="display: inline;"><?= $message['create_date'] ?></p>

    <hr>

    <?php
    endforeach;
    ?>
</pre>
    <hr>
</body>

</html>