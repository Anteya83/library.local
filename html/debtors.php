<h1>ДОЛЖНИКИ</h1>
<?php if ($book_copies) { ?>
    <table border="1" style="text-align:center;">
        <tr>
            <td>Название книги</td>
            <td>Имя пользователя</td>
            <td>Логин пользователя</td>
            <td>Должна быть возвращена до</td>
            <td>Функции</td>
        </tr>
        <?php foreach ($book_copies as $book_copy) { ?>
            <tr>
                <td>
                    <a href="book.php?id=<?= $book_copy['book_id'] ?>"><?= $books[$book_copy['book_id']]['title'] ?></a>
                </td>
                <td><?= $users[$book_copy['user_id']['name']] ?></td>
                <td><?= $users[$book_copy['user_id']['login']] ?></td>
                <td><?= date(DATE_FORMAT, $book_copy['return_date']) ?></td>
                <td>
                    <a href="?id=<?= $book_copy['id'] ?>&amp;return=1">Возвращена</a>
                </td>
            </tr>
        <?php } ?>
    </table>
<?php } ?>
<h1>Выдать книгу</h1>
<?php if ($available_books) { ?>
    <form action="" name="give" method="post">
        <p>
            <label for="">Пользователь</label>
            <select name="user_id" id="">
                <?php foreach ($all_users as $user) { ?>
                    <option value="<?= $user['id'] ?>"><?= $user['login'] ?></option>
                <?php } ?>

            </select>
        </p>
        <p>
            <label for="">Книга</label>
            <select name="book_id" id="">
                <?php foreach ($available_books as $book) { ?>
                    <option value="<?= $book['id'] ?>"><?= $book['title'] ?></option>
                <?php } ?>

            </select>
        </p>
        <p>
            <input type="submit" name="give" value="Книга выдана">
        </p>
    </form>

<?php } else { ?>
    <p>Дщступных книг нет</p>
<?php } ?>