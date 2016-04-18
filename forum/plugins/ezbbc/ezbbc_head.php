<?php
// Integration of EZBBC Toolbar script only in the pages containing the req_message textarea and in the profile page
$section = isset($_GET['section']) ? $_GET['section'] : null;
if ((isset($required_fields['req_message']) && basename($_SERVER['PHP_SELF']) != 'misc.php') || ($section == 'personality' && $pun_config['o_signatures'] == '1')):

// Retrieving all values from config file
require PUN_ROOT.'plugins/ezbbc/config.php';
$smilies_path = ($ezbbc_config['smilies_set'] == 'fluxbb_default_smilies') ? 'img/smilies/' : 'plugins/ezbbc/style/smilies/'; 
$plugin_folder = 'plugins/ezbbc/';

// Identifying the name of the current page textatera
$textarea_name = (PUN_ACTIVE_PAGE == 'profile') ? 'signature' : 'req_message';

//Looking for the toolbar displaying config value
if (($textarea_name == 'signature' && $ezbbc_config['signature_toolbar'] == 'signature_toolbar') || ($textarea_name == 'req_message' && (basename($_SERVER['PHP_SELF']) != 'viewtopic.php') && $ezbbc_config['post_toolbar'] == 'post_toolbar') || ($textarea_name == 'req_message' && (basename($_SERVER['PHP_SELF']) == 'viewtopic.php') && $ezbbc_config['quickpost_toolbar'] == 'quickpost_toolbar')):

// Language file load
$ezbbc_language_folder = (file_exists(PUN_ROOT.'plugins/ezbbc/lang/'.$pun_user['language'].'/ezbbc_plugin.php')) ? $pun_user['language'] : 'English';    
require PUN_ROOT.'plugins/ezbbc/lang/'.$ezbbc_language_folder.'/ezbbc_plugin.php';

// Retrieving help file
$help_folder = (file_exists(PUN_ROOT.'plugins/ezbbc/lang/'.$ezbbc_language_folder.'/help.php')) ? $ezbbc_language_folder : 'English';
$help_file_path = 'plugins/ezbbc/lang/'.$help_folder.'/help.php';

// Retrieving smilies
require PUN_ROOT.'plugins/ezbbc/ezbbc_smilies1.php';

$smiley_groups = array();

foreach ($smilies as $smiley_text => $smiley_img)
	$smiley_groups[$smiley_img][] = $smiley_text;

