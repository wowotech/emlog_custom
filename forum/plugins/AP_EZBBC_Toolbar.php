<?php

/**
 * Copyright (C) 2008-2014 Jojaba
 * see CREDITS file to learn more about this page
 * License: http://www.gnu.org/licenses/gpl.html GPL version 2 or higher
 */

// Make sure no one attempts to run this script "directly"
if (!defined('PUN'))
	exit;

// Tell admin_loader.php that this is indeed a plugin and that it is loaded
define('PUN_PLUGIN_LOADED', 1);

/* ******************************** */
/* Core of the EZBBC Toolbar Plugin */
/* ******************************** */

//
// Generate the config PHP script
//
function generate_ezbbc_config()
{
	global $ezbbc_config;

	$output = array();
	foreach ($ezbbc_config as $key => $value)
		$output[$key] = $value;

	// Output config as PHP code
	$fh = @fopen(PUN_ROOT.'plugins/ezbbc/config.php', 'wb');
	if (!$fh)
		error('Unable to write configuration file. Please make sure PHP has write access to the directory \''.pun_htmlspecialchars(PUN_ROOT.'plugins/ezbbc/').'\'', __FILE__, __LINE__);

	fwrite($fh, '<?php'."\n\n".'$ezbbc_config = '.var_export($output, true).';'."\n\n".'?>');

	fclose($fh);
}

// Language file load
$ezbbc_language_folder = file_exists(PUN_ROOT.'plugins/ezbbc/lang/'.$admin_language.'/ezbbc_plugin.php') ? $admin_language : 'English';    
require PUN_ROOT.'plugins/ezbbc/lang/'.$ezbbc_language_folder.'/ezbbc_plugin.php';

//Retrieving language file folder
$ezbbc_lang_folder = file_exists (PUN_ROOT.'plugins/ezbbc/lang/'.$ezbbc_language_folder.'/help.php') ? $ezbbc_language_folder : 'English';
$help_file_path = 'plugins/ezbbc/lang/'.$ezbbc_lang_folder.'/help.php';

// Some data that have to be set before all treatments
$new_install = false;
$wrong_install = false;
$config_data_err = '';
$img_folder_err = '';
$doc_folder_err = '';

// Getting the config data from config.php file
$plugin_version = "1.6.2";
require PUN_ROOT.'plugins/ezbbc/config.php';

// Looking if config.txt file exists to get the old datas
if ($ezbbc_config['install'] == 0 && file_exists(PUN_ROOT.'plugins/ezbbc/config.txt')) {
	$config_content = trim(file_get_contents(PUN_ROOT.'plugins/ezbbc/config.txt'));
	$config_item = explode(";", $config_content);
	//$ezbbc_config = array();
	//$ezbbc_config['install'] = $config_item[0];
	//$ezbbc_config['status'] = $config_item[1];
	if (isset($config_item[2])) $ezbbc_config['style_folder'] = $config_item[2];
	if (isset($config_item[3])) $ezbbc_config['smilies_set'] = $config_item[3];
	if (isset($config_item[4])) $ezbbc_config['h_id'] = $config_item[4];
	if (isset($config_item[5])) $ezbbc_config['video'] = $config_item[5];
	if (isset($config_item[6])) $ezbbc_config['img_upload'] = $config_item[6];
	if (isset($config_item[7])) $ezbbc_config['img_folder'] = $config_item[7];
	if (isset($config_item[8])) $ezbbc_config['max_img_width'] = $config_item[8];
	if (isset($config_item[9])) $ezbbc_config['max_img_size'] = $config_item[9];
	if (isset($config_item[10])) $ezbbc_config['img_list'] = $config_item[10];
	if (isset($config_item[11])) $ezbbc_config['img_limit'] = $config_item[11];
	if (isset($config_item[12])) $ezbbc_config['img_limit_mod'] = $config_item[12];
	if (isset($config_item[13])) $ezbbc_config['doc_upload'] = $config_item[13];
	if (isset($config_item[14])) $ezbbc_config['doc_folder'] = $config_item[14];
	if (isset($config_item[15])) $ezbbc_config['max_doc_size'] = $config_item[15];
	if (isset($config_item[16])) $ezbbc_config['allowed_ext'] = $config_item[16];
	if (isset($config_item[17])) $ezbbc_config['doc_list'] = $config_item[17];
	if (isset($config_item[18])) $ezbbc_config['doc_limit'] = $config_item[18];
	if (isset($config_item[19])) $ezbbc_config['doc_limit_mod'] = $config_item[19];
	if (isset($config_item[20])) $ezbbc_config['b'] = $config_item[20];
	if (isset($config_item[21])) $ezbbc_config['u'] = $config_item[21];
	if (isset($config_item[22])) $ezbbc_config['i'] = $config_item[22];
	if (isset($config_item[23])) $ezbbc_config['s'] = $config_item[23];
	if (isset($config_item[24])) $ezbbc_config['del'] = $config_item[24];
	if (isset($config_item[25])) $ezbbc_config['ins'] = $config_item[25];
	if (isset($config_item[26])) $ezbbc_config['em'] = $config_item[26];
	if (isset($config_item[27])) $ezbbc_config['color'] = $config_item[27];
	if (isset($config_item[28])) $ezbbc_config['heading'] = $config_item[28];
	if (isset($config_item[29])) $ezbbc_config['url'] = $config_item[29];
	if (isset($config_item[30])) $ezbbc_config['email'] = $config_item[30];
	if (isset($config_item[31])) $ezbbc_config['img'] = $config_item[31];
	if (isset($config_item[32])) $ezbbc_config['quote'] = $config_item[32];
	if (isset($config_item[33])) $ezbbc_config['code'] = $config_item[33];
	if (isset($config_item[34])) $ezbbc_config['ulist'] = $config_item[34];
	if (isset($config_item[35])) $ezbbc_config['olist'] = $config_item[35];
	if (isset($config_item[36])) $ezbbc_config['alist'] = $config_item[36];
	if (isset($config_item[37])) $ezbbc_config['smiliesb'] = $config_item[37];
	if (isset($config_item[38])) $ezbbc_config['help'] = $config_item[38];
	if (isset($config_item[39])) $ezbbc_config['post_toolbar'] = $config_item[39];
	if (isset($config_item[40])) $ezbbc_config['quickpost_toolbar'] = $config_item[40];
	if (isset($config_item[41])) $ezbbc_config['signature_toolbar'] = $config_item[41];
	if (isset($config_item[42])) $ezbbc_config['smiliesbar_position'] = $config_item[42];
	if (isset($config_item[43])) $ezbbc_config['bars_position'] = $config_item[43]; 
}

/* Treating some datas to have some infos about plugins */
/* **************************************************** */
// Installation date
if ($ezbbc_config['install'] != 0) {
        $first_install = false;
        $install_date = date($lang_ezbbc['Date format'], $ezbbc_config['install']);
} else { 
        $first_install = true;
}

// Installation status
if ($ezbbc_config['status'] == 0) {
        $ezbbc_plugin_status = '<span style="background: #FFF url(plugins/ezbbc/style/admin/style/install_no.png) no-repeat left center; color: red; border: #FFF 2px solid; border-radius: 5px; padding: 0 5px 0 18px;font-weight: bold;">'.$lang_ezbbc['Plugin disabled'].'</span>';
} else { 
        // Looking first if all is really installed and updated
        $header_file_content = file_get_contents(PUN_ROOT.'header.php');
        $parser_file_content = file_get_contents(PUN_ROOT.'include/parser.php');
        $help_file_content = file_get_contents(PUN_ROOT.'help.php');
        // looking if the right code is in all modified files
        if (strpos($header_file_content, "<?php require PUN_ROOT.'plugins/ezbbc/ezbbc_head.php'; ?>") === false || strpos($parser_file_content, "require PUN_ROOT.'plugins/ezbbc/ezbbc_smilies1.php';") === false || strpos($parser_file_content, "require PUN_ROOT.'plugins/ezbbc/ezbbc_smilies2.php';") === false || strpos($help_file_content, "require PUN_ROOT.'plugins/ezbbc/ezbbc_smilies3.php';") === false) {
                $ezbbc_plugin_status = '<span style="background: #FFF url(plugins/ezbbc/style/admin/style/warning.png) no-repeat left center; color: OrangeRed; border: #FFF 2px solid; border-radius: 5px; padding: 0 5px 0 18px;font-weight: bold;">'.$lang_ezbbc['Plugin wrong installation'].'</span>';
                $wrong_install = true;
        } else {
                $ezbbc_plugin_status = '<span style="background: #FFF url(plugins/ezbbc/style/admin/style/ok.png) no-repeat left center; color: green; border: #FFF 2px solid; border-radius: 5px; padding: 0 5px 0 22px;font-weight: bold;">'.$lang_ezbbc['Plugin in action'].'</span>';
        }
}

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

/* *************************************************************************************** */
/* Installation of the plugin and style change                                             */
/* *************************************************************************************** */

if (isset($_POST['enable']) || $first_install){
        /* Trying to set right permissions for files to be writeable */
        @chmod (PUN_ROOT.'header.php', 0640);
        @chmod (PUN_ROOT.'include/parser.php', 0640);
        @chmod (PUN_ROOT.'help.php', 0640);
        @chmod (PUN_ROOT.'plugins/ezbbc/config.php', 0640);
        
/* Looking if the files are writable */
if (is_writable(PUN_ROOT.'header.php') && is_writable(PUN_ROOT.'include/parser.php') && is_writable(PUN_ROOT.'help.php') && is_writable(PUN_ROOT.'plugins/ezbbc/config.php')):
    
	/* Getting the content of the header.php file */
	$file_content = file_get_contents(PUN_ROOT.'header.php');
	if (strpos($file_content, "<?php require PUN_ROOT.'plugins/ezbbc/ezbbc_head.php'; ?>") === false) {
	    //Inserting the EZBBC code by replacing an existing line
	    $search = '</title>';
	    $insert = "<?php require PUN_ROOT.'plugins/ezbbc/ezbbc_head.php'; ?>";
	    $replacement = $search."\n".$insert;
	    $file_content = str_replace ($search, $replacement, $file_content);
	    $fp = fopen (PUN_ROOT.'header.php', 'wb');
	    fwrite ($fp, $file_content);
	    fclose ($fp);
	}
		
	/* Getting the content of the include/parser.php file and processing replacement */ 
	$file_content = file_get_contents(PUN_ROOT.'include/parser.php');  
	if (strpos($file_content, "require PUN_ROOT.'plugins/ezbbc/ezbbc_smilies1.php';") === false) {  
	    //Inserting the EZBBC code by replacing several existing lines  
        $search = '~\$smilies\s*=\s*array\(.*?\);~si';  
        $replacement = "require PUN_ROOT.'plugins/ezbbc/ezbbc_smilies1.php';";  
        $file_content = preg_replace ($search, $replacement, $file_content);  
        $fp = fopen (PUN_ROOT.'include/parser.php', 'wb');  
        fwrite ($fp, $file_content);  
        fclose ($fp);                    
	}
	$file_content = file_get_contents(PUN_ROOT.'include/parser.php');
	if (strpos($file_content, "require PUN_ROOT.'plugins/ezbbc/ezbbc_smilies2.php';") === false) {
	    //Inserting the EZBBC code by replacing several existing lines  
        $search = '~\$text.*/img/smilies/.*\$text\);~';  
        $replacement =  "require PUN_ROOT.'plugins/ezbbc/ezbbc_smilies2.php';";  
        $file_content = preg_replace ($search, $replacement, $file_content);  
        $fp = fopen (PUN_ROOT.'include/parser.php', 'wb');  
        fwrite ($fp, $file_content);  
        fclose ($fp);                    
	}
	
	/* Getting the content of the help.php file and processing replacement */ 
	$file_content = file_get_contents(PUN_ROOT.'help.php');  
	if (strpos($file_content, "require PUN_ROOT.'plugins/ezbbc/ezbbc_smilies3.php';") === false) {
	    //Inserting the EZBBC code by replacing several existing lines  
        $search = '~echo.*/img/smilies/.*;~';  
        $replacement =  "require PUN_ROOT.'plugins/ezbbc/ezbbc_smilies3.php';";  
        $file_content = preg_replace ($search, $replacement, $file_content);  
        $fp = fopen (PUN_ROOT.'help.php', 'wb');  
        fwrite ($fp, $file_content);  
        fclose ($fp);                    
	}
        
	// Adding new data to config file
	$ezbbc_config['status'] = 1;
	if ($first_install) {
		$ezbbc_config['install'] = time();
		$install_date = date($lang_ezbbc['Date format'], $ezbbc_config['install']);
	}
	generate_ezbbc_config();
	// New status message
	$ezbbc_plugin_status = '<span style="background: #FFF url(plugins/ezbbc/style/admin/style/ok.png) no-repeat left center; color: green; border: #FFF 2px solid; border-radius: 5px; padding: 0 5px 0 22px;font-weight: bold;">'.$lang_ezbbc['Plugin in action'].'</span>';
	$wrong_install = false;

// The files are not writable...
else:
    $ezbbc_plugin_status = '<span style="color: red; font-weight: bold;">'.$lang_ezbbc['Not writable'].'</span>';
endif;
}

