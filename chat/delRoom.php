<?php
header("Content-type: text/html; charset=utf-8");
require_once '../../../../init.php';
include_once "../include/function.php";
date_default_timezone_set("Etc/GMT-8");
if(ROLE!=ROLE_ADMIN){echo('无权限');exit;}

$DB = Database::getInstance();
$get_option = $DB -> once_fetch_array("SELECT * FROM `".DB_PREFIX."options` WHERE `option_name` = 'TleChat_option' ");
$config_app=unserialize($get_option["option_value"]);
if(!isset($config_app["appId"])||!isset($config_app["appKey"])){echo('有未填写参数');exit;}
if($config_app["objectId"]==""){echo('聊天室为空，不必删除。');exit;}
//删除聊天室
$result=delRoom($config_app["objectId"], $config_app["appId"], $config_app["appKey"]);

$config_app["objectId"]="";
$config_app["createdAt"]="";
$DB -> query("UPDATE `".DB_PREFIX."options`  SET `option_value` = '".addslashes(serialize($config_app))."' WHERE `option_name` = 'TleChat_option' ");

echo('删除完成');exit;
?>