?>
<!-- EZBBC Toolbar integration -->
<link rel="stylesheet" type="text/css" href="plugins/ezbbc/style/<?php echo $ezbbc_config['style_folder'] ?>/ezbbc.css" />
<script type="text/javascript">
/* <![CDATA[ */
// Preloading the smilies images
var preload = ( function ( ) {
	var images = [ ];
	function preload( ) {
		var i = arguments.length,
		image;
		while ( i-- ) {
			image = new Image;
			images.src = arguments[ i ];
			images.push( image );
		}
	}
    return preload;
}( ) );
preload(
<?php

$smiley_text = '';
foreach ($smiley_groups as $smiley_img => $smiley_texts)
	$smiley_text .= '"'.$smilies_path.$smiley_img.'",'."\n";
echo substr($smiley_text, 0, strlen($smiley_text)-2);

?>
);
// Function to insert the tags in the textarea       
function insertTag(startTag, endTag, tagType) {
        var field  = document.getElementsByName('<?php echo $textarea_name ?>')[0]; 
        var scroll = field.scrollTop;
        field.focus();
        
        
        /* === Part 1: get the selection === */
        if (window.ActiveXObject) { //For IE
                var textRange = document.selection.createRange();
                var currentSelection = textRange.text;
        } else { //For other browsers
                var startSelection   = field.value.substring(0, field.selectionStart);
                var currentSelection = field.value.substring(field.selectionStart, field.selectionEnd);
                var endSelection     = field.value.substring(field.selectionEnd);
        }
        
        /* === Part 2: what Tag type ? === */
        if (tagType) {
                switch (tagType) {
			case "smiley":
       		            if (window.ActiveXObject) { //For IE
       		                //Calculating the start point of the selection
	                        var storedRange = textRange.duplicate();
	                        storedRange.moveToElementText(field);
	                        storedRange.setEndPoint('EndToEnd', textRange);
	                        field.selectionStart = storedRange.text.length - currentSelection.length;
                            if (field.selectionStart == 0) { //We are at the beginning of the textarea
       		                    startTag = ' ' + startTag + ' ';
       		                    currentSelection = '';
							} else { //We are not at the beginning of the textarea, extending the text selection to handle the previous and next character
       		                    textRange.moveStart('character', -1);
       		                    textRange.moveEnd('character');
       		                    textRange.select();
       		                    currentSelection = textRange.text;
       		                    if (currentSelection.length == 1) { //Case caret at the end of a line
       		                        startTag = currentSelection + ' ' + startTag + '\n';
       		                        currentSelection = '';
       		                    }
       		                }
       		                       
       		            } else { //For other browsers
       		                if (startSelection.length == 0) { //Looking if we are at the beginning of the textarea
       		                    startTag = ' ' + startTag + ' ';
       		                    currentSelection = '';
       		                } else { //Textarea not empty, extending the text selection to handle the previous and next character
       		                    field.setSelectionRange(startSelection.length -1, startSelection.length + currentSelection.length +1);
       		                    startSelection = field.value.substring(0, field.selectionStart);
       		                    currentSelection = field.value.substring(field.selectionStart, field.selectionEnd);
       		                    endSelection = field.value.substring(field.selectionEnd);
       		                    if (currentSelection.length == 1) { //Case at the end of a line
       		                        startTag = currentSelection + ' ' + startTag + ' ';
       		                        currentSelection = '';
       		                    }
       		                }
       		            }
       		                       
       		            //Common situations for all browsers
       		            if (currentSelection.length >= 2) {
							//To ease checking, variable definition
       		                var charBefore = currentSelection.substr(0,1);
       		                var charAfter = currentSelection.substr(currentSelection.length-1,1);
       		                //Parsing and treating the new selection
       		                if (charBefore != ' ' && charAfter != ' ') {
       		                    //Adding a space before and after the smiley
       		                    startTag = charBefore + ' ' + startTag + ' ';
       		                    endTag = charAfter;
       		                } else if (charBefore != ' ') {
       		                    //Adding a space before the smiley
       		                    startTag = charBefore + ' ' + startTag + ' ';
       		                } else if (charAfter != ' ') {
       		                    //Adding a space after the smiley
       		                    currentSelection = startTag;
       		                    startTag = ' ' + startTag + ' ';
       		                    endTag = charAfter;
       		                } else {
       		                    startTag = ' ' + starTag + ' ';
       		                }
       		                currentSelection = '';
       		            } 
			break;
		}
        }
        
        /* === Part 3: adding what was produced === */
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
		
}
//Function to make an element with a certain id visible or not
function ezbbcVisibility(id) {
    var element = document.getElementById(id);
	if (element.style.display == "none") {
		element.style.display = "block";
	} else {
		element.style.display = "none";
	}
}

//Function to create the smilies bar
function doSmiliesbar() {
    var smiliesbar = '';
// Smiliesbar for common textareas
<?php if ($textarea_name == 'req_message'): ?>
     <?php if ($pun_config['o_smilies'] == '1'): ?>
	<?php

		foreach ($smiley_groups as $smiley_img => $smiley_texts)
			echo "smiliesbar += '<img class=\"smiley\" src=\"".$smilies_path.$smiley_img."\" title=\"".$smiley_texts[0]."\" alt=\"".$smiley_texts[0]."\" onclick=\"insertTag(\'".$smiley_texts[0]."\',\'\',\'smiley\'); return false;\" />';"."\n";

	?>
  <?php endif; ?>
<?php endif; ?>

// Smiliesbar for signature textarea
<?php if ($textarea_name == 'signature'): ?>
    <?php if ($pun_config['o_smilies_sig'] == '1'): ?>
	<?php

		foreach ($smiley_groups as $smiley_img => $smiley_texts)
			echo "smiliesbar += '<img class=\"smiley\" src=\"".$smilies_path.$smiley_img."\" title=\"".$smiley_texts[0]."\" alt=\"".$smiley_texts[0]."\" onclick=\"insertTag(\'".$smiley_texts[0]."\',\'\',\'smiley\'); return false;\" />';"."\n";

	?>
  <?php endif; ?>
<?php endif; ?>

return smiliesbar;
}


