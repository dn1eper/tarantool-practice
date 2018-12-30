<?php
    if (isset($_POST["name"])) {
        echo "your name is ".$_POST["name"];
    }
    else if(is_file("template/template.php")) {
        $__TITLE = "Login";
        $__CONTENT = file_get_contents("template/html/login-form.html");

        require "template/template.php";
    }