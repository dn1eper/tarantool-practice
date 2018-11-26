<?php
    //TITLE
    $__TITLE = "MySite";

    //META
    $__META = array(
        array(  "http-equiv" => "Content-Type",
                "content" => "text/html; charset=utf-8"),
        array(  "name" => "viewport",
                "content" => "width=device-width, initial-scale=1.0"),
        array(  "http-equiv" => "X-UA-Compatible",
                "content" => "ie=edge")
    );

    //CSS FILES
    $__CSS = array("template/css/style.css");

    //HEADER
    $__HEADER__TEXT = "MySite";
    $__HEADER__IMAGE = "template/img/logo.png";

    //NAVIGATION/MENU
    $__NAV = array(
        array('name' => 'Main page', 'title' => 'Main page', 'url' => '/', 'parent' => '0', 'id' => '1'),
        array('name' => 'Other pages', 'title' => 'Some other shit', 'url' => '', 'parent' => '0', 'id' => '2'),
        array('name' => 'Page 1', 'title' => 'Page 1', 'url' => 'page1.php', 'parent' => '2', 'id' => '3'),
        array('name' => 'Page 2', 'title' => 'Page 2', 'url' => 'page2.php', 'parent' => '2', 'id' => '4'),
        array('name' => 'Login', 'title' => 'Описание 2.1', 'url' => 'login.php', 'parent' => '0', 'id' => '5'),
        array('name' => 'SignUp', 'title' => 'Описание 3', 'url' => 'signup.php', 'parent' => '0', 'id' => '6')        
    );
    
    //FOOTER
    $__FOOTER = "MySite 2018";

    //SCRIPT FILES
    $__SCRIPT = array("template/javascript/script.js");