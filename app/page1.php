<?php          
    if(is_file("template/template.php")) {
        $__TITLE = "Page 1";
        $__CONTENT = "<h1>Hello guest</h1>
            <p>You should login to view this information</p>";

        require "template/template.php";
    }
