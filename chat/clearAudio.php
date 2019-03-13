<?php
header("Content-type: text/html; charset=utf-8");
require_once '../../../../init.php';
include_once "../include/function.php";
date_default_timezone_set("Etc/GMT-8");
if(ROLE!=ROLE_ADMIN){die('err');}

delDir(dirname(__FILE__)."/upload/audio/");
mkdir(dirname(__FILE__)."/upload/audio/");
?>