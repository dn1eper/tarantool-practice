<?php
ini_set('display_errors', 1);
require_once('database/user.php');

$res = ['status' => 'success', 'message' => false];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['name']) && $login = $_POST['name']) {
    $user = new User($login, $_POST['password']);
    if (!$user->check()) {
        $res['status']  = 'error';
        $res['message'] = $user->error_msg();
    }
    else $res['message'] = "User login success";
}

if(is_file("template/template.php")) {
    $__TITLE = "Login";
    $__CONTENT = file_get_contents("template/html/login-form.html");

    if ($res['message']) {
        $__ALERT = $res['message'];
    }

    require "template/template.php";
}