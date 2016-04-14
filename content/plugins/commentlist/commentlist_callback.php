<?php
function callback_init(){
	global $CACHE;
	$DB = MySql::getInstance();
	$navibar = Option::get('navibar');

	if(!isset($navibar['commentlist'])){
		$navibar['commentlist'] = array('title'=>'评论列表', 'url'=>BLOG_URL.'?plugin=commentlist', 'is_blank'=>'', 'hide'=>'n');
		$DB->query("UPDATE ".DB_PREFIX."options SET option_value='".serialize($navibar)."' where option_name='navibar'");
		$CACHE->updateCache('options');
	}

	commentlist_callback_do('n');
}

function callback_rm(){
	commentlist_callback_do('y');
}

function commentlist_callback_do($hide){
	global $CACHE;
	$DB = MySql::getInstance();
	$navibar = Option::get('navibar');
	if(!isset($navibar['commentlist'])) return;
	$navibar['commentlist']['hide'] = $hide;
	$navibar['commentlist']['url'] = BLOG_URL.'?plugin=commentlist';
	$result = $DB->query("UPDATE ".DB_PREFIX."options SET option_value='".serialize($navibar)."' where option_name='navibar'");
	$CACHE->updateCache('options');
}
?>