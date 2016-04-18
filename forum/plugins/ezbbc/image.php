<?php
define('PUN_ROOT', '../../');
require PUN_ROOT . 'include/common.php';
// Retrieving style folder
require PUN_ROOT . 'plugins/ezbbc/config.php';
$allowed_ext     = array(
    'jpg',
    'gif',
    'png',
    'jpeg'
);
$location        = PUN_ROOT . $ezbbc_config['img_folder'];
$cache           = PUN_ROOT . 'cache/ezbbc/';
$path            = $pun_config['o_base_url'] . '/' . $ezbbc_config['img_folder'];
$file_path       = '';
$upload_ok       = false;
$message         = '';
$action_message  = '';
$img_list        = array();
$loc_user_folder = $location . '/' . $pun_user['id'];

// Getting the textarea name from get string
$textarea_name = isset($_GET['textarea_name']) && $_GET['textarea_name'] == 'req_message' ? 'req_message' : 'signature';
// Language file load
require PUN_ROOT . 'lang/' . $pun_user['language'] . '/common.php';
$ezbbc_language_folder = (file_exists(PUN_ROOT . 'plugins/ezbbc/lang/' . $pun_user['language'] . '/ezbbc_plugin.php')) ? $pun_user['language'] : 'English';
require PUN_ROOT . 'plugins/ezbbc/lang/' . $ezbbc_language_folder . '/ezbbc_plugin.php';

