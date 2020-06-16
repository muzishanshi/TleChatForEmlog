<?php
function callback_init(){
	TleChat_callback_do('y');
}

function callback_rm(){
	TleChat_callback_do('n');
}

function TleChat_callback_do($enable){
	global $CACHE;
	$DB = Database::getInstance();
	if($enable=="y"){
		$get_option = $DB -> query("SELECT * FROM `".DB_PREFIX."options` WHERE `option_name` = 'TleChat_option' ");
		$num = $DB -> num_rows($get_option);
		if($num == 0){
			$TleChat_option=addslashes(serialize(array()));
			$DB -> query("INSERT INTO `".DB_PREFIX."options`  (`option_name`, `option_value`) VALUES('TleChat_option', '".$TleChat_option."') ");
		}
	}else{
		$get_option = $DB -> query("SELECT * FROM `".DB_PREFIX."options` WHERE `option_name` = 'TleChat_option' ");
		$num = $DB -> num_rows($get_option);
		if($num > 0){
			//$DB -> query("DELETE FROM `".DB_PREFIX."options` WHERE option_name='TleChat_option'");
		}
	}
	$CACHE->updateCache('options');
}
?>