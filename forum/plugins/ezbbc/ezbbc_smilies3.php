<?php
// Retrieving smilies set enabled
require PUN_ROOT.'plugins/ezbbc/config.php';
if ($ezbbc_config['smilies_set'] == 'ezbbc_smilies'):
	echo "\t\t".'<p><code>'.implode('</code> '.$lang_common['and'].' <code>', $smiley_texts).'</code> <span>'.$lang_help['produces'].'</span> <samp><img src="'.pun_htmlspecialchars(get_base_url(true)).'/plugins/ezbbc/style/smilies/'.$smiley_img.'" alt="'.$smiley_texts[0].'" /></samp></p>'."\n";
else:
	echo "\t\t".'<p><code>'.implode('</code> '.$lang_common['and'].' <code>', $smiley_texts).'</code> <span>'.$lang_help['produces'].'</span> <samp><img src="'.pun_htmlspecialchars(get_base_url(true)).'/img/smilies/'.$smiley_img.'" width="15" height="15" alt="'.$smiley_texts[0].'" /></samp></p>'."\n";
endif;
?>
