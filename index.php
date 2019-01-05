<?php
require_once('function.php');

if(is_file("template/template.php")) {
    $__TITLE = "Main page";
    if ($_SESSION['valid']) {
        $__CONTENT = "<h1>Hello " .$_SESSION['login']. "</h1>
        <p>Some secret information. <br>HAHAHA!!!</p>";
    }
    else $__CONTENT = "<h1>Best topic ever</h1>
        <p>Some intresting information</p>";

    require "template/template.php";
}
