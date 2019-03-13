<?php
header("Content-type: text/html; charset=utf-8");
require_once '../../../../init.php';
include_once "../include/function.php";
date_default_timezone_set("Etc/GMT-8");
if(ROLE!=ROLE_ADMIN){echo('无权限');exit;}

$config_app=@unserialize(ltrim(file_get_contents(dirname(__FILE__).'/../../../plugins/TleChat/config/config_app.php'),'<?php die; ?>'));
if(!isset($config_app["appId"])||!isset($config_app["appKey"])){echo('有未填写参数');exit;}
//创建聊天室
$nickname=$userData['nickname']?$userData['nickname']:$userData['username'];
$result=createRoom(Option::get('blogname'),array($nickname), $config_app["appId"], $config_app["appKey"]);

file_put_contents(dirname(__FILE__).'/../../../plugins/TleChat/config/config_room.php','<?php die; ?>'.serialize(array(
	'objectId'=>$result["objectId"],
	'createdAt'=>$result["createdAt"]
)));

echo('创建成功');exit;
?>