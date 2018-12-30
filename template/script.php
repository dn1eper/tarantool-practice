<!--SCRIPTS-->
<?php foreach($__SCRIPT as $item): ?>
    <?php if(is_file($item)): ?>
        <script src=<?=$item?>></script>
    <?php endif ?>
<?php endforeach ?>
</body>
</html>