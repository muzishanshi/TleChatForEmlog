<?php if(!defined('EMLOG_ROOT')){die('err');}?>
<?php
function plugin_setting_view(){
	$action = isset($_POST['action']) ? addslashes(trim($_POST['action'])) : '';
	if($action=='submit'){
		$qqUrl = isset($_POST['qqUrl']) ? addslashes(trim($_POST['qqUrl'])) : '';
		$wechatUrl = isset($_POST['wechatUrl']) ? addslashes(trim($_POST['wechatUrl'])) : '';
		$aliUrl = isset($_POST['aliUrl']) ? addslashes(trim($_POST['aliUrl'])) : '';
		$token = isset($_POST['token']) ? addslashes(trim($_POST['token'])) : '';
		file_put_contents(dirname(__FILE__).'/config.php','<?php die; ?>'.serialize(array(
			'qqUrl'=>$qqUrl,
			'wechatUrl'=>$wechatUrl,
			'aliUrl'=>$aliUrl,
			'token'=>$token
		)));
	}
	$config=@unserialize(ltrim(file_get_contents(dirname(__FILE__).'/../../plugins/TleChat/config.php'),'<?php die; ?>'));
	?>
	<div>
		<h2>站长聊天室:</h2>
		作者：<a href="http://www.tongleer.com" target="_blank" title="">二呆</a><br />
		<form method="post" action="">
			<p>
				QQ支付二维码url<br /><input type="text" name="qqUrl" value="<?=$config["qqUrl"]==""?"https://i.qianbao.qq.com/wallet/sqrcode.htm?m=tenpay&f=wallet&u=2293338477&a=1&n=Mr.%E8%B4%B0%E5%91%86&ac=26A9D4109C10A5D5C08964FCFD5634EAC852E009B700ECDA2A064092BCF6C016":$config["qqUrl"];?>" placeholder="QQ支付二维码url" size="50" />
			</p>
			<p>
				微信支付二维码url<br /><input type="text" name="wechatUrl" value="<?=$config["wechatUrl"]==""?"wxp://f2f0XXfQeK36aDieMEjmveUENW16IZMdDk_c":$config["wechatUrl"];?>" placeholder="微信支付二维码url" size="50" />
			</p>
			<p>
				支付宝支付二维码url<br /><input type="text" name="aliUrl" value="<?=$config["aliUrl"]==""?"HTTPS://QR.ALIPAY.COM/FKX03546YRHSVIW3YUK925":$config["aliUrl"];?>" placeholder="支付宝支付二维码url" size="50" />
			</p>
			<p>
				token<br /><input type="text" name="token" value="<?=$config["token"];?>" placeholder="token" size="50" />
			</p>
			<p>
				<input type="hidden" name="action" value="submit" />
				<input type="submit" value="保存" />
			</p>
		</form>
		<?php
		$json=file_get_contents('https://www.tongleer.com/api/interface/TleChat.php?action=updateEmlog&version=1&domain='.$_SERVER['SERVER_NAME'].'&token='.$config["token"]);
		$result=json_decode($json,true);
		?>
		版本检查：<?=$result["content"];?>
		<iframe src="<?=urldecode($result["url"]);?>" width="100%" height="700" scrolling = "no"></iframe>
		<small style="color:#aaaaaa">站长聊天室插件为Typecho站长提供聊天室功能，让站长之间的联系更加友爱，支持文本、长文本、语音聊天、图片传输及站长之间的QQ、微信、支付宝打赏，共同建立一个友爱的站长联盟。</small>
	</div>
	<?php
}
?>