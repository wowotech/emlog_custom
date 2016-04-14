<?php
/*
Plugin Name: 自动备份并发送到邮箱
Version: 1.9
Plugin URL: http://kller.cn/?post=76
Description: 自动备份并发送到邮箱。
Author: KLLER
Author Email: kller@foxmail.com
Author URL: http://kller.cn
*/

!defined('EMLOG_ROOT') && exit('access deined!');
function kl_auto_backup_and_mail_menu()
{
	echo '<div class="sidebarsubmenu" id="kl_auto_backup_and_mail"><a href="./plugin.php?plugin=kl_auto_backup_and_mail">自动备份</a></div>';
}
addAction('adm_sidebar_ext', 'kl_auto_backup_and_mail_menu');

function kl_auto_backup_and_mail_trigger()
{
	$url_info = parse_url(DYNAMIC_BLOGURL);
	echo "<script type=\"text/javascript\">XMLHttp.sendReq('GET','".$url_info['scheme'].'://'.$url_info['host']."/content/plugins/kl_auto_backup_and_mail/kl_auto_backup_and_mail_do.php','',function(obj){return;});</script>\r\n";
}
addAction('index_footer', 'kl_auto_backup_and_mail_trigger');

function kl_auto_backup_and_mail_mail_to($mailserver, $port, $mailuser, $mailpass, $mailto, $subject, $content, $fromname, $attachment = ''){
	$mail = new KL_AUTO_BACKUP_AND_MAIL_PHPMailer();
	$mail->CharSet = "UTF-8";
	$mail->Encoding = "base64";
	$mail->Port = $port;
	if(KL_AUTO_BACKUP_AND_MAIL_SENDTYPE == 1){
		$mail->IsSMTP();
	}else{
		$mail->IsMail();
	}
	$mail->Host = $mailserver;
	$mail->SMTPAuth = true;
	$mail->Username = $mailuser;
	$mail->Password = $mailpass;

	$mail->From = $mailuser;
	$mail->FromName = $fromname;

	$mail->AddAddress($mailto);
	$mail->WordWrap = 500;
	$mail->IsHTML(true);
	$mail->Subject = $subject;
	$mail->Body = $content;
	$mail->AltBody = "This is the body in plain text for non-HTML mail clients";
	if(!empty($attachment)) $mail->AddAttachment($attachment);
	if($mail->Host == 'smtp.gmail.com') $mail->SMTPSecure = "ssl";
	if(!$mail->Send())	{
		echo $mail->ErrorInfo;
		return false;
	}else{
		return true;
	}
}

function kl_auto_backup_and_mail_zip($orig_fname, $content, $tempzip) {
	if (!class_exists('ZipArchive', FALSE)) {
		return false;
	}
	$zip = new ZipArchive();
	$res = $zip->open($tempzip, ZipArchive::CREATE);
	if ($res === TRUE) {
		$zip->addFromString($orig_fname, $content);
		$zip->close();
		$zip_content = file_get_contents($tempzip);
		return $tempzip;
	} else {
		return false;
	}
}
?>