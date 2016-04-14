<?php
!defined('EMLOG_ROOT') && exit('access deined!');

require EMLOG_ROOT.'/content/plugins/commentlist/commentlist_config.php';
if(!isset($_GET['page']))
{
    $y_commentlist_page = 1;
}
else
{
    $y_commentlist_page = $_GET['page'];
}

global $CACHE;
$options_cache = $CACHE->readCache('options');
$navibar = unserialize($options_cache['navibar']);
$blogtitle = '评论列表 - '.Option::get('blogname');
$log_title = $navibar['commentlist']['title'];
$blogname = Option::get('blogname');
$description = $bloginfo = Option::get('bloginfo');
$site_key = Option::get('site_key');
$istwitter = Option::get('istwitter');
$comments = array("commentStacks" => array());
$ckname = $ckmail = $ckurl = $verifyCode = false;
$icp = Option::get('icp');
$footer_info = Option::get('footer_info');
include View::getView('header');
$log_content = '';
$log_content .= y_commentlist_show(C_NUM,$y_commentlist_page,C_ADMIN);
?>
<style type="text/css">
#comment_list .comment-box {margin-top:20px;width:96%;background-color:#f9f9f9;border:#CCC solid 1px;}
#comment_list .comment-about {font-size:13px;color:#333;margin-top:10px;padding-left:10px;}
#comment_list .comment-content {font-size:14px;padding:8px 10px 10px 10px;word-break:break-all;overflow:hidden;}
#comment_list .comment-content img{border:0;vertical-align:text-bottom;margin-left:2px;margin-right:2px;}
#comment_list .comment-data {font-size:12px;color:#676767;padding-left:10px;padding-bottom:10px;}
#comment_list .blogger {color:#F00;}
#comment_list .page {float:left;margin:15px 0 10px 20px;}
#comment_list .page a {float:left;border: #CCC 1px solid; padding-bottom: 5px;padding-left: 10px;padding-right: 10px;padding-top: 5px;margin-right:5px;text-align:center;}
#comment_list .page a:hover {background-color:#f9f9f9;}
#comment_list .page a.currentpage {color:#666;background-color:#f9f9f9;}
#comment_list .page a.currentpage:hover {text-decoration:none;}
#comment_list .page .records {background-color:#f9f9f9;}
#comment_list .page .pageinfo {background-color:#f9f9f9;}
#comment_list .grimg {float:left;margin:0 5px;border-radius:5px;border:1px solid #bbb;}
</style>
<?php
include View::getView('page');
?>