<?php
define('PUN_ROOT', '../../');
require PUN_ROOT.'include/common.php';
// Retrieving style folder
require PUN_ROOT.'plugins/ezbbc/config.php';
// Getting the textarea name and the list type from get string
$textarea_name = isset($_GET['textarea_name']) && $_GET['textarea_name'] == 'req_message' ? 'req_message' : 'signature';
$list_type = isset($_GET['list_type']) && in_array($_GET['list_type'], array('*','1','a')) ? $_GET['list_type'] : '*';
switch ($list_type) {
		case '*' :
			$ltype_start_tag = '<ul id="itemlist" style="list-style-type: disc">'."\n";
			$ltype_end_tag = '</ul>'."\n";
		break;
		case '1' :
			$ltype_start_tag = '<ol id="itemlist" style="list-style-type: decimal">'."\n";
			$ltype_end_tag = '</ol>'."\n";
		break;
		case 'a' :
			$ltype_start_tag = '<ol id="itemlist" style="list-style-type: lower-alpha">'."\n";
			$ltype_end_tag = '</ol>'."\n";
		break;
}
// Language file load
require PUN_ROOT.'lang/'.$pun_user['language'].'/common.php';
$ezbbc_language_folder = (file_exists(PUN_ROOT.'plugins/ezbbc/lang/'.$pun_user['language'].'/ezbbc_plugin.php')) ? $pun_user['language'] : 'English';    
require PUN_ROOT.'plugins/ezbbc/lang/'.$ezbbc_language_folder.'/ezbbc_plugin.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<title><?php echo $lang_ezbbc['EZBBC List creator'] ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="<?php echo PUN_ROOT.'style/'.$pun_user['style'].'.css' ?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo PUN_ROOT.'plugins/ezbbc/style/'.$ezbbc_config['style_folder'].'/ezbbc.css' ?>" />
	<!-- Adding JS function to send the generated list to the opener -->
	<script type="text/javascript">
	/* <![CDATA[ */
	// Global variables
	var it_count = 0;
	// Function to display the form matching the link type
	function addItem() {
		var liItem = document.createElement('li');
		liItem.innerHTML = '<input type="text" name="element' + it_count + '" size="55" onKeyPress="if (event.keyCode == 13) addItem();" />';
		document.getElementById('itemlist').appendChild(liItem);
		document.listform.elements[it_count].focus(); // Focus on that created field
		it_count++;
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
        /* Treating the selection */
		if (currentSelection != '') {
			var item = currentSelection.split('\n');
       		for(i=0;i<item.length;i++) {
       			item[i] = '<li><input type="text" name="element' + i + '" value="' + item[i] + '" size="55" onKeyPress="if (event.keyCode == 13) addItem();"  /></li>';
			}
			it_count = i;
			var allItems = item.join("\n");
			// adding the items on the right place
			var ulItems = document.getElementById('itemlist');
			ulItems.innerHTML = allItems;
			document.listform.elements[it_count-1].focus(); // Focus on the last input field
		} else {
			var oneItem = '<li><input type="text" name="element0" size="55" onKeyPress="if (event.keyCode == 13) addItem();" /></li>';
			it_count = 1;
			// adding the item on the right place
			var listItems = document.getElementById('itemlist');
			listItems.innerHTML = oneItem;
			document.listform.elements[0].focus(); // Focus on that field
		}
	}
	// Function to insert The listags and selection in opener Window
	function insertListTag(tagType) {
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
        switch (tagType) {
			case "*":
				//Creating the items code to insert
				var itListBBCode = '';
				for (var i=0; i<document.listform.elements.length - 2; i++) {
					var itValue = document.listform.elements[i].value; 
					if (itValue != '') { 
						itListBBCode += '[*]' + itValue + '[/*]\n'; 
					}
				}					
				// Defining the needed values
				currentSelection = itListBBCode;
				if (itListBBCode != '') {
					startTag = '[list]\n';
					endTag = '[/list]\n';
				}
			break;
			
			case "1":
				//Creating the items code to insert
				var itListBBCode = '';
				for (var i=0; i<document.listform.elements.length - 2; i++) {
					var itValue = document.listform.elements[i].value;
					if (itValue != '') {
						itListBBCode += '[*]' + itValue + '[/*]\n';
						}
					}
				// Defining the needed values
				currentSelection = itListBBCode;
				if (itListBBCode != '') {
					startTag = '[list=1]\n';
					endTag = '[/list]\n';
				}
			break;
			
			case "a":
				//Creating the items code to insert
				var itListBBCode = '';
				for (var i=0; i<document.listform.elements.length - 2; i++) {
					var itValue = document.listform.elements[i].value;
					if (itValue != '') {
						itListBBCode += '[*]' + itValue + '[/*]\n';
						}
					}
				// Defining the needed values
				currentSelection = itListBBCode;
				if (itListBBCode != '') {
					startTag = '[list=a]\n';
					endTag = '[/list]\n';
				}
			break;	
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
			<div id="ezbbclink">
				<form name="listform">
					<div class="postmsg">
						<?php echo $ltype_start_tag ?>
						<?php echo $ltype_end_tag ?>
						<p><a href="#" onclick="addItem(); return false;"><?php echo $lang_ezbbc['Add item'] ?></a></p>
					</div>
					<p class="buttons">
					<input type="button" value="<?php echo $lang_ezbbc['OK'] ?>" onclick="insertListTag('<?php echo $list_type ?>')" /> <input type="button" value="<?php echo $lang_ezbbc['Cancel'] ?>" onclick="self.close()" />
					</p>
				</form>
			</div>
		</div>
	</div>
</div>
</body>
</html>
