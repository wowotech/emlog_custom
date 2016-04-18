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
	<title><?php echo $lang_ezbbc['EZBBC Code insertion'] ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="<?php echo PUN_ROOT.'style/'.$pun_user['style'].'.css' ?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo PUN_ROOT.'plugins/ezbbc/style/'.$ezbbc_config['style_folder'].'/ezbbc.css' ?>" />
	<!-- Adding JS function to send the code value to the opener -->
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
        /* Add the selection to the code field */
		document.codeform.code.value = currentSelection;
		document.codeform.code.focus();
	}
	// Function to insert The codetags and selection in opener Window
	function insertCodeTag() {
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
		
        /* === Part 2: what Tag type ? === */
		var startTag = endTag = '';
		var selectedLang = document.codeform.language.selectedIndex;
		var language = document.codeform.language.options[selectedLang].value;
		var code = document.codeform.code.value;
		// Treating The fields
        if (code != '') { // Code has been entered
            startTag = '[code]\n[== ' + language + ' ==]\n';
        	endTag = '\n[/code]';
			currentSelection = code;
        } else { // No code has been entered
			alert("<?php echo $lang_ezbbc['Ask code'] ?>");
			document.codeform.code.focus();
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
<body onload="getSelection();">
<div class="pun">
	<div class="punwrap">
		<div id="brdmain">
			<div id="ezbbccode">
				<form name="codeform">
				<p>
					<?php echo $lang_ezbbc['Ask language'] ?><br />
					<select name="language">
						<option value="<?php echo $lang_ezbbc['HTML'] ?>"><?php echo $lang_ezbbc['HTML'] ?></option>
						<option value="<?php echo $lang_ezbbc['XHTML'] ?>"><?php echo $lang_ezbbc['XHTML'] ?></option>
						<option value="<?php echo $lang_ezbbc['XML'] ?>"><?php echo $lang_ezbbc['XML'] ?></option>
						<option value="<?php echo $lang_ezbbc['CSS'] ?>"><?php echo $lang_ezbbc['CSS'] ?></option>
						<option value="<?php echo $lang_ezbbc['SASS'] ?>"><?php echo $lang_ezbbc['SASS'] ?></option>
						<option value="<?php echo $lang_ezbbc['JavaScript'] ?>"><?php echo $lang_ezbbc['JavaScript'] ?></option>
						<option value="<?php echo $lang_ezbbc['CoffeeScript'] ?>"><?php echo $lang_ezbbc['CoffeeScript'] ?></option>
						<option value="<?php echo $lang_ezbbc['PHP'] ?>"><?php echo $lang_ezbbc['PHP'] ?></option>
						<option value="<?php echo $lang_ezbbc['C++'] ?>"><?php echo $lang_ezbbc['C++'] ?></option>
						<option value="<?php echo $lang_ezbbc['Perl'] ?>"><?php echo $lang_ezbbc['Perl'] ?></option>
						<option value="<?php echo $lang_ezbbc['Java'] ?>"><?php echo $lang_ezbbc['Java'] ?></option>
						<option value="<?php echo $lang_ezbbc['Undefined'] ?>" selected="selected"><?php echo $lang_ezbbc['Undefined'] ?></option>
					</select>
				</p>
				<p>
					<label class="required"><strong><?php echo $lang_ezbbc['Ask code'] ?> <span><?php echo $lang_common['Required'] ?></span></strong><br />
					<textarea name="code" cols="80" rows="10"></textarea></label>
				</p>
				<p class="buttons"><input type="button" value="<?php echo $lang_ezbbc['OK'] ?>" onclick="insertCodeTag()" /> <input type="button" value="<?php echo $lang_ezbbc['Cancel'] ?>" onclick="self.close()" /></p>
				</form>
			</div>
		</div>
	</div>
</div>
</body>
</html>