/* If the remove button was clicked */
/* ******************************** */
if (isset($_POST['disable'])) {
    /* Trying to set right permissions for files to be writeable */
    @chmod (PUN_ROOT.'header.php', 0640);
    @chmod (PUN_ROOT.'include/parser.php', 0640);
    @chmod (PUN_ROOT.'help.php', 0640);
    @chmod (PUN_ROOT.'plugins/ezbbc/config.php', 0640);   

/* First looking if the files are writable */
if (is_writable(PUN_ROOT.'header.php') && is_writable(PUN_ROOT.'include/parser.php') && is_writable(PUN_ROOT.'plugins/ezbbc/config.php') && is_writable(PUN_ROOT.'help.php')):	
    
	/* Getting the content of the header.php file */
	$file_content = file_get_contents(PUN_ROOT.'header.php');
	//Searching for ezbbc code and replacing it with nothing
	$search = "\n<?php require PUN_ROOT.'plugins/ezbbc/ezbbc_head.php'; ?>";
	$replacement = '';
	$file_content = str_replace ($search, $replacement, $file_content);
	$fp = fopen (PUN_ROOT.'header.php', 'wb');
	fwrite ($fp, $file_content);
	fclose ($fp);
	
	/* Getting the content of the include/parser.php file */
	$file_content = file_get_contents(PUN_ROOT.'include/parser.php');
	//smilies remove
	$search = array("require PUN_ROOT.'plugins/ezbbc/ezbbc_smilies1.php';","require PUN_ROOT.'plugins/ezbbc/ezbbc_smilies2.php';");
	$replacement = array("\$smilies = array(
	        ':)' => 'smile.png',
	        '=)' => 'smile.png',
	        ':|' => 'neutral.png',
	        '=|' => 'neutral.png',
	        ':(' => 'sad.png',
	        '=(' => 'sad.png',
	        ':D' => 'big_smile.png',
	        '=D' => 'big_smile.png',
	        ':o' => 'yikes.png',
	        ':O' => 'yikes.png',
	        ';)' => 'wink.png',
	        ':/' => 'hmm.png',
	        ':P' => 'tongue.png',
	        ':p' => 'tongue.png',
	        ':lol:' => 'lol.png',
	        ':mad:' => 'mad.png',
	        ':rolleyes:' => 'roll.png',
	        ':cool:' => 'cool.png');",
	        '$text = preg_replace("#(?<=[>\s])".preg_quote($smiley_text, \'#\')."(?=\W)#m", \'<img src="\'.pun_htmlspecialchars((function_exists(\'get_base_url\') ? get_base_url(true) : $pun_config[\'o_base_url\']).\'/img/smilies/\'.$smiley_img).\'" width="15" height="15" alt="\'.substr($smiley_img, 0, strrpos($smiley_img, \'.\')).\'" />\', $text);',
	        );
	$file_content = str_replace ($search, $replacement, $file_content);
	$fp = fopen (PUN_ROOT.'include/parser.php', 'wb');
	fwrite ($fp, $file_content);
	fclose ($fp);
	
	// Help file modification replacement
	/* Getting the content of the help.php file */
	$file_content = file_get_contents(PUN_ROOT.'help.php');
	//Searching for ezbbc code and replacing it with nothing
	$search = "require PUN_ROOT.'plugins/ezbbc/ezbbc_smilies3.php';";
	$replacement = 'echo "\t\t".\'<p><code>\'.implode(\'</code> \'.$lang_common[\'and\'].\' <code>\', $smiley_texts).\'</code> <span>\'.$lang_help[\'produces\'].\'</span> <samp><img src="\'.pun_htmlspecialchars(get_base_url(true)).\'/img/smilies/\'.$smiley_img.\'" width="15" height="15" alt="\'.$smiley_texts[0].\'" /></samp></p>\'."\n";';
	$file_content = str_replace ($search, $replacement, $file_content);
	$fp = fopen (PUN_ROOT.'help.php', 'wb');
	fwrite ($fp, $file_content);
	fclose ($fp);
	
	// advanced features remove
	$file_content = file_get_contents(PUN_ROOT.'include/parser.php');
	$search = array(
		"\n\t\$pattern[] = '%\[h=([^\[]+?)\](.*?)\[/h\]%ms';",
		"\n\t\$replace[] = '</p><h5 id=\"\$1\"><a href=\"#\$1\">#</a> \$2</h5><p>';",
		"video|",
		", 'video'",
		"\n\t\t'video' => array('url'),",
		"\n\trequire PUN_ROOT.'plugins/ezbbc/ezbbc_video_pattern.php';",
		"\n\trequire PUN_ROOT.'plugins/ezbbc/ezbbc_video_replace.php';",
	);
	$replacement = '';
        $file_content = str_replace ($search, $replacement, $file_content);
	$fp = fopen (PUN_ROOT.'include/parser.php', 'wb');
	fwrite ($fp, $file_content);
	fclose ($fp);
	
	// Adding new data to config file
	$ezbbc_config['status'] = 0;
	$ezbbc_config['h_id'] = 'no_h_id';
	$ezbbc_config['video'] = 'no_video';
	$ezbbc_config['img_upload'] = 'no_img_upload';
	$ezbbc_config['doc_upload'] = 'no_doc_upload';
	generate_ezbbc_config();
	// New status message
	$ezbbc_plugin_status = '<span style="background: #FFF url(plugins/ezbbc/style/admin/style/install_no.png) no-repeat left center; color: red; border: #FFF 2px solid; border-radius: 5px; padding: 0 5px 0 18px;font-weight: bold;">'.$lang_ezbbc['Plugin disabled'].'</span>';
else:
        $ezbbc_plugin_status = '<span style="color: red; font-weight: bold;">'.$lang_ezbbc['Not writable'].'</span>';
endif;	
}

/* If the change style button was clicked */
/* ************************************** */
if (isset($_POST['style_change'])) {
    $ezbbc_config['style_folder'] = $_POST['ezbbc_style'];
    $ezbbc_config['smilies_set'] = $_POST['ezbbc_smilies_set'];
    // Changing config data
    generate_ezbbc_config();
}

/* Plugin status and checking if installation went right  */
/* ****************************************************** */
if ($ezbbc_config['status'] == 0) {
        $ezbbc_plugin_status = '<span style="background: #FFF url(plugins/ezbbc/style/admin/style/install_no.png) no-repeat left center; color: red; border: #FFF 2px solid; border-radius: 5px; padding: 0 5px 0 18px;font-weight: bold;">'.$lang_ezbbc['Plugin disabled'].'</span>';
} else { 
        // Looking first if all is really installed and updated
        $header_file_content = file_get_contents(PUN_ROOT.'header.php');
        $parser_file_content = file_get_contents(PUN_ROOT.'include/parser.php');
        $help_file_content = file_get_contents(PUN_ROOT.'help.php');
        // looking if the right code is in all modified files
        if (strpos($header_file_content, "<?php require PUN_ROOT.'plugins/ezbbc/ezbbc_head.php'; ?>") === false || strpos($parser_file_content, "require PUN_ROOT.'plugins/ezbbc/ezbbc_smilies1.php';") === false || strpos($parser_file_content, "require PUN_ROOT.'plugins/ezbbc/ezbbc_smilies2.php';") === false || strpos($help_file_content, "require PUN_ROOT.'plugins/ezbbc/ezbbc_smilies3.php';") === false) {
                $ezbbc_plugin_status = '<span style="background: #FFF url(plugins/ezbbc/style/admin/style/warning.png) no-repeat left center; color: OrangeRed; border: #FFF 2px solid; border-radius: 5px; padding: 0 5px 0 18px;font-weight: bold;">'.$lang_ezbbc['Plugin wrong installation'].'</span>';
                $wrong_install = true;
        } else {
                $ezbbc_plugin_status = '<span style="background: #FFF url(plugins/ezbbc/style/admin/style/ok.png) no-repeat left center; color: green; border: #FFF 2px solid; border-radius: 5px; padding: 0 5px 0 22px;font-weight: bold;">'.$lang_ezbbc['Plugin in action'].'</span>';
        }
}

/* *************************************************************************************** */
/* Style file and folder managing                                                          */
/* *************************************************************************************** */

