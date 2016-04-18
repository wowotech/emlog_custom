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
	<title><?php echo $lang_ezbbc['EZBBC Heading'] ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="<?php echo PUN_ROOT.'style/'.$pun_user['style'].'.css' ?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo PUN_ROOT.'plugins/ezbbc/style/'.$ezbbc_config['style_folder'].'/ezbbc.css' ?>" />
	<!-- Adding JS function to send the heading text value to the opener -->
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
		document.headingform.heading_label.value = currentSelection;
		document.headingform.heading_label.focus();
	}
	// Function to insert The linktags and selection in opener Window
	function insertHeaderTag() {
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
        var id = document.headingform.id.value;
        var label = document.headingform.heading_label.value;
        <?php if ($ezbbc_config['h_id'] == 'h_id'): ?>
        if (id != '' && label != '') {
		startTag = '[h=' + id +']';
		currentSelection = label;
		endTag = '[/h]';
	} else if (label != '') {
	        startTag = '[h]';
		currentSelection = label;
		endTag = '[/h]';
	<?php else: ?>
	if (label != '') {
	        startTag = '[h]';
		currentSelection = label;
		endTag = '[/h]';
        <?php endif; ?>
	} else {
	        alert("<?php echo $lang_ezbbc['Invalid label'] ?>");
		document.headingform.heading_label.focus();
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
				<div id="ezbbccheading">
					<form name="headingform">
					<p>
					<label class="required"><strong><?php echo $lang_ezbbc['Ask title'] ?> <span><?php echo $lang_common['Required'] ?></span></strong><br />
					<input type="text" name="heading_label"  size="45" /></label>
					</p>
					<?php if ($ezbbc_config['h_id'] == 'h_id'): ?>
					<p>
					<?php echo $lang_ezbbc['Title ID'] ?><br />
					<input type="text" name="id"  size="35" />
					</p>
					<?php endif; ?>
					<p class="buttons"><input type="button" value="<?php echo $lang_ezbbc['OK'] ?>" onclick="insertHeaderTag()" /> <input type="button" value="<?php echo $lang_ezbbc['Cancel'] ?>" onclick="self.close()" /></p>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
