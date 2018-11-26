<html lang="ru">
<head>
    <!--META-->
    <?php foreach($__META as $item): ?>
        <meta <?=isset($item['http-equiv']) ? 'http-equiv='.$item['http-equiv'] : 'name='.$item['name']?>
        content="<?=$item['content']?>">
    <?php endforeach ?>
    <!--TITLE-->
    <title><?=$__TITLE?></title>
    <!--LINK CSS-->
    <?php foreach($__CSS as $item): ?>
        <?php if(is_file($item)): ?>
            <link href="<?=$item?>" rel="stylesheet">
        <?php endif ?>
    <?php endforeach ?>
</head>