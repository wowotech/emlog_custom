<?php
define('PUN_ROOT', '../../');
require PUN_ROOT.'include/common.php';
// Retrieving style folder
require PUN_ROOT.'plugins/ezbbc/config.php';
// Getting the textarea name from get string
$textarea_name = isset($_GET['textarea_name']) && $_GET['textarea_name'] == 'req_message' ? 'req_message' : 'signature';
// Language file load
$ezbbc_language_folder = (file_exists(PUN_ROOT.'plugins/ezbbc/lang/'.$pun_user['language'].'/ezbbc_plugin.php')) ? $pun_user['language'] : 'English';    
require PUN_ROOT.'plugins/ezbbc/lang/'.$ezbbc_language_folder.'/ezbbc_plugin.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<title><?php echo $lang_ezbbc['EZBBC ColorPicker'] ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="<?php echo PUN_ROOT.'style/'.$pun_user['style'].'.css' ?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo PUN_ROOT.'plugins/ezbbc/style/'.$ezbbc_config['style_folder'].'/ezbbc.css' ?>" />
	<!-- loading jscolor script -->
	<script type="text/javascript" src="jscolor/jscolor.js"></script>
	<!-- Adding JS function to send the color value to the opener -->
	<script type="text/javascript">
	/* <![CDATA[ */
	// Function to apply the defined color to the label text in the label field
	function switchColor() {
	document.colorform.label.style.color = document.colorform.color_choice.value;
	document.colorform.color_choice.style.backgroundColor = document.colorform.color_choice.value;
	return false;
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
		document.colorform.label.value = currentSelection;
		(currentSelection == '') ? document.colorform.label.focus() : document.colorform.color_choice.focus();
	}
	// Function to insert The linktags and selection in opener Window
	function insertColorTag() {
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
		var label = document.colorform.label.value;
        var color = document.colorform.color_choice.value;
				if (label != '') { //A label has been entered
       				if (color != '') {
       				    startTag = '[color=' + color + ']';
						currentSelection = label;
						endTag = '[/color]';
       				 } else {
       				    alert("<?php echo $lang_ezbbc['Ask color'] ?>");
						document.colorform.color_choice.focus();
						return false;
       				        }
       			} else { //No label entered
       				if (color != '') {
       				    startTag = '[color=' + color + ']';
						currentSelection = "<?php echo$lang_ezbbc['Ask colorized text'] ?>";
						endTag = '[/color]';
       				} else {
       				    alert("<?php echo $lang_ezbbc['Ask color'] ?>");
						document.colorform.color_choice.focus();
						return false;
       				}
       			}
		
		
        /* === Part 3: adding what was produced to the opener === */
        if (window.ActiveXObject) { //For IE
                textRange.text = startTag + currentSelection + endTag;
                textRange.moveStart('character', -endTag.length - currentSelection.length);
                textRange.moveEnd('character', -endTag.length);
                textRange.select();     
        } else { //For other browsers
                field.value = startSelection + startTag + currentSelection + endTag + endSelection;
                field.focus();
                field.setSelectionRange(startSelection.length + startTag.length, startSelection.length + startTag.length + currentSelection.length);
        } 

        field.scrollTop = scroll;
		self.close();		
	}
	/* ]]> */
	</script>
</head>
<body onload="document.getElementById('color_choice').color.showPicker();getSelection()">
	<div class="pun">
		<div class="punwrap">
			<div id="brdmain">
				<div id="ezbbccolorpicker">
					<form name="colorform">
					<p>
					<?php echo $lang_ezbbc['Ask label'] ?><br />
					<input type="text" name="label" size="35" />
					</p>
					<p style="padding-bottom: 130px;">
					<label class="required"><strong><?php echo $lang_ezbbc['Ask color'] ?> <span><?php echo $lang_common['Required'] ?></span></strong><br />
					<input type="text" name="color_choice" id="color_choice" class="color {adjust:false,hash:true,caps:false,pickerOnfocus:false}" title="<?php echo $lang_ezbbc['Ask color explanation'] ?>" size="25" onchange="switchColor()" onkeydown="switchColor()" onkeyup="switchColor()"/></label>
					</p>
					<p class="buttons"><input type="button" value="<?php echo $lang_ezbbc['OK'] ?>" onclick="insertColorTag()" /> <input type="button" value="<?php echo $lang_ezbbc['Cancel'] ?>" onclick="self.close()" /></p>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
