<?php 
// Including common.php file to have access to fluxBB functions
define('PUN_ROOT', '../../../../');
require PUN_ROOT.'include/common.php';

// Retrieving all values from config file
require PUN_ROOT.'plugins/ezbbc/config.php';
// Looking if images available
$bold = (file_exists(PUN_ROOT.'plugins/ezbbc/style/'.$ezbbc_config['style_folder'].'/images/bold.png')) ? '<img class="button" src="../../style/'.$ezbbc_config['style_folder'].'/images/bold.png" alt="Bold" />' : '<span>B</span>';
$underline = (file_exists(PUN_ROOT.'plugins/ezbbc/style/'.$ezbbc_config['style_folder'].'/images/underline.png')) ? '<img class="button" src="../../style/'.$ezbbc_config['style_folder'].'/images/underline.png" alt="Underline" />' : '<span>U</span>';
$italic = (file_exists(PUN_ROOT.'plugins/ezbbc/style/'.$ezbbc_config['style_folder'].'/images/italic.png')) ? '<img class="button" src="../../style/'.$ezbbc_config['style_folder'].'/images/italic.png" alt="Italic" />' : '<span>I</span>';
$strike_through = (file_exists(PUN_ROOT.'plugins/ezbbc/style/'.$ezbbc_config['style_folder'].'/images/strike-through.png')) ? '<img class="button" src="../../style/'.$ezbbc_config['style_folder'].'/images/strike-through.png" alt="Strike-through" />' : '<span>S</span>';
$delete = (file_exists(PUN_ROOT.'plugins/ezbbc/style/'.$ezbbc_config['style_folder'].'/images/delete.png')) ? '<img class="button" src="../../style/'.$ezbbc_config['style_folder'].'/images/delete.png" alt="Delete" />' : '<span>Del</span>';
$insert = (file_exists(PUN_ROOT.'plugins/ezbbc/style/'.$ezbbc_config['style_folder'].'/images/insert.png')) ? '<img class="button" src="../../style/'.$ezbbc_config['style_folder'].'/images/insert.png" alt="Insert" />' : '<span>Ins</span>';
$emphasis = (file_exists(PUN_ROOT.'plugins/ezbbc/style/'.$ezbbc_config['style_folder'].'/images/emphasis.png')) ? '<img class="button" src="../../style/'.$ezbbc_config['style_folder'].'/images/emphasis.png" alt="Emphasis" />' : '<span>Em</span>';

$colorize = (file_exists(PUN_ROOT.'plugins/ezbbc/style/'.$ezbbc_config['style_folder'].'/images/color.png')) ? '<img class="button" src="../../style/'.$ezbbc_config['style_folder'].'/images/color.png" alt="Colorize" />' : '<span>Color</span>';
$heading = (file_exists(PUN_ROOT.'plugins/ezbbc/style/'.$ezbbc_config['style_folder'].'/images/heading.png')) ? '<img class="button" src="../../style/'.$ezbbc_config['style_folder'].'/images/heading.png" alt="Heading" />' : '<span>H</span>';

$link = (file_exists(PUN_ROOT.'plugins/ezbbc/style/'.$ezbbc_config['style_folder'].'/images/link.png')) ? '<img class="button" src="../../style/'.$ezbbc_config['style_folder'].'/images/link.png" alt="URL" />' : '<span>URL</span>';
$email = (file_exists(PUN_ROOT.'plugins/ezbbc/style/'.$ezbbc_config['style_folder'].'/images/email.png')) ? '<img class="button" src="../../style/'.$ezbbc_config['style_folder'].'/images/email.png" alt="E-mail" />' : '<span>@</span>';
$image = (file_exists(PUN_ROOT.'plugins/ezbbc/style/'.$ezbbc_config['style_folder'].'/images/image.png')) ? '<img class="button" src="../../style/'.$ezbbc_config['style_folder'].'/images/image.png" alt="Image" />' : '<span>Img</span>';

