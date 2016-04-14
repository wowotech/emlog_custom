<?php
/*
Plugin Name: 评论列表
Version: 1.1
Plugin URL:http://www.yomoxi.com
Description: 显示所有评论
Author: 游木夕
Author Email: yomoxi@qq.com
Author URL: http://www.yomoxi.com
*/
if (!defined('EMLOG_ROOT')) {
	exit('error!');
} 

/* 写入插件导航 */
function y_commentlist_menu()
{
	echo '<div class="sidebarsubmenu" id="commentlist"><a href="./plugin.php?plugin=commentlist">评论列表</a></div>';
}
addAction('adm_sidebar_ext', 'y_commentlist_menu');

/* 写入配置文件 */
function y_commentlist_write($num,$admin)
{
	$content = "<?php
	              define(\"C_NUM\",\"".$num."\");
				  define(\"C_ADMIN\",\"".$admin."\");
			    ?>";
	$config_path = EMLOG_ROOT.'/content/plugins/commentlist/commentlist_config.php';
	@$fp = fopen($config_path,'wb');
	if(!$fp) {
	    echo "打开配置文件失败！<br />";
		return false;
	}
	@$result = fwrite($fp,$content);
	if(!$result) {
	    echo "配置文件不可写，请设置插件目录下commentlist_config文件权限为777！<br />";
		return false;
	}
	fclose($fp);
	return true;
}

/* 输出评论列表 */
function y_commentlist_show($num,$page,$admin)
{
    $page = intval($page);
    $num = intval($num);
	$admin = intval($admin);
	$DB = MySql::getInstance();
	
	//获取博主(uid为1的用户)昵称
	$sql = "select * from `".DB_PREFIX."user` where `role` = 'admin' limit 1";
	$result = $DB->query($sql);
	while($row = $DB->fetch_array($result, MYSQL_ASSOC))
	    $name = $row['username'];
	
    //获取评论总数
	if($admin == 1)
	$sql = "select * from `".DB_PREFIX."comment` where `hide` = 'n'";
	else
	$sql = "select * from `".DB_PREFIX."comment` where `poster` != '".$name."' and `hide` = 'n'";	
	$result = $DB->query($sql);
	$total = mysql_num_rows($result);
	
	//获取评论内容
	date_default_timezone_set('Etc/GMT-8');//设置时区
	$begin = ($page-1)*$num;
	if($admin == 1)
	$sql = "select * from `".DB_PREFIX."comment` where `hide` = 'n' order by `date` desc limit ".$begin.",".$num;
	else
	$sql = "select * from `".DB_PREFIX."comment` where `poster` != '".$name."' and `hide` = 'n' order by `date` desc limit ".$begin.",".$num;
	$result = $DB->query($sql); 
	$c_comment = '<ul>';
	while($row = $DB->fetch_array($result, MYSQL_ASSOC))
	{
		$sql_t = "select * from `".DB_PREFIX."blog` where `gid` = ".$row['gid']." limit 1";
		$result_t = $DB->query($sql_t);
		while($row_t = $DB->fetch_array($result_t, MYSQL_ASSOC))
		{
			$logtitle = $row_t['title'];
		}
		if($admin == 1 and $row['poster'] == $name)
		{
			$isadmin_out = "<span class=\"blogger\">[博主]</span>";
		}
		else
		{
			$isadmin_out = "";
		}
		$c_comment.= "<div class=\"comment-box\"><div class=\"comment-about\"><img class=\"grimg\" width=\"32\" height=\"32\" src=\"".getGravatar($row['mail'])."\" />".$row['poster'].$isadmin_out."</div><div class=\"comment-content\">".htmlspecialchars($row['comment'])."</div><div class=\"comment-data\"><span>《<a href=\"".BLOG_URL."?post=".$row['gid']."#".$row['cid']."\" target=\"_blank\">".$logtitle."</a>》</span>&nbsp;&nbsp;<span>发表时间：".date("Y-m-d H:i",$row['date'])."</span></div></div>";
	}
	$c_comment.= "</ul><p></p>";
	
	//生成分页列表
	if($total%$num == 0)
	    $allpage = $total/$num;
	else 
	    $allpage = ceil($total/$num);	

	$c_page = "<div class=\"page\"><a class=\"records\">共".$total."条</a><a class=\"pageinfo\">".$page."/".$allpage."</a>";
	
	$c_pagenum = " ";
	for($i=1;$i<=$allpage;$i++)
	{
		if($i == $page)
			$c_pagenum.= "<a class=\"currentpage\">".$page."</a>";
		else
			$c_pagenum.= "<a href=\"".BLOG_URL."?plugin=commentlist&page=".$i."\">".$i."</a> ";
	}

    if($allpage == 1 || $allpage == 0)
	{
		$c_page.= "</div>";
	}	
	else if($page == 1 and $allpage != 1)
	{
		$c_page.= $c_pagenum."<a href=\"".BLOG_URL."?plugin=commentlist&page=".($page+1)."\">下一页</a></div>";
	}
	else if($page == $allpage and $allpage != 1)
	{
		$c_page.= "<a href=\"".BLOG_URL."?plugin=commentlist&page=".($page-1)."\">上一页</a>".$c_pagenum."</div>";
	}
	else
	{
		$c_page.= "<a href=\"".BLOG_URL."?plugin=commentlist&page=".($page-1)."\">上一页</a>".$c_pagenum."<a href=\"".BLOG_URL."?plugin=commentlist&page=".($page+1)."\">下一页</a></div>";
	}
	
	//组合字符串并输出
	$out = "<div id=\"comment_list\">".$c_comment.$c_page."</div>";
	return $out;
}