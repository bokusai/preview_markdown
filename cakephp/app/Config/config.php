<?php
define('CLASS_DIR', ROOT . '/class/');
require CLASS_DIR . 'ClassAutoLoader.php';
$ClassAutoLoader = new ClassAutoLoader();
$ClassAutoLoader->registerDir(CLASS_DIR);
