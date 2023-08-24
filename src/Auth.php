<?php
$error = false;

if (isset($request->auth)) { //if form was send
    $_SESSION['login'] = $request->login ?? ''; //write to session login
    if (isset($request->password) && is_string($request->password)) {
        $_SESSION['password'] = md5($request->password . SECRET); //salt for password
    }
    $error = true;
} elseif (isset($request->logout)) {
    unset($_SESSION['login']);
    unset($_SESSION['password']);
}
//check the correctness of the data and db
$login = $_SESSION['login'] ?? false;
$password = $_SESSION['password'] ?? false;
$auth_user = $db->getRowByWhere('users', '`login` = ? AND `password` = ?', [$login, $password]); //if the data is correct, the array with the user will be written t0 $auth_user
if ($auth_user) {
    // print_r($auth_user);
    $error = false;
}
