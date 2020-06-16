<?php
/*
Plugin Name: 即时聊天
Version: 1.0.6
Description: TleChatForEmlog是一个即时通信聊天插件，暂包括两种聊天系统，1、旧版站长聊天室基于LeanCloud实现，支持文本、长文本、语音聊天、图片传输及QQ、微信、支付宝打赏；2、新版聊天系统基于LayUI和环信实现，功能更多，注意：若Emlog低于6.1.1版本，查看init.php中是否有ADMIN_DIR常量，需给ADMIN_DIR定义常量为后台目录名。使用插件搭建起站长和用户之间的桥梁，共同建立一个友爱的站长联盟。
Plugin URL: https://github.com/muzishanshi/TleChatForEmlog
ForEmlog: 6.1.1
Author: 二呆
Author URL: https://www.tongleer.com
*/
define('TLECHAT_VERSION', '6');
if(!defined('EMLOG_ROOT')){die('err');}
function tle_chat_menu(){
	echo '<li class="sidebarsubmenu layui-nav-item" id="TleChat"><a href="./plugin.php?plugin=TleChat" class="waves-effect">即时通信</a></li>';
}
addAction('adm_sidebar_ext', 'tle_chat_menu');

function tle_chat_head(){
	$DB = Database::getInstance();
	$get_option = $DB -> once_fetch_array("SELECT * FROM `".DB_PREFIX."options` WHERE `option_name` = 'TleChat_option' ");
	$config_app=unserialize($get_option["option_value"]);
	$chatType=explode("|",$config_app["chatType"]);
	if(in_array("leancloud",$chatType)){
		echo '
			<link rel="stylesheet" href="'.BLOG_URL.'content/plugins/TleChat/im/layui/css/layui.css"  media="all">
		';
	}
}
addAction('index_head', 'tle_chat_head');

function tle_chat_footer(){
	$DB = Database::getInstance();
	$get_option = $DB -> once_fetch_array("SELECT * FROM `".DB_PREFIX."options` WHERE `option_name` = 'TleChat_option' ");
	$config_app=unserialize($get_option["option_value"]);
	if(@$config_app['isEnableJQuery']=="y"){
		$jquerysrc='<script src=https://apps.bdimg.com/libs/jquery/1.7.1/jquery.min.js></script>';
	}else{
		$jquerysrc='';
	}
	$chatType=explode("|",$config_app["chatType"]);
	echo !in_array("leancloud",$chatType)?'':'
		<div style="position:fixed;bottom:60px;right:2%;z-index:999999;">
			<button id="btnChatroom" class="layui-btn layui-btn-xs">聊天室</button>
		</div>
		'.$jquerysrc.'
		<script src="https://www.tongleer.com/api/web/include/layui/layui.js"></script>
		<script>
		$(function(){
			layui.use("layer", function(){
				var $ = layui.jquery, layer = layui.layer;
				$("#btnChatroom").click(function(){
					layer.open({
						type: 2
						,title: "聊天室"
						,id: "chatroom"
						,area: ["95%", "95%"]
						,shade: 0
						,maxmin: true
						,offset: "auto"
						,content: "'.BLOG_URL.'content/plugins/TleChat/chat/chat.php"
						,btn: ["关闭"]
						,yes: function(){
						  layer.closeAll();
						}
						,zIndex: layer.zIndex
						,success: function(layero){
						  layer.setTop(layero);
						}
					});
				});
			});
		});
		</script>
	';
}
addAction('index_footer', 'tle_chat_footer');