if ($ezbbc_config['img_upload'] == 'img_upload' && !$pun_user['is_guest'])
  {
    
    // If action required 
    if (isset($_GET['action']))
    	{
        $action   = $_GET['action'];
        $filename = pun_htmlspecialchars($_GET['fname']);
        if (preg_match('@^([0-9]+)_([a-z0-9_\.\-]*)\.(gif|png|jpg|jpeg)$@', $filename, $matches))
        {
            $timestamp  = $matches[1];
            $name       = $matches[2];
            $ext        = $matches[3];
            $name       = $name . '.' . $ext;
            $rootfolder = $ezbbc_config['img_folder'];
            $ftype      = 'img';
            $id         = $pun_user['id'];
            $file_path  = PUN_ROOT . $rootfolder . '/' . $id . '/' . $filename;
            $data_file  = PUN_ROOT . 'cache/ezbbc/' . $timestamp . '_' . $ftype . '_' . $id . '_' . $name . '.txt';
            if ($action == 'remove')
              {
                if (@unlink($file_path) && @unlink($data_file))
                  {
                    $action_message = '<p id="amessage" style="color: green; text-align: center;">/' . $rootfolder . '/' . $id . '/' . $filename . ' ' . $lang_ezbbc['File remove ok'] . '</p>';
                  }
                else
                  {
                    $action_message = '<p id="amessage" style="color: red; text-align: center;">/' . $rootfolder . '/' . $id . '/' . $filename . ' ' . $lang_ezbbc['File remove fail'] . '</p>';
                  }
              }
        }
    }
    // End action required
    
    //Function to get the max_file_size in the php.ini file
    function return_bytes($FormattedSize)
      {
        $FormattedSize = trim($FormattedSize);
        $Size          = floatval($FormattedSize);
        $MultipSize    = strtoupper(substr($FormattedSize, -1));
        
        if ($MultipSize == "G")
            $Size *= pow(1024, 3);
        else if ($MultipSize == "M")
            $Size *= pow(1024, 2);
        else if ($MultipSize == "K")
            $Size *= 1024;
        
        return $Size;
      }
    $max_file_size_php = return_bytes(ini_get('upload_max_filesize'));
    
    // Counting the already uploaded images
    if (file_exists($loc_user_folder))
      {
        //Retrieving the submitted images
        $img_file_loc = opendir($loc_user_folder);
        while (false !== ($img_file = readdir($img_file_loc)))
          {
            $file_ext = pathinfo($img_file, PATHINFO_EXTENSION);
            if (!in_array($file_ext, $allowed_ext))
              {
                continue;
              }
            $img_list[] = $img_file;
          }
        rsort($img_list);
        $img_count = count($img_list);
      }
    else
      {
        $img_count = 0;
      }
    
    // Setting limit and max values for each user rank
    if (!$pun_user['is_admmod'])
        $img_limit = $ezbbc_config['img_limit']; //users
    if ($pun_user['g_id'] == PUN_ADMIN)
        $img_limit = 0; //admin
    if ($pun_user['g_id'] != PUN_ADMIN && $pun_user['g_moderator'] == '1')
        $img_limit = $ezbbc_config['img_limit_mod']; // mods
    if ($pun_user['is_admmod'])
        $ezbbc_config['max_img_size'] = $max_file_size_php / 1024; //admins and mods
    
    // File submission
    if (isset($_POST['subfile']) && ($img_count < $img_limit || $img_limit == 0))
      {
        $file_name     = $_FILES['file']['name'];
        $uploaded_file = $_FILES['file']['tmp_name'];
        //User folder treatment
        $location      = $loc_user_folder;
        if (file_exists($loc_user_folder))
          {
            @chmod($loc_user_folder, 0755);
          }
        else
          {
            @mkdir($loc_user_folder, 0755);
          }
        // Adding html file to user folder if it doesn't exist
        if (!file_exists($loc_user_folder . '/index.html'))
          {
            $fp = fopen($loc_user_folder . '/index.html', 'wb');
            fwrite($fp, '<html><head><title>.</title></head><body>.</body></html>');
            fclose($fp);
          }
        if (is_writable($location) && is_writable($cache))
          {
            //treating the file name
            $file_name     = htmlentities($file_name, ENT_QUOTES, 'utf-8');
            $search        = array(
                '&Agrave;',
                '&agrave;',
                '&Aacute;',
                '&aacute;',
                '&Acirc;',
                '&acirc;',
                '&Atilde;',
                '&atilde;',
                '&Auml;',
                '&auml;',
                '&Aring;',
                '&aring;',
                '&AElig;',
                '&aelig;',
                '&Ccedil;',
                '&ccedil;',
                '&ETH;',
                '&eth;',
                '&Egrave;',
                '&egrave;',
                '&Eacute;',
                '&eacute;',
                '&Ecirc;',
                '&ecirc;',
                '&Euml;',
                '&euml;',
                '&Igrave;',
                '&igrave;',
                '&Iacute;',
                '&iacute;',
                '&Icirc;',
                '&icirc;',
                '&Iuml;',
                '&iuml;',
                '&Ntilde;',
                '&ntilde;',
                '&Ograve;',
                '&ograve;',
                '&Oacute;',
                '&oacute;',
                '&Ocirc;',
                '&ocirc;',
                '&Otilde;',
                '&otilde;',
                '&Ouml;',
                '&ouml;',
                '&Oslash;',
                '&oslash;',
                '&OElig;',
                '&oelig;',
                '&szlig;',
                '&THORN;',
                '&thorn;',
                '&Ugrave;',
                '&ugrave;',
                '&Uacute;',
                '&uacute;',
                '&Ucirc;',
                '&ucirc;',
                '&Uuml;',
                '&uuml;',
                '&Yacute;',
                '&yacute;',
                '&Yuml;',
                '&yuml;',
                ' ',
                '&lt;',
                '&gt;',
                '&quot;',
                '&#039;',
                '\'',
                '/',
                '\\',
                '?',
                '*',
                ':',
                '!',
                '|'
            );
            $replace       = array(
                'a',
                'a',
                'a',
                'a',
                'a',
                'a',
                'a',
                'a',
                'a',
                'a',
                'a',
                'a',
                'ae',
                'ae',
                'c',
                'c',
                'd',
                'e',
                'e',
                'e',
                'e',
                'e',
                'e',
                'e',
                'e',
                'e',
                'i',
                'i',
                'i',
                'i',
                'i',
                'i',
                'i',
                'i',
                'n',
                'n',
                'o',
                'o',
                'o',
                'o',
                'o',
                'o',
                'o',
                'o',
                'o',
                'o',
                'o',
                'o',
                'oe',
                'oe',
                'ss',
                'p',
                'p',
                'u',
                'u',
                'u',
                'u',
                'u',
                'u',
                'u',
                'u',
                'y',
                'y',
                'y',
                'y',
                '_',
                '_',
                '_',
                '_',
                '_',
                '_',
                '_',
                '_',
                '_',
                '_',
                '_',
                '_',
                '_'
            );
            $file_name     = str_replace($search, $replace, $file_name);
            $file_name     = strtolower(str_replace(' ', '_', $file_name));
            $file_name     = preg_replace('/[^\w\.-]+/', '', $file_name);
            $timestamp     = time();
            $def_file_name = $timestamp . '_' . $file_name;
            $file_location = $location . '/' . $def_file_name;
            $file_path     = $pun_config['o_base_url'] . '/' . $ezbbc_config['img_folder'] . '/' . $pun_user['id'] . '/' . $def_file_name;
            $file_ext      = pathinfo($file_name, PATHINFO_EXTENSION);
            list($width, $height) = @getimagesize($uploaded_file);
            // Handling the errors and finally send the file to the folder
            if ($_FILES['file']['error'] == UPLOAD_ERR_NO_FILE)
              {
                $message = '<span style="color: orange"> » ' . $lang_ezbbc['No file submitted'] . '</span>';
              }
            else if (!in_array($file_ext, $allowed_ext))
              {
                $message = '<span style="color: orange"> » <strong>' . $file_ext . '</strong> ' . $lang_ezbbc['File not allowed'] . '</span>';
              }
            else if ($_FILES['file']['error'] == UPLOAD_ERR_FORM_SIZE || $_FILES['file']['error'] == UPLOAD_ERR_INI_SIZE || filesize($uploaded_file) > $ezbbc_config['max_img_size'] * 1024)
              {
                $message = '<span style="color: orange"> » ' . $lang_ezbbc['File too big'] . '</span>';
              }
            else if ($width > $ezbbc_config['max_img_width'] && function_exists('gd_info'))
              {
                $gd = gd_info();
                if ($gd["PNG Support"] && $gd["GIF Read Support"] && ($gd["JPEG Support"] || $gd["JPG Support"]) && is_uploaded_file($uploaded_file))
                {
                //Moving the temp file to user folder (to have resizing job work in all server cases)
                    $temp_file = $file_location . '.tmp';
                    if (@move_uploaded_file($uploaded_file, $temp_file))
                      {
                        //Width too big, we have to resize the file
                        $new_width  = $ezbbc_config['max_img_width'];
                        $new_height = $ezbbc_config['max_img_width'] / $width * $height;
                        switch ($file_ext)
                        {
                            case 'gif':
                                $img_to_modify = imagecreatefromgif($temp_file);
                                $new_name      = str_replace('.gif', '.jpg', $def_file_name);
                                $file_name     = str_replace('.gif', '.jpg', $file_name);
                                $file_path     = $pun_config['o_base_url'] . '/' . $ezbbc_config['img_folder'] . '/' . $pun_user['id'] . '/' . $new_name;
                                break;
                            case 'png':
                                $img_to_modify = imagecreatefrompng($temp_file);
                                $new_name      = str_replace('.png', '.jpg', $def_file_name);
                                $file_name     = str_replace('.png', '.jpg', $file_name);
                                $file_path     = $pun_config['o_base_url'] . '/' . $ezbbc_config['img_folder'] . '/' . $pun_user['id'] . '/' . $new_name;
                                break;
                            case 'jpg':
                                $img_to_modify = imagecreatefromjpeg($temp_file);
                                $new_name      = str_replace('.jpg', '.jpg', $def_file_name);
                                $file_name     = str_replace('.jpg', '.jpg', $file_name);
                                $file_path     = $pun_config['o_base_url'] . '/' . $ezbbc_config['img_folder'] . '/' . $pun_user['id'] . '/' . $new_name;
                                break;
                            case 'jpeg':
                                $img_to_modify = imagecreatefromjpeg($temp_file);
                                $new_name      = str_replace('.jpeg', '.jpg', $def_file_name);
                                $file_name     = str_replace('.jpeg', '.jpg', $file_name);
                                $file_path     = $pun_config['o_base_url'] . '/' . $ezbbc_config['img_folder'] . '/' . $pun_user['id'] . '/' . $new_name;
                                break;
                        }
                        $resized_img = imagecreatetruecolor($new_width, $new_height);
                        imagecopyresampled($resized_img, $img_to_modify, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                        $upload_ok = imagejpeg($resized_img, $loc_user_folder . '/' . $new_name, 85);
                        @chmod($loc_user_folder . '/' . $new_name, 0644);
                        imagedestroy($resized_img);
                        imagedestroy($img_to_modify);
                        @unlink($temp_file);
                        //adding file to the uploaded img array
                        array_unshift($img_list, $new_name);
                        $img_count++;
                        // Creating file in cache to have easy fetching datas
                        $data_file = $timestamp . '_img_' . $pun_user['id'] . '_' . $file_name . '.txt';
                        $fp        = fopen($cache . $data_file, 'wb');
                        fclose($fp);
                      }
                    else
                      {
                        $message = '<span style="color: orange"> » ' . $lang_ezbbc['Img size too large'] . $ezbbc_config['max_img_width'] . 'px</span>';
                      }
                }
                else
                {
                    $message = '<span style="color: orange"> » ' . $lang_ezbbc['Img size too large'] . $ezbbc_config['max_img_width'] . 'px</span>';
                }
                
              }
		    else if ($width > $ezbbc_config['max_img_width'] && !function_exists('gd_info'))
			{
				$message = '<span style="color: orange"> » ' . $lang_ezbbc['Img size too large'] . $ezbbc_config['max_img_width'] . 'px</span>';
			}
            else if (is_uploaded_file($uploaded_file) && @move_uploaded_file($uploaded_file, $file_location))
              {
                $upload_ok = true;
                //adding file to the uploaded img array
                array_unshift($img_list, $def_file_name);
                $img_count++;
                // Creating file in cache to have easy to fetch datas
                $data_file = $timestamp . '_img_' . $pun_user['id'] . '_' . $file_name . '.txt';
                $fp        = fopen($cache . $data_file, 'wb');
                fclose($fp);
              }
            else
              {
                $message = '<span style="color: orange"> » ' . $lang_ezbbc['Upload fail'] . '</span>';
              }
          }
        else
          {
            $message = '<span style="color: orange"> » ' . $lang_ezbbc['User Folder not writable'] . '</span>';
          }
      }
    
    //Listing of the images files if feature enabled
    if ($ezbbc_config['img_list'] == 'img_list')
      {
        $folder_path = $path . '/' . $pun_user['id'];
        for ($i = 0; $i < $img_count; $i++)
          {
            preg_match('@^([0-9]+)_(.*)$@', $img_list[$i], $matches);
            $timestamp = $matches[1];
            $name      = $matches[2];
            $date      = date($lang_ezbbc['Date format'], $timestamp);
            $img_path  = $folder_path . '/' . $img_list[$i];
            list($width, $height) = @getimagesize($img_path);
            $width              = $width + 20;
            $height             = $height + 20;
            $img_list_display[] = '<li><a href="' . $img_path . '" onclick="window.open(this.href, \'Preview\', \'height=' . $height . ', width=' . $width . ', top=50, left=50, toolbar=no, menubar=no, location=no, resizable=yes, scrollbars=no, status=no\'); return false;" title="' . $lang_ezbbc['Display'] . '"><img src="style/admin/listing/img.png" alt="' . $lang_ezbbc['Display'] . '" /></a> <a href="' . $_SERVER['SCRIPT_NAME'] . '?textarea_name=' . $textarea_name . '&amp;action=remove&amp;fname=' . $img_list[$i] . '" onclick="return window.confirm(\'' . $lang_ezbbc['Remove file confirm'] . '\')" title="' . $lang_ezbbc['Remove'] . '"><img src="style/admin/listing/img-del.png" alt="' . $lang_ezbbc['Remove'] . '" /></a> <a href="#" onclick="document.imageform.url.value = \'' . $img_path . '\'; document.imageform.alt.focus(); return false;" title="' . $lang_ezbbc['Add'] . '"><img src="style/admin/listing/img-add.png" alt="' . $lang_ezbbc['Add'] . '" /></a> ' . $date . ' - <strong>' . $name . '</strong></li>';
          }
      }
  }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<title><?php echo $lang_ezbbc['EZBBC Image']; ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="<?php echo PUN_ROOT . 'style/' . $pun_user['style'] . '.css';
?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo PUN_ROOT . 'plugins/ezbbc/style/' . $ezbbc_config['style_folder'] . '/ezbbc.css';
?>" />
	<script type="text/javascript">
	/* <![CDATA[ */
	// Function to make visible the images list
	function imgVisibility() {
		var imageForm = document.getElementById('cimages');;
		if (imageForm.style.display == "block") {
			imageForm.style.display = "none";
		} else {
			imageForm.style.display = "block";
		}
	}
	function clearMessage() {
	        var amessage = document.getElementById("amessage");
	        amessage.style.display = "none";
	}
	        
	// Function to retrieve the selection in opener and add it to the right field    
	function getSelection()
	{
        var field  = window.opener.document.getElementsByName('<?php echo $textarea_name; ?>')[0]; 
        var scroll = field.scrollTop;
        field.focus();
        /* get the selection */
        if (window.ActiveXObject)
        { //For IE
                var textRange = window.opener.document.selection.createRange();
                var currentSelection = textRange.text;
        }
        else
        { //For other browsers
                var startSelection   = field.value.substring(0, field.selectionStart);
                var currentSelection = field.value.substring(field.selectionStart, field.selectionEnd);
                var endSelection     = field.value.substring(field.selectionEnd);
        }
        /* Add the selection to the label field */
		document.imageform.alt.value = currentSelection;
		document.imageform.url.focus();
	}
	// Function to insert The linktags and selection in opener Window
	function insertImageTag()
	{
        var field  = window.opener.document.getElementsByName('<?php echo $textarea_name; ?>')[0]; 
        var scroll = field.scrollTop;
        field.focus();
                
        /* === Part 1: get the selection === */
        if (window.ActiveXObject)
        { //For IE
			var textRange = window.opener.document.selection.createRange();
			var currentSelection = textRange.text;
        }
        else
        { //For other browsers
			var startSelection   = field.value.substring(0, field.selectionStart);
			var currentSelection = field.value.substring(field.selectionStart, field.selectionEnd);
			var endSelection     = field.value.substring(field.selectionEnd);
        }
		
        /* === Part 2: creating tagged element === */
		var startTag = endTag = '';
		var alt = document.imageform.alt.value;
		var url = document.imageform.url.value;
		var testurl = url.toLowerCase();
		if (alt != '')
		{ //A label has been entered
			if (testurl.indexOf('http://') == 0 || testurl.indexOf('https://') == 0 || testurl.indexOf('ftp://') == 0)
			{
				startTag = '[img=' + alt + ']';
				currentSelection = url;
				endTag = '[/img]';
			}
			else
			{
				alert("<?php echo $lang_ezbbc['Invalid url']; ?>");
				document.imageform.url.focus();
				return false;
			}
		}
		else
		{ //No alt text entered
			if (testurl.indexOf('http://') == 0 || testurl.indexOf('https://') == 0 || testurl.indexOf('ftp://') == 0)
			{
				startTag = '[img]';
				currentSelection = url;
				endTag = '[/img]';
			}
			else
			{
				alert("<?php echo $lang_ezbbc['Invalid url']; ?>");
				document.imageform.url.focus();
				return false;
			}
		}
		
		/* === Part 3: adding what was produced to the opener === */
        if (window.ActiveXObject)
        { //For IE
			textRange.text = startTag + currentSelection + endTag;   
        }
        else
        { //For other browsers
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
				<div id="ezbbcimage">
					<form name="imageform" method="post" action="<?php echo $_SERVER['SCRIPT_NAME'] . '?textarea_name=' . $textarea_name; ?>" enctype="multipart/form-data">
						<p>
						<?php echo $lang_ezbbc['Ask alt']; ?><br />
						<input type="text" name="alt"  size="55" />
						</p>
						<p>
						<label class="required"><strong><?php echo $lang_ezbbc['Ask url img']; ?> <span><?php echo $lang_common['Required']; ?></span></strong><br />
						<input type="text" name="url" size="55" value="<?php if ($upload_ok) echo $file_path; ?>" /></label>
						</p>
                    	<?php if ($ezbbc_config['img_upload'] == 'img_upload' && !$pun_user['is_guest'] && ($img_count < $img_limit || $img_limit == 0)): ?>                  	
							<p>
							<?php echo $lang_ezbbc['Upload image']; ?><?php echo $message; ?><br />
							<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo ($ezbbc_config['max_img_size'] * 1024); ?>" />
							<input type="file" name="file" size="35" />
							<input type="submit" name="subfile" value="<?php echo $lang_ezbbc['Submit']; ?>" /><br />
							<?php echo $lang_ezbbc['Allowed extension display'] . implode(',', $allowed_ext) . ' - ' . $lang_ezbbc['Max size'] . $ezbbc_config['max_img_size'] . $lang_ezbbc['Kb']; ?>
							</p>
						<?php endif; ?>
						<?php if ($ezbbc_config['img_upload'] == 'img_upload' && !$pun_user['is_guest']): ?>
				    	    <p>
				    	    <?php echo $lang_ezbbc['Already uploaded'] . '<strong>' . $img_count . '</strong>'; ?>
				    	    <?php if ($img_limit > 0) echo '- ' . $lang_ezbbc['Max img upload'] . '<strong>' . $img_limit . '</strong>'; ?><br />
				    	    </p>
						<?php endif; ?>
                    	<?php if ($ezbbc_config['img_upload'] == 'img_upload' && $ezbbc_config['img_list'] == 'img_list' && count($img_list) > 0): ?>
							<p>
							<a href="#" onclick="imgVisibility(); return false;"><?php echo $lang_ezbbc['My images']; ?></a>
							<?php echo $action_message; ?>
							</p>
							<ul style="display: none; max-height: 100px; overflow: auto; border-bottom: grey 1px solid; border-top: grey 1px solid;" id="cimages">
							<?php foreach ($img_list_display as $img_item) { echo $img_item; } ?>
							</ul>
						<?php endif; ?>	
						<p class="buttons">
						<input type="button" value="<?php echo $lang_ezbbc['OK']; ?>" onclick="insertImageTag()" />
						<input type="button" value="<?php echo $lang_ezbbc['Cancel']; ?>" onclick="self.close()" />
						</p>
                    </form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
