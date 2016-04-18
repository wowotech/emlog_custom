<?php
$code_line = explode("\n", $inside[$i]);
$first_line = trim($code_line[1]);
if (strpos($first_line, '[==') !== false && strpos($first_line, '==]') !== false) {
	// fetching the language name
	$language = strtolower(trim(str_replace(array('[==', '==]'), '', $first_line)));
	// Markup case
	if($language == 'html' || $language == 'xhtml' || $language == 'xml') { $h_class = ' class="language-markup"'; }
	// C-like languages case
	elseif($language == 'php' || $language == 'c++' || $language == 'perl') { $h_class = ' class="language-clike"'; }
	// JavaScript case
	elseif($language == 'javascript') { $h_class = ' class="language-javascript"'; }
	// Java case
	elseif($language == 'java') { $h_class = ' class="language-java"'; }	
	// CoffeeScript case
	elseif($language == 'coffeescript') { $h_class = ' class="language-coffeescript"'; }
	// Css case
	elseif($language == 'css') { $h_class = ' class="language-css"'; }	
	// Sass case
	elseif($language == 'sass') { $h_class = ' class="language-sass"'; }
	// Other cases
	else { $h_class = ' class="language-none"'; }
	// Deleting the line giving the code name
	$inside[$i] = str_replace($first_line, '', $inside[$i]);
	// Generating the the HTML code block
	$text .= '</p><div class="codebox"><pre'.(($num_lines > 28) ? ' class="vscroll"' : '').'><code'.$h_class.'>'.pun_trim($inside[$i], "\n\r").'</code></pre></div><p>';
} else {
	$text .= '</p><div class="codebox"><pre'.(($num_lines > 28) ? ' class="vscroll"' : '').'><code>'.pun_trim($inside[$i], "\n\r").'</code></pre></div><p>';
}
?>
