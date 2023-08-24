<?php
require_once 'src/Base.php';
$title = "Библиотека";
$content = 'index';
$books = $db->getCountRows('books');
$book_copies = $db->getCountRows('book_copies');
$authors =  $db->getCountRows('authors');
$users = $db->getCountRows('users');
$books_copies_available = $db->getCountRows('book_copies', '`return_date` IS NULL');

require_once 'html/main.php';
