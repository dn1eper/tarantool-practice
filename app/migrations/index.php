<?php
    require_once('migrations.php')
    $config = require('config.php')

    $db = new Migration($config['host'], $config['user'], $config['password'], $config['database']);

    if ($db->is_error()) {
        echo $db->error_msg();
    }
    else {
        if ($db->last_new_version()) {
            if ($db->migrate()) {
                echo "Your database has been updated from version ".$db->cur_version()." (".$db->last_migration_date().
                ") to new ".$db->last_new_version()." version.";
            }
            else if ($db->is_error()) {
                echo $db->error_msg();
            } 
            else echo "Avalible new version ".$db->last_new_version().", but migration faild. Try again.";
        }            
        else echo "Your have the latest database version.";
    }

