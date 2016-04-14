<?php
/**
 * kl_auto_backup_and_mail_test_do.php
 * design by KLLER
 */
require_once('../../../init.php');
!(ISLOGIN === true && ROLE == 'admin') && exit('access deined!');
include_once('kl_auto_backup_and_mail_config.php');
require_once(EMLOG_ROOT.'/content/plugins/kl_auto_backup_and_mail/class/class.smtp.php');
require_once(EMLOG_ROOT.'/content/plugins/kl_auto_backup_and_mail/class/class.phpmailer.php');
$blogname = Option::get('blogname');
$subject = $content = '这是一封测试邮件';
if(kl_auto_backup_and_mail_mail_to(KL_AUTO_BACKUP_AND_MAIL_SMTP, KL_AUTO_BACKUP_AND_MAIL_PORT, KL_AUTO_BACKUP_AND_MAIL_SENDEMAIL, KL_AUTO_BACKUP_AND_MAIL_PASSWORD, KL_AUTO_BACKUP_AND_MAIL_TOEMAIL, $subject, $blogname, $blogname))
{
	echo '<font color="green">发送成功！请到相应邮箱查收！：）</font>';
}