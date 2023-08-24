<?php
require_once 'src/Base.php';
$title = "Авторы";
$content = 'authors';
$authors = $db->getRows('authors', order_by: 'author');
require_once 'html/main.php';