/* If the Rename button was clicked */
/* ******************************** */
if (isset($_POST['folder_count'])){
    $folder_count = $_POST['folder_count'];
    for ($i=0; $i<$folder_count; $i++) {
        if (isset($_POST['vrename'.$i])){
            $folder_name = $_POST['folder_name'.$i];
            $new_name = $_POST['rename'.$i];
            if ($new_name != '') {
                // Converting special characters
                $new_name = htmlentities($new_name, ENT_QUOTES, 'utf-8');
                $search = array('&Agrave;', '&agrave;', '&Aacute;', '&aacute;', '&Acirc;', '&acirc;', '&Atilde;', '&atilde;', '&Auml;', '&auml;', '&Aring;', '&aring;', '&AElig;', '&aelig;', '&Ccedil;', '&ccedil;', '&ETH;', '&eth;', '&Egrave;', '&egrave;', '&Eacute;', '&eacute;', '&Ecirc;', '&ecirc;', '&Euml;', '&euml;', '&Igrave;', '&igrave;', '&Iacute;', '&iacute;', '&Icirc;', '&icirc;', '&Iuml;', '&iuml;', '&Ntilde;', '&ntilde;', '&Ograve;', '&ograve;', '&Oacute;', '&oacute;', '&Ocirc;', '&ocirc;', '&Otilde;', '&otilde;', '&Ouml;', '&ouml;', '&Oslash;', '&oslash;', '&OElig;', '&oelig;', '&szlig;', '&THORN;', '&thorn;', '&Ugrave;', '&ugrave;', '&Uacute;', '&uacute;', '&Ucirc;', '&ucirc;', '&Uuml;', '&uuml;', '&Yacute;', '&yacute;', '&Yuml;', '&yuml;', ' ', '&lt;', '&gt;', '&quot;', '&#039;', '\'', '/', '\\', '?', '*', ':');
                $replace = array('a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'ae', 'c', 'c', 'd', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'i', 'i', 'i', 'i', 'n', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'oe', 'oe', 'ss', 'p', 'p', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'y', 'y', 'y', 'y', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_');
                $new_name = str_replace($search, $replace, $new_name);
                @rename (PUN_ROOT.'plugins/ezbbc/style/'.$folder_name, PUN_ROOT.'plugins/ezbbc/style/'.$new_name);
            }
        }
    }
}

/* If the Copy button was clicked */
/* ******************************** */
if (isset($_GET['copy'])) {
    $style_folder = $_GET['style_folder'];
    // Creating the new folders
    mkdir(PUN_ROOT.'plugins/ezbbc/style/'.$style_folder.'-copy');
    mkdir(PUN_ROOT.'plugins/ezbbc/style/'.$style_folder.'-copy/images');
    // Copying the files in the images folder
    $images = opendir(PUN_ROOT.'plugins/ezbbc/style/'.$style_folder.'/images/');
	while(false !== ($image = readdir($images))) {
		if ($image != '.' && $image != '..') {
		    copy (PUN_ROOT.'plugins/ezbbc/style/'.$style_folder.'/images/'.$image, PUN_ROOT.'plugins/ezbbc/style/'.$style_folder.'-copy/images/'.$image);
		}
	}
	closedir($images);
	// Copying the css and the html file in the new style folder
	copy (PUN_ROOT.'plugins/ezbbc/style/'.$style_folder.'/ezbbc.css', PUN_ROOT.'plugins/ezbbc/style/'.$style_folder.'-copy/ezbbc.css');
	copy (PUN_ROOT.'plugins/ezbbc/style/'.$style_folder.'/index.html', PUN_ROOT.'plugins/ezbbc/style/'.$style_folder.'-copy/index.html');
	header('Location: admin_loader.php?plugin=AP_EZBBC_Toolbar.php'); 
}

/* If the Remove button was clicked */
/* ******************************** */
if (isset($_GET['remove'])) {
    $style_folder = $_GET['style_folder'];
    // Retrieving and removing the files in images folder
    $images = opendir(PUN_ROOT.'plugins/ezbbc/style/'.$style_folder.'/images/');
	while(false !== ($image = readdir($images))) {
		if ($image != '.' && $image != '..') {
		    @chmod (PUN_ROOT.'plugins/ezbbc/style/'.$style_folder.'/images/'.$image, 0777);
		    @unlink (PUN_ROOT.'plugins/ezbbc/style/'.$style_folder.'/images/'.$image);
		}
	}
	closedir($images);
	// Removing images folder
	@rmdir(PUN_ROOT.'plugins/ezbbc/style/'.$style_folder.'/images/');
	// Removing css file and html file		
	@unlink (PUN_ROOT.'plugins/ezbbc/style/'.$style_folder.'/ezbbc.css');
	@unlink (PUN_ROOT.'plugins/ezbbc/style/'.$style_folder.'/index.html');
    // Removing the style folder
    @rmdir(PUN_ROOT.'plugins/ezbbc/style/'.$style_folder);
    header('Location: admin_loader.php?plugin=AP_EZBBC_Toolbar.php');
}          

/* *************************************************************************************** */
/* Handling the advanced features                                                          */
/* *************************************************************************************** */

/* Feature enabling */
/* **************** */

/* Button selection */
if (isset($_POST['button_selection'])) {
	$bdatas = array('b', 'u', 'i', 's', 'del', 'ins', 'em', 'color', 'heading', 'url', 'email', 'img', 'quote', 'code', 'ulist', 'olist', 'alist', 'smiliesb', 'help');
	foreach ($bdatas as $bdata) {
	   $ezbbc_config[$bdata] = ${'ezbbc_'.$bdata} = (isset($_POST[$bdata])) ? $bdata : 'no_'.$bdata;
	}
	// Disabling doc or img upload if doc or img button disabled
	if ($ezbbc_config['url'] == 'no_url') $ezbbc_config['doc_upload'] = 'no_doc_upload';
	if ($ezbbc_config['img'] == 'no_img') $ezbbc_config['img_upload'] = 'no_img_upload';
	generate_ezbbc_config(); 
} 

/* Toolbar in post and edit window */
if (isset($_POST['post_toolbar_enable'])) {
	$ezbbc_config['post_toolbar'] = 'post_toolbar';
	generate_ezbbc_config();
}

/* Toolbar on quickpost window */
if (isset($_POST['quickpost_toolbar_enable'])) {
	$ezbbc_config['quickpost_toolbar'] = 'quickpost_toolbar';
	generate_ezbbc_config();
}

/* Toolbar on signature window */
if (isset($_POST['signature_toolbar_enable'])) {
	$ezbbc_config['signature_toolbar'] = 'signature_toolbar';
	generate_ezbbc_config();
}

/* Smiliesbar position */
if (isset($_POST['sb_pos_valid'])) {
	$ezbbc_config['smiliesbar_position'] = $_POST['smiliesbar_position'];
	generate_ezbbc_config();
}

/* Bars position */
if (isset($_POST['bars_pos_valid'])) {
	$ezbbc_config['bars_position'] = $_POST['bars_position'];
	generate_ezbbc_config();
}

/* Code syntax highlight */
if (isset($_POST['syntax_highlight_enable'])) {
	/* Trying to set right permissions for file to be writeable */        
	@chmod (PUN_ROOT.'include/parser.php', 0640);
	
	if (is_writable(PUN_ROOT.'include/parser.php')) {
		$file_content = file_get_contents(PUN_ROOT.'include/parser.php');
	    //Inserting the EZBBC code by replacing several existing lines  
        $search = '~\$text.*vscroll.*<p>\';~';  
        $replacement =  "require PUN_ROOT.'plugins/ezbbc/ezbbc_code_highlight.php';";  
        $file_content = preg_replace ($search, $replacement, $file_content);  
        $fp = fopen (PUN_ROOT.'include/parser.php', 'wb');  
        fwrite ($fp, $file_content);  
        fclose ($fp);
       //changing config data
       $ezbbc_config['syntax_highlight'] = 'syntax_highlight';
       generate_ezbbc_config();
	}
}

/* id for [h] tag enabling */
if (isset($_POST['h_id_enable'])) {
	/* Trying to set right permissions for file to be writeable */        
	@chmod (PUN_ROOT.'include/parser.php', 0640);
	
	if (is_writable(PUN_ROOT.'include/parser.php')) {	      
		$file_content = file_get_contents(PUN_ROOT.'include/parser.php');
		$search = array(
				"\$pattern[] = '%\[h\](.*?)\[/h\]%ms';",
				"\$replace[] = '</p><h5>\$1</h5><p>';"
				);
		$insert = array(
				"\$pattern[] = '%\[h=([^\[]+?)\](.*?)\[/h\]%ms';",
				"\$replace[] = '</p><h5 id=\"\$1\"><a href=\"#\$1\">#</a> \$2</h5><p>';"
				);
		$replacement = array(
				$search[0]."\n\t".$insert[0],
				$search[1]."\n\t".$insert[1]
				);
		$file_content = str_replace ($search, $replacement, $file_content);
		$fp = fopen (PUN_ROOT.'include/parser.php', 'wb');
		fwrite ($fp, $file_content);
		fclose ($fp);
		// Changing config data
		$ezbbc_config['h_id'] = 'h_id';
		generate_ezbbc_config();
	}       
}

/* Video enabling */
if (isset($_POST['video_enable'])) {
	/* Trying to set right permissions for file to be writeable */        
	@chmod (PUN_ROOT.'include/parser.php', 0640);
	
	if (is_writable(PUN_ROOT.'include/parser.php')) {	      
		$file_content = file_get_contents(PUN_ROOT.'include/parser.php');
		$search = array(
				"[(b|",
				"\$tags = array('quote',",
				"\$tags_inline = array('b',",
				"\$tags_trim = array('img')",
				"\$tags_quotes = array('url',",
				"'img' 	=> array(),",
				"\$pattern[] = '%\[h\](.*?)\[/h\]%ms';",
				"\$replace[] = '</p><h5>$1</h5><p>';",
				);
		$replacement = array(
				"[(b|video|",
				"\$tags = array('quote', 'video',",
				"\$tags_inline = array('b', 'video',",
				"\$tags_trim = array('img', 'video')",
				"\$tags_quotes = array('url', 'video',",
				"'img' 	=> array(),\n\t\t'video' => array('url'),",
				"\$pattern[] = '%\[h\](.*?)\[/h\]%ms';\n\trequire PUN_ROOT.'plugins/ezbbc/ezbbc_video_pattern.php';",
				"\$replace[] = '</p><h5>$1</h5><p>';\n\trequire PUN_ROOT.'plugins/ezbbc/ezbbc_video_replace.php';",
				);
		$file_content = str_replace ($search, $replacement, $file_content);
		$fp = fopen (PUN_ROOT.'include/parser.php', 'wb');
		fwrite ($fp, $file_content);
		fclose ($fp);
		// Changing config data
		$ezbbc_config['video'] = 'video';
		generate_ezbbc_config();
	}        
}

/* Img upload enabling */
if (isset($_POST['img_upload_enable'])) {
	/* Trying to set right permissions for files to be writeable */
	@chmod (PUN_ROOT.'cache/ezbbc', 0755);
	if (is_writable(PUN_ROOT.'cache/ezbbc')) {
		// Trying to create the img folder or set good write permissions
		@mkdir (PUN_ROOT.$ezbbc_config['img_folder'], 0755, true);
		@chmod (PUN_ROOT.$ezbbc_config['img_folder'], 0755);
		if (is_dir(PUN_ROOT.$ezbbc_config['img_folder']) && is_writable(PUN_ROOT.$ezbbc_config['img_folder'])) {
			// Changing config data
			$ezbbc_config['img_upload'] = 'img_upload';
			$ezbbc_config['img'] = 'img';
			generate_ezbbc_config();
		} else {
			$img_folder_err = '<span style="color: red; font-weight: bold;">'.$ezbbc_config['img_folder'].' '.$lang_ezbbc['Folder or file not writable'].'</span>';
		}
	} else {
		$config_data_err = '<span style="color: red; font-weight: bold;">/cache/ezbbc/ '.$lang_ezbbc['Folder or file not writable'].'</span>';
	}
}        