$quote = (file_exists(PUN_ROOT.'plugins/ezbbc/style/'.$ezbbc_config['style_folder'].'/images/quote.png')) ? '<img class="button" src="../../style/'.$ezbbc_config['style_folder'].'/images/quote.png" alt="Quote" />' : '<span>Quote</span>';
$code = (file_exists(PUN_ROOT.'plugins/ezbbc/style/'.$ezbbc_config['style_folder'].'/images/code.png')) ? '<img class="button" src="../../style/'.$ezbbc_config['style_folder'].'/images/code.png" alt="Code" />' : '<span>Code</span>';

$l_unordered = (file_exists(PUN_ROOT.'plugins/ezbbc/style/'.$ezbbc_config['style_folder'].'/images/list-unordered.png')) ? '<img class="button" src="../../style/'.$ezbbc_config['style_folder'].'/images/list-unordered.png" alt="Unordered list" />' : '<span>U-list</span>';
$l_ordered = (file_exists(PUN_ROOT.'plugins/ezbbc/style/'.$ezbbc_config['style_folder'].'/images/list-ordered.png')) ? '<img class="button" src="../../style/'.$ezbbc_config['style_folder'].'/images/list-ordered.png" alt="Ordered list" />' : '<span>O-list</span>';
$l_a_ordered = (file_exists(PUN_ROOT.'plugins/ezbbc/style/'.$ezbbc_config['style_folder'].'/images/list-ordered-alpha.png')) ? '<img class="button" src="../../style/'.$ezbbc_config['style_folder'].'/images/list-ordered-alpha.png" alt="Alphabetical ordered list" />' : '<span>A-list</span>';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="<?php echo PUN_ROOT.'style/'.$pun_user['style'].'.css' ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo PUN_ROOT.'plugins/ezbbc/style/'.$ezbbc_config['style_folder'].'/ezbbc.css' ?>" />
<title>EZBBC Toolbar help</title>
</head>
<body>
<div class="pun">
<div class="punwrap">
<div id="brdmain">
<div  id="ezbbc_help">
        <ul id="menu">
                <li><a href="#common_buttons">Common buttons</a></li>
                <li><a href="#color_button">Color button</a></li>
                <li><a href="#heading_button">Heading button</a></li>
                <li><a href="#url_button">URL button</a></li>
                <li><a href="#email_button">E-mail button</a></li>
                <li><a href="#image_button">Image button</a></li>
                <li><a href="#quote_button">Quote button</a></li>
                <li><a href="#code_button">Code button</a></li>
                <li><a href="#list_buttons">List buttons</a></li>
                <li><a href="#smilies">Smilies</a></li>
                <li><a href="#advanced">Advanced features</a></li>
        </ul>

