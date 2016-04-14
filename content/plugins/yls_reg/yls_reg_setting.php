<?php

!defined('EMLOG_ROOT') && exit('access deined!');

function plugin_setting_view(){
}//plugin_setting_view end!!!

?>
<style type="text/css">
.reginfoboard{width:500px; padding:50px; line-height:30px;}
</style>

<div class="reginfoboard">
	用户注册页面：<a href="<?php echo BLOG_URL;?>?plugin=yls_reg" target="_blank"><?php echo BLOG_URL;?>?plugin=yls_reg</a> （已登录用户将直接跳转到后台！）<br/>
	注册链接代码:<input type="text" size="80" value='<a href="<?php echo BLOG_URL;?>?plugin=yls_reg">立即注册</a>' />
	<br/>
	提示：用户管理为后台左侧导航的用户栏目
	<br/>
	<a href="http://www.yilushang.net/emlog_yls_reg.html" target="_blank">插件作者</a>
</div>