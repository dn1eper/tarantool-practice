<?php          
    if(is_file("template/template.php")) {
        $__TITLE = "Sign up";
        $__CONTENT = file_get_contents("template/html/signup-form.html");

        require "template/template.php";
    }
