<?php 
// Including common.php file to have access to fluxBB functions
define('PUN_ROOT', '../../');
require PUN_ROOT.'include/common.php';

if ($pun_user['g_id'] != PUN_ADMIN)
	exit;

// Language file load
$ezbbc_language_folder = (file_exists(PUN_ROOT.'plugins/ezbbc/lang/'.$pun_user['language'].'/ezbbc_plugin.php')) ? $pun_user['language'] : 'English';    
require PUN_ROOT.'plugins/ezbbc/lang/'.$ezbbc_language_folder.'/ezbbc_plugin.php';

// Retrieving config datas
require PUN_ROOT.'plugins/ezbbc/config.php';
$action_message = '';

/* ****************** */
/* If action required */
/* ****************** */
if (isset($_GET['action'])):
	$action = $_GET['action'];
	$filename = $_GET['fname'];
	$ftype = $_GET['ftype'];
	preg_match('@^([0-9]+)_(.*)$@', $filename, $matches);
	$timestamp = $matches[1];
	$name = $matches[2];
	$rootfolder = ($ftype == 'img') ? $ezbbc_config['img_folder'] : $ezbbc_config['doc_folder'];
	$id = intval($_GET['id']);
	$file_path = PUN_ROOT.$rootfolder.'/'.$id.'/'.$filename;
	$data_file = PUN_ROOT.'cache/ezbbc/'.$timestamp.'_'.$ftype.'_'.$id.'_'.$name.'.txt';
	if ($action == 'remove') {
		if (@unlink($file_path) && @unlink($data_file)) {
			$action_message = '<p style="color: green; text-align: center;">/'.$rootfolder.'/'.$id.'/'.$filename.' '.$lang_ezbbc['File remove ok'].'</p>';
		} else {
			$action_message = '<p style="color: red; text-align: center;">/'.$rootfolder.'/'.$id.'/'.$filename.' '.$lang_ezbbc['File remove fail'].'</p>';
		}
	}
endif;
/* End action required */

// Getting the type to handle each listing case
$type = isset($_GET['type']) ? $_GET['type'] : null;

/* ******************* */
/* Recent file listing */
/* ******************* */
if ($type == 'recent'):
	$limit = intval($_GET['limit']);
	$fselect = isset($_GET['fselect']) ? $_GET['fselect'] : null;
	$cache = PUN_ROOT.'cache/ezbbc/';
	
	//Getting the listing of the files
	$file_list = $file_list_display = $user_ids = $usernames = array();
        $timestamp = $ftype = $id = $name = $date = $file = $rootfolder = $file_path = array();
	$files = opendir($cache);
	while(false !== ($file = readdir($files))) {
		if ($file == '.' || $file == '..' || $file == 'index.html') continue;
		$file_list[] = $file;
	}
	closedir($files);
	rsort($file_list);
	$file_count = count($file_list);
	
	// Deleting data files if more than 100 in the cache folder
	if ($file_count > 100) {
	        for ($i=99; $i<$file_count; $i++) {
	                @unlink($cache.$file_list[$i]);
	        }
	}
	
	// Taking in account the file selection if set
	if (isset($fselect)) {
	        foreach ($file_list as $file) {
	                if (strpos($file, $fselect) === false) continue;
	                $sfile_list[] = $file;
	        }
	        $file_list = array(); // cleaning the file list array
	        $file_list = $sfile_list;
	        $file_count = count($file_list);
	}
	
	
        if ($file_count) {
                $rlimit = ($limit > $file_count) ? $file_count : $limit;
                // Generation of the listing with limit
                for ($i = 0; $i < $rlimit; $i++) {
                        // Sorting out the datas of the data file
                        preg_match('@^([0-9]+)_(img|doc)_([0-9]+)_(.*)\.txt$@', $file_list[$i], $matches);
                        $timestamp[$i] = $matches[1];
                        $ftype[$i] = $matches[2];
                        $id[$i] = $user_ids[] = $matches[3];
                        $name[$i] = $matches[4];
                        $date[$i] = date($lang_ezbbc['Date format'], $timestamp[$i]);
                        $file_name[$i] = $timestamp[$i].'_'.$name[$i];
                        $rootfolder[$i] = ($ftype[$i] == 'img') ? $ezbbc_config['img_folder'] : $ezbbc_config['doc_folder'];
                        $file_path[$i] = $pun_config['o_base_url'].'/'.$rootfolder[$i].'/'.$id[$i].'/'.$file_name[$i];
                }
                // Grab the user names
                $result = $db->query('SELECT id, username FROM '.$db->prefix.'users WHERE id IN('.implode(',', $user_ids).')') or error('Unable to fetch user names', __FILE__, __LINE__, $db->error());
                while ($cur_user = $db->fetch_assoc($result)) {
                    $usernames[$cur_user['id']] = $cur_user['username'];
                }

                for ($i = 0; $i < $rlimit; $i++) {
                        $file_list_display[]= '<li><a href="'.$_SERVER['SCRIPT_NAME'].'?type=folder&amp;ftype='.$ftype[$i].'&amp;id='.$id[$i].'" title="'.$lang_ezbbc['Go user folder'].'"><img src="style/admin/listing/'.$ftype[$i].'-folder.png" alt="'.$lang_ezbbc['Go user folder'].'" /></a> <a href="'.$file_path[$i].'" onclick="window.open(this.href, \'Preview\', \'height=300, width=400, top=50, left=50, toolbar=no, menubar=no, location=no, resizable=yes, scrollbars=no, status=no\'); return false;" title="'.$lang_ezbbc['Display'].'"><img src="style/admin/listing/'.$ftype[$i].'.png" alt="'.$lang_ezbbc['Display'].'" /></a> <a href="'.$_SERVER['SCRIPT_NAME'].'?type=recent&amp;limit='.$limit.'&amp;ftype='.$ftype[$i].'&amp;id='.$id[$i].'&amp;action=remove&amp;fname='.$file_name[$i].'" onclick="return window.confirm(\''.$lang_ezbbc['Remove file confirm'].'\')" title="'.$lang_ezbbc['Remove'].'"><img src="style/admin/listing/'.$ftype[$i].'-del.png" alt="'.$lang_ezbbc['Remove'].'" /></a> '.$date[$i].' - <strong>'.$name[$i].'</strong> - <span class="user">'.pun_htmlspecialchars($usernames[$id[$i]]).'</span></li>'."\n";
                }
                // Defining the label for the HTML part
                $html_title = '<span class="recent">'.$lang_ezbbc['Recent title'].'</span> ['.$rlimit.']';
        } else {
               $html_title = $lang_ezbbc['Recent title'];
               $file_list_display[]= '<li style="color: orange">'.$lang_ezbbc['Files listing not possible'].'</li>';
        }
