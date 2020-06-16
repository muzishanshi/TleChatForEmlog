<?php if(!defined('EMLOG_ROOT')){die('err');}?>
<?php
$action=empty($_POST['action'])?'':trim($_POST['action']);
if(!empty($_POST)&&$action=="submitTleChat"){
	$DB = Database::getInstance();
	$isEnableJQuery=empty($_POST['isEnableJQuery'])?'y':trim($_POST['isEnableJQuery']);
	$appId=empty($_POST['appId'])?'':trim($_POST['appId']);
	$appKey=empty($_POST['appKey'])?'':trim($_POST['appKey']);
	$notice=empty($_POST['notice'])?'':trim($_POST['notice']);
	$chatType=empty($_POST['chatType'])?'':$_POST['chatType'];
	$chatType=implode("|",$chatType);
	if(get_magic_quotes_gpc()){
		$isEnableJQuery=stripslashes($isEnableJQuery);
		$appId=stripslashes($appId);
		$appKey=stripslashes($appKey);
		$notice=stripslashes($notice);
		$chatType=stripslashes($chatType);
	}
	$get_option = $DB -> once_fetch_array("SELECT * FROM `".DB_PREFIX."options` WHERE `option_name` = 'TleChat_option' ");
	$config_app=unserialize($get_option["option_value"]);
	$config_app["isEnableJQuery"]=$isEnableJQuery;
	$config_app["appId"]=$appId;
	$config_app["appKey"]=$appKey;
	$config_app["notice"]=$notice;
	$config_app["chatType"]=$chatType;
	$DB -> query("UPDATE `".DB_PREFIX."options`  SET `option_value` = '".addslashes(serialize($config_app))."' WHERE `option_name` = 'TleChat_option' ");
	header('Location:./plugin.php?plugin=TleChat');
}
function plugin_setting_view(){
	$DB = Database::getInstance();
	$get_option = $DB -> once_fetch_array("SELECT * FROM `".DB_PREFIX."options` WHERE `option_name` = 'TleChat_option' ");
	$config_app=unserialize($get_option["option_value"]);
	$chatType=explode("|",$config_app["chatType"]);
	?>
	<div>
		<fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
		  <legend>
			版本检查
		  </legend>
		</fieldset>
		<span id="TleChatUpdateInfo"></span><script>TleChatXmlHttp=new XMLHttpRequest();TleChatXmlHttp.open("GET","https://www.tongleer.com/api/interface/TleChat.php?action=updateEmlog&version=<?=TLECHAT_VERSION;?>&domain=<?=$_SERVER['SERVER_NAME'];?>",true);TleChatXmlHttp.send(null);TleChatXmlHttp.onreadystatechange=function () {if (TleChatXmlHttp.readyState ==4 && TleChatXmlHttp.status ==200){var data=JSON.parse(TleChatXmlHttp.responseText);document.getElementById("TleChatUpdateInfo").innerHTML=data.content;$("#chatUrl").html('<iframe src="'+decodeURIComponent(data.url)+'" width="100%" height="800" scrolling = "no"></iframe>');}}</script>
		<fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
		  <legend>
			即时聊天
		  </legend>
		</fieldset>
		<form id="TleChatSetForm" method="post" action="">
			<p style="margin-top:10px;">
				前台是否加载jquery：
				<input type="radio" name="isEnableJQuery" value="n" <?=isset($config_app['isEnableJQuery'])?($config_app['isEnableJQuery']=="n"?"checked":""):"";?> />否
				<input type="radio" name="isEnableJQuery" value="y" <?=isset($config_app['isEnableJQuery'])?($config_app['isEnableJQuery']!="n"?"checked":""):"checked";?> />是
			</p>
			<p style="margin-top:10px;">
				开关：
				<input type="checkbox" name="chatType[]" value="leancloud" <?=in_array("leancloud",$chatType)?"checked":"";?> />leancloud
				<input type="checkbox" name="chatType[]" value="easemob" <?=in_array("easemob",$chatType)?"checked":"";?> />环信
			</p>
			<div class="leancloudTag" style="border:1px dashed #000;">
				<p class="leancloudTag" style="margin-top:10px;">
					<input type="hidden" id="objectId" value="<?=isset($config_app["objectId"])?$config_app["objectId"]:"";?>" />
					<input type="button" id="clearAudio" value="清空所有录音" />
					<input type="button" id="delRoom" value="删除当前聊天室" />
					<input type="button" id="createRoom" value="创建新聊天室" />
				</p>
				<p class="leancloudTag" style="margin-top:10px;">
					前台聊天室配置<a href="https://leancloud.cn/" target="_blank"><font color="blue">leancloud</font></a>的appId<br /><input type="text" name="appId" value="<?=$config_app["appId"]==""?"":$config_app["appId"];?>" placeholder="leancloud的appId" size="50" />
				</p>
				<p class="leancloudTag" style="margin-top:10px;">
					前台聊天室配置<a href="https://leancloud.cn/" target="_blank"><font color="blue">leancloud</font></a>的appKey<br /><input type="text" name="appKey" value="<?=$config_app["appKey"]==""?"":$config_app["appKey"];?>" placeholder="leancloud的appKey" size="50" />
				</p>
				<p class="leancloudTag" style="margin-top:10px;">
					公告<br /><input type="text" name="notice" value="<?=$config_app["notice"]==""?"":$config_app["notice"];?>" placeholder="输入前台显示的公告" size="50" />
				</p>
				<p class="leancloudTag" style="margin-top:10px;">
					备注：若新增除语音和图片外的其他功能，暂时只支持单独添加。
				</p>
			</div>
			<hr />
			<div class="easemobTag" style="border:1px dashed #000;">
				更多即时通信功能需要升级插件
			</div>
			<p style="margin-top:10px;">
				<input type="hidden" name="action" value="submitTleChat" />
				<input type="submit" style="background-color: #4CAF50;border: none;color: white;padding:5px 5px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;border-radius: 5%;" value="保存基础设置" />
			</p>
		</form>
		<div id="chatUrl" class="leancloudTag" style="margin-top:10px;"></div>
	</div>
	<script>
		<?php if(in_array("leancloud",$chatType)){?>
		$(".leancloudTag").show();
		<?php }else{?>
		$(".leancloudTag").hide();
		<?php }?>
		<?php if(in_array("easemob",$chatType)){?>
		$(".easemobTag").show();
		<?php }else{?>
		$(".easemobTag").hide();
		<?php }?>
		$("#TleChatSetForm input[name='chatType[]']").change(function(){
			if($(this).prop("checked")){
				if($(this).val()=="leancloud"){
					$(".leancloudTag").show();
				}else if($(this).val()=="easemob"){
					$(".easemobTag").show();
				}
			}else{
				if($(this).val()=="leancloud"){
					$(".leancloudTag").hide();
				}else if($(this).val()=="easemob"){
					$(".easemobTag").hide();
				}
			}
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
		<?php if(Option::EMLOG_VERSION>="6.1.1"){?>
		$("#TleChat").addClass('layui-this');
		$("#TleChat").parent().parent().addClass('layui-nav-itemed');
		<?php }else if(Option::EMLOG_VERSION=="6.0.0"){?>
		$("#TleChat a").addClass('active');
		<?php }else if(Option::EMLOG_VERSION=="6.0.1"){?>
		$("#TleChat").addClass('active');
		<?php }else if(Option::EMLOG_VERSION=="5.3.1"){?>
		$("#TleChat").addClass('sidebarsubmenu1');
		<?php }?>
	</script>
	<?php
}
?>