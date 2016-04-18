<?php
define('PUN_ROOT', '../../');
require PUN_ROOT.'include/common.php';

// Getting the textarea name from get string
$textarea_name = isset($_GET['textarea_name']) && $_GET['textarea_name'] == 'req_message' ? 'req_message' : 'signature';
// Language file load
require PUN_ROOT.'lang/'.$pun_user['language'].'/common.php';
$ezbbc_language_folder = (file_exists(PUN_ROOT.'plugins/ezbbc/lang/'.$pun_user['language'].'/ezbbc_plugin.php')) ? $pun_user['language'] : 'English';    
require PUN_ROOT.'plugins/ezbbc/lang/'.$ezbbc_language_folder.'/ezbbc_plugin.php';

// Retrieving style folder
require PUN_ROOT.'plugins/ezbbc/config.php';
$allowed_ext = explode(',', $ezbbc_config['allowed_ext']);
$location = PUN_ROOT.$ezbbc_config['doc_folder'];
$cache = PUN_ROOT.'cache/ezbbc/';
$path = $pun_config['o_base_url'].'/'.$ezbbc_config['doc_folder'];
$file_path = '';
$upload_ok = false;
$message = '';
$action_message = '';
$doc_list = array();
$loc_user_folder = $location.'/'.$pun_user['id'];

