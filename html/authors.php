<h1>Авторы</h1>
<ul>
    <?php foreach ($authors as $author) { ?>
        <li>
            <a href="author.php?id=<?= $author['id'] ?>">
                <?= $author['author'] ?> </a>
        </li>
    <?php } ?>
</ul>