/* Img folder set */
if (isset($_POST['img_folder_set'])) {
	$ezbbc_config['img_folder'] = $_POST['img_folder'];
	// Trying to create the folder or set good write permissions
	@mkdir (PUN_ROOT.$ezbbc_config['img_folder'], 0755, true);
	@chmod (PUN_ROOT.$ezbbc_config['img_folder'], 0755);
	if (is_dir(PUN_ROOT.$ezbbc_config['img_folder']) && is_writable(PUN_ROOT.$ezbbc_config['img_folder'])) {
		generate_ezbbc_config();
	} else {
		$img_folder_err = '<span style="color: red; font-weight: bold;">'.$ezbbc_config['img_folder'].' '.$lang_ezbbc['Folder or file not writable'].'</span>';
	}
}

/* Max img with set */
if (isset($_POST['max_img_width_set'])) {
	$max_img_width = trim($_POST['max_img_width']);
	if (preg_match("/^[0-9]+$/", $max_img_width)) {
		$ezbbc_config['max_img_width'] = $max_img_width;
		generate_ezbbc_config();
	}
}

/* Max image size set */
if (isset($_POST['max_img_size_set'])) {
	$max_img_size = trim($_POST['max_img_size']);
	if ($max_img_size*1024 < $max_file_size_php) {
		$ezbbc_config['max_img_size'] = $max_img_size;
		generate_ezbbc_config();
	}
}

/* Max doc size set */
if (isset($_POST['max_doc_size_set'])) {
$max_doc_size = trim($_POST['max_doc_size']);
	if (($max_doc_size*1024 < $max_file_size_php)) {
		$ezbbc_config['max_doc_size'] = $max_doc_size;
		generate_ezbbc_config();
	}
}

/* Img listing enabling */
if (isset($_POST['img_list_enable'])) {
	$ezbbc_config['img_list'] = 'img_list';
	generate_ezbbc_config();
} 

/* Number of Img allowed */
if (isset($_POST['img_limit_set'])) {
	$img_limit = trim($_POST['img_limit']);
	$img_limit_mod = trim($_POST['img_limit_mod']);
	if (preg_match("/^[0-9]+$/", $img_limit) && preg_match("/^[0-9]+$/", $img_limit_mod)) {
		$ezbbc_config['img_limit'] = $img_limit;
		$ezbbc_config['img_limit_mod'] = $img_limit_mod;
		generate_ezbbc_config();
	}
}

/* Doc upload enabling */
if (isset($_POST['doc_upload_enable'])) {
	/* Trying to set right permissions for files to be writeable */
	@chmod (PUN_ROOT.'cache/ezbbc', 0755);
	if (is_writable(PUN_ROOT.'cache/ezbbc')) {
		// Trying to create the doc folder or set good write permissions
		@mkdir (PUN_ROOT.$ezbbc_config['doc_folder'], 0755, true);
		@chmod (PUN_ROOT.$ezbbc_config['doc_folder'], 0755);
		// Changing config data
		if (is_dir(PUN_ROOT.$ezbbc_config['doc_folder']) && is_writable(PUN_ROOT.$ezbbc_config['doc_folder'])) {
			$ezbbc_config['doc_upload'] = 'doc_upload';
			$ezbbc_config['url'] = 'url';
			generate_ezbbc_config();
		} else {
			$doc_folder_err = '<span style="color: red; font-weight: bold;">'.$ezbbc_config['doc_folder'].' '.$lang_ezbbc['Folder or file not writable'].'</span>';
		}
	} else {
		$config_data_err = '<span style="color: red; font-weight: bold;">/cache/ezbbc/ '.$lang_ezbbc['Folder or file not writable'].'</span>';
	}
}

/* Doc folder set */
if (isset($_POST['doc_folder_set'])) {
	$ezbbc_config['doc_folder'] = trim($_POST['doc_folder']);
	// Trying to create the folder or set good write permissions
	@mkdir (PUN_ROOT.$ezbbc_config['doc_folder'], 0755, true);
	@chmod (PUN_ROOT.$ezbbc_config['doc_folder'], 0755);
	if (is_dir(PUN_ROOT.$ezbbc_config['doc_folder']) && is_writable(PUN_ROOT.$ezbbc_config['doc_folder'])) {
		generate_ezbbc_config();
	} else {
		$doc_folder_err = '<span style="color: red; font-weight: bold;">'.$ezbbc_config['doc_folder'].' '.$lang_ezbbc['Folder or file not writable'].'</span>';
	}
}

/* Allowed extension for docs */
if (isset($_POST['allowed_ext_set'])) {
	$ezbbc_config['allowed_ext'] = trim(strtolower(str_replace(' ','',$_POST['allowed_ext'])));
	generate_ezbbc_config();
}

/* Doc listing enabling */
if (isset($_POST['doc_list_enable'])) {
	$ezbbc_config['doc_list'] = 'doc_list';
	generate_ezbbc_config();
}

/* Number of doc files allowed */
if (isset($_POST['doc_limit_set'])) {
	$doc_limit = trim($_POST['doc_limit']);
	$doc_limit_mod = trim($_POST['doc_limit_mod']);
	if (preg_match("/^[0-9]+$/", $doc_limit) && preg_match("/^[0-9]+$/", $doc_limit_mod)) {
		$ezbbc_config['doc_limit'] = $doc_limit;
		$ezbbc_config['doc_limit_mod'] = $doc_limit_mod;
		generate_ezbbc_config();
	}
}
        
/* Disabling features */
/* ****************** */

/* Toolbar in post and edit window disabling*/
if (isset($_POST['post_toolbar_disable'])) {
	$ezbbc_config['post_toolbar'] = 'no_post_toolbar';
	generate_ezbbc_config();
}

/* Toolbar on quickpost window disabling*/
if (isset($_POST['quickpost_toolbar_disable'])) {
	$ezbbc_config['quickpost_toolbar'] = 'no_quickpost_toolbar';
	generate_ezbbc_config();
}

/* Toolbar on signature window disabling*/
if (isset($_POST['signature_toolbar_disable'])) {
	$ezbbc_config['signature_toolbar'] = 'no_signature_toolbar';
	generate_ezbbc_config();
}

/* Syntax highlighting disabling */
if (isset($_POST['syntax_highlight_disable']) || isset($_POST['disable'])) {
	/* Trying to set right permissions for files to be writeable */        
	@chmod (PUN_ROOT.'include/parser.php', 0640);

	if (is_writable(PUN_ROOT.'include/parser.php')) {
		$file_content = file_get_contents(PUN_ROOT.'include/parser.php');
		$search = "require PUN_ROOT.'plugins/ezbbc/ezbbc_code_highlight.php';";
		$replacement = '$text .= \'</p><div class="codebox"><pre\'.(($num_lines > 28) ? \' class="vscroll"\' : \'\').\'><code>\'.pun_trim($inside[$i], "\\n\\r").\'</code></pre></div><p>\';';
		$file_content = str_replace ($search, $replacement, $file_content);
		$fp = fopen (PUN_ROOT.'include/parser.php', 'wb');
		fwrite ($fp, $file_content);
		fclose ($fp);
		//changing config data
		$ezbbc_config['syntax_highlight'] = 'no_syntax_highlight';
		generate_ezbbc_config();
	}
}

/* id for [h] tag disabling */
if (isset($_POST['h_id_disable']) || isset($_POST['disable'])) {
	/* Trying to set right permissions for files to be writeable */        
	@chmod (PUN_ROOT.'include/parser.php', 0640);

	if (is_writable(PUN_ROOT.'include/parser.php')) {	      
		$file_content = file_get_contents(PUN_ROOT.'include/parser.php');
		$search = array(
			"\n\t\$pattern[] = '%\[h=([^\[]+?)\](.*?)\[/h\]%ms';",
			"\n\t\$replace[] = '</p><h5 id=\"\$1\"><a href=\"#\$1\">#</a> \$2</h5><p>';"
		);
		$replacement = '';
		$file_content = str_replace ($search, $replacement, $file_content);
		$fp = fopen (PUN_ROOT.'include/parser.php', 'wb');
		fwrite ($fp, $file_content);
		fclose ($fp);
		// Changing config data
		$ezbbc_config['h_id'] = 'no_h_id';
		generate_ezbbc_config();
	}
}

/* Video disabling */
if (isset($_POST['video_disable']) || isset($_POST['disable'])) {
	/* Trying to set right permissions for files to be writeable */        
	@chmod (PUN_ROOT.'include/parser.php', 0640);

	if (is_writable(PUN_ROOT.'include/parser.php')) {	      
		$file_content = file_get_contents(PUN_ROOT.'include/parser.php');
		$search = array(
			"video|",
			", 'video'",
			"\n\t\t'video' => array('url'),",
			"\n\trequire PUN_ROOT.'plugins/ezbbc/ezbbc_video_pattern.php';",
			"\n\trequire PUN_ROOT.'plugins/ezbbc/ezbbc_video_replace.php';",
		);
		$replacement = '';
		$file_content = str_replace ($search, $replacement, $file_content);
		$fp = fopen (PUN_ROOT.'include/parser.php', 'wb');
		fwrite ($fp, $file_content);
		fclose ($fp);
		// Changing config data
		$ezbbc_config['video'] = 'no_video';
		generate_ezbbc_config();
	}
}

/* Img upload disabling */
if (isset($_POST['img_upload_disable'])) {
	$ezbbc_config['img_upload'] = 'no_img_upload';
	generate_ezbbc_config();       
}        

/* Img listing disabling */
if (isset($_POST['img_list_disable'])) {
	$ezbbc_config['img_list'] = 'no_img_list';
	generate_ezbbc_config();       
}

/* doc upload disabling */
if (isset($_POST['doc_upload_disable'])) {
	$ezbbc_config['doc_upload'] = 'no_doc_upload';
	generate_ezbbc_config();        
}

/* Doc listing disabling */
if (isset($_POST['doc_list_disable'])) {
	$ezbbc_config['doc_list'] = 'no_doc_list';
	generate_ezbbc_config();       
}

/* **************************************************************************************** */
/* Beginning the page displaying                                                            */
/* **************************************************************************************** */

/* Display the admin navigation menu */
/* ********************************* */
	generate_admin_menu($plugin);

