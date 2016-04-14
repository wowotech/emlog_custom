<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
function plugin_setting_view(){
}
	
if(isset($_POST['num']) and isset($_POST['admin']))
{
	$num = intval($_POST['num']);
	$admin = intval($_POST['admin']);
	$result = y_commentlist_write($num,$admin);
	
	if($result)
	    echo "设置成功!<br />";
	else
	    echo "设置失败!<br />";
}

require EMLOG_ROOT.'/content/plugins/commentlist/commentlist_config.php';
?>
<form method="post" action="">
<table width="500" border="1">
  <tr>
    <td width="94" height="34">博主评论：</td>
    <td width="390"><select name="admin">
      <option value="1" <?php if(C_ADMIN == '1') echo "selected=\"selected\""; ?>>显示</option>
      <option value="0" <?php if(C_ADMIN == '0') echo "selected=\"selected\""; ?>>不显示</option>
    </select></td>
  </tr>
  <tr>
    <td height="35">每页显示：</td>
    <td height="35"><input name="num" type="text" value="<?php echo C_NUM; ?>" size="6" />
条 </td>
  </tr>
  <tr>
    <td height="35" colspan="2"><input type="submit" name="button" value="设置" /></td>
  </tr>
</table>
</form>