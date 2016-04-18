<?php
define('PUN_ROOT', '../../');
require PUN_ROOT.'include/common.php';
// Retrieving style folder
require PUN_ROOT.'plugins/ezbbc/config.php';
// Getting the textarea name from get string
$textarea_name = isset($_GET['textarea_name']) && $_GET['textarea_name'] == 'req_message' ? 'req_message' : 'signature';
// Language file load
require PUN_ROOT.'lang/'.$pun_user['language'].'/common.php';
$ezbbc_language_folder = (file_exists(PUN_ROOT.'plugins/ezbbc/lang/'.$pun_user['language'].'/ezbbc_plugin.php')) ? $pun_user['language'] : 'English';    
require PUN_ROOT.'plugins/ezbbc/lang/'.$ezbbc_language_folder.'/ezbbc_plugin.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<title><?php echo $lang_ezbbc['EZBBC Video chooser'] ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="<?php echo PUN_ROOT.'style/'.$pun_user['style'].'.css' ?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo PUN_ROOT.'plugins/ezbbc/style/'.$ezbbc_config['style_folder'].'/ezbbc.css' ?>" />
	<script type="text/javascript">
	/* <![CDATA[ */
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
		document.videoform.url.value = currentSelection;
		(currentSelection == '') ? document.videoform.url.focus() : document.videoform.width.focus();
	}
	// Function to insert The linktags and selection in opener Window
	function insertVideoTag() {
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
		
        /* === Part 2: creating tagged element === */
		var startTag = endTag = '';
		var exp = new RegExp("^[0-9]*$");
		var url = document.videoform.url.value;
		var testurl = url.toLowerCase();
		var width = document.videoform.width.value;
		var height = document.videoform.height.value;
		if (width != '' && height != '' && exp.test(width) && exp.test(height)) { //Width and height set
		        if (testurl.indexOf('http://www.youtube.com/watch') == 0 || testurl.indexOf('http://youtu.be/') == 0 || testurl.indexOf('http://www.dailymotion.com/video') == 0 || testurl.indexOf('https://vimeo.com/') == 0 || testurl.indexOf('http://vimeo.com/') == 0) {
                                     startTag = '[video=' + width + ',' + height + '][url]';
                                     currentSelection = url;
                                     endTag = '[/url][/video]';
       				} else {
       				    alert("<?php echo $lang_ezbbc['Invalid url'] ?>");
       				    document.videoform.url.focus();
       				    return false;
       				}
                } else if (width == '' || height == '') { //one value or both values of size not set
       				 if (testurl.indexOf('http://www.youtube.com/watch') == 0 || testurl.indexOf('http://youtu.be/') == 0 || testurl.indexOf('http://dai.ly/') == 0 || testurl.indexOf('http://www.dailymotion.com/video') == 0 || testurl.indexOf('https://vimeo.com/') == 0 || testurl.indexOf('http://vimeo.com/') == 0) {
       				    startTag = '[video=480,360][url]';
       				    currentSelection = url;
       				    endTag = '[/url][/video]';
       				} else {
       				    alert("<?php echo $lang_ezbbc['Invalid url'] ?>");
						document.videoform.url.focus();
						return false;
       				}
       		} else if (!exp.test(height)) { // Wrong height value
       		        alert("<?php echo $lang_ezbbc['Invalid height'] ?>");
					document.linkform.height.focus();
					return false;
		} else if (!exp.test(width)) { // Wrong width value
		        alert("<?php echo $lang_ezbbc['Invalid width'] ?>");
					document.linkform.width.focus();
					return false;
		}
       		        
		
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
<body onload="getSelection()">
	<div class="pun">
		<div class="punwrap">
			<div id="brdmain">
				<div id="ezbbcvideo">
					<form name="videoform">
					<p>
					<label class="required"><strong><?php echo $lang_ezbbc['Ask url video'] ?> <span><?php echo $lang_common['Required'] ?></span></strong><br />
					<input type="text" name="url" size="55" /></label>
					</p>
					<p>
					<?php echo $lang_ezbbc['Ask video width'] ?><br />
					<input type="text" name="width"  size="4" />
					</p>
					<p>
					<?php echo $lang_ezbbc['Ask video height'] ?><br />
					<input type="text" name="height" size="4" />
					</p>
					<p class="buttons"><input type="button" value="<?php echo $lang_ezbbc['OK'] ?>" onclick="insertVideoTag()" /> <input type="button" value="<?php echo $lang_ezbbc['Cancel'] ?>" onclick="self.close()" /></p>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
