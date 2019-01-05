<?php
    //data.php
    require "template/data.php";
    //functions.php
    require "template/utils.php";
    //head.php
    if(is_file("template/head.php")) 
        require "template/head.php";
    else echo "<html>";
    echo "<body>";
    //header.php
    //if(is_file("template/header.php")) 
    //    require "template/header.php";
    //main.php
    if(is_file("template/menu.php")) 
        require "template/menu.php";
    //content.php
    if(is_file("template/content.php"))
        require "template/content.php";
    //footer.php
    if(is_file("template/footer.php")) 
        require "template/footer.php";
    //script.php
    if(is_file("template/script.php"))
        require "template/script.php";
    else echo "</body></html>";