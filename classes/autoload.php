<?php
function autoloadModel($className) {
    $filename = $_SERVER['DOCUMENT_ROOT'] . "/store2/classes/" . $className . ".php";
    if (is_readable($filename)) {
        require $filename;
    }
}


spl_autoload_register("autoloadModel");