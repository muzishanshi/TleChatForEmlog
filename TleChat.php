<?php
/*
Plugin Name: TleChat聊天室
Version: 1.0.1
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