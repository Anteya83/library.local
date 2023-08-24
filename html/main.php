<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
</head>

<body>
    <div style="float:left;">
        <h4>Меню Сайта</h4>
        <ul>
            <li><a href="/">Главная</a></li>
            <li><a href="books.php">Книги</a></li>
            <li><a href="authors.php">Авторы</a></li>
            <li><a href="registration.php">Регистрация</a></li>
            <?php if ($auth_user) { ?>
                <li><a href="mybooks.php">Мои книги</a></li>
                <?php if ($auth_user['type'] >= LIBRARIAN) { ?>
                    <li>
                        <a href="debtors.php">Должники</a>
                    </li>
                <?php } ?>
                <li><a href="?<?= http_build_query(array_merge($_GET, ['logout' => '1'])) ?>">Exit</li></a>
            <?php } ?>
        </ul>
        <?php if ($auth_user) { ?>
            <p>Здравствуйте, <?= $auth_user['name'] ?>!</p>
        <?php } else { ?>
            <form name="auth" action="" method="post">
                <h3>Вход на сайт</h3>
                <?php if ($error) { ?>
                    <p>Неверный логин и/или пароль!</p>
                <?php } ?>
                <p>
                    <label>Логин:</label>
                    <input type="text" name="login">
                </p>
                <p>
                    <label>Пароль:</label>
                    <input type="password" name="password">
                </p>
                <p>
                    <input type="submit" name="auth" value="Вход">
                </p>
            </form>
        <?php } ?>
    </div>
    <div style="margin-left: 300px">
        <?php require_once "html/$content.php"; ?>
    </div>
</body>

</html>