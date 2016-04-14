<?php
/**
 * kl_auto_backup_and_mail_do.php
 * design by KLLER
 */
@set_time_limit(0);
require_once('../../../init.php');
include_once('kl_auto_backup_and_mail_config.php');
require_once(EMLOG_ROOT.'/content/plugins/kl_auto_backup_and_mail/class/class.smtp.php');
require_once(EMLOG_ROOT.'/content/plugins/kl_auto_backup_and_mail/class/class.phpmailer.php');
$is_reproduct = false;
echo KL_AUTO_BACKUP_AND_MAIL_THE_TIME."\n";
if(KL_AUTO_BACKUP_AND_MAIL_LAST_BACKUP_FILE != '' && file_exists(KL_AUTO_BACKUP_AND_MAIL_LAST_BACKUP_FILE))
{
	$delay_time = time() - filemtime(KL_AUTO_BACKUP_AND_MAIL_LAST_BACKUP_FILE);
	if($delay_time > intval(KL_AUTO_BACKUP_AND_MAIL_THE_TIME)) $is_reproduct = true;
	echo $delay_time;
}else{
	$is_reproduct = true;
}
if($is_reproduct)
{
	$blogname = Option::get('blogname');
	if(file_exists(KL_AUTO_BACKUP_AND_MAIL_LAST_BACKUP_FILE)) unlink(KL_AUTO_BACKUP_AND_MAIL_LAST_BACKUP_FILE);
	$timezone = Option::get('timezone');
	if(Option::EMLOG_VERSION >= '5.2.0'){
		$tables = array('attachment', 'blog', 'comment', 'options', 'navi', 'reply', 'sort', 'link','tag','twitter','user');
	}elseif(Option::EMLOG_VERSION >= '5.0.0'){
		$tables = array('attachment', 'blog', 'comment', 'options', 'navi', 'reply', 'sort', 'link','tag','trackback','twitter','user');
	}else{
		$tables = array('attachment', 'blog', 'comment', 'options', 'reply', 'sort', 'link','tag','trackback','twitter','user');
	}
	$defname = 'emlog_'. gmdate('Ymd', time() + $timezone * 3600) . '_' . substr(md5(gmdate('YmdHis', time() + $timezone * 3600)),0,18);
	doAction('data_prebakup');
	$filename = $defname.'.sql';
	$fso = fopen('kl_auto_backup_and_mail_config.php','r'); //获取配置文件内容
	$config = fread($fso,filesize('kl_auto_backup_and_mail_config.php'));
	fclose($fso);

	$patt = array(
	"/define\('KL_AUTO_BACKUP_AND_MAIL_LAST_BACKUP_FILE',(.*)\)/",
	);

	$replace = array(
	"define('KL_AUTO_BACKUP_AND_MAIL_LAST_BACKUP_FILE','".$filename."')",
	);
	$new_config = preg_replace($patt, $replace, $config);
	$fso = fopen('kl_auto_backup_and_mail_config.php','w'); //写入替换后的配置文件
	fwrite($fso,$new_config);
	fclose($fso);

	$sqldump = '';
	foreach($tables as $table)
	{
		$sqldump .= dataBak(DB_PREFIX.$table);
	}
	$dumpfile = '#version:emlog '. Option::EMLOG_VERSION . "\n";
	$dumpfile .= '#date:' . gmdate('Y-m-d H:i', time() + $timezone * 3600) . "\n";
	$dumpfile .= '#tableprefix:' . DB_PREFIX . "\n";
	$dumpfile .= $sqldump;
	$dumpfile .= "\n#the end of backup";

	@$fp = fopen($filename, 'w+');
	if ($fp)
	{
		@flock($fp, 3);
		if(@!fwrite($fp, $dumpfile))
		{
			@fclose($fp);
		}else{
			@fclose($fp);
			if(KL_AUTO_BACKUP_AND_MAIL_ISZIP){
				$zipfile = $defname.'.zip';
				$thefilename = kl_auto_backup_and_mail_zip($filename, $dumpfile, $zipfile);
				if($thefilename !== false) $filename = $thefilename;
			}
			kl_auto_backup_and_mail_mail_to(KL_AUTO_BACKUP_AND_MAIL_SMTP, KL_AUTO_BACKUP_AND_MAIL_PORT, KL_AUTO_BACKUP_AND_MAIL_SENDEMAIL, KL_AUTO_BACKUP_AND_MAIL_PASSWORD, KL_AUTO_BACKUP_AND_MAIL_TOEMAIL, '您的博客自动备份数据', '附件中为您的博客'.$blogname.'的自动备份数据 ：）', $blogname, $filename);
			if(KL_AUTO_BACKUP_AND_MAIL_ISZIP && file_exists($zipfile)) unlink($zipfile);
		}
	}
}

function dataBak($table) {
	$DB = MySql::getInstance();
	$sql = "DROP TABLE IF EXISTS $table;\n";
	$createtable = $DB->query("SHOW CREATE TABLE $table");
	$create = $DB->fetch_row($createtable);
	$sql .= $create[1].";\n\n";

	$rows = $DB->query("SELECT * FROM $table");
	$numfields = $DB->num_fields($rows);
	$numrows = $DB->num_rows($rows);
	while ($row = $DB->fetch_row($rows)) {
		$comma = '';
		$sql .= "INSERT INTO $table VALUES(";
		for ($i = 0; $i < $numfields; $i++) {
			$sql .= $comma."'".mysql_real_escape_string($row[$i])."'";
			$comma = ',';
		}
		$sql .= ");\n";
	}
	$sql .= "\n";
	return $sql;
}
?>