<?php
session_start();
!defined('EMLOG_ROOT') && exit('access deined!');

if(ROLE == 'admin' || ROLE == 'writer'){
	header('Location:'.BLOG_URL.'admin/');
}
global $CACHE;
$options_cache = $CACHE->readCache('options');
$DB = MySql::getInstance();
$blogname = $options_cache['blogname'];
$bloginfo = $options_cache['bloginfo'];
$site_title = $options_cache['blogname'];
$site_title = '用户注册 - '.$blogname;
$site_description = $options_cache['bloginfo'];
$site_key = $options_cache['site_key'];
$log_title = '用户注册';
$comments = array('commentStacks'=>array(), 'commentPageUrl'=>'');
$yls_reg_enable = $options_cache['yls_reg_enable'];

if($yls_reg_enable != 'y'){
	echo '本站注册功能已经关闭';
	exit();
}


$username = isset($_POST['username']) ? addslashes(trim($_POST['username'])) : '';
$password = isset($_POST['password']) ? addslashes(trim($_POST['password'])) : '';
$password2 = isset($_POST['password2']) ? addslashes(trim($_POST['password2'])) : '';
$imgcode = isset($_POST['imgcode']) ? strtoupper(addslashes(trim($_POST['imgcode']))): '';

if($username && $password && $password2 && $imgcode && $yls_reg_enable == 'y'){
	$sessionCode = isset($_SESSION['code']) ? $_SESSION['code'] : '';
	//echo $sessionCode;
	if($imgcode == $sessionCode){
		$User_Model = new User_Model();
		if(!$User_Model -> isUserExist($username)){
			$hsPWD = new PasswordHash(8, true);
			$password = $hsPWD->HashPassword($password);
			$User_Model->addUser($username, $password, 'writer', 'y');
			$CACHE->updateCache();
			echo'<script>alert("注册成功！"); window.location.href="'.BLOG_URL.'admin/"</script>';
		}else{
			echo'<script>alert("用户名已存在！");</script>';
		}
	}else{
		echo'<script>alert("验证码错误！");</script>';
	}
	
}




$log_content = '
<div class="box">
	<div class="inner">
		<table align="center">
			<form action="" method="post" name="reg" id="reg" onsubmit="return checkReg();">
			<tr>
				<td align="right">用户名：</td><td><input name="username" class="usr" ></td><td> <span class="info">* 必填，大于等于5位</span></td>
			</tr>
			<tr>
				<td align="right">密码：</td><td><input name="password" type="password"></td><td> <span class="info">* 必填，大于等于5位</span></td>
			</tr>
			<tr>
				<td align="right">重复密码：</td><td><input name="password2" type="password"></td><td> <span class="info">* </span></td>
			</tr>
			<tr>
				<td align="right">验证码：</td>
				<td><input name="imgcode" type="text" class="imgcode"><img src="'.BLOG_URL.'include/lib/checkcode.php" width="80" id="yzcode" /></td>
				<td><span id="imginfo">更换验证码</span></td>
			</tr>
			<tr>
				<td align="right"></td><td><input type="submit" value="确认注册" class="btn"> <input type="reset" value="重置" class="rst"></td><td></td>
			</tr>
			<tr>
				<td></td><td class="bot"><a href="'.BLOG_URL.'" title="返回首页">网站首页</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.BLOG_URL.'admin/" title="前往登录">已有账号？</a></td><td></td>
			</tr>
			</form>
		</table>
	</div>
</div>
';
?>
<?php include View::getView('header');?>

<script type="text/javascript">
function checkReg(){
	var usrName = $("input[name=username]").val().replace(/(^\s*)|(\s*$)/g, "");
	var pwd = $("input[name=password]").val().replace(/(^\s*)|(\s*$)/g, "");
	var pwd2 = $("input[name=password2]").val().replace(/(^\s*)|(\s*$)/g, "");
	var yzm = $("input[name=imgcode]").val().replace(/(^\s*)|(\s*$)/g, "");

	if(usrName.match(/\s/) || pwd.match(/\s/)){
		alert("用户名和密码中不能有空格");
		return false;
	}

	if(usrName == '' || pwd == '' || yzm == ''){
		alert("用户名、密码、验证码都不能为空！");
		return false;
	}
	if(usrName.length < 5 || pwd.length < 5){
		alert("用户名和密码都不能小于5位！");
		return false;
	}
	else if(pwd != pwd2){
		alert("两次输入密码不相等！");
		return false;
	}
}
$(function(){
	$("#imginfo").click(function(){
		//alert('haha');
		$("img#yzcode").attr("src", "<?php echo BLOG_URL;?>include/lib/checkcode.php?"+Math.random());
	});
})

</script>
<style type="text/css">
body{font-size:13px;}
.box{width:400px; border:3px solid #f2f2f2; border-radius:10px; margin:30px auto;}
.box .inner{border:1px solid #ccc; border-radius:10px; padding:10px 20px;}
.box .inner .info{font-size:12px; color:#999;}
.box .inner table{line-height:30px; margin:0 auto; border:none;}
.box .inner table input{height:20px; width:160px;}
.box .inner table input.btn{background:#f2f2f2; border:1px solid #ccc; height:25px; width:90px; cursor:pointer;}
.box .inner table input.usr{width:100px;}
.box .inner table input.rst{background:#f2f2f2; border:1px solid #ccc; height:25px; width:60px; cursor:pointer;}
.box .inner table input.imgcode{width:80px;}
.box .inner .bot{font-size:12px;}
.box .inner .bot a{color:#999;}
.box .inner .bot a:hover{color:#333;}
.headtitle{font-size:18px;}
#imginfo{cursor:pointer;}
</style>
<?php include View::getView('page');?>