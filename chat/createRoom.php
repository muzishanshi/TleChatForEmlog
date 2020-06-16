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
//创建聊天室
$nickname=$userData['nickname']?$userData['nickname']:$userData['username'];
$result=createRoom(Option::get('blogname'),array($nickname), $config_app["appId"], $config_app["appKey"]);
if(isset($result["objectId"])){
	$config_app["objectId"]=$result["objectId"];
	$config_app["createdAt"]=$result["createdAt"];
	$DB -> query("UPDATE `".DB_PREFIX."options`  SET `option_value` = '".addslashes(serialize($config_app))."' WHERE `option_name` = 'TleChat_option' ");
	echo('创建成功');exit;
}else{
	echo('创建失败，请确认appid和appkey正确性。');exit;
}
?>