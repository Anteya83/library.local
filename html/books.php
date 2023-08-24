<h1>Все книги</h1>

<ul>
    <?php foreach ($books as $book) { ?>
        <li>
            <a href="book.php?id=<?= $book['id'] ?>">
                <?= $book['title'] ?> </a>

        </li>

    <?php } ?>
</ul>