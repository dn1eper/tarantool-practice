<?php
    function _build_nav_tree($arr, $parent, $idle = false) {
        $flag = true;
        foreach ($arr as $item) {            
            if ($item["parent"] == $parent) {
                if ($idle) return true;
                else if ($flag) {
                    echo "<ul>";
                    $flag = false;
                }
                echo "<li title='{$item["title"]}' class='menu-item";
                if (_build_nav_tree($arr, $item["id"], true)) echo "-has-child";
                echo "'><a href='{$item["url"]}'>{$item["name"]}</a>";
                _build_nav_tree($arr, $item["id"]);
                echo "</li>";                
            }
        }
        if(!$flag) echo "</ul>";
        return !$flag;
    }