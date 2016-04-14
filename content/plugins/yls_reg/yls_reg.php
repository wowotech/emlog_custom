<?php
/*
Plugin Name: 注册插件（一路上）
Version: 1.5.2
Plugin URL: http://www.yilushang.net/emlog_yls_reg.html
Description: 用户注册插件，默认注册为网站作者权限的账号，可直接登录后台。
ForEmlog:5.2.0+
Author:	秦时明月 Kurly 
Author Email: Kurly@foxmail.com
Author URL: http://www.yilushang.net
 */
!defined('EMLOG_ROOT') && exit('access deined!');

function yls_reg() {//写入插件导航
    echo '<div class="sidebarsubmenu"><a href="./plugin.php?plugin=yls_reg">用户注册</a></div>';
}
addAction('adm_sidebar_ext', 'yls_reg');

?>