<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
    <title>Nos 30 derniers articles</title>
</head>

<body>
    <nav>
        <?php
        include "inc/menu.inc.view.php";
        ?>
    </nav>
    <main>
        <section>
            <div>
                <h1>Nos 30 derniers articles</h1>
                <p>Par date desc</p> <br>
                <?php
            foreach ($articles as $article):
            ?>
                <h3>
                    <?= $article["thearticletitle"] ?>
                </h3>
                <p><?= "En date de {$article['thearticledate']}" ?></p>
            <?php
            endforeach;
            ?>
            </div>
        </section>
    </main>

</body>

</html>