<h1><?= $author['author'] ?></h1>
<p><?= $author['description'] ?></p>
<h2>Книги автора</h2>
<ul>
    <?php foreach ($books as $book) { ?>
        <li>
            <a href="book.php?id=<?= $book['id'] ?>">
                <?= $book['title'] ?> </a>
        </li>
    <?php } ?>
</ul>