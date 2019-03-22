<?php
/*
Plugin Name: TleChat聊天室
Version: 1.0.3
Description: 站长聊天室插件为Emlog站长提供聊天室功能，让站长之间的联系更加友爱，支持文本、长文本、语音聊天、图片传输及站长之间的QQ、微信、支付宝打赏，共同建立一个友爱的站长联盟。
Plugin URL: https://github.com/muzishanshi/TleChatForEmlog
ForEmlog: 5.3.1
Author: 二呆
Author URL: http://www.tongleer.com
*/
if(!defined('EMLOG_ROOT')){die('err');}
function tle_chat_menu(){
	echo '<div class="sidebarsubmenu"><a href="./plugin.php?plugin=TleChat">聊天室</a></div>';
}
addAction('adm_sidebar_ext', 'tle_chat_menu');

function tle_chat_head(){
	echo '
		<link rel="stylesheet" href="'.BLOG_URL.'content/plugins/TleChat/chat/ui/css/layui.css"  media="all">
	';
}
addAction('index_head', 'tle_chat_head');
function tle_chat_footer(){
	echo '
		<div style="position:fixed;bottom:0;right:0;">
			<button id="btnChatroom" class="layui-btn layui-btn-normal">站长聊天室</button>
		</div>
		<script src=https://apps.bdimg.com/libs/jquery/1.7.1/jquery.min.js></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/layer/2.3/layer.js"></script>
		<script>
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
		</script>
	';
}
addAction('index_footer', 'tle_chat_footer');