if ($ezbbc_config['doc_upload'] == 'doc_upload' && !$pun_user['is_guest']) {
        
        // If action required 
        if (isset($_GET['action'])):
                $action = $_GET['action'];
                $filename = pun_htmlspecialchars($_GET['fname']);
                $allowed_ext_choice = implode('|',$allowed_ext);
                if (preg_match('@^([0-9]+)_([a-z0-9_\.\-]*)\.('.$allowed_ext_choice.')$@', $filename, $matches)):
                        $timestamp = $matches[1];
                        $name = $matches[2];
                        $ext = $matches[3];
                        $name = $name.'.'.$ext;
                        $rootfolder = $ezbbc_config['doc_folder'];
                        $ftype = 'doc';
                        $id = $pun_user['id'];
                        $file_path = PUN_ROOT.$rootfolder.'/'.$id.'/'.$filename;
                        $data_file = PUN_ROOT.'cache/ezbbc/'.$timestamp.'_'.$ftype.'_'.$id.'_'.$name.'.txt';
                        if ($action == 'remove') {
                                if (@unlink($file_path) && @unlink($data_file)) {
                                        $action_message = '<p id="amessage" style="color: green; text-align: center;">/'.$rootfolder.'/'.$id.'/'.$filename.' '.$lang_ezbbc['File remove ok'].'</p>';
                                } else {
                                        $action_message = '<p id="amessage" style="color: red; text-align: center;">/'.$rootfolder.'/'.$id.'/'.$filename.' '.$lang_ezbbc['File remove fail'].'</p>';
                                }
                        }
                endif;
        endif;
        // End action required
        
        //Function to get the max_file_size in the php.ini file
        function return_bytes($FormattedSize)
        {
           $FormattedSize = trim($FormattedSize);
           $Size = floatval($FormattedSize);
           $MultipSize = strtoupper(substr($FormattedSize, -1));
        
           if($MultipSize == "G") $Size *= pow(1024, 3);
           else if($MultipSize == "M") $Size *= pow(1024, 2);
           else if($MultipSize == "K") $Size *= 1024;
        
           return $Size;
        }
        $max_file_size_php = return_bytes(ini_get('upload_max_filesize'));
        
        // Counting the already uploaded documents
        if  (file_exists($loc_user_folder)) {
			//Retrieving the submitted docs
			$doc_file_loc = opendir($loc_user_folder);
			while(false !== ($doc_file = readdir($doc_file_loc))) {
					$file_ext = pathinfo($doc_file, PATHINFO_EXTENSION);
					if (!in_array($file_ext,$allowed_ext)) { continue; }
					 $doc_list[] = $doc_file;
			}
			rsort($doc_list);
			$doc_count = count($doc_list);
			
        } else {
			$doc_count = 0;
        }
        
        // Setting limit and max values for each user rank
		if (!$pun_user['is_admmod']) $doc_limit = $ezbbc_config['doc_limit']; //users
		if ($pun_user['g_id'] == PUN_ADMIN) $doc_limit = 0; //admin
		if ($pun_user['g_id'] != PUN_ADMIN && $pun_user['g_moderator'] == '1') $doc_limit = $ezbbc_config['doc_limit_mod']; // mods
		if ($pun_user['is_admmod']) $ezbbc_config['max_doc_size'] = $max_file_size_php / 1024; //admins and mods
		
        // File submission
        if (isset($_POST['subfile']) && ($doc_count < $doc_limit || $doc_limit == 0)) {
			$file_name = $_FILES['file']['name'];
			$uploaded_file = $_FILES['file']['tmp_name'];
        	//User folder treatment
        	$location = $loc_user_folder;
        	if (file_exists($loc_user_folder)) {
        	        @chmod($loc_user_folder, 0755);
        	} else {
        	        @mkdir($loc_user_folder, 0755);
        	}
        	// Adding html file to user folder if it doesn't exist
        	if (!file_exists($loc_user_folder.'/index.html')) {
        		$fp = fopen($loc_user_folder.'/index.html', 'wb');
        		fwrite($fp, '<html><head><title>.</title></head><body>.</body></html>');
        		fclose($fp);
        	}
        	if  (is_writable($location) && is_writable($cache)) {
        	        //treating the file name
                        $file_name = htmlentities($file_name, ENT_QUOTES, 'utf-8');
                        $search = array('&Agrave;', '&agrave;', '&Aacute;', '&aacute;', '&Acirc;', '&acirc;', '&Atilde;', '&atilde;', '&Auml;', '&auml;', '&Aring;', '&aring;', '&AElig;', '&aelig;', '&Ccedil;', '&ccedil;', '&ETH;', '&eth;', '&Egrave;', '&egrave;', '&Eacute;', '&eacute;', '&Ecirc;', '&ecirc;', '&Euml;', '&euml;', '&Igrave;', '&igrave;', '&Iacute;', '&iacute;', '&Icirc;', '&icirc;', '&Iuml;', '&iuml;', '&Ntilde;', '&ntilde;', '&Ograve;', '&ograve;', '&Oacute;', '&oacute;', '&Ocirc;', '&ocirc;', '&Otilde;', '&otilde;', '&Ouml;', '&ouml;', '&Oslash;', '&oslash;', '&OElig;', '&oelig;', '&szlig;', '&THORN;', '&thorn;', '&Ugrave;', '&ugrave;', '&Uacute;', '&uacute;', '&Ucirc;', '&ucirc;', '&Uuml;', '&uuml;', '&Yacute;', '&yacute;', '&Yuml;', '&yuml;', ' ', '&lt;', '&gt;', '&quot;', '&#039;', '\'', '/', '\\', '?', '*', ':', '!', '|');
                        $replace = array('a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'ae', 'c', 'c', 'd', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'i', 'i', 'i', 'i', 'n', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'oe', 'oe', 'ss', 'p', 'p', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'y', 'y', 'y', 'y', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_');
                        $file_name = str_replace($search, $replace, $file_name);
                        $file_name = strtolower(str_replace(' ', '_', $file_name));
                        $file_name = preg_replace('/[^\w\.-]+/', '', $file_name);
                        $timestamp = time();
                        $def_file_name = $timestamp.'_'.$file_name;
                        $file_location = $location.'/'.$def_file_name;
                        $file_path = $pun_config['o_base_url'].'/'.$ezbbc_config['doc_folder'].'/'.$pun_user['id'].'/'.$def_file_name;
                        $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
                        // Handling the errors and finally send the file to the folder
                        if($_FILES['file']['error'] == UPLOAD_ERR_NO_FILE) {
                                $message = '<span style="color: orange"> » '.$lang_ezbbc['No file submitted'].'</span>';
                        } else if (!in_array($file_ext,$allowed_ext)) {
                                $message = '<span style="color: orange"> » <strong>'.$file_ext.'</strong> '.$lang_ezbbc['File not allowed'].'</span>';
                        } else if($_FILES['file']['error'] == UPLOAD_ERR_FORM_SIZE || $_FILES['file']['error'] == UPLOAD_ERR_INI_SIZE || filesize($uploaded_file) > $ezbbc_config['max_doc_size']*1024) {
                                $message = '<span style="color: orange"> » '.$lang_ezbbc['File too big'].'</span>';
                        } else if (is_uploaded_file($uploaded_file) && @move_uploaded_file($uploaded_file,$file_location)) {
                                $upload_ok = true;
                                //adding file to the uploaded doc array
        	                array_unshift($doc_list, $def_file_name);
        	                $doc_count++;
                                // Creating file in cache to have easy to fetch datas
                                $data_file = $timestamp.'_doc_'.$pun_user['id'].'_'.$file_name.'.txt';
        	                $fp = fopen($cache.$data_file, 'wb');
        	                fclose($fp);
                        } else {
                                $message = '<span style="color: orange"> » '.$lang_ezbbc['Upload fail'].'</span>';
                        }
        	} else {
        	        $message = '<span style="color: orange"> » '.$lang_ezbbc['User Folder not writable'].'</span>';
        	}
        }
        
        //Listing of the doc files if feature enabled
        if ($ezbbc_config['doc_list'] == 'doc_list') { 
                $folder_path = $path.'/'.$pun_user['id'];
                for($i=0;$i<$doc_count;$i++) {
                        preg_match('@^([0-9]+)_(.*)$@', $doc_list[$i], $matches);
                        $timestamp = $matches[1];
                        $name = $matches[2];
                        $date = date($lang_ezbbc['Date format'], $timestamp);
                        $doc_path = $folder_path.'/'.$doc_list[$i];
                         $doc_list_display[]= '<li><a href="'.$doc_path.'" onclick="window.open(this.href, \'Preview\', \'height=400, width=500, top=50, left=50, toolbar=no, menubar=no, location=no, resizable=yes, scrollbars=no, status=no\'); return false;" title="'.$lang_ezbbc['Display'].'"><img src="style/admin/listing/doc.png" alt="'.$lang_ezbbc['Display'].'" /></a> <a href="'.$_SERVER['SCRIPT_NAME'].'?textarea_name='.$textarea_name.'&amp;action=remove&amp;fname='.$doc_list[$i].'" onclick="return window.confirm(\''.$lang_ezbbc['Remove file confirm'].'\')" title="'.$lang_ezbbc['Remove'].'"><img src="style/admin/listing/doc-del.png" alt="'.$lang_ezbbc['Remove'].'" /></a> <a href="#" onclick="document.linkform.web_link.value = \''.$doc_path.'\'; document.linkform.link_label.focus(); return false;" title="'.$lang_ezbbc['Add'].'"><img src="style/admin/listing/doc-add.png" alt="'.$lang_ezbbc['Add'].'" /></a> '.$date.' - <strong>'.$name.'</strong></li>';
                }
                        
        }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<title><?php echo $lang_ezbbc['EZBBC Link chooser'] ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="<?php echo PUN_ROOT.'style/'.$pun_user['style'].'.css' ?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo PUN_ROOT.'plugins/ezbbc/style/'.$ezbbc_config['style_folder'].'/ezbbc.css' ?>" />
	<!-- Adding JS function to send the link value to the opener -->
	<script type="text/javascript">
	/* <![CDATA[ */
	// Function to display the form matching the link type
	function lVisibility() {
		var webForm = document.getElementById('cweb');
		var idForm = document.getElementById('cid');
		if (document.linkform.radiolink[0].checked) {
			webForm.style.display = "block";
			document.linkform.web_link.focus();
		} else {
			webForm.style.display = "none";
		}
		if (document.linkform.radiolink[1].checked || document.linkform.radiolink[2].checked || document.linkform.radiolink[3].checked || document.linkform.radiolink[4].checked) {
			idForm.style.display = "block";
			document.linkform.id_link.focus();
		} else {
			idForm.style.display = "none";
		}
	}
	function docVisibility() {
		var docForm = document.getElementById('cdocs');;
		if (docForm.style.display == "block") {
			docForm.style.display = "none";
		} else {
			docForm.style.display = "block";
		}
	}
	// Function to retrieve the selection in opener and add it to the right field    
	function getSelection() {
        var field  = window.opener.document.getElementsByName('<?php echo $textarea_name ?>')[0]; 
        var scroll = field.scrollTop;
        field.focus();
        /* get the selection */
        if (window.ActiveXObject) { //For IE
                var textRange = window.opener.document.selection.createRange();
                var currentSelection = textRange.text;
        } else { //For other browsers
                var startSelection   = field.value.substring(0, field.selectionStart);
                var currentSelection = field.value.substring(field.selectionStart, field.selectionEnd);
                var endSelection     = field.value.substring(field.selectionEnd);
        }
        /* Add the selection to the label field */
		document.linkform.link_label.value = currentSelection;
		(currentSelection == '' && document.linkform.web_link.value != '') ? document.linkform.link_label.focus() : document.linkform.web_link.focus();
	}
	//Function to clear the action message
	function clearMessage() {
	        var amessage = document.getElementById("amessage");
	        amessage.style.display = "none";
	}
	// Function to insert The linktags and selection in opener Window
	function insertLinkTag() {
        var field  = window.opener.document.getElementsByName('<?php echo $textarea_name ?>')[0]; 
        var scroll = field.scrollTop;
        field.focus();
        
        
        /* === Part 1: get the selection === */
        if (window.ActiveXObject) { //For IE
                var textRange = window.opener.document.selection.createRange();
                var currentSelection = textRange.text;
        } else { //For other browsers
                var startSelection   = field.value.substring(0, field.selectionStart);
                var currentSelection = field.value.substring(field.selectionStart, field.selectionEnd);
                var endSelection     = field.value.substring(field.selectionEnd);
        }
		
<?php if (version_compare($pun_config['o_cur_version'], '1.4.6') >= 0): ?>
        /* === Part 2: what Tag type ? === */
		var startTag = endTag = '';
		var exp = new RegExp("^[0-9]*$");
		var label = document.linkform.link_label.value;
		// Treating each link case (url, topic, post, forum, user, links)
        if (document.linkform.radiolink[0].checked) { //url
			var url = document.linkform.web_link.value;
			var testurl = url.toLowerCase();
			if (label != '') { //A label has been entered
       				if (testurl.indexOf('http://') == 0 || testurl.indexOf('https://') == 0 || testurl.indexOf('ftp://') == 0 || testurl.indexOf('www.') == 0) {
       				    startTag = '[url=' + url + ']';
       				    currentSelection = label;
       				    endTag = '[/url]';
       				} else {
       				    alert("<?php echo $lang_ezbbc['Invalid url'] ?>");
       				    document.linkform.web_link.focus();
       				    return false;
       				}
       			} else { //No label entered
       				if (testurl.indexOf('http://') == 0 || testurl.indexOf('https://') == 0 || testurl.indexOf('ftp://') == 0 || testurl.indexOf('www.') == 0) {
       				        startTag = '[url=' + url + ']';
                                        currentSelection = url;
                                        endTag = '[/url]';
       				} else {
       				        alert("<?php echo $lang_ezbbc['Invalid url'] ?>");
                                        document.linkform.web_link.focus();
                                        return false;
       				}
       			}
		}
			
		if (document.linkform.radiolink[1].checked) { //topic
			var id = document.linkform.id_link.value;
			if (label != '') { //A label has been entered
				if (exp.test(id) && id > 0) { // Is the id a numerical value > 0?
       				startTag = '[topic=' + id + ']';
					currentSelection = label;
					endTag = '[/topic]';
				} else {
				        alert("<?php echo $lang_ezbbc['Invalid id'] ?>");
					document.linkform.id_link.focus();
					return false;
				}
			} else { //No label entered
			        if (exp.test(id) && id > 0) { // Is the id a numerical value > 0?
			                startTag = '[topic]';
					currentSelection = id;
					endTag = '[/topic]';
				} else {
       				alert("<?php echo $lang_ezbbc['Invalid id'] ?>");
					document.linkform.id_link.focus();
					return false;
				}
			}
		}
			
		if (document.linkform.radiolink[2].checked) { //post
			var id = document.linkform.id_link.value;
			if (label != '') { //A label has been entered
				if (exp.test(id) && id > 0) { // Is the id a numerical value > 0?
       				startTag = '[post=' + id + ']';
					currentSelection = label;
					endTag = '[/post]';
       			} else {
       				alert("<?php echo $lang_ezbbc['Invalid id'] ?>");
					document.linkform.id_link.focus();
					return false;
       			}
       		} else { //No label entered
       			if (exp.test(id) && id > 0) { // Is the id a numerical value > 0?
       				startTag = '[post]';
					currentSelection = id;
					endTag = '[/post]';
       			} else {
       				alert("<?php echo $lang_ezbbc['Invalid id'] ?>");
					document.linkform.id_link.focus();
					return false;
       			}
			}
		}
			
		if (document.linkform.radiolink[3].checked) { //forum
			var id = document.linkform.id_link.value;
			if (label != '') { //A label has been entered
				if (exp.test(id) && id > 0) { // Is the id a numerical value > 0?
       				startTag = '[forum=' + id + ']';
					currentSelection = label;
					endTag = '[/forum]';
       			} else {
       				alert("<?php echo $lang_ezbbc['Invalid id'] ?>");
					document.linkform.id_link.focus();
					return false;
       			}
       		} else { //No label entered
       			if (exp.test(id) && id > 0) { // Is the id a numerical value > 0?
       				startTag = '[forum]';
					currentSelection = id;
					endTag = '[/forum]';
       			} else {
       				alert("<?php echo $lang_ezbbc['Invalid id'] ?>");
					document.linkform.id_link.focus();
					return false;
       			}
			}
		}
			
		if (document.linkform.radiolink[4].checked) { //user
			var id = document.linkform.id_link.value;
			if (label != '') { //A label has been entered
				if (exp.test(id) && id > 0) { // Is the id a numerical value > 0?
       				startTag = '[user=' + id + ']';
					currentSelection = label;
					endTag = '[/user]';
       			} else {
       				alert("<?php echo $lang_ezbbc['Invalid id'] ?>");
					document.linkform.id_link.focus();
					return false;
       			}
       		} else { //No label entered
       			if (exp.test(id) && id > 0) { // Is the id a numerical value >0?
       				startTag = '[user]';
					currentSelection = id;
					endTag = '[/user]';
       			} else {
       				alert("<?php echo $lang_ezbbc['Invalid id'] ?>");
					document.linkform.id_link.focus();
					return false;
       			}
			}
		}
<?php else: ?>
/* === Part 2: what Tag type ? === */
		var startTag = endTag = '';
		var exp = new RegExp("^[0-9]*$");
		var label = document.linkform.link_label.value;
		var url = document.linkform.web_link.value;
                        if (label != '') { //A label has been entered
                                if (url.indexOf('http://') == 0 || url.indexOf('https://') == 0 || url.indexOf('ftp://') == 0 || url.indexOf('www.') == 0) {
                                        startTag = '[url=' + url + ']';
                                        currentSelection = label;
                                        endTag = '[/url]';
                                } else {
                                        alert("<?php echo $lang_ezbbc['Invalid url'] ?>");
                                        document.linkform.web_link.focus();
                                        return false;
                                }
       			} else { //No label entered
       				if (url.indexOf('http://') == 0 || url.indexOf('https://') == 0 || url.indexOf('ftp://') == 0 || url.indexOf('www.') == 0) {
       				    startTag = '[url=' + url + ']';
						currentSelection = url;
						endTag = '[/url]';
       				} else {
       				    alert("<?php echo $lang_ezbbc['Invalid url'] ?>");
						document.linkform.web_link.focus();
						return false;
       				}
       			}
<?php endif; ?>
        /* === Part 3: adding what was produced to the opener === */
        if (window.ActiveXObject) { //For IE
                textRange.text = startTag + currentSelection + endTag;   
        } else { //For other browsers
                field.value = startSelection + startTag + currentSelection + endTag + endSelection;
                field.focus();
        } 

        field.scrollTop = scroll;
		self.close();		
	}
	/* ]]> */
	</script>
</head>
<body onload="getSelection(); setTimeout('clearMessage()', 4000);">
<div class="pun">
	<div class="punwrap">
		<div id="brdmain">
			<div id="ezbbclink">
				<form name="linkform" method="post" action="<?php echo $_SERVER['SCRIPT_NAME'].'?textarea_name='.$textarea_name ?>" enctype="multipart/form-data">
				<?php if (version_compare($pun_config['o_cur_version'], '1.4.6') >= 0): ?>
				<p>
					<?php echo $lang_ezbbc['Ask url type'] ?><br />
					<?php if (version_compare($pun_config['o_cur_version'], '1.5.0') >= 0 && $pun_user['g_post_links'] == '1'): ?>
						<input type="radio" value="web" name="radiolink" checked="checked" onclick="lVisibility()" /><?php echo $lang_ezbbc['Web link'] ?>
						<input type="radio" value="topic" name="radiolink" onclick="lVisibility()" /><?php echo $lang_ezbbc['Topic link'] ?>
					<?php else: ?>
						<input type="radio" value="web" name="radiolink" style="display: none" onclick="lVisibility()" />
						<input type="radio" value="topic" name="radiolink" checked="checked" onclick="lVisibility()" /><?php echo $lang_ezbbc['Topic link'] ?>
					<?php endif; ?>
					<input type="radio" value="post" name="radiolink" onclick="lVisibility()" /><?php echo $lang_ezbbc['Post link'] ?> 
					<input type="radio" value="forum" name="radiolink" onclick="lVisibility()" /><?php echo $lang_ezbbc['Forum link'] ?> 
					<input type="radio" value="user" name="radiolink" onclick="lVisibility()" /><?php echo $lang_ezbbc['User link'] ?>
				</p>
				<?php endif; ?>
				<p>
				<?php echo $lang_ezbbc['Ask label'] ?><br />
					<input type="text" name="link_label" size="45" />
					</p>
				<?php if (version_compare($pun_config['o_cur_version'], '1.5.0') >= 0 && $pun_user['g_post_links'] == '1'): ?>
					<div id="cweb">
						<p>
						<label class="required"><strong><?php echo $lang_ezbbc['Ask url'] ?> <span><?php echo $lang_common['Required'] ?></span></strong><br />
						<input type="text" name="web_link" size="60" value="<?php if($upload_ok) echo $file_path; ?>" /></label><br />
						</p>
					<?php if ($ezbbc_config['doc_upload'] == 'doc_upload' && !$pun_user['is_guest'] && ($doc_count < $doc_limit || $doc_limit == 0)): ?>
						<p>
						<?php echo $lang_ezbbc['Upload Doc'] ?><?php echo $message ?><br />
						<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo ($ezbbc_config['max_doc_size']*1024) ?>" />
						<input type="file" name="file" size="35" />
						<input type="submit" name="subfile" value="<?php echo $lang_ezbbc['Submit'] ?>" /><br />
						<?php echo $lang_ezbbc['Allowed extension display'].implode(',',$allowed_ext).' - '.$lang_ezbbc['Max size'].$ezbbc_config['max_doc_size'].$lang_ezbbc['Kb'] ?>
						</p>
					<?php endif; ?>
					<?php if ($ezbbc_config['doc_upload'] == 'doc_upload' && !$pun_user['is_guest']): ?>
						<p>
						<?php echo $lang_ezbbc['Already uploaded'].'<strong>'.$doc_count.'</strong>' ?>
						<?php if ($doc_limit > 0) echo '- '.$lang_ezbbc['Max doc upload'].'<strong>'.$doc_limit.'</strong>' ?>
						</p>
					<?php endif; ?>
					<?php if ($ezbbc_config['doc_upload'] == 'doc_upload' && $ezbbc_config['doc_list'] == 'doc_list' && count($doc_list) > 0): ?>
                	    <p>
						<a href="#" onclick="docVisibility(); return false;"><?php echo $lang_ezbbc['My docs'] ?></a>
						<?php echo $action_message ?>
						</p>
						<ul style="display: none; max-height: 100px; overflow: auto; border-bottom: grey 1px solid; border-top: grey 1px solid;" id="cdocs">
						<?php 
						foreach($doc_list_display as $doc_item) {
						        echo $doc_item;
						}
						?>
						</ul>
					<?php endif; ?>
					</div>
				<?php endif; ?>
				<?php if (version_compare($pun_config['o_cur_version'], '1.4.6') >= 0): ?>
					<div id="cid"<?php if (version_compare($pun_config['o_cur_version'], '1.5.0') >= 0 && $pun_user['g_post_links'] == '1') echo ' style="display: none"'; ?>>
						<p>
						<?php echo $lang_ezbbc['Ask id'] ?><br />
						<input type="text" name="id_link" size="5" /><br />
						</p>
					</div>
				<?php endif; ?>
				        <p class="buttons"><input type="button" value="<?php echo $lang_ezbbc['OK'] ?>" onclick="insertLinkTag()" /> <input type="button" value="<?php echo $lang_ezbbc['Cancel'] ?>" onclick="self.close()" /></p>
				</form>
			</div>
		</div>
	</div>
</div>
</body>
</html>
