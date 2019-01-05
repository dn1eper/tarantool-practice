<?php
    // TITLE
    $__TITLE = "";

    // META
    $__META = array(
		array(  "http-equiv" => "Content-Type",
			"content" => "text/html; charset=utf-8"),
		array(  "name" => "viewport",
			"content" => "width=device-width, initial-scale=1.0"),
		array(  "http-equiv" => "X-UA-Compatible",
			"content" => "ie=edge")
    );

    // CSS FILES
    $__CSS = array();
	if ($dh = opendir("template/css/")) {
		while ($file = readdir($dh)) {
			if (pathinfo($file, PATHINFO_EXTENSION) == "css") {
				$__CSS[] = "template/css/".$file;
			}
		}
		closedir($dh);
	}

    // HEADER
    $__HEADER__TEXT = "MySite";
    $__HEADER__IMAGE = "template/img/logo.png";

    // NAVIGATION/MENU
    $__NAV = array(
		array('name' => 'Main page', 'title' => 'Main page', 'url' => '/', 'parent' => '0', 'id' => '1'),
		array('name' => 'Login', 'title' => 'Login', 'url' => 'login.php', 'parent' => '0', 'id' => '2'),
		array('name' => 'SignUp', 'title' => 'SignUp', 'url' => 'signup.php', 'parent' => '0', 'id' => '3')        
    );
    
    // FOOTER
    $__FOOTER = "MySite 2018";

    // SCRIPT FILES
	$__SCRIPT = array();
	if (is_dir("template/js/") ) {
		$dh = opendir("template/js/");
		while ($file = readdir($dh)) {
			if (pathinfo($file, PATHINFO_EXTENSION) == 'js') {
				$__SCRIPT[] = "template/js".$file;
			}
		}
		closedir($dh);
	}
