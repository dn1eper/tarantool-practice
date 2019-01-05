<?php
//ini_set('display_errors', 1);

require_once('model/user.php');
require_once('tarantool/index.php');

session_start();
if (isset($_SESSION['id'])) {
    $tarantool = new Tarantool_User($_SESSION['id'], $_SESSION['accessToken']);
    $_SESSION['valid'] = $tarantool->validate();
}
else $_SESSION['valid'] = false;