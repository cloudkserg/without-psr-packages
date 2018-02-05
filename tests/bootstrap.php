<?php

error_reporting(E_ALL ^ (E_WARNING | E_NOTICE | E_DEPRECATED));
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');


$rootPath = __DIR__;
require_once($rootPath . '/vendor/autoload.php');
