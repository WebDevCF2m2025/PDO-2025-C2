<nav>
    <a href="./">Accueil</a> |
    <a href="./?p=insert">Insert</a> |
    <a href="./?p=update">Met à jour</a> |
    <?php
    foreach ($menu as $item):
        ?>
        <a href="./?section=<?= $item['section_slug'] ?>"><?= $item['section_title'] ?></a> |
    <?php
    endforeach;
    ?>
</nav>