/* Display the EZBBC Tolbar admin page */
/* ************************************** */
?>
	<div id="ezbbc" class="plugin blockform">
		<h2><span><?php echo $lang_ezbbc['Plugin title'] ?></span></h2>
		<h3><span><?php echo $lang_ezbbc['Description title'] ?></span></h3>
		<div class="box">
		<p>
		<?php echo ($lang_ezbbc['Explanation']) ?><br />
		<?php if (file_exists('plugins/ezbbc/style/'.$ezbbc_config['style_folder'].'/images/help.png')): ?>
		<img src="plugins/ezbbc/style/<?php echo $ezbbc_config['style_folder'] ?>/images/help.png" alt="<?php echo $lang_ezbbc['Toolbar help'] ?>" />  
		<?php endif; ?>
		<a class="toolbar_help" href="<?php echo $help_file_path ?>" title="<?php echo $lang_ezbbc['Toolbar help'] ?>" onclick="window.open(this.href, 'Toolbar_help', 'height=400, width=750, top=50, left=50, toolbar=yes, menubar=yes, location=no, resizable=yes, scrollbars=yes, status=no'); return false;"><?php echo $lang_ezbbc['Toolbar help title'] ?></a>
		</p>
		</div>

		<h3><span><?php echo $lang_ezbbc['Form title'] ?></span></h3>
		<div class="box">
			<form id="ezbbcform" name="ezbbcform" method="post" action="<?php echo pun_htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
				<div class="inform">
				        
					<fieldset>
						<legend><?php echo $lang_ezbbc['Legend status'] ?></legend>
						<div class="infldset">
						<ul>
						    <li><?php echo $lang_ezbbc['Plugin version'].' '.$plugin_version ?></li>
							<li><?php echo $lang_ezbbc['Installation date'] ?> <?php echo $install_date ?></li>
							<li><?php echo $lang_ezbbc['Available languages'] ?> 
							<?php //retrieving the language folder name and flags
							$lang_folders = opendir(PUN_ROOT.'plugins/ezbbc/lang');
							while(false !== ($lang_folder = readdir($lang_folders))) {
							        if ($lang_folder != '.' && $lang_folder != '..' && is_dir('plugins/ezbbc/lang/'.$lang_folder)) {
							                $lang_flag_path = file_exists(PUN_ROOT.'plugins/ezbbc/style/admin/flags/'.strtolower($lang_folder).'.png') ? 'plugins/ezbbc/style/admin/flags/'.strtolower($lang_folder).'.png' : 'plugins/ezbbc/style/admin/flags/no_flag.png';
							                $alt_lang = $lang_folder;
							                $lang_folder = ($lang_folder == $ezbbc_lang_folder) ? '<strong>'.$lang_folder.'</strong>' : $lang_folder;
							                echo '<img src="'.$lang_flag_path.'" alt="'.$alt_lang.' flag" /> '.$lang_folder.' ';
							        }
							}
							closedir($lang_folders);
							?>
							</li>
							<li><?php echo $lang_ezbbc['Plugin status'] ?> <?php echo $ezbbc_plugin_status ?></li>
						</ul>
						<p>
						<?php if ($ezbbc_config['status'] == '0' || $wrong_install): ?>
						<input type="submit" name="enable" value="<?php echo $lang_ezbbc['Enable'] ?>" />
						<?php else: ?>
						<input type="submit" name="disable" value="<?php echo $lang_ezbbc['Disable'] ?>" />
						<?php endif; ?>
						</p>
						</div>
					</fieldset>
					
					<fieldset>
						<legend><?php echo $lang_ezbbc['Legend style'] ?></legend>
						<div class="infldset">
						<p>
						 <input type="submit" name="style_change" value="<?php echo $lang_ezbbc['Change style'] ?>" />
						 </p>
						<?php //Displaying the current style
						$smilies_style = ($ezbbc_config['smilies_set'] == "ezbbc_smilies") ? $lang_ezbbc['EZBBC smilies'] : $lang_ezbbc['Default smilies'];
						echo '<p style="text-align: center; border: #DDD 1px solid; background: #FFF;">'.$lang_ezbbc['Current style'].' <span style="color: #008000; font-weight: bold;">'.$ezbbc_config['style_folder'].'</span> ['.$lang_ezbbc['Buttons'].'] - <span style="color: #008000;font-weight: bold;">'.$smilies_style.'</span></p>';
						?>
						<h4 style="padding-bottom: 0; border-bottom: #DDD 2px solid;"><?php echo $lang_ezbbc['Buttons'] ?></h4>
						<script type="text/javascript" src="plugins/ezbbc/ezbbctoolbar.js"></script>
						<?php
						$style_folders = opendir(PUN_ROOT.'plugins/ezbbc/style');
						while(false !== ($style_folder = readdir($style_folders))) {
						        if ($style_folder != '.' && $style_folder != '..' && file_exists(PUN_ROOT.'plugins/ezbbc/style/'.$style_folder.'/ezbbc.css')) {
						                $unsorted_style_folders[] = $style_folder;
						        }
						}
						closedir($style_folders);
                        // Sorting sttyle folder names
                        natcasesort($unsorted_style_folders);
                        $sorted_style_folders = $unsorted_style_folders;
                        $folder_count = count($sorted_style_folders);
                        $i = 0;
                        foreach ($sorted_style_folders as $style_folder) {
                            @chmod (PUN_ROOT.'plugins/ezbbc/style/'.$style_folder.'/ezbbc.css', 0664);
                            // Selection of several data to display the style folder and their management
                            $radio_value = ($style_folder == $ezbbc_config['style_folder'])?'<strong style="background: url(plugins/ezbbc/style/admin/style/ok.png) no-repeat left center; padding-left: 18px; color: green;"><input type="radio" value="'.$style_folder.'" name="ezbbc_style" checked="checked" />'.$style_folder.'</strong>':'<input type="radio" value="'.$style_folder.'" name="ezbbc_style" /><span style="color: grey">'.$style_folder.'</span>';
                            $edit_css = (is_writable(PUN_ROOT.'plugins/ezbbc/style/'.$style_folder.'/ezbbc.css'))?' <a href="plugins/ezbbc/ezbbc_edit.php?file=style/'.$style_folder.'/ezbbc.css" onclick="window.open(this.href, \'CSS Edition\', \'height=520, width=660, top=80, left=80, toolbar=no, menubar=no, location=no, resizable=yes, scrollbars=no, status=no\'); return false;" title="'.$lang_ezbbc['Edit css'].'"><img src="plugins/ezbbc/style/admin/buttons/edit.png" alt="'.$lang_ezbbc['Edit css'].'" /></a>':'';
                                $rename_folder = ((substr(decoct(@fileperms(PUN_ROOT.'plugins/ezbbc/style/')),2) == 777) || (@chmod (PUN_ROOT.'plugins/ezbbc/style/', 0777)) && ((substr(decoct(@fileperms(PUN_ROOT.'plugins/ezbbc/style/'.$style_folder)),2) == 777) || (@chmod (PUN_ROOT.'plugins/ezbbc/style/'.$style_folder, 0777))) && ($style_folder != $ezbbc_config['style_folder']))?'<span id="rfield_'.$style_folder.'" style="display: none;"> <input type="text" name="rename'.$i.'" value="'.$style_folder.'" /> <input type="hidden" name="folder_name'.$i.'" value="'.$style_folder.'" /><input type="submit" name="vrename'.$i.'" value="'.$lang_ezbbc['OK'].'" /></span> <a href="#rfield_'.$style_folder.'" onclick="visibility(\'rfield_'.$style_folder.'\'); return false;" title="'.$lang_ezbbc['Rename'].'"><img src="plugins/ezbbc/style/admin/buttons/rename.png" alt="'.$lang_ezbbc['Rename'].'" /></a>':'';
                                $copy_folder = ((substr(decoct(@fileperms(PUN_ROOT.'plugins/ezbbc/style/')),2) == 777) || (@chmod (PUN_ROOT.'plugins/ezbbc/style/', 0777)))?' <a href="admin_loader.php?plugin=AP_EZBBC_Toolbar.php&amp;style_folder='.$style_folder.'&amp;copy=yes" title="'.$lang_ezbbc['Copy'].'"><img src="plugins/ezbbc/style/admin/buttons/copy.png" alt="'.$lang_ezbbc['Copy'].'" /></a>':'';
                                $remove_folder = (((substr(decoct(@fileperms(PUN_ROOT.'plugins/ezbbc/style/')),2) == 777) || (@chmod (PUN_ROOT.'plugins/ezbbc/style/', 0777))) && ((substr(decoct(@fileperms(PUN_ROOT.'plugins/ezbbc/style/'.$style_folder)),2) == 777) || (@chmod (PUN_ROOT.'plugins/ezbbc/style/'.$style_folder, 0777))) && ((substr(decoct(@fileperms(PUN_ROOT.'plugins/ezbbc/style/'.$style_folder.'/images/')),2) == 777) || (@chmod (PUN_ROOT.'plugins/ezbbc/style/'.$style_folder.'/images/', 0777))) && ((substr(decoct(@fileperms(PUN_ROOT.'plugins/ezbbc/style/'.$style_folder.'/index.html')),2) == 777) || (@chmod (PUN_ROOT.'plugins/ezbbc/style/'.$style_folder.'/index.html', 0777))) && ((substr(decoct(@fileperms(PUN_ROOT.'plugins/ezbbc/style/'.$style_folder.'/ezbbc.css')),2) == 777) || (@chmod (PUN_ROOT.'plugins/ezbbc/style/'.$style_folder.'/ezbbc.css', 0777))) && ($style_folder != $ezbbc_config['style_folder']))?' <a href="admin_loader.php?plugin=AP_EZBBC_Toolbar.php&amp;style_folder='.$style_folder.'&amp;remove=yes" onclick="return window.confirm(\''.$lang_ezbbc['Remove confirm'].'\')" title="'.$lang_ezbbc['Remove'].'"><img src="plugins/ezbbc/style/admin/buttons/remove.png" alt="'.$lang_ezbbc['Remove'].'" /></a>':'';
                                $preview_screenshot = (file_exists(PUN_ROOT.'plugins/ezbbc/style/'.$style_folder.'/images/preview.png'))?'<img src="plugins/ezbbc/style/'.$style_folder.'/images/preview.png" alt="'.$lang_ezbbc['Toolbar preview'].'" style="border: #DDD 1px groove;"/>':$lang_ezbbc['No preview'];
                                echo '<dl>'."\n";
                                echo '<dt>'.$radio_value.$rename_folder.$edit_css.$copy_folder.$remove_folder.'</dt>'."\n";
						    echo '<dd>'.$preview_screenshot.'</dd>'."\n";
						    echo '</dl>'."\n";
						    $i++;
						}
						echo '<input type="hidden" name="folder_count" value="'.$folder_count.'" />'
						?>
						
						<h4 style="padding-bottom: 0; border-bottom: #DDD 2px solid;"><?php echo $lang_ezbbc['Smilies'] ?></h4>
						<?php
						// Retrieving the smilies icons and defining the image list for each set
						//Default FluxBB smilies
						$default_smilies_images = '';
						$icons = opendir(PUN_ROOT.'img/smilies');
						while(false !== ($icon = readdir($icons))) {
						    if ($icon != '.' && $icon != '..' && substr($icon, -3) == 'png') {
								$icon_path = 'img/smilies/'.$icon;
								$default_smilies_images .= '<img src="'.$icon_path.'" alt="'.$lang_ezbbc['Smiley'].'" /> ';
						    }
						}
						closedir($icons);
						//EZBBC smilies
						$ezbbc_config['smilies_images'] = '';
						$icons = opendir(PUN_ROOT.'plugins/ezbbc/style/smilies');
						while(false !== ($icon = readdir($icons))) {
						    if ($icon != '.' && $icon != '..' && substr($icon, -3) == 'png') {
						        $icon_path = 'plugins/ezbbc/style/smilies/'.$icon;
						        $ezbbc_config['smilies_images'] .= '<img src="'.$icon_path.'" alt="'.$lang_ezbbc['Smiley'].'" /> ';
						    }
						}
						closedir($icons);
						//Displaying the two sets
						 if ($ezbbc_config['smilies_set'] == "fluxbb_default_smilies") {
						    echo '<dl>'."\n";
						    echo '<dt style="background: url(plugins/ezbbc/style/admin/style/ok.png) no-repeat left center; padding-left: 18px; color: green;"><input type="radio" value="fluxbb_default_smilies" name="fluxbb_default_smilies_set" checked="checked" /><strong>'.$lang_ezbbc['Default smilies'].'</strong></dt>'."\n";
						    echo '<dd>'.$default_smilies_images.'</dd>'."\n";
						    echo '<dt style="color: grey"><input type="radio" value="ezbbc_smilies" name="ezbbc_smilies_set" />'.$lang_ezbbc['EZBBC smilies'].'</dt>'."\n";
						    echo '<dd>'.$ezbbc_config['smilies_images'].'</dd>'."\n";
						    echo '</dl>'."\n";
						 } else {
						    echo '<dl>'."\n";
						    echo '<dt style="color: grey"><input type="radio" value="fluxbb_default_smilies" name="ezbbc_smilies_set"  />'.$lang_ezbbc['Default smilies'].'</dt>'."\n";
						    echo '<dd>'.$default_smilies_images.'</dd>'."\n";
						    echo '<dt style="background: url(plugins/ezbbc/style/admin/style/ok.png) no-repeat left center; padding-left: 18px; color: green;"><input type="radio" value="ezbbc_smilies" name="ezbbc_smilies_set" checked="checked" /><strong>'.$lang_ezbbc['EZBBC smilies'].'</strong></dt>'."\n";
						    echo '<dd>'.$ezbbc_config['smilies_images'].'</dd>'."\n";
						    echo '</dl>'."\n";
						 }
						?>
						<?php //Displaying the current style
						$smilies_style = ($ezbbc_config['smilies_set'] == "ezbbc_smilies") ? $lang_ezbbc['EZBBC smilies'] : $lang_ezbbc['Default smilies'];
						echo '<p style="text-align: center; border: #DDD 1px solid; background: #FFF;">'.$lang_ezbbc['Current style'].' <span style="color: #008000; font-weight: bold;">'.$ezbbc_config['style_folder'].'</span> ['.$lang_ezbbc['Buttons'].'] - <span style="color: #008000;font-weight: bold;">'.$smilies_style.'</span></p>';
						?>
						 <p>
						 <input type="submit" name="style_change" value="<?php echo $lang_ezbbc['Change style'] ?>" />
						 </p>
						 </div>
					</fieldset>
					
					<fieldset>
					<legend><?php echo $lang_ezbbc['Legend advanced features'] ?></legend>
						<div class="infldset">
						
						<dl style="margin: 10px 5px;">
						<dt style="padding-bottom: 0; margin-bottom: 5px; font-weight: bold; border-bottom: #DDD 2px solid;"><?php echo $lang_ezbbc['Button selection title'] ?></dt>
						        <dd>
						        <input type="checkbox" name="b" <?php if ($ezbbc_config['b'] == 'b') echo 'checked="checked" '; ?>/> <?php echo $lang_ezbbc['Bold title'] ?><br />
						        <input type="checkbox" name="u" <?php if ($ezbbc_config['u'] == 'u') echo 'checked="checked" '; ?>/> <?php echo $lang_ezbbc['Underline title'] ?><br />
						        <input type="checkbox" name="i" <?php if ($ezbbc_config['i'] == 'i') echo 'checked="checked" '; ?>/> <?php echo $lang_ezbbc['Italic title'] ?><br />
						        <input type="checkbox" name="s" <?php if ($ezbbc_config['s'] == 's') echo 'checked="checked" '; ?>/> <?php echo $lang_ezbbc['Strike-through title'] ?><br />
						        <input type="checkbox" name="del" <?php if ($ezbbc_config['del'] == 'del') echo 'checked="checked" '; ?>/> <?php echo $lang_ezbbc['Delete title'] ?><br />
						        <input type="checkbox" name="ins" <?php if ($ezbbc_config['ins'] == 'ins') echo 'checked="checked" '; ?>/> <?php echo $lang_ezbbc['Insert title'] ?><br />
						        <input type="checkbox" name="em" <?php if ($ezbbc_config['em'] == 'em') echo 'checked="checked" '; ?>/> <?php echo $lang_ezbbc['Emphasis title'] ?><br />
						        <input type="checkbox" name="color" <?php if ($ezbbc_config['color'] == 'color') echo 'checked="checked" '; ?>/> <?php echo $lang_ezbbc['Colorize title'] ?><br />
						        <input type="checkbox" name="heading" <?php if ($ezbbc_config['heading'] == 'heading') echo 'checked="checked" '; ?>/> <?php echo $lang_ezbbc['Heading title'] ?><br />
						        <input type="checkbox" name="url" <?php if ($ezbbc_config['url'] == 'url') echo 'checked="checked" '; ?>/> <?php echo $lang_ezbbc['URL title'] ?><br />
						        <input type="checkbox" name="email" <?php if ($ezbbc_config['email'] == 'email') echo 'checked="checked" '; ?>/> <?php echo $lang_ezbbc['E-mail title'] ?><br />
						        <input type="checkbox" name="img" <?php if ($ezbbc_config['img'] == 'img') echo 'checked="checked" '; ?>/> <?php echo $lang_ezbbc['Image title'] ?><br />
						        <input type="checkbox" name="quote" <?php if ($ezbbc_config['quote'] == 'quote') echo 'checked="checked" '; ?>/> <?php echo $lang_ezbbc['Quote title'] ?><br />
						        <input type="checkbox" name="code" <?php if ($ezbbc_config['code'] == 'code') echo 'checked="checked" '; ?>/> <?php echo $lang_ezbbc['Code title'] ?><br />
						        <input type="checkbox" name="ulist" <?php if ($ezbbc_config['ulist'] == 'ulist') echo 'checked="checked" '; ?>/> <?php echo $lang_ezbbc['Unordered List title'] ?><br />
						        <input type="checkbox" name="olist" <?php if ($ezbbc_config['olist'] == 'olist') echo 'checked="checked" '; ?>/> <?php echo $lang_ezbbc['Ordered List title'] ?><br />
						        <input type="checkbox" name="alist" <?php if ($ezbbc_config['alist'] == 'alist') echo 'checked="checked" '; ?>/> <?php echo $lang_ezbbc['Alphabetical Ordered List title'] ?><br />
						        <input type="checkbox" name="smiliesb" <?php if ($ezbbc_config['smiliesb'] == 'smiliesb') echo 'checked="checked" '; ?>/> <?php echo $lang_ezbbc['Smilies toggle title'] ?><br />
						        <input type="checkbox" name="help" <?php if ($ezbbc_config['help'] == 'help') echo 'checked="checked" '; ?>/> <?php echo $lang_ezbbc['Toolbar help title'] ?><br />
						        </dd>
						        <dd>
						        <input type="submit" name="button_selection" value="<?php echo $lang_ezbbc['Set'] ?>" />
						        </dd>
						</dl>
						<dl style="margin: 10px 5px;">
						<dt style="padding-bottom: 0; margin-bottom: 5px; font-weight: bold; border-bottom: #DDD 2px solid;"><?php echo $lang_ezbbc['Toolbar display'] ?></dt>
						        <dd>
						        <?php if ($ezbbc_config['post_toolbar'] == 'no_post_toolbar'): ?>
						        <span style="color: grey; background: url(plugins/ezbbc/style/admin/style/no.png) no-repeat left center; padding-left: 18px;"><?php echo $lang_ezbbc['Display on post edit'] ?></span>
						        <input type="submit" name="post_toolbar_enable" value="<?php echo $lang_ezbbc['Yes'] ?>" />
						        <?php else: ?>
						        <span style="color: #008000; background: url(plugins/ezbbc/style/admin/style/ok.png) no-repeat left center; padding-left: 22px;"><?php echo $lang_ezbbc['Display on post edit ok'] ?></span>
						        <input type="submit" name="post_toolbar_disable" value="<?php echo $lang_ezbbc['No'] ?>" />
						        <?php endif; ?>
						        </dd>
						        <dd>
						        <?php if ($ezbbc_config['quickpost_toolbar'] == 'no_quickpost_toolbar'): ?>
						        <span style="color: grey; background: url(plugins/ezbbc/style/admin/style/no.png) no-repeat left center; padding-left: 18px;"><?php echo $lang_ezbbc['Display on quickpost'] ?></span>
						        <input type="submit" name="quickpost_toolbar_enable" value="<?php echo $lang_ezbbc['Yes'] ?>" />
						        <?php else: ?>
						        <span style="color: #008000; background: url(plugins/ezbbc/style/admin/style/ok.png) no-repeat left center; padding-left: 22px;"><?php echo $lang_ezbbc['Display on quickpost ok'] ?></span>
						        <input type="submit" name="quickpost_toolbar_disable" value="<?php echo $lang_ezbbc['No'] ?>" />
						        <?php endif; ?>
						        </dd>
						        <dd>
						        <?php if ($ezbbc_config['signature_toolbar'] == 'no_signature_toolbar'): ?>
						        <span style="color: grey; background: url(plugins/ezbbc/style/admin/style/no.png) no-repeat left center; padding-left: 18px;"><?php echo $lang_ezbbc['Display on signature'] ?></span>
						        <input type="submit" name="signature_toolbar_enable" value="<?php echo $lang_ezbbc['Yes'] ?>" />
						        <?php else: ?>
						        <span style="color: #008000; background: url(plugins/ezbbc/style/admin/style/ok.png) no-repeat left center; padding-left: 22px;"><?php echo $lang_ezbbc['Display on signature ok'] ?></span>
						        <input type="submit" name="signature_toolbar_disable" value="<?php echo $lang_ezbbc['No'] ?>" />
						        <?php endif; ?>
						        </dd>
						</dl>
						
						<dl style="margin: 10px 5px;">
						<dt style="padding-bottom: 0; margin-bottom: 5px; font-weight: bold; border-bottom: #DDD 2px solid;"><?php echo $lang_ezbbc['SmiliesBar position'] ?></dt>
						        <?php if ($ezbbc_config['smiliesbar_position'] == 'sb_over_tb'): ?>
						        <dd style="color: #008000; background: url(plugins/ezbbc/style/admin/style/ok.png) no-repeat left center; padding-left: 18px;">
						        <input type="radio" value="sb_over_tb" name="smiliesbar_position" checked="checked" /><?php echo $lang_ezbbc['SmiliesBar over Toolbar'] ?>
						        </dd>
						        <?php else: ?>
						        <dd style="color: grey; padding-left: 18px;">
						        <input type="radio" value="sb_over_tb" name="smiliesbar_position" /><?php echo $lang_ezbbc['SmiliesBar over Toolbar'] ?>
						        </dd>
						        <?php endif; ?>
						        <?php if ($ezbbc_config['smiliesbar_position'] == 'sb_under_tb'): ?>
						        <dd style="color: #008000; background: url(plugins/ezbbc/style/admin/style/ok.png) no-repeat left center; padding-left: 18px;">
						        <input type="radio" value="sb_under_tb" name="smiliesbar_position" checked="checked" /><?php echo $lang_ezbbc['SmiliesBar under Toolbar'] ?>
						        </dd>
						        <?php else: ?>
						        <dd style="color: grey; padding-left: 18px;">
						        <input type="radio" value="sb_under_tb" name="smiliesbar_position" /><?php echo $lang_ezbbc['SmiliesBar under Toolbar'] ?>
						        </dd>
						        <?php endif; ?>
						        <?php if ($ezbbc_config['smiliesbar_position'] == 'sb_under_texta'): ?>
						        <dd style="color: #008000; background: url(plugins/ezbbc/style/admin/style/ok.png) no-repeat left center; padding-left: 18px;">
						        <input type="radio" value="sb_under_texta" name="smiliesbar_position" checked="checked" /><?php echo $lang_ezbbc['SmiliesBar under Textarea'] ?>
						        </dd>
						        <?php else: ?>
						        <dd style="color: grey; padding-left: 18px;">
						        <input type="radio" value="sb_under_texta" name="smiliesbar_position" /><?php echo $lang_ezbbc['SmiliesBar under Textarea'] ?>
						        </dd>
						        <?php endif; ?>
						        <dd>
						        <input type="submit" name="sb_pos_valid" value="<?php echo $lang_ezbbc['Set'] ?>"/>
						        </dd>
						</dl>
						
						<dl style="margin: 10px 5px;">
						<dt style="padding-bottom: 0; margin-bottom: 5px; font-weight: bold; border-bottom: #DDD 2px solid;"><?php echo $lang_ezbbc['Bars position'] ?></dt>
						        <dd>
						        <?php if ($ezbbc_config['bars_position'] == 'bars_left'): ?>
						        <span style="color: #008000; background: url(plugins/ezbbc/style/admin/style/ok.png) no-repeat left center; padding-left: 18px;">
						        <input type="radio" value="bars_left" name="bars_position" checked="checked" /><?php echo $lang_ezbbc['Left'] ?></span> 
						        <span style="color: grey;"><input type="radio" value="bars_right" name="bars_position" /><?php echo $lang_ezbbc['Right'] ?></span> 
						        <?php else: ?>
						        <span style="color: grey;"><input type="radio" value="bars_left" name="bars_position" /><?php echo $lang_ezbbc['Left'] ?></span>
						        <span style="color: #008000; background: url(plugins/ezbbc/style/admin/style/ok.png) no-repeat left center; padding-left: 18px;"><input type="radio" value="bars_right" name="bars_position" checked="checked" /><?php echo $lang_ezbbc['Right'] ?></span>
						        <?php endif; ?>
						        <input type="submit" name="bars_pos_valid" value="<?php echo $lang_ezbbc['Set'] ?>"/>
						        </dd>
						</dl>
						
						<dl style="margin: 10px 5px;">
						<dt style="padding-bottom: 0; margin-bottom: 5px; font-weight: bold; border-bottom: #DDD 2px solid;"><?php echo $lang_ezbbc['Syntax Highlight title'] ?></dt>
						<?php
						@chmod (PUN_ROOT.'plugins/ezbbc/prism/prism.css', 0640);
						// Generating the css edit button
						$edit_prism_css = (is_writable(PUN_ROOT.'plugins/ezbbc/prism/prism.css'))?' <a href="plugins/ezbbc/ezbbc_edit.php?file=prism/prism.css" onclick="window.open(this.href, \'CSS Edition\', \'height=520, width=660, top=80, left=80, toolbar=no, menubar=no, location=no, resizable=yes, scrollbars=no, status=no\'); return false;" title="'.$lang_ezbbc['Edit css'].'"><img src="plugins/ezbbc/style/admin/buttons/edit.png" alt="'.$lang_ezbbc['Edit css'].'" /></a>':'';
						?>
						        <dd>
						        <?php if ($ezbbc_config['syntax_highlight'] == 'no_syntax_highlight'): ?>
						        <span style="color: grey; background: url(plugins/ezbbc/style/admin/style/no.png) no-repeat left center; padding-left: 18px;"><?php echo $lang_ezbbc['Syntax Highlight'] ?></span>
						        <input type="submit" name="syntax_highlight_enable" value="<?php echo $lang_ezbbc['Yes'] ?>" />
						        <?php else: ?>
						        <span style="color: #008000; background: url(plugins/ezbbc/style/admin/style/ok.png) no-repeat left center; padding-left: 22px;"><?php echo $lang_ezbbc['Syntax Highlight ok'] ?></span>
						        <input type="submit" name="syntax_highlight_disable" value="<?php echo $lang_ezbbc['No'] ?>" />
						        <?php endif; ?>
						        <?php echo $edit_prism_css ?>
						        </dd>
						</dl>
						
						<dl style="margin: 10px 5px;">
						<dt style="padding-bottom: 0; margin-bottom: 5px; font-weight: bold; border-bottom: #DDD 2px solid;"><?php echo $lang_ezbbc['H id title'] ?></dt>
						        <dd>
						        <?php if ($ezbbc_config['h_id'] == 'no_h_id'): ?>
						        <span style="color: grey; background: url(plugins/ezbbc/style/admin/style/no.png) no-repeat left center; padding-left: 18px;"><?php echo $lang_ezbbc['H id'] ?></span>
						        <input type="submit" name="h_id_enable" value="<?php echo $lang_ezbbc['Yes'] ?>" />
						        <?php else: ?>
						        <span style="color: #008000; background: url(plugins/ezbbc/style/admin/style/ok.png) no-repeat left center; padding-left: 22px;"><?php echo $lang_ezbbc['H id ok'] ?></span>
						        <input type="submit" name="h_id_disable" value="<?php echo $lang_ezbbc['No'] ?>" />
						        <?php endif; ?>
						        </dd>
						</dl>
						
						<dl style="margin: 10px 5px;">
						<dt style="padding-bottom: 0; margin-bottom: 5px; font-weight: bold; border-bottom: #DDD 2px solid;"><?php echo $lang_ezbbc['Video add title'] ?></dt>
						        <dd>
						        <?php if ($ezbbc_config['video'] == 'no_video'): ?>
						        <span style="color: grey; background: url(plugins/ezbbc/style/admin/style/no.png) no-repeat left center; padding-left: 18px;"><?php echo $lang_ezbbc['Video add'] ?></span>
						        <input type="submit" name="video_enable" value="<?php echo $lang_ezbbc['Yes'] ?>" />
						        <?php else: ?>
						        <span style="color: #008000; background: url(plugins/ezbbc/style/admin/style/ok.png) no-repeat left center; padding-left: 22px;"><?php echo $lang_ezbbc['Video add ok'] ?></span>
						        <input type="submit" name="video_disable" value="<?php echo $lang_ezbbc['No'] ?>" />
						        <?php endif; ?>
						        </dd>
						</dl>
						
						<dl style="margin: 10px 5px;">
						<dt style="padding-bottom: 0; margin-bottom: 5px; font-weight: bold; border-bottom: #DDD 2px solid;"><?php echo $lang_ezbbc['Image upload title'] ?> <?php echo $config_data_err ?></dt>
						        <dd>
						        <?php if ($ezbbc_config['img_upload'] == 'no_img_upload'): ?>
						        <span style="color: grey; background: url(plugins/ezbbc/style/admin/style/no.png) no-repeat left center; padding-left: 18px;"><?php echo $lang_ezbbc['Image upload'] ?></span>
						        <input type="submit" name="img_upload_enable" value="<?php echo $lang_ezbbc['Yes'] ?>" />
						        <?php else: ?>
						        <span style="color: #008000; background: url(plugins/ezbbc/style/admin/style/ok.png) no-repeat left center; padding-left: 22px;"><?php echo $lang_ezbbc['Image upload ok'] ?></span>
						        <input type="submit" name="img_upload_disable" value="<?php echo $lang_ezbbc['No'] ?>" />
						        <?php endif; ?>
						        </dd>
						        
						        <?php if ($ezbbc_config['img_upload'] == 'img_upload'): ?>
						        <dd style="padding: 2px 20px;"><?php echo $lang_ezbbc['Folder'] ?>
						        <input type="text" name="img_folder" value="<?php echo $ezbbc_config['img_folder'] ?>" /> <input type="submit" name="img_folder_set" value="<?php echo $lang_ezbbc['Set'] ?>" /><?php echo $img_folder_err ?>
						        </dd>
						        
						        <dd style="padding: 2px 20px;"><?php echo $lang_ezbbc['Max img upload user'] ?>
						        <input size="3" type="text" name="img_limit" value="<?php echo $ezbbc_config['img_limit'] ?>" /> <?php echo $lang_ezbbc['For moderators'] ?> <input size="3" type="text" name="img_limit_mod" value="<?php echo $ezbbc_config['img_limit_mod'] ?>" /> (<?php echo '0 = '.$lang_ezbbc['unlimited'] ?>) <input type="submit" name="img_limit_set" value="<?php echo $lang_ezbbc['Set'] ?>" />
						        </dd>
						        
						        <dd style="padding: 2px 20px;"><?php echo $lang_ezbbc['Max size'] ?>
						        <input size="4" type="text" name="max_img_size" value="<?php echo $ezbbc_config['max_img_size'] ?>" /><?php echo $lang_ezbbc['Kb'] ?>
						         (&lt;<?php echo ($max_file_size_php/1024).$lang_ezbbc['Kb'].' - '.$lang_ezbbc['Max size adminmod'].($max_file_size_php/1024).$lang_ezbbc['Kb'] ?>)
						         <input type="submit" name="max_img_size_set" value="<?php echo $lang_ezbbc['Set'] ?>" />
						        </dd>
						        
						        <?php if (function_exists('gd_info')) : $gd = gd_info(); if (($gd["JPEG Support"] || $gd["JPG Support"]) && $gd["PNG Support"] && $gd["GIF Read Support"]): ?> 
						        <dd style="padding: 2px 20px;"><?php echo $lang_ezbbc['Max img width'] ?>
						        <input size="4" type="text" name="max_img_width" value="<?php echo $ezbbc_config['max_img_width'] ?>" /><?php echo $lang_ezbbc['px'] ?> <input type="submit" name="max_img_width_set" value="<?php echo $lang_ezbbc['Set'] ?>" />
						        </dd>
						        <?php endif; endif; ?>
						        
						        <dd style="padding: 2px 20px;">
						        <?php if ($ezbbc_config['img_list'] == 'no_img_list'): ?>
						        <span style="color: grey; background: url(plugins/ezbbc/style/admin/style/no.png) no-repeat left center; padding-left: 18px;"><?php echo $lang_ezbbc['Files listing'] ?></span>
						        <input type="submit" name="img_list_enable" value="<?php echo $lang_ezbbc['Yes'] ?>" />
						        <?php else: ?>
						        <span style="color: #008000; background: url(plugins/ezbbc/style/admin/style/ok.png) no-repeat left center; padding-left: 22px;"><?php echo $lang_ezbbc['Files listing ok'] ?></span>
						        <input type="submit" name="img_list_disable" value="<?php echo $lang_ezbbc['No'] ?>" />
						        <?php endif; ?>
						        </dd>
						        <?php endif; ?>
						</dl>
						
						<dl style="margin: 10px 5px;">
						<dt style="padding-bottom: 0; margin-bottom: 5px; font-weight: bold; border-bottom: #DDD 2px solid;"><?php echo $lang_ezbbc['Doc upload title'] ?> <?php echo $config_data_err ?></dt>
						        <dd>
						        <?php if ($ezbbc_config['doc_upload'] == 'no_doc_upload'): ?>
						        <span style="color: grey; background: url(plugins/ezbbc/style/admin/style/no.png) no-repeat left center; padding-left: 18px;"><?php echo $lang_ezbbc['Doc upload'] ?></span>
						        <input type="submit" name="doc_upload_enable" value="<?php echo $lang_ezbbc['Yes'] ?>" />
						        <?php else: ?>
						        <span style="color: #008000; background: url(plugins/ezbbc/style/admin/style/ok.png) no-repeat left center; padding-left: 22px;"><?php echo $lang_ezbbc['Doc upload ok'] ?></span>
						        <input type="submit" name="doc_upload_disable" value="<?php echo $lang_ezbbc['No'] ?>" />
						        <?php endif; ?>
						        </dd>
						        
						        <?php if ($ezbbc_config['doc_upload'] == 'doc_upload'): ?>
                                                        <dd style="padding: 2px 20px;"><?php echo $lang_ezbbc['Folder'] ?>
						        <input type="text" name="doc_folder" value="<?php echo $ezbbc_config['doc_folder'] ?>" /> <input type="submit" name="doc_folder_set" value="<?php echo $lang_ezbbc['Set'] ?>" /><?php echo $doc_folder_err ?>
						        </dd>
						        
						        <dd style="padding: 2px 20px;"><?php echo $lang_ezbbc['Max doc upload user'] ?>
						        <input size="3" type="text" name="doc_limit" value="<?php echo $ezbbc_config['doc_limit'] ?>" /> <?php echo $lang_ezbbc['For moderators'] ?> <input size="3" type="text" name="doc_limit_mod" value="<?php echo $ezbbc_config['doc_limit_mod'] ?>" /> (<?php echo '0 = '.$lang_ezbbc['unlimited'] ?>) <input type="submit" name="doc_limit_set" value="<?php echo $lang_ezbbc['Set'] ?>" />
						        </dd>
						        
						        <dd style="padding: 2px 20px;"><?php echo $lang_ezbbc['Max size'] ?>
						        <input size="4" type="text" name="max_doc_size" value="<?php echo $ezbbc_config['max_doc_size'] ?>" /><?php echo $lang_ezbbc['Kb'] ?>
						        (&lt;<?php echo ($max_file_size_php/1024).$lang_ezbbc['Kb'].' - '.$lang_ezbbc['Max size adminmod'].($max_file_size_php/1024).$lang_ezbbc['Kb'] ?>) <input type="submit" name="max_doc_size_set" value="<?php echo $lang_ezbbc['Set'] ?>" />
						        </dd>
						        
						        <dd style="padding: 2px 20px;"><?php echo $lang_ezbbc['Allowed ext'] ?><input  size="50" type="text" name="allowed_ext" value="<?php echo $ezbbc_config['allowed_ext'] ?>" /> <input type="submit" name="allowed_ext_set" value="<?php echo $lang_ezbbc['Set'] ?>" />
						        </dd>
						        
						        <dd style="padding: 2px 20px;">
						        <?php if ($ezbbc_config['doc_list'] == 'no_doc_list'): ?>
						        <span style="color: grey; background: url(plugins/ezbbc/style/admin/style/no.png) no-repeat left center; padding-left: 18px;"><?php echo $lang_ezbbc['Files listing'] ?></span>
						        <input type="submit" name="doc_list_enable" value="<?php echo $lang_ezbbc['Yes'] ?>" />
						        <?php else: ?>
						        <span style="color: #008000; background: url(plugins/ezbbc/style/admin/style/ok.png) no-repeat left center; padding-left: 22px;"><?php echo $lang_ezbbc['Files listing ok'] ?></span>
						        <input type="submit" name="doc_list_disable" value="<?php echo $lang_ezbbc['No'] ?>" />
						        <?php endif; ?>
						        </dd>
						        <?php endif; ?>
						</dl>
						
						<?php if ($ezbbc_config['doc_upload'] == 'doc_upload' || $ezbbc_config['img_upload'] == 'img_upload'): ?>
						<dl style="margin: 10px 5px;">
						<dt style="padding-bottom: 0; margin-bottom: 5px; font-weight: bold; border-bottom: #DDD 2px solid;"><?php echo $lang_ezbbc['File listing title'] ?></dt>
						        <dd style="padding: 2px 20px;">
						        <?php echo $lang_ezbbc['Recent files'] ?> 
						        <select name="listlimit">
                                                                <option>10</option>
                                                                <option>25</option>
                                                                <option>50</option>
                                                                <option>100</option>
                                                        </select>
                                                        <?php echo $lang_ezbbc['Last files'] ?>
                                                        <a title="<?php echo $lang_ezbbc['Display'] ?>" href="#" onclick="window.open('<?php echo $pun_config['o_base_url'] ?>/plugins/ezbbc/listing.php?type=recent&amp;limit=' + document.ezbbcform.listlimit.value , 'Listing', 'height=400, width=750, top=50, left=50, toolbar=yes, menubar=no, location=no, resizable=yes, scrollbars=yes, status=no');return false;"><img src="plugins/ezbbc/style/admin/listing/recent.png" alt="<?php echo $lang_ezbbc['Display'] ?>" /></a> 
                                                        <?php if ($ezbbc_config['doc_upload'] == 'doc_upload' && $ezbbc_config['img_upload'] == 'img_upload'): ?>
                                                        <a title="<?php echo $lang_ezbbc['Display images'] ?>" href="#" onclick="window.open('<?php echo $pun_config['o_base_url'] ?>/plugins/ezbbc/listing.php?type=recent&amp;fselect=img&amp;limit=' + document.ezbbcform.listlimit.value , 'Listing', 'height=400, width=750, top=50, left=50, toolbar=yes, menubar=no, location=no, resizable=yes, scrollbars=yes, status=no');return false;"><img src="plugins/ezbbc/style/admin/listing/img-folder.png" alt="<?php echo $lang_ezbbc['Display images'] ?>" /></a> 
                                                        <a title="<?php echo $lang_ezbbc['Display docs'] ?>" href="#" onclick="window.open('<?php echo $pun_config['o_base_url'] ?>/plugins/ezbbc/listing.php?type=recent&amp;fselect=doc&amp;limit=' + document.ezbbcform.listlimit.value , 'Listing', 'height=400, width=750, top=50, left=50, toolbar=yes, menubar=no, location=no, resizable=yes, scrollbars=yes, status=no');return false;"><img src="plugins/ezbbc/style/admin/listing/doc-folder.png" alt="<?php echo $lang_ezbbc['Display docs'] ?>" /></a>
                                                        <?php endif; ?>
						        </dd>
						        
						        <dd style="padding: 2px 20px;">
						        <?php echo $lang_ezbbc['Files by user'] ?> 
						        <input type="text" size="10" name="username" /> 
						        <?php if ($ezbbc_config['img_upload'] == 'img_upload'): ?>
                                                        <a title="<?php echo $lang_ezbbc['Image folder display'] ?>" href="#" onclick="window.open('<?php echo $pun_config['o_base_url'] ?>/plugins/ezbbc/listing.php?type=folder&amp;uname=' + encodeURIComponent(document.ezbbcform.username.value) + '&amp;ftype=img' , 'Listing', 'height=400, width=750, top=50, left=50, toolbar=yes, menubar=no, location=no, resizable=yes, scrollbars=yes, status=no');return false;"><img src="plugins/ezbbc/style/admin/listing/img-folder.png" alt="<?php echo $lang_ezbbc['Image folder display'] ?>" /></a> 
                                                        <?php endif; ?>
                                                        <?php if ($ezbbc_config['doc_upload'] == 'doc_upload'): ?>
                                                        <a  title="<?php echo $lang_ezbbc['Document folder display'] ?>" href="#" onclick="window.open('<?php echo $pun_config['o_base_url'] ?>/plugins/ezbbc/listing.php?type=folder&amp;uname=' + encodeURIComponent(document.ezbbcform.username.value) + '&amp;ftype=doc' , 'Listing', 'height=400, width=750, top=50, left=50, toolbar=yes, menubar=no, location=no, resizable=yes, scrollbars=yes, status=no');return false;"><img src="plugins/ezbbc/style/admin/listing/doc-folder.png" alt="<?php echo $lang_ezbbc['Document folder display'] ?>" /></a>
                                                        <?php endif; ?>
						        </dd>
						        
						        <dd style="padding: 2px 20px;">
						        <?php echo $lang_ezbbc['Files by id'] ?> 
						        <input type="text" size="5" name="userid" />
						        <?php if ($ezbbc_config['img_upload'] == 'img_upload'): ?>
                                                        <a title="<?php echo $lang_ezbbc['Image folder display'] ?>" href="#" onclick="window.open('<?php echo $pun_config['o_base_url'] ?>/plugins/ezbbc/listing.php?type=folder&amp;id=' + document.ezbbcform.userid.value + '&amp;ftype=img' , 'Listing', 'height=400, width=750, top=50, left=50, toolbar=yes, menubar=no, location=no, resizable=yes, scrollbars=yes, status=no');return false;"><img src="plugins/ezbbc/style/admin/listing/img-folder.png" alt="<?php echo $lang_ezbbc['Image folder display'] ?>" /></a> 
                                                        <?php endif; ?>
                                                        <?php if ($ezbbc_config['doc_upload'] == 'doc_upload'): ?>
                                                        <a title="<?php echo $lang_ezbbc['Document folder display'] ?>" href="#" onclick="window.open('<?php echo $pun_config['o_base_url'] ?>/plugins/ezbbc/listing.php?type=folder&amp;id=' + document.ezbbcform.userid.value + '&amp;ftype=doc' , 'Listing', 'height=400, width=750, top=50, left=50, toolbar=yes, menubar=no, location=no, resizable=yes, scrollbars=yes, status=no');return false;"><img src="plugins/ezbbc/style/admin/listing/doc-folder.png" alt="<?php echo $lang_ezbbc['Document folder display'] ?>" /></a>
                                                        <?php endif; ?>
						        </dd>
						</dl>
						<?php endif; ?>
						</div>
                                        </fieldset>
						
				</div>
			</form>
		</div>
	</div>
<?php

// Note that the script just ends here. The footer will be included by admin_loader.php
