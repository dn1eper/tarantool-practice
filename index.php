<?php          
    if(is_file("template/template.php")) {
        $__TITLE = "Main page";
        $__CONTENT = "<h1>Best topic ever</h1>
            <p>Some intresting information</p>";

        require "template/template.php";
    }
