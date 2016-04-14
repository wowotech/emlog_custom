<?php
function callback_init()
{
	yls_reg_callback_do('y');
}

function callback_rm()
{
	yls_reg_callback_do('n');
}

function yls_reg_callback_do($enable)
{
	global $CACHE;
	$db = MySql::getInstance();
	$get_option = $db -> query("SELECT * FROM `".DB_PREFIX."options` WHERE `option_name` = 'yls_reg_enable' ");
	$num = $db -> num_rows($get_option);
	if($num > 0){
		$db -> query("UPDATE `".DB_PREFIX."options`  SET `option_value` = '".$enable."' WHERE `option_name` = 'yls_reg_enable' ");
	}else{
		$db -> query("INSERT INTO `".DB_PREFIX."options`  (`option_name`, `option_value`) VALUES('yls_reg_enable', '".$enable."') ");
	}
	$CACHE->updateCache('options');
}
?>