<?php if(!defined('EMLOG_ROOT')){die('err');}?>
<?php
function plugin_setting_view(){
	$action = isset($_POST['action']) ? addslashes(trim($_POST['action'])) : '';
	if($action=='submit'){
		$appId = isset($_POST['appId']) ? addslashes(trim($_POST['appId'])) : '';
		$appKey = isset($_POST['appKey']) ? addslashes(trim($_POST['appKey'])) : '';
		$notice = isset($_POST['notice']) ? addslashes(trim($_POST['notice'])) : '';
		file_put_contents(dirname(__FILE__).'/config/config_app.php','<?php die; ?>'.serialize(array(
			'appId'=>$appId,
			'appKey'=>$appKey,
			'notice'=>$notice
		)));
	}
	$config_app=@unserialize(ltrim(file_get_contents(dirname(__FILE__).'/../../plugins/TleChat/config/config_app.php'),'<?php die; ?>'));
	$config_room=@unserialize(ltrim(file_get_contents(dirname(__FILE__).'/../../plugins/TleChat/config/config_room.php'),'<?php die; ?>'));
	?>
	<div>
		<h2>站长聊天室:</h2>
		作者：<a href="http://www.tongleer.com" target="_blank" title="">二呆</a><br />
		<form method="post" action="">
			<p>
				前台聊天室配置<a href="https://leancloud.cn/" target="_blank">leancloud</a>的appId<br /><input type="text" name="appId" value="<?=$config_app["appId"]==""?"":$config_app["appId"];?>" placeholder="leancloud的appId" size="50" />
			</p>
			<p>
				前台聊天室配置<a href="https://leancloud.cn/" target="_blank">leancloud</a>的appKey<br /><input type="text" name="appKey" value="<?=$config_app["appKey"]==""?"":$config_app["appKey"];?>" placeholder="leancloud的appKey" size="50" />
			</p>
			<p>
				公告<br /><input type="text" name="notice" value="<?=$config_app["notice"]==""?"":$config_app["notice"];?>" placeholder="输入前台显示的公告" size="50" />
			</p>
			<p>
				<input type="hidden" name="action" value="submit" />
				<input type="submit" value="保存基础设置" />
			</p>
			<p>
				<input type="hidden" id="objectId" value="<?=isset($config_room["objectId"])?$config_room["objectId"]:"";?>" />
				<input type="button" id="clearAudio" value="清空所有录音" />
				<input type="button" id="delRoom" value="删除当前聊天室" />
				<input type="button" id="createRoom" value="创建新聊天室" />
			</p>
		</form>
		版本检查：<span id="versionCode"></span><br />
		<small>注：若前台点击午反应，则可能是jquery冲突，只需把插件目录下Plugin.php中加载jquery的代码删掉即可。</small>
		<div id="chatUrl"></div>
		<small style="color:#aaaaaa">站长聊天室插件为站长和用户提供聊天室功能，让站长与用户之间的联系更加友爱，支持文本、长文本、语音聊天、图片传输及站长之间的QQ、微信、支付宝打赏，共同建立一个友爱的联盟。</small>
	</div>
	<script>
		$.post("<?=BLOG_URL;?>content/plugins/TleChat/update.php",{version:6},function(data){
			var data=JSON.parse(data);
			$("#versionCode").html(data.content);
			$("#chatUrl").html('<iframe src="'+decodeURIComponent(data.url)+'" width="100%" height="800" scrolling = "no"></iframe>');
		});
		$("#clearAudio").click(function(){
			$.post("<?=BLOG_URL;?>content/plugins/TleChat/chat/clearAudio.php",{action:"clearAudio"},function(data){
				alert("清空录音成功");
			});
		});
		$("#delRoom").click(function(){
			$.post("<?=BLOG_URL;?>content/plugins/TleChat/chat/delRoom.php",{action:"delRoom"},function(data){
				alert(data);
			});
		});
		$("#createRoom").click(function(){
			var flag=false;
			if($("#objectId").val()!=""){
				if(confirm("确认当前聊天室已经销毁后可创建新聊天室，还要继续吗？")){
					flag=true;
				}
			}else{
				flag=true;
			}
			if(flag){
				$.post("<?=BLOG_URL;?>content/plugins/TleChat/chat/createRoom.php",{action:"createRoom"},function(data){
					alert(data);
				});
			}
		});
	</script>
	<?php
}
?>