endif;
/* End recent file listing */

/* *********************************** */
/* Doc or img folder listing of a user */
/* *********************************** */
if ($type == 'folder'):
	$id = $username = '';
	$ftype = $_GET['ftype'];
	$rootfolder = ($ftype == 'img') ? $ezbbc_config['img_folder'] : $ezbbc_config['doc_folder'];
	if (isset($_GET['id'])) {
		$id = intval($_GET['id']);
		// Fetch user name
		$result = $db->query('SELECT username FROM '.$db->prefix.'users WHERE id='.$id);
		$username = $db->result($result);
	}
	if (isset($_GET['uname'])) {
		$username = $_GET['uname'];
		// Fetch id of the user
		$result = $db->query('SELECT id FROM '.$db->prefix.'users WHERE username=\''.$db->escape($username).'\'');
		$id = $db->result($result);
	}
	$folder_path = $rootfolder.'/'.$id;

	if ($username != '' && $id != '' && file_exists(PUN_ROOT.$folder_path)) {
		//Getting the listing of the files
		$file_list = $file_list_display = array();
		$files = opendir(PUN_ROOT.$folder_path);
		while(false !== ($file = readdir($files))) {
			if ($file == '.' || $file == '..' || $file == 'index.html') continue;
			$file_list[] = $file;
		}
		closedir($files);
		rsort($file_list);
		if (count($file_list) > 0) {
			foreach ($file_list as $file) {
				preg_match('@^([0-9]+)_(.*)$@', $file, $matches);
				$timestamp = $matches[1];
				$name = $matches[2];
				$file_name = $timestamp.'_'.$name;
				$date = date($lang_ezbbc['Date format'], $timestamp);
				$file_path = $pun_config['o_base_url'].'/'.$folder_path.'/'.$file_name;
				$file_list_display[]= '<li><a href="'.$file_path.'" onclick="window.open(this.href, \'Preview\', \'height=300, width=400, top=50, left=50, toolbar=no, menubar=no, location=no, resizable=yes, scrollbars=no, status=no\'); return false;" title="'.$lang_ezbbc['Display'].'"><img src="style/admin/listing/'.$ftype.'.png" alt="'.$lang_ezbbc['Display'].'" /></a> <a href="'.$_SERVER['SCRIPT_NAME'].'?type=folder&amp;ftype='.$ftype.'&amp;id='.$id.'&amp;action=remove&amp;fname='.$file_name.'" onclick="return window.confirm(\''.$lang_ezbbc['Remove file confirm'].'\')" title="'.$lang_ezbbc['Remove'].'"><img src="style/admin/listing/'.$ftype.'-del.png" alt="'.$lang_ezbbc['Remove'].'" /></a> '.$date.' - <strong>'.$name.'</strong> </li>'."\n";
			} 
		} else {
			$file_list_display[]= '<li>'.$lang_ezbbc['No files in folder'].'</li>';
		}
		// Defining the label for the HTML part
		$html_title = '<span class="'.$ftype.'-folder">'.$lang_ezbbc['Files listing of' ].'</span> <strong class="user">'.pun_htmlspecialchars($username).'</strong> ['.count($file_list).']';
	} else {
		$html_title = $lang_ezbbc['Files listing not possible'];
		$file_list_display[] = '<li style="color: orange">'.$lang_ezbbc['Reasons not listing'].'</li>';
	}
endif;
/* End user doc or img file listing */

/* ******************* */
/* Beginning HTML part */
/* ******************* */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="<?php echo PUN_ROOT.'style/'.$pun_user['style'].'.css' ?>" />
<style type="text/css">
 .recent {background: transparent url(style/admin/listing/recent.png) no-repeat; padding-left: 22px;}
 .user {background: transparent url(style/admin/listing/user.png) no-repeat; padding-left: 15px;}
 .img-folder {background: transparent url(style/admin/listing/img-folder.png) no-repeat; padding-left: 20px;}
 .doc-folder {background: transparent url(style/admin/listing/doc-folder.png) no-repeat; padding-left: 20px;}
</style>
<title><?php echo strip_tags($html_title) ?></title>
</head>
<body>
<div class="pun">
<div class="punwrap">
<div id="brdmain">
	<h3><span><?php echo $html_title ?></span></h3>
	<div class="box">
		<div class="inform">
			<fieldset>
				<legend><?php echo $lang_ezbbc['Legend files'] ?></legend>
				<div class="infldset">
				<?php echo $action_message ?>
				<ul>
				<?php
				foreach ($file_list_display as $file_line_display) {
					echo $file_line_display;
				}
				?>
				</ul>
				</div>
			</fieldset>
		</div>
	</div>
</div>
</div>
</div>
</body>
</html>
