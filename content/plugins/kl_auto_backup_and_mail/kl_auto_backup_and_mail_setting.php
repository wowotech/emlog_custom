<?php
/**
 * kl_auto_backup_and_mail_setting.php
 * design by KLLER
 */

!defined('EMLOG_ROOT') && exit('access deined!');

function plugin_setting_view()
{
	include(EMLOG_ROOT.'/content/plugins/kl_auto_backup_and_mail/kl_auto_backup_and_mail_config.php');
	$the_time_arr = array(120=>'两分钟', 3600=>'一个小时', 86400=>'一天', 604800=>'一周', 864000=>'十天', 1296000=>'半个月', 2592000=>'一个月');
	$the_time_option_str = '';
	foreach($the_time_arr as $value=>$the_time)
	{
		$selected = $value == KL_AUTO_BACKUP_AND_MAIL_THE_TIME ? 'selected' : '';
		$the_time_option_str .= "<option value=\"{$value}\" {$selected}>{$the_time}</option>";
	}
  $dir_is_writable_msg = is_writable(EMLOG_ROOT.'/content/plugins/kl_auto_backup_and_mail/') ? '' : '<span class="error">kl_auto_backup_and_mail目录可能不可写，如果已经是可写状态，请忽略此信息。</span>';
?>
<script type="text/javascript">
jQuery.fn.onlyPressNum = function(){$(this).css('ime-mode','disabled');$(this).css('-moz-user-select','none');$(this).bind('keydown',function(event){var k=event.keyCode;if(!((k==13)||(k==9)||(k==35)||(k == 36)||(k==8)||(k==46)||(k>=48&&k<=57)||(k>=96&&k<=105)||(k>=37&&k<=40))){event.preventDefault();}})}
jQuery(function($){
	$('#port').onlyPressNum();
	$('#testsend').click(function(){$('#testresult').html('邮件发送中..');$.get('../content/plugins/kl_auto_backup_and_mail/kl_auto_backup_and_mail_test_do.php',{sid:Math.random()},function(result){if($.trim(result)!=''){$('#testresult').html(result);}else{$('#testresult').html('发送失败！');}});});
	$("#kl_auto_backup_and_mail").addClass('sidebarsubmenu1');
});
setTimeout(hideActived,2600);
</script>
<style type="text/css">
.table_b { float:left;border-collapse: collapse;border-style: none; border:1px solid #ccc; width:100%;}
.table_b td { border:1px solid #e0e0e0; padding:2px 5px;}
</style>
<div class=containertitle><b>自动备份【插件】</b><span style="font-size:12px;color:#999999;">（版本：1.9）</span>
<?php if(isset($_GET['setting'])):?>
  <span class="actived">插件设置完成</span>
<?php else:?>
<?php echo $dir_is_writable_msg;?>
<?php endif;?>
</div>
<div class=line></div>
<div>
  <form id="form1" name="form1" method="post" action="plugin.php?plugin=kl_auto_backup_and_mail&action=setting">
    <table width="500" border="0" cellspacing="1" cellpadding="0" class="table_b">
       <tr>
         <td height="40" width="92"><span style="width:300px;">smtp服务器:</span></td>
         <td width="300"><input name="smtp" type="text" id="smtp" style="width:180px;" value="<?php echo KL_AUTO_BACKUP_AND_MAIL_SMTP;?>"/> 如:smtp.163.com</td>
         <td rowspan="9">&nbsp;</td>
         <td><span style="width:300px;">测试发送:<font color="red">（请先在左边设置好相关信息<b>保存</b>后测试）</font></span></td>
       </tr>
       <tr>
         <td height="40"><span style="width:200px;">smtp端口:</span></td>
         <td><input name="port" type="text" id="port" style="ime-mode:disabled;width:180px;" value="<?php echo KL_AUTO_BACKUP_AND_MAIL_PORT;?>"/> 一般默认为:25</td>
         <td><input id="testsend" type="button" value="发送一封测试邮件" /></td>
       </tr>
       <tr>
         <td height="40">发信邮箱:</td>
         <td><input name="sendemail" type="text" id="sendemail" style="width:180px;" value="<?php echo KL_AUTO_BACKUP_AND_MAIL_SENDEMAIL;?>"/></td>
         <td><span style="width:300px;">测试结果:</span></td>
       </tr>
       <tr>
         <td height="50">发信密码: </td>
         <td><input type="password" name="password" value="<?php echo KL_AUTO_BACKUP_AND_MAIL_PASSWORD;?>" style="width:180px;"/></td>
         <td rowspan="3"><div id="testresult" style="height:128px; padding:10px; border:1px dashed #ccc; overflow:auto;/*background-color:#bbd9e2;*/"></div></td>
       </tr>
       <tr>
         <td height="50">收信邮箱:</td>
         <td><input name="toemail" type="text" id="toemail" style="width:180px;" value="<?php echo KL_AUTO_BACKUP_AND_MAIL_TOEMAIL;?>"/></td>
       </tr>
       <tr>
         <td height="40">时间间隔:</td>
         <td><select name="the_time"><?php echo $the_time_option_str; ?></select><br /><?php if(KL_AUTO_BACKUP_AND_MAIL_THE_TIME == 120){?><font color="red">注：两分钟仅用于测试！测试完成后请更改为其它选项！</font><?php }?></td>
        </tr>
        <tr>
          <td height="40">发送方式:</td>
          <td><label><input type="radio" name="sendtype" value="0" <?php if(KL_AUTO_BACKUP_AND_MAIL_SENDTYPE == 0) echo 'checked'; ?> />Mail方式</label> <label><input type="radio" name="sendtype" value="1" <?php if(KL_AUTO_BACKUP_AND_MAIL_SENDTYPE == 1) echo 'checked'; ?> />SMTP方式</label></td>
          <td rowspan="3">
            <div style="padding:5px; border:1px dashed #CCC">
              <font color="Green"><b>本插件自动备份机制说明：</b></font><br />
              每当博客被访问时触发备份程序，备份程序判断与上一次有效备份时间的差大于上面设置的时间间隔则再次备份.<br />
              <font color="Green"><b>自动备份状态：</b></font><br />
              上一次备份时间：<?php echo KL_AUTO_BACKUP_AND_MAIL_LAST_BACKUP_FILE == '' || !file_exists(EMLOG_ROOT.'/content/plugins/kl_auto_backup_and_mail/'.KL_AUTO_BACKUP_AND_MAIL_LAST_BACKUP_FILE) ? '读取不到时间，这或许是您第一次使用自动备份。' : date('Y-m-d H:i:s', filemtime(EMLOG_ROOT.'/content/plugins/kl_auto_backup_and_mail/'.KL_AUTO_BACKUP_AND_MAIL_LAST_BACKUP_FILE)); ?><br />
              下一次备份时间：<?php echo KL_AUTO_BACKUP_AND_MAIL_LAST_BACKUP_FILE == '' || !file_exists(EMLOG_ROOT.'/content/plugins/kl_auto_backup_and_mail/'.KL_AUTO_BACKUP_AND_MAIL_LAST_BACKUP_FILE) ? '当有人访问博客时。' : date('Y-m-d H:i:s', (filemtime(EMLOG_ROOT.'/content/plugins/kl_auto_backup_and_mail/'.KL_AUTO_BACKUP_AND_MAIL_LAST_BACKUP_FILE) + KL_AUTO_BACKUP_AND_MAIL_THE_TIME)); ?>
            </div>
          </td>
        </tr>
        <tr>
          <td height="40">压缩(zip格式):</td>
          <td><label><input name="iszip" type="checkbox" value="1" <?php if(KL_AUTO_BACKUP_AND_MAIL_ISZIP == 1) echo 'checked'; ?>/></label></td>
        </tr>
        <tr>
          <td height="40">&nbsp;</td>
          <td><input name="Input" type="submit" value="保　存" /></td>
        </tr>
      </table>
    </form>
</div>
<?php
}

function plugin_setting()
{
	//修改配置信息
	$fso = fopen(EMLOG_ROOT.'/content/plugins/kl_auto_backup_and_mail/kl_auto_backup_and_mail_config.php','r'); //获取配置文件内容
	$config = fread($fso,filesize(EMLOG_ROOT.'/content/plugins/kl_auto_backup_and_mail/kl_auto_backup_and_mail_config.php'));
	fclose($fso);

	$smtp=htmlspecialchars($_POST['smtp'], ENT_QUOTES);
	$port=htmlspecialchars($_POST['port'], ENT_QUOTES);
	$sendemail=htmlspecialchars($_POST['sendemail'], ENT_QUOTES);
	$password=htmlspecialchars($_POST['password'], ENT_QUOTES);
	$toemail=htmlspecialchars($_POST['toemail'], ENT_QUOTES);
	$sendtype=intval($_POST['sendtype']);
	$iszip = intval($_POST['iszip']);
	$the_time = $_POST['the_time'];

	$patt = array(
	"/define\('KL_AUTO_BACKUP_AND_MAIL_SMTP',(.*)\)/",
	"/define\('KL_AUTO_BACKUP_AND_MAIL_PORT',(.*)\)/",
	"/define\('KL_AUTO_BACKUP_AND_MAIL_SENDEMAIL',(.*)\)/",
	"/define\('KL_AUTO_BACKUP_AND_MAIL_PASSWORD',(.*)\)/",
	"/define\('KL_AUTO_BACKUP_AND_MAIL_TOEMAIL',(.*)\)/",
	"/define\('KL_AUTO_BACKUP_AND_MAIL_SENDTYPE',(.*)\)/",
	"/define\('KL_AUTO_BACKUP_AND_MAIL_ISZIP',(.*)\)/",
	"/define\('KL_AUTO_BACKUP_AND_MAIL_THE_TIME',(.*)\)/",
	);

	$replace = array(
	"define('KL_AUTO_BACKUP_AND_MAIL_SMTP','".$smtp."')",
	"define('KL_AUTO_BACKUP_AND_MAIL_PORT','".$port."')",
	"define('KL_AUTO_BACKUP_AND_MAIL_SENDEMAIL','".$sendemail."')",
	"define('KL_AUTO_BACKUP_AND_MAIL_PASSWORD','".$password."')",
	"define('KL_AUTO_BACKUP_AND_MAIL_TOEMAIL','".$toemail."')",
  "define('KL_AUTO_BACKUP_AND_MAIL_SENDTYPE','".$sendtype."')",
	"define('KL_AUTO_BACKUP_AND_MAIL_ISZIP','".$iszip."')",
	"define('KL_AUTO_BACKUP_AND_MAIL_THE_TIME','".$the_time."')",
	);

	$new_config = preg_replace($patt, $replace, $config);
	$fso = fopen(EMLOG_ROOT.'/content/plugins/kl_auto_backup_and_mail/kl_auto_backup_and_mail_config.php','w'); //写入替换后的配置文件
	fwrite($fso,$new_config);
	fclose($fso);
}
?>