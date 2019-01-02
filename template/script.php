<!--SCRIPTS-->
<?php foreach($__SCRIPT as $item): ?>
    <?php if(is_file($item)): ?>
        <script src=<?=$item?>></script>
    <?php endif ?>
<?php endforeach ?>

<?php if(isset($__ALERT)): ?>
    <script type="text/javascript">
        window.onload = () =>
            alert(<?='"'.$__ALERT.'"'?>)
    </script>
<?php endif ?>
</body>
</html>