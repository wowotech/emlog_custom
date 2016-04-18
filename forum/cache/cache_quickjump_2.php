<?php

if (!defined('PUN')) exit;
define('PUN_QJ_LOADED', 1);
$forum_id = isset($forum_id) ? $forum_id : 0;

?>				<form id="qjump" method="get" action="viewforum.php">
					<div><label><span><?php echo $lang_common['Jump to'] ?><br /></span>
					<select name="id" onchange="window.location=('viewforum.php?id='+this.options[this.selectedIndex].value)">
						<optgroup label="项目专区">
							<option value="6"<?php echo ($forum_id == 6) ? ' selected="selected"' : '' ?>>X Project</option>
						</optgroup>
						<optgroup label="问答专区">
							<option value="5"<?php echo ($forum_id == 5) ? ' selected="selected"' : '' ?>>新手提问</option>
						</optgroup>
						<optgroup label="谈天说地">
							<option value="3"<?php echo ($forum_id == 3) ? ' selected="selected"' : '' ?>>灌水区</option>
						</optgroup>
					</select></label>
					<input type="submit" value="<?php echo $lang_common['Go'] ?>" accesskey="g" />
					</div>
				</form>