//Function to create the Toolbar
function doToolbar() {
        var toolbar = '';
// Toolbar for common textareas
<?php if ($textarea_name == 'req_message'): ?>
 <?php if ($pun_config['p_message_bbcode'] == '1'): ?>
  // if BBcode enabled
	// Text style
	<?php if ($ezbbc_config['b'] == 'b'): ?>
	toolbar += '<a href="#" id="bold" title="<?php echo $lang_ezbbc['Bold title'] ?>" onclick="insertTag(\'[b]\',\'[/b]\',\'\'); return false;"><span><?php echo $lang_ezbbc['Bold'] ?><\/span><\/a>';
	<?php endif; ?>
	<?php if ($ezbbc_config['u'] == 'u'): ?>
	toolbar += '<a href="#" id="underline" title="<?php echo $lang_ezbbc['Underline title'] ?>" onclick="insertTag(\'[u]\',\'[/u]\',\'\'); return false;"><span><?php echo $lang_ezbbc['Underline'] ?><\/span><\/a>';
	<?php endif; ?>
	<?php if ($ezbbc_config['i'] == 'i'): ?>
	toolbar += '<a href="#" id="italic" title="<?php echo $lang_ezbbc['Italic title'] ?>" onclick="insertTag(\'[i]\',\'[/i]\',\'\'); return false;"><span><?php echo $lang_ezbbc['Italic'] ?><\/span><\/a>';
	<?php endif; ?>
	<?php if ($ezbbc_config['s'] == 's'): ?>
	toolbar += '<a href="#" id="strike" title="<?php echo $lang_ezbbc['Strike-through title'] ?>" onclick="insertTag(\'[s]\',\'[/s]\',\'\'); return false;"><span><?php echo $lang_ezbbc['Strike-through'] ?><\/span><\/a>';
	<?php endif; ?>
	<?php if ($ezbbc_config['del'] == 'del'): ?>
	toolbar += '<a href="#" id="delete" title="<?php echo $lang_ezbbc['Delete title'] ?>" onclick="insertTag(\'[del]\',\'[/del]\',\'\'); return false;"><span><?php echo $lang_ezbbc['Delete'] ?><\/span><\/a>';
	<?php endif; ?>
	<?php if ($ezbbc_config['ins'] == 'ins'): ?>
	toolbar += '<a href="#" id="insert" title="<?php echo $lang_ezbbc['Insert title'] ?>" onclick="insertTag(\'[ins]\',\'[/ins]\',\'\'); return false;"><span><?php echo $lang_ezbbc['Insert'] ?><\/span><\/a>';
	<?php endif; ?>
	<?php if ($ezbbc_config['em'] == 'em'): ?>
	toolbar += '<a href="#" id="emphasis"  title="<?php echo $lang_ezbbc['Emphasis title'] ?>" onclick="insertTag(\'[em]\',\'[/em]\',\'\'); return false;"><span><?php echo $lang_ezbbc['Emphasis'] ?><\/span><\/a>';
	<?php endif; ?>
	
	// Color and heading
	<?php if ($ezbbc_config['color'] == 'color'): ?>
	toolbar += '<a href="#" id="color"  title="<?php echo $lang_ezbbc['Colorize title'] ?>" onclick="window.open(\'<?php echo $plugin_folder ?>colorpicker.php?textarea_name=<?php echo $textarea_name ?>\', \'Colorpicker\', \'height=400, width=400, top=100, left=100, toolbar=no, menubar=no, location=no, resizable=yes, scrollbars=no, status=no\'); return false;"><span><?php echo $lang_ezbbc['Colorize'] ?><\/span><\/a>';
	<?php endif; ?>
	<?php if ($ezbbc_config['heading'] == 'heading'): ?>
	toolbar += '<a href="#" id="heading" title="<?php echo $lang_ezbbc['Heading title'] ?>" onclick="window.open(\'<?php echo $plugin_folder ?>heading.php?textarea_name=<?php echo $textarea_name ?>\', \'Header\', \'height=280, width=500, top=100, left=100, toolbar=no, menubar=no, location=no, resizable=yes, scrollbars=no, status=no\'); return false;"><span><?php echo $lang_ezbbc['Heading'] ?><\/span><\/a>';
	<?php endif; ?>

	// Links and images
	<?php if ($ezbbc_config['url'] == 'url'): ?>
	toolbar += '<a href="#" id="url" title="<?php echo $lang_ezbbc['URL title'] ?>" onclick="window.open(\'<?php echo $plugin_folder ?>link.php?textarea_name=<?php echo $textarea_name ?>\', \'Link\', \'height=<?php echo ($ezbbc_config['doc_upload'] == 'no_doc_upload' || $pun_user['is_guest']) ? '335' : (($ezbbc_config['doc_list'] == 'doc_list') ? '600' : '440') ?>, width=600, top=100, left=100, toolbar=no, menubar=no, location=no, resizable=yes, scrollbars=no, status=no\'); return false;"><span><?php echo $lang_ezbbc['URL'] ?><\/span><\/a>';
	<?php endif; ?>
	<?php if ($ezbbc_config['email'] == 'email'): ?>
	toolbar += '<a href="#" id="email" title="<?php echo $lang_ezbbc['E-mail title'] ?>" onclick="window.open(\'<?php echo $plugin_folder ?>email.php?textarea_name=<?php echo $textarea_name ?>\', \'Email\', \'height=300, width=600, top=100, left=100, toolbar=no, menubar=no, location=no, resizable=yes, scrollbars=no, status=no\'); return false;"><span><?php echo $lang_ezbbc['E-mail'] ?><\/span><\/a>';
	<?php endif; ?>
    
	<?php if ($pun_config['p_message_img_tag'] == '1' && $ezbbc_config['img'] == 'img'): ?>
	// if image tag enabled
	toolbar += '<a href="#" id="image" title="<?php echo $lang_ezbbc['Image title'] ?>" onclick="window.open(\'<?php echo $plugin_folder ?>image.php?textarea_name=<?php echo $textarea_name ?>\', \'Image\', \'height=<?php echo ($ezbbc_config['img_upload'] == 'no_img_upload' || $pun_user['is_guest']) ? '300' : (($ezbbc_config['img_list'] == 'img_list') ? '560' : '410') ?>, width=600, top=100, left=100, toolbar=no, menubar=no, location=no, resizable=yes, scrollbars=no, status=no\'); return false;"><span><?php echo $lang_ezbbc['Image'] ?><\/span><\/a>';
	<?php endif; ?>

	// Quote and code
	<?php if ($ezbbc_config['quote'] == 'quote'): ?>
	toolbar += '<a href="#" id="quote" title="<?php echo $lang_ezbbc['Quote title'] ?>" onclick="window.open(\'<?php echo $plugin_folder ?>quote.php?textarea_name=<?php echo $textarea_name ?>\', \'Quote\', \'height=450, width=750, top=100, left=100, toolbar=no, menubar=no, location=no, resizable=yes, scrollbars=no, status=no\'); return false;"><span><?php echo $lang_ezbbc['Quote'] ?><\/span><\/a>';
	<?php endif; ?>
	<?php if ($ezbbc_config['code'] == 'code'): ?>
	toolbar += '<a href="#" id="code" title="<?php echo $lang_ezbbc['Code title'] ?>" onclick="window.open(\'<?php echo $plugin_folder ?>code.php?textarea_name=<?php echo $textarea_name ?>\', \'Code\', \'height=450, width=750, top=100, left=100, toolbar=no, menubar=no, location=no, resizable=yes, scrollbars=no, status=no\'); return false;"><span><?php echo $lang_ezbbc['Code'] ?><\/span><\/a>';
	<?php endif; ?>

	// Lists
	<?php if ($ezbbc_config['ulist'] == 'ulist'): ?>
    toolbar += '<a href="#" id="ulist" title="<?php echo $lang_ezbbc['Unordered List title'] ?>" onclick="window.open(\'<?php echo $plugin_folder ?>list.php?textarea_name=<?php         echo $textarea_name ?>&amp;list_type=*\', \'List\', \'height=350, width=600, top=100, left=100, toolbar=no, menubar=no, location=no, resizable=yes, scrollbars=yes, status=no\'); return false;"><span><?php echo $lang_ezbbc['Unordered List'] ?><\/span><\/a>';
	<?php endif; ?>
	<?php if ($ezbbc_config['olist'] == 'olist'): ?>
	toolbar += '<a href="#" id="olist" title="<?php echo $lang_ezbbc['Ordered List title'] ?>" onclick="window.open(\'<?php echo $plugin_folder ?>list.php?textarea_name=<?php echo $textarea_name ?>&amp;list_type=1\', \'List\', \'height=350, width=620, top=100, left=100, toolbar=no, menubar=no, location=no, resizable=yes, scrollbars=yes, status=no\'); return false;"><span><?php echo $lang_ezbbc['Ordered List'] ?><\/span><\/a>';
	<?php endif; ?>
	<?php if ($ezbbc_config['alist'] == 'alist'): ?>
	toolbar += '<a href="#" id="aolist" title="<?php echo $lang_ezbbc['Alphabetical Ordered List title'] ?>" onclick="window.open(\'<?php echo $plugin_folder ?>list.php?textarea_name=<?php echo $textarea_name ?>&amp;list_type=a\', \'List\', \'height=350, width=620, top=100, left=100, toolbar=no, menubar=no, location=no, resizable=yes, scrollbars=yes, status=no\'); return false;"><span><?php echo $lang_ezbbc['Alphabetical Ordered List'] ?><\/span><\/a>';
	<?php endif; ?>
	
	<?php if ($ezbbc_config['video'] == 'video'): ?>
	// Video
    toolbar += '<a href="#" id="video" title="<?php echo $lang_ezbbc['Video title'] ?>" onclick="window.open(\'<?php echo $plugin_folder ?>video.php?textarea_name=<?php echo $textarea_name ?>\', \'Video\', \'height=350, width=600, top=100, left=100, toolbar=no, menubar=no, location=no, resizable=yes, scrollbars=no, status=no\'); return false;"><span><?php echo $lang_ezbbc['Video'] ?><\/span><\/a>';
	<?php endif; ?>
	
  <?php endif; ?>
  // End if BBCode enabled
  
        <?php if ($pun_config['o_smilies'] == '1' && $ezbbc_config['smiliesb'] == 'smiliesb'): ?>
        // Smilies toggle button
	toolbar += '<a href="#" id="smiliesb" title="<?php echo $lang_ezbbc['Smilies toggle title'] ?>" onclick="ezbbcVisibility(\'ezbbcsmiliesbar\'); return false;"><span><?php echo $lang_ezbbc['Smilies toggle'] ?><\/span><\/a>';
	<?php endif; ?>
	<?php if (($pun_config['o_smilies'] == '1' || $pun_config['p_message_bbcode'] == '1') && ($ezbbc_config['help'] == 'help')): ?>
	// Help link
	toolbar += '<a href="#" id="help" title="<?php echo $lang_ezbbc['Toolbar help title'] ?>" onclick="window.open(\'<?php echo $help_file_path ?>\', \'Toolbar_help\', \'height=400, width=750, top=50, left=50, toolbar=no, menubar=yes, location=no, resizable=yes, scrollbars=yes, status=no\'); return false;"><span><?php echo $lang_ezbbc['Toolbar help'] ?><\/span><\/a>';
	<?php endif; ?>
  
// End Toolbar for common teaxtareas
<?php endif; ?>

<?php if ($textarea_name == 'signature'): ?>
// Toolbar for signature textarea
  <?php if ($pun_config['p_sig_bbcode'] == '1'): ?>
  // if BBcode enabled
	// Text style
	<?php if ($ezbbc_config['b'] == 'b'): ?>
	toolbar += '<a href="#" id="bold" title="<?php echo $lang_ezbbc['Bold title'] ?>" onclick="insertTag(\'[b]\',\'[/b]\',\'\'); return false;"><span><?php echo $lang_ezbbc['Bold'] ?><\/span><\/a>';
	<?php endif; ?>
	<?php if ($ezbbc_config['u'] == 'u'): ?>
	toolbar += '<a href="#" id="underline" title="<?php echo $lang_ezbbc['Underline title'] ?>" onclick="insertTag(\'[u]\',\'[/u]\',\'\'); return false;"><span><?php echo $lang_ezbbc['Underline'] ?><\/span><\/a>';
	<?php endif; ?>
	<?php if ($ezbbc_config['i'] == 'i'): ?>
	toolbar += '<a href="#" id="italic" title="<?php echo $lang_ezbbc['Italic title'] ?>" onclick="insertTag(\'[i]\',\'[/i]\',\'\'); return false;"><span><?php echo $lang_ezbbc['Italic'] ?><\/span><\/a>';
	<?php endif; ?>
	<?php if ($ezbbc_config['s'] == 's'): ?>
	toolbar += '<a href="#" id="strike" title="<?php echo $lang_ezbbc['Strike-through title'] ?>" onclick="insertTag(\'[s]\',\'[/s]\',\'\'); return false;"><span><?php echo $lang_ezbbc['Strike-through'] ?><\/span><\/a>';
	<?php endif; ?>
	<?php if ($ezbbc_config['del'] == 'del'): ?>
	toolbar += '<a href="#" id="delete" title="<?php echo $lang_ezbbc['Delete title'] ?>" onclick="insertTag(\'[del]\',\'[/del]\',\'\'); return false;"><span><?php echo $lang_ezbbc['Delete'] ?><\/span><\/a>';
	<?php endif; ?>
	<?php if ($ezbbc_config['ins'] == 'ins'): ?>
	toolbar += '<a href="#" id="insert" title="<?php echo $lang_ezbbc['Insert title'] ?>" onclick="insertTag(\'[ins]\',\'[/ins]\',\'\'); return false;"><span><?php echo $lang_ezbbc['Insert'] ?><\/span><\/a>';
	<?php endif; ?>
	<?php if ($ezbbc_config['em'] == 'em'): ?>
	toolbar += '<a href="#" id="emphasis"  title="<?php echo $lang_ezbbc['Emphasis title'] ?>" onclick="insertTag(\'[em]\',\'[/em]\',\'\'); return false;"><span><?php echo $lang_ezbbc['Emphasis'] ?><\/span><\/a>';
	<?php endif; ?>

	// Color
	<?php if ($ezbbc_config['color'] == 'color'): ?>
	toolbar += '<a href="#" id="color"  title="<?php echo $lang_ezbbc['Colorize title'] ?>" onclick="window.open(\'<?php echo $plugin_folder ?>colorpicker.php?textarea_name=<?php echo $textarea_name ?>\', \'Colorpicker\', \'height=400, width=400, top=100, left=100, toolbar=no, menubar=no, location=no, resizable=yes, scrollbars=no, status=no\'); return false;"><span><?php echo $lang_ezbbc['Colorize'] ?><\/span><\/a>';
	<?php endif; ?>

	// Links and images
    <?php if ($ezbbc_config['url'] == 'url'): ?>
	toolbar += '<a href="#" id="url" title="<?php echo $lang_ezbbc['URL title'] ?>" onclick="window.open(\'<?php echo $plugin_folder ?>link.php?textarea_name=<?php echo $textarea_name ?>\', \'Link\', \'height=<?php echo ($ezbbc_config['doc_upload'] == 'no_doc_upload' || $pun_user['is_guest']) ? '335' : (($ezbbc_config['doc_list'] == 'doc_list') ? '600' : '440') ?>, width=600, top=100, left=100, toolbar=no, menubar=no, location=no, resizable=yes, scrollbars=no, status=no\'); return false;"><span><?php echo $lang_ezbbc['URL'] ?><\/span><\/a>';
	<?php endif; ?>
	<?php if ($ezbbc_config['email'] == 'email'): ?>
    toolbar += '<a href="#" id="email" title="<?php echo $lang_ezbbc['E-mail title'] ?>" onclick="window.open(\'<?php echo $plugin_folder ?>email.php?textarea_name=<?php echo $textarea_name ?>\', \'Email\', \'height=300, width=600, top=100, left=100, toolbar=no, menubar=no, location=no, resizable=yes, scrollbars=no, status=no\'); return false;"><span><?php echo $lang_ezbbc['E-mail'] ?><\/span><\/a>';
    <?php endif; ?>
	// if image tag enabled
	<?php if ($pun_config['p_sig_img_tag'] == '1' && $ezbbc_config['img'] == 'img'): ?>
	toolbar += '<a href="#" id="image" title="<?php echo $lang_ezbbc['Image title'] ?>" onclick="window.open(\'<?php echo $plugin_folder ?>image.php?textarea_name=<?php echo     $textarea_name ?>\', \'Image\', \'height=<?php echo ($ezbbc_config['img_upload'] == 'no_img_upload' || $pun_user['is_guest']) ? '300' : (($ezbbc_config['img_list'] == 'img_list') ? '560' : '410') ?>, width=600, top=100, left=100, toolbar=no, menubar=no, location=no, resizable=yes, scrollbars=no, status=no\'); return false;"><span><?php echo $lang_ezbbc['Image'] ?><\/span><\/a>';
	<?php endif; ?>
	
  // End if BBCode enabled
  <?php endif; ?>
  
        <?php if ($pun_config['o_smilies_sig'] == '1' && $ezbbc_config['smiliesb'] == 'smiliesb'): ?>
        // smilies toggle button
	toolbar += '<a href="#" id="smiliesb" title="<?php echo $lang_ezbbc['Smilies toggle title'] ?>" onclick="ezbbcVisibility(\'ezbbcsmiliesbar\'); return false;"><span><?php echo $lang_ezbbc['Smilies toggle'] ?><\/span><\/a>';
	<?php endif; ?>
  
	<?php if (($pun_config['o_smilies_sig'] == '1' || $pun_config['p_sig_bbcode'] == '1') && ($ezbbc_config['help'] == 'help')): ?>
	// Help link
    toolbar += '<a href="#" id="help" title="<?php echo $lang_ezbbc['Toolbar help title'] ?>" onclick="window.open(\'<?php echo $help_file_path ?>\', \'Toolbar_help\', \'height=400, width=750, top=50, left=50, toolbar=no, menubar=yes, location=no, resizable=yes, scrollbars=yes, status=no\'); return false;"><span><?php echo $lang_ezbbc['Toolbar help'] ?><\/span><\/a>';
	<?php endif; ?>
        
// End for Signature textarea
<?php endif; ?>

// Returning the right Toolbar
	return toolbar;
}