<h1>EZBBC Toolbar help</h1>
        
        <h2 id="common_buttons" style="margin-right: 20%;">Common inline formating buttons</h2>
                <h3>Use</h3>
                        <p>
                        These buttons only insert a beginning and an ending tag to selected text. If no text is selected, then the tags are inserted and the cursor blinks between the beginning and ending tag.<br />
                        This is what it should look like for the Bold button: <code>[b]Selected text[/b]</code>
                        </p>
                <h3>Summary</h3>
                        <table>
                                <tbody>
                                        <tr>
                                        <th>Buttons</th>
                                       <td><?php echo $bold ?></td>
                                        <td><?php echo $underline ?></td>
                                        <td><?php echo $italic ?></td>
                                        <td><?php echo $strike_through ?></td>
                                        <td><?php echo $delete ?></td>
                                        <td><?php echo $insert ?></td>
                                        <td><?php echo $emphasis ?></td>
                                        </tr>
                                        <tr>
                                        <th>Use</th>
                                        <td>Bold</td>
                                        <td>Underline</td>
                                        <td>Italic</td>
                                        <td>Strike-Through</td>
                                        <td>Delete</td>
                                        <td>Insert</td>
                                        <td>Emphasis</td>
                                        </tr>
                                        <tr>
                                        <th>BBCode Tags</th>
                                        <td><code>[b]…[/b]</code></td>
                                        <td><code>[u]…[/u]</code></td>
                                        <td><code>[i]…[/i]</code></td>
                                        <td><code>[s]…[/s]</code></td>
                                        <td><code>[del]…[/del]</code></td>
                                        <td><code>[ins]…[/ins]</code></td>
                                        <td><code>[em]…[/em]</code></td>
                                        </tr>
                                        <tr>
                                        <th>HTML tags</th>
                                        <td><code>&lt;strong&gt;…&lt;/strong&gt;</code></td>
                                        <td><code>&lt;span…&gt;…&lt;/span&gt;</code></td>
                                        <td><code>&lt;span…&gt;…&lt;/span&gt;</code></td>
                                        <td><code>&lt;span…&gt;…&lt;/span&gt;</code></td>
                                        <td><code>&lt;del&gt;…&lt;/del&gt;</code></td>
                                        <td><code>&lt;ins&gt;…&lt;/ins&gt;</code></td>
                                        <td><code>&lt;em&gt;…&lt;/em&gt;</code></td>
                                        </tr>
                                </tbody>
                        </table>

        <h2>Color and heading buttons</h2>
                <h3 id="color_button"><?php echo $colorize ?> Color button</h3>
                        <p>
                        The color button will be used to colorize the selected text. First select the text you want to change the color of, then you have to enter in the displaying popup window a color name (red, green, blue, purple, …) - if you want to know them all have a look to <a href="http://www.somacon.com/p142.php" onclick="window.open(this.href, 'Color_name', 'height=500, width=310, top=10, left=650, toolbar=no, menubar=no, location=no, resizable=yes, scrollbars=yes, status=no'); return false;">this page</a> - or a hexadecimal color code (ex.: #DDDDDD) - you can find this hex code by using the Color Picker. If no text is selected, then the text "Text that has to be colorized" enclosed in <code>[color]</code> tags will be displayed and highlighted so that you can change it.<br/>
                        This is what it should look like for a red text: <code>[color=red]Selected text[/color]</code>.
                        </p>
                <h3 id="heading_button"><?php echo $heading ?> Heading button</h3>
                        <p>
                        The heading button formats the selected text into a title element. Just select the text that has to become a title and click on that button or click on the button (without selecting anything), enter a title, and validate.
                        </p>
                <h3>Summary</h3>
                        <table>
                                <tbody>
                                        <tr>
                                        <th>Buttons</th>
                                        <td><?php echo $colorize ?></td>
                                        <td><?php echo $heading ?></td>
                                        </tr>
                                        <tr>
                                        <th>Use</th>
                                        <td>Colorized</td>
                                        <td>Title</td>
                                        </tr>
                                        <tr>
                                        <th>BBCode Tags</th>
                                        <td><code>[color=color_code]…[/color]</code></td>
                                        <td><code>[h]…[/h]</code></td>
                                        </tr>
                                        <tr>
                                        <th>HTML tags</th>
                                        <td><code>&lt;span…&gt;…&lt;/span&gt;</code></td>
                                        <td><code>&lt;h5&gt;…&lt;/h5&gt;</code></td>
                                        </tr>
                                </tbody>
                        </table>

        <h2>URL, E-mail and Image buttons</h2>
                <h3 id="url_button"><?php echo $link ?> URL button</h3>
                        <p>
                        If you've selected text, before clicking on the URL button, you should see appear a window displaying the text as the label, a few radio buttons to define which type of link should be inserted and a field asking for the URL or the id. The supported URL types are those who begins with: <code>http://</code>, <code>https://</code>, <code>ftp://</code>, or <code>www.</code>. The id must be an integer. If you didn't select any text, clicking on the URL button will popup a window asking for the link type (Web, Topic, Post, Forum, or User), the link label (optional) and the address.<br />
                        This is what it should look like: <code>[url=the_URL_you_entered]The label[/url]</code>.
                        </p>
                <h3 id="email_button"><?php echo $email ?> E-mail button</h3>
                        <p>
                        If you selected text, before clicking on the E-mail button, this will be considered as the label of the link, you should then define the Address. You have to enter a valid E-mail address (containing a <code>@</code> and a <code>.</code>). If you didn't select any text, yopu must define both the E-mail address and the link label (optional).<br />
                        This is what it should look like: <code>[email=the_address@you_entered]The label[/email]</code>.
                        </p>
                <h3 id="image_button"><?php echo $image ?> Image button</h3>
                        <p>
                        If you selected text, before clicking on the Image button, you should see appear a window containing the alternative text (<code>alt</code> attribute in HTML language) and asking for the URL of the image. If nothing has been selected, you had to define both alternative text (optional) and Image URL.<br />
                        This is what it should look like: <code>[img=Your alt text]http://image_url.en[/img]</code>.
                        </p>
                <h3>Summary</h3>
                        <table>
                                <tbody>
                                        <tr>
                                        <th>Buttons</th>
                                        <td><?php echo $link ?></td>
                                        <td><?php echo $email ?></td>
                                        <td><?php echo $image ?></td>
                                        </tr>
                                        <tr>
                                        <th>Use</th>
                                        <td>A Web link</td>
					<td>A Topic, Post, Forum, or User link</td>
                                        <td>An E-mail link</td>
                                        <td>An image</td>
                                        </tr>
                                        <tr>
                                        <th>BBCode Tags</th>
                                        <td><code>[url=http://website.com]…[/url]</code></td>
										<td><code>[topic=id]…[/topic], [post=id]…[/post], [forum=id]…[/forum], [user=id]…[/user]</code></td>
                                        <td><code>[email=your_email@somewhere.com]…[/email]</code></td>
                                        <td><code>[img=Alternative text]…[/img]</code></td>
                                        </tr>
                                        <tr>
                                        <th>HTML tags</th>
                                        <td><code>&lt;a href="http://…"&gt;…&lt;/a&gt;</code></td>
										<td><code>&lt;a href="http://…"&gt;…&lt;/a&gt;</code></td>
                                        <td><code>&lt;a href="mailto:…"&gt;…&lt;/a&gt;</code></td>
                                        <td><code>&lt;img src="…" alt="…" /&gt;</code></td>
                                        </tr>
                                </tbody>
                        </table>
        
        <h2>Quote and Code buttons</h2>
                <h3 id="quote_button"><?php echo $quote ?> Quote button</h3>
                        <p>
                        In the popup window that appears you can set the author (optional) of the quotation and the text you want to cite. If something was selected before clicking on the quote button, the selected text will be added to the code textarea of the popup window.<br />
                        This is what it should look like:<br />
                        <code>[quote=Author name]<br />
                        Citation<br />
                        [/quote]</code>
                        </p>
                <h3 id="code_button"><?php echo $code ?> Code button</h3>
                        <p>
                        The popup window that appears when clicking on that button provides a dropdown menu where you can choose the language (php, html, Javascript… - optional) and a textarea for pasting the code lines you want to insert. If something was selected before clicking on that button, it will be considered as the code.<br />
                        This is what it should look like:<br />
                        <code>[code]<br/>
                        [== language ==]<br />
                        Code<br />
                        [/code]</code>.
                        </p>
                <h3>Summary</h3>
                        <table>
                                <tbody>
                                        <tr>
                                        <th>Buttons</th>
                                        <td><?php echo $quote ?></td>
                                        <td><?php echo $code ?></td>
                                        </tr>
                                        <tr>
                                        <th>Use</th>
                                        <td>Quote</td>
                                        <td>Code</td>
                                        </tr>
                                        <tr>
                                        <th>BBCode Tags</th>
                                        <td><code>[quote=Author name]…[/quote]</code></td>
                                        <td><code>[code]…[/code]</code></td>
                                        </tr>
                                        <tr>
                                        <th>HTML tags</th>
                                        <td><code>&lt;cite&gt;…&lt;/cite&gt;&lt;blockquote&gt;…&lt;/blockquote&gt;</code></td>
                                        <td><code>&lt;pre&gt;&lt;code&gt;…&lt;/code&gt;&lt;/pre&gt;</code></td>
                                        </tr>
                                </tbody>
                        </table>
        
        <h2 id="list_buttons">List buttons</h2>
                <h3>Use</h3>
                        <p>
                        If you selected multiple lines and clicked on one of the list button, each line will be considered as an item of the list. For example, if you selected 3 lines, you will get a list with 3 items. If you didn't select anything, a prompt will popup and ask you for the first item of the list. You can then add more items by clicking on the "Add an item" link or by pressing the "enter" key. When finished, validate the list by clicking on the right button (the fields left blank will be ignored).
                        </p>
                <h3>Summary</h3>
                        <table>
                                <tbody>
                                        <tr>
                                        <th>Buttons</th>
                                        <td><?php echo $l_unordered ?></td>
                                        <td><?php echo $l_ordered ?></td>
                                        <td><?php echo $l_a_ordered ?></td>
                                        </tr>
                                        <tr>
                                        <th>Use</th>
                                        <td>An unordered list</td>
                                        <td>An ordered list</td>
                                        <td>An alphabetical ordered list</td>
                                        </tr>
                                        <tr>
                                        <th>BBCode Tags</th>
                                        <td style="text-align: left;"><code>[list=*]<br />[*]…[/*]<br />[*]…[/*]<br />[*]…[/*]<br />[/list]</code></td>
                                        <td style="text-align: left;"><code>[list=1]<br />[*]…[/*]<br />[*]…[/*]<br />[*]…[/*]<br />[/list]</code></td>
                                        <td style="text-align: left;"><code>[list=a]<br />[*]…[/*]<br />[*]…[/*]<br />[*]…[/*]<br />[/list]</code></td>
                                        </tr>
                                        <tr>
                                        <th>HTML tags</th>
                                        <td style="text-align: left;"><code>&lt;ul&gt;<br />&lt;li&gt;…&lt;/li&gt;<br />&lt;li&gt;…&lt;/li&gt;<br />&lt;li&gt;…&lt;/li&gt;<br />&lt;/ul&gt;</code></td>
                                        <td style="text-align: left;"><code>&lt;ol&gt;<br />&lt;li&gt;…&lt;/li&gt;<br />&lt;li&gt;…&lt;/li&gt;<br />&lt;li&gt;…&lt;/li&gt;<br />&lt;/ol&gt;</code></td>
                                        <td style="text-align: left;"><code>&lt;ol type="a"&gt;<br />&lt;li&gt;…&lt;/li&gt;<br />&lt;li&gt;…&lt;/li&gt;<br />&lt;li&gt;…&lt;/li&gt;<br />&lt;/ol&gt;</code></td>
                                        </tr>
                                </tbody>
                        </table>
                        
         <h2 id="smilies">Smilies</h2>
                <table>
                                <tbody>
                                        <tr>
                                        <th>BBCode Tags</th>
                                        <td><code>:)</code><br />or<br /><code>=)</code></td>
                                        <td><code>:|</code><br />or<br /><code>=)</code></td>
                                        <td><code>:(</code><br />or<br /><code>=(</code></td>
                                        <td><code>:D</code><br />or<br /><code>=D</code></td>
                                        <td><code>:o</code><br />or<br /><code>:O</code></td>
                                        <td><code>;)</code></td>
                                        <td><code>:/</code></td>
                                        <td><code>:P</code><br />or<br /><code>:p</code></td>
                                        <td><code>:lol:</code></td>
                                        <td><code>:mad:</code></td>
                                        <td><code>:rolleyes:</code></td>
                                        <td><code>:cool:</code></td>
                                        </tr>
                                        <tr>
                                        <th>FluxBB default smilies</th>
                                        <td><img src="../../../../img/smilies/smile.png" alt=":)" /></td>
                                        <td><img src="../../../../img/smilies/neutral.png" alt=":|" /></td>
                                        <td><img src="../../../../img/smilies/sad.png" alt=":(" /></td>
                                        <td><img src="../../../../img/smilies/big_smile.png" alt=":D" /></td>
                                        <td><img src="../../../../img/smilies/yikes.png" alt=":o" /></td>
                                        <td><img src="../../../../img/smilies/wink.png" alt=";)" /></td>
                                        <td><img src="../../../../img/smilies/hmm.png" alt=":/" /></td>
                                        <td><img src="../../../../img/smilies/tongue.png" alt=":P" /></td>
                                        <td><img src="../../../../img/smilies/lol.png" alt=":lol:" /></td>
                                        <td><img src="../../../../img/smilies/mad.png" alt=":mad:" /></td>
                                        <td><img src="../../../../img/smilies/roll.png" alt=":rolleyes:" /></td>
                                        <td><img src="../../../../img/smilies/cool.png" alt=":cool:" /></td>
                                        </tr>
                                        <tr>
                                         <th>EZBBC custom smilies</th>
                                        <td><img src="../../style/smilies/smile.png" alt=":)" /></td>
                                        <td><img src="../../style/smilies/neutral.png" alt=":|" /></td>
                                        <td><img src="../../style/smilies/sad.png" alt=":(" /></td>
                                        <td><img src="../../style/smilies/big_smile.png" alt=":D" /></td>
                                        <td><img src="../../style/smilies/yikes.png" alt=":o" /></td>
                                        <td><img src="../../style/smilies/wink.png" alt=";)" /></td>
                                        <td><img src="../../style/smilies/hmm.png" alt=":/" /></td>
                                        <td><img src="../../style/smilies/tongue.png" alt=":P" /></td>
                                        <td><img src="../../style/smilies/lol.png" alt=":lol:" /></td>
                                        <td><img src="../../style/smilies/mad.png" alt=":mad:" /></td>
                                        <td><img src="../../style/smilies/roll.png" alt=":rolleyes:" /></td>
                                        <td><img src="../../style/smilies/cool.png" alt=":cool:" /></td>
                                        </tr>
                                        
                                </tbody>
                        </table>
                        
                        <table>
                                <tbody>
                                        <tr>
                                        <th>BBCode Tags</th>
                                        <td><code>O:)</code><br />or<br /><code>:angel:</code></td> 
                                        <td><code>8.(</code><br />or<br /><code>:cry:</code></td> 
                                        <td><code>]:D</code><br />or<br /><code>:devil:</code></td> 
                                        <td><code>8)</code><br />or<br /><code>:glasses:</code></td>
                                        <td><code>{)</code><br />or<br /><code>:kiss:</code></td>
                                        <td><code>8o</code><br />or<br /><code>:monkey:</code></td> 
                                        <td><code>:8</code><br />or<br /><code>:ops:</code></td>
                                        </tr>
                                        <tr>
                                        <th>FluxBB default smilies</th>
                                        <td>O:)</td> 
                                        <td>8.(</td> 
                                        <td>]:D</td> 
                                        <td>8)</td>
                                        <td>{)</td>
                                        <td>8o</td> 
                                        <td>:8</td>
                                        </tr>
                                        <tr>
                                         <th>EZBBC custom smilies</th>
                                        <td><img src="../../style/smilies/angel.png" alt="O:)" /></td> 
                                        <td><img src="../../style/smilies/cry.png" alt="8.(" /></td> 
                                        <td><img src="../../style/smilies/devil.png" alt="]:D" /></td>
                                        <td><img src="../../style/smilies/glasses.png" alt="8)" /></td>
                                        <td><img src="../../style/smilies/kiss.png" alt="{)" /></td>
                                        <td><img src="../../style/smilies/monkey.png" alt="8o" /></td> 
                                        <td><img src="../../style/smilies/ops.png" alt=":8" /></td>
                                        </tr>
                                        
                                </tbody>
                        </table>
	<h2 id="advanced">Advanced features</h2>
		<p>Some advanced features are available in the EZBBC Toolbar. You can have an overview of this features below if they have been enabled by the forums admin.</p>
		
		<?php if ($ezbbc_config['h_id'] == 'h_id'): ?>
		<h3>Adding <code>id</code> attribute to heading</h3>
		<p>You can add an <code>id</code> to your headings. See the screenshot below to get an overview of what you can set:</p>
		<p class="screenshot"><img src="images/heading_window.png" alt="Heading window" /></p>
		<p>These settings will result to this BBCode:</p>
		<p><code>[h=title01]First title[/h]</code></p>
		<p>Here the generated HTML:</p>
		<p><code>&lt;h5 id=&quot;title01&quot;&gt;&lt;a href=&quot;#title01&quot;&gt;#&lt;/a&gt; First title&lt;/h5&gt;</code></p>
		<?php endif; ?>
		
		<?php if ($ezbbc_config['video'] == 'video'): ?>
		<h3>Video tag</h3>
		<p>You can add videos (Youtube and Dailymotion) by using video tags. A video window screenshot:</p>
		<p class="screenshot"><img src="images/video_window.png" alt="Video window" /></p>
		<p>These settings will result to this BBCode:</p>
		<p><code>[video=560,315][url]http://youtu.be/yyIK0dwg6rM[/url][/video]</code></p>
		<p>Here the generated HTML:</p>
		<p><code>&lt;iframe width=&quot;560&quot; height=&quot;315&quot; src=&quot;http://www.youtube.com/embed/yyIK0dwg6rM?rel=0&quot; frameborder=&quot;0&quot; allowfullscreen&gt;&lt;/iframe&gt;</code></p>
		<?php endif; ?>
		
		<?php if ($ezbbc_config['img_upload'] == 'img_upload'): ?>
		<h3>Image upload</h3>
		<p>You can upload images to display them on the forums. The allowed image formats are: gif, png, jpg, and jpeg. You have to click on the following button to access the image upload form: <?php echo $image ?>.</p>
		<p>The screenshot of the Image adding window with already uploaded images:</p>
		<p class="screenshot"><img src="images/image_window.png" alt="Image window" /></p>
		<p>To upload images, just click on the "Browse" button and find the image in your computer filebrowser then click on the "Upload image" button. Add an alternative text (optional) then click on the "OK" button. If the listing feature has been enabled by the forums admin, you can see and manage your uploaded images. Click on the first icon to see the image. Click on the second one to remove the image. Clicking on the third one will add the url to the matching field (if you want to add the picture to the post).</p>
		<?php endif; ?>
		
		<?php if($ezbbc_config['doc_upload'] == 'doc_upload'): ?>
		<h3>Document upload</h3>
		<p>You can upload documents to create a link pointing to them on the forums. The allowed document formats are: <?php echo $ezbbc_config['allowed_ext'] ?>. You have to click on the following button to access the document upload form: <?php echo $link ?>.</p>
		<p>The screenshot of the document adding window with already uploaded documents:</p>
		<p class="screenshot"><img src="images/doc_window.png" alt="URL window with doc upload field" /></p>
		<p>To upload documents, just click on the "Browse" button and find the document in your computer filebrowser then click on the "Upload file" button. Add a label (optional) then click on the "OK" button. If the listing feature has been enabled by the forums admin, you can see and manage your uploaded images. Click on the first icon to see the document. Click on the second one to remove the document. Clicking on the third one will add the url to the matching field (if you want to add the document link to the post).</p>
		<?php endif; ?>
</div>
</div>
</div>
</div>
</body>
</html>
