<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
    <title>Toutes les rubriques</title>
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
            <h1>Toutes les rubriques</h1>
            <?php
        foreach($rubriques as $rubrique):
        ?>
        <h2><?=$rubrique['thesectiontitle'];
        ?>
        </h2>
        <?php
        endforeach;
        ?>
            </div>
        </section>
       
    </main>

</body>

</html>