//Adding the Toolbar and the smiliesBar on the right place
function addBars(){
    var textarea = document.getElementsByName('<?php echo $textarea_name ?>')[0];
    // Toolbar creation
    var tbspan = document.createElement('span');
    tbspan.setAttribute("idName","ezbbctoolbar"); /* For IE */
    tbspan.setAttribute("id","ezbbctoolbar");
	tbspan.innerHTML = doToolbar();
	// Smiliesbar creation
	var sbspan = document.createElement('span');
	sbspan.setAttribute("idName","ezbbcsmiliesbar"); /* For IE */
    sbspan.setAttribute("id","ezbbcsmiliesbar");
	sbspan.innerHTML = doSmiliesbar();
	// Positionning the Bars
	<?php if ($ezbbc_config['smiliesbar_position'] == 'sb_over_tb'): ?>
	/* Smiliesbar insertion */
	var sbhtml = textarea.parentNode;
	sbhtml.insertBefore(sbspan, textarea);
	/* Toolbar insertion */
	var tbhtml = textarea.parentNode;
	tbhtml.insertBefore(tbspan,textarea);
	<?php endif; ?>
	<?php if ($ezbbc_config['smiliesbar_position'] == 'sb_under_tb'): ?>
	/* Toolbar insertion */
	var tbhtml = textarea.parentNode;
	tbhtml.insertBefore(tbspan,textarea);
	/* Smiliesbar insertion */
	var sbhtml = textarea.parentNode;
	sbhtml.insertBefore(sbspan, textarea);
	<?php endif; ?>
	<?php if ($ezbbc_config['smiliesbar_position'] == 'sb_under_texta'): ?>
	/* Toolbar insertion */
	var tbhtml = textarea.parentNode;
	tbhtml.insertBefore(tbspan,textarea);
	/* Smiliesbar insertion */
	var sbhtml = textarea.parentNode;
	sbhtml.appendChild(sbspan);
	<?php endif; ?>
	// Bars on the left or on the right (the spans have "display: block;" propertie)
	<?php if ($ezbbc_config['bars_position'] == 'bars_left'): ?>
	sbspan.style.textAlign = 'left';
	tbspan.style.textAlign = 'left';
	<?php endif; ?>
	<?php if ($ezbbc_config['bars_position'] == 'bars_right'): ?>
	sbspan.style.textAlign = 'right';
	tbspan.style.textAlign = 'right';
	<?php endif; ?>
}
window.addEventListener ? window.addEventListener('load',addBars,false) : window.attachEvent('onload',addBars);

/* ]]> */
</script>
<!-- EZBBC Toolbar integration end -->
<?php endif; ?>
<?php endif; ?>
<?php if (basename($_SERVER['PHP_SELF']) == 'viewtopic.php' && $ezbbc_config['syntax_highlight'] == 'syntax_highlight'): ?>
<!-- PRISMJS syntaxic coloration -->
<style type="text/css">
<?php echo file_get_contents(PUN_ROOT.'plugins/ezbbc/prism/prism.css'); ?>
</style>
<link rel="stylesheet" type="text/css" href="prism.css" />
<script type="text/javascript" defer="defer">
/* <![CDATA[ */
<?php echo file_get_contents(PUN_ROOT.'plugins/ezbbc/prism/prism.js'); ?>
/* ]]> */
</script>
<!-- PRISMJS syntaxic coloration end-->
<?php endif; ?>