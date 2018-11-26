<body>
<!--HEADER-->
<header>
    <?php if(is_file($__HEADER__IMAGE)): ?>
        <img src=<?=$__HEADER__IMAGE?> alt="logo">
    <?php endif ?>
    <?=$__HEADER__TEXT?>
</header>
<!--MENU-->
<nav>
    <?php _build_nav_tree($__NAV, 0) ?>
</nav>