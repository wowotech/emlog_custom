<?php 
// Including common.php file to have access to fluxBB functions
define('PUN_ROOT', '../../../../');
require PUN_ROOT.'include/common.php';

// Retrieving all values from config file
require PUN_ROOT.'plugins/ezbbc/config.php';
// Looking if images available
$bold = (file_exists(PUN_ROOT.'plugins/ezbbc/style/'.$ezbbc_config['style_folder'].'/images/bold.png')) ? '<img class="button" src="../../style/'.$ezbbc_config['style_folder'].'/images/bold.png" alt="Gras" />' : '<span>B</span>';
$underline = (file_exists(PUN_ROOT.'plugins/ezbbc/style/'.$ezbbc_config['style_folder'].'/images/underline.png')) ? '<img class="button" src="../../style/'.$ezbbc_config['style_folder'].'/images/underline.png" alt="Souligné" />' : '<span>U</span>';
$italic = (file_exists(PUN_ROOT.'plugins/ezbbc/style/'.$ezbbc_config['style_folder'].'/images/italic.png')) ? '<img class="button" src="../../style/'.$ezbbc_config['style_folder'].'/images/italic.png" alt="Italique" />' : '<span>I</span>';
$strike_through = (file_exists(PUN_ROOT.'plugins/ezbbc/style/'.$ezbbc_config['style_folder'].'/images/strike-through.png')) ? '<img class="button" src="../../style/'.$ezbbc_config['style_folder'].'/images/strike-through.png" alt="Barré" />' : '<span>S</span>';
$delete = (file_exists(PUN_ROOT.'plugins/ezbbc/style/'.$ezbbc_config['style_folder'].'/images/delete.png')) ? '<img class="button" src="../../style/'.$ezbbc_config['style_folder'].'/images/delete.png" alt="Supprimé" />' : '<span>Del</span>';
$insert = (file_exists(PUN_ROOT.'plugins/ezbbc/style/'.$ezbbc_config['style_folder'].'/images/insert.png')) ? '<img class="button" src="../../style/'.$ezbbc_config['style_folder'].'/images/insert.png" alt="Inséré" />' : '<span>Ins</span>';
$emphasis = (file_exists(PUN_ROOT.'plugins/ezbbc/style/'.$ezbbc_config['style_folder'].'/images/emphasis.png')) ? '<img class="button" src="../../style/'.$ezbbc_config['style_folder'].'/images/emphasis.png" alt="Emphase" />' : '<span>Em</span>';

$colorize = (file_exists(PUN_ROOT.'plugins/ezbbc/style/'.$ezbbc_config['style_folder'].'/images/color.png')) ? '<img class="button" src="../../style/'.$ezbbc_config['style_folder'].'/images/color.png" alt="Couleure" />' : '<span>Color</span>';
$heading = (file_exists(PUN_ROOT.'plugins/ezbbc/style/'.$ezbbc_config['style_folder'].'/images/heading.png')) ? '<img class="button" src="../../style/'.$ezbbc_config['style_folder'].'/images/heading.png" alt="Titre" />' : '<span>H</span>';

$link = (file_exists(PUN_ROOT.'plugins/ezbbc/style/'.$ezbbc_config['style_folder'].'/images/link.png')) ? '<img class="button" src="../../style/'.$ezbbc_config['style_folder'].'/images/link.png" alt="Lien" />' : '<span>URL</span>';
$email = (file_exists(PUN_ROOT.'plugins/ezbbc/style/'.$ezbbc_config['style_folder'].'/images/email.png')) ? '<img class="button" src="../../style/'.$ezbbc_config['style_folder'].'/images/email.png" alt="Courriel" />' : '<span>@</span>';
$image = (file_exists(PUN_ROOT.'plugins/ezbbc/style/'.$ezbbc_config['style_folder'].'/images/image.png')) ? '<img class="button" src="../../style/'.$ezbbc_config['style_folder'].'/images/image.png" alt="Image" />' : '<span>Img</span>';

$quote = (file_exists(PUN_ROOT.'plugins/ezbbc/style/'.$ezbbc_config['style_folder'].'/images/quote.png')) ? '<img class="button" src="../../style/'.$ezbbc_config['style_folder'].'/images/quote.png" alt="Citation" />' : '<span>Quote</span>';
$code = (file_exists(PUN_ROOT.'plugins/ezbbc/style/'.$ezbbc_config['style_folder'].'/images/code.png')) ? '<img class="button" src="../../style/'.$ezbbc_config['style_folder'].'/images/code.png" alt="Code" />' : '<span>Code</span>';

$l_unordered = (file_exists(PUN_ROOT.'plugins/ezbbc/style/'.$ezbbc_config['style_folder'].'/images/list-unordered.png')) ? '<img class="button" src="../../style/'.$ezbbc_config['style_folder'].'/images/list-unordered.png" alt="Liste à puce" />' : '<span>U-list</span>';
$l_ordered = (file_exists(PUN_ROOT.'plugins/ezbbc/style/'.$ezbbc_config['style_folder'].'/images/list-ordered.png')) ? '<img class="button" src="../../style/'.$ezbbc_config['style_folder'].'/images/list-ordered.png" alt="Liste numérotée" />' : '<span>O-list</span>';
$l_a_ordered = (file_exists(PUN_ROOT.'plugins/ezbbc/style/'.$ezbbc_config['style_folder'].'/images/list-ordered-alpha.png')) ? '<img class="button" src="../../style/'.$ezbbc_config['style_folder'].'/images/list-ordered-alpha.png" alt="Liste alphabétique" />' : '<span>A-list</span>';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="<?php echo PUN_ROOT.'style/'.$pun_user['style'].'.css' ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo PUN_ROOT.'plugins/ezbbc/style/'.$ezbbc_config['style_folder'].'/ezbbc.css' ?>" />
<title>Aide EZBBC Toolbar</title>
</head>
<body>
<div class="pun">
<div class="punwrap">
<div id="brdmain">
<div  id="ezbbc_help">
        <ul id="menu">
                <li><a href="#common_buttons">Boutons courants</a></li>
                <li><a href="#color_button">Bouton couleur</a></li>
                <li><a href="#heading_button">Bouton titre</a></li>
                <li><a href="#url_button">Bouton URL (lien)</a></li>
                <li><a href="#email_button">Bouton e-mail</a></li>
                <li><a href="#image_button">Bouton image</a></li>
                <li><a href="#quote_button">Bouton citation</a></li>
                <li><a href="#code_button">Bouton code</a></li>
                <li><a href="#list_buttons">Boutons liste</a></li>
                <li><a href="#smilies">Émoticônes</a></li>
                <li><a href="#advanced">Fonctionnalités avancées</a></li>
        </ul>

<h1>Aide EZBBC Toolbar</h1>
        
       <h2 id="common_buttons">Boutons de mise en forme inline courants</h2>
                <h3>Utilisation</h3>
                        <p>
                        Ces boutons n'insèrent qu'une balise ouvrante et fermante au texte sélectionné. Si aucun texte n'est sélectionné, alors les balises sont insérées et le curseur clignote entre les deux balises.<br />
                        Vous obtiendrez quelque chose ressemblant à ça pour le bouton « gras » : <code>[b]Texte sélectionné[/b]</code>.
                        </p>
                <h3>Résumé</h3>
                        <table>
                                <tbody>
                                        <tr>
                                        <th>Boutons</th>
                                        <td><?php echo $bold ?></td>
                                        <td><?php echo $underline ?></td>
                                        <td><?php echo $italic ?></td>
                                        <td><?php echo $strike_through ?></td>
                                        <td><?php echo $delete ?></td>
                                        <td><?php echo $insert ?></td>
                                        <td><?php echo $emphasis ?></td>
                                        </tr>
                                        <tr>
                                        <th>Utilisation</th>
                                        <td>Gras</td>
                                        <td>Souligné</td>
                                        <td>Italique</td>
                                        <td>Barré</td>
                                        <td>Supprimé</td>
                                        <td>Inséré</td>
                                        <td>Emphase</td>
                                        </tr>
                                        <tr>
                                        <th>Balises BBCode</th>
                                        <td><code>[b]…[/b]</code></td>
                                        <td><code>[u]…[/u]</code></td>
                                        <td><code>[i]…[/i]</code></td>
                                        <td><code>[s]…[/s]</code></td>
                                        <td><code>[del]…[/del]</code></td>
                                        <td><code>[ins]…[/ins]</code></td>
                                        <td><code>[em]…[/em]</code></td>
                                        </tr>
                                        <tr>
                                        <th>Balises HTML</th>
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

        <h2>Bouton couleur et titre</h2>
                <h3 id="color_button"><?php echo $colorize ?> Bouton couleur</h3>
                        <p>
                        Le bouton couleur sera utilisé pour coloriser du texte. D'abord sélectionnez le texte que vous souhaitez mettre en couleur, puis indiquez dans la enêtre popup qui s'affiche un nom de couleur (red, green, blue, purple, …) - si vous voulez les connaître tous, rendez-vous à <a href="http://www.crockford.com/wrrrld/color.html" onclick="window.open(this.href, 'Color_name', 'height=500, width=500, top=10, left=10, toolbar=no, menubar=no, location=no, resizable=yes, scrollbars=yes, status=no'); return false;">cette page</a> - ou un code hexadécimal (ex.: #DDDDDD) - vous pouvez définir ce code en utilisant la palette de couleur. Si aucun texte n'est sélectionné, alors le text « Texte à coloriser » encadré par des balises <code>[color]</code> s'affichera et sera mis en surbrillance pour modification.<br/>
                        Vous obtiendrez quelque chose ressemblant à ça pour un texte à mettre en rouge : <code>[color=red]Texte sélectionné[/color]</code>.
                        </p>
                <h3 id="heading_button"><?php echo $heading ?> Bouton titre</h3>
                        <p>
                        Ce bouton vous permet de transformer du texte en titre. Pour cela, sélectionnez le texte et cliquez sur le bouton pour en faire un titre ou cliquez sur le bouton (sans sélectionner de texte), indiquez le titre et validez.
                        </p>
                <h3>Résumé</h3>
                        <table>
                                <tbody>
                                        <tr>
                                        <th>Boutons</th>
                                       <td><?php echo $colorize ?></td>
                                        <td><?php echo $heading ?></td>
                                        </tr>
                                        <tr>
                                        <th>Utilisation</th>
                                        <td>Colorisé</td>
                                        <td>Titre</td>
                                        </tr>
                                        <tr>
                                        <th>Balises BBCode</th>
                                        <td><code>[color=code_couleur]…[/color]</code></td>
                                        <td><code>[h]…[/h]</code></td>
                                        </tr>
                                        <tr>
                                        <th>Balises HTML</th>
                                        <td><code>&lt;span…&gt;…&lt;/span&gt;</code></td>
                                        <td><code>&lt;h5&gt;…&lt;/h5&gt;</code></td>
                                        </tr>
                                </tbody>
                        </table>

        <h2>Boutons URL, E-mail et image</h2>
                <h3 id="url_button"><?php echo $link ?> Bouton URL</h3>
                        <p>
                        Si vous avez sélectionné du texte avant de cliquer sur le bouton URL, vous devriez voir apparaître une fenêtre affichant le texte comme intitulé, quelques boutons radio pour définir le type de lien à insérer et un champ permettant d'indiquer l'URL (adresse) ou l'ID. Les types d'URL pris en charge sont ceux qui commencent par : <code>http://</code>, <code>https://</code>, <code>ftp://</code> ou <code>www.</code>. L'ID doit être un nombre entier. Si vous n'avez sélectionné aucun texte, on vous demandera le type de lien (Web, discussion, message, forum, utilisateur), l'intitulé du lien (facultatif) et l'adresse.<br />
                        Vous obtiendrez quelque chose ressemblant à ça : <code>[url=URL_indiquée_dans_le_champ]L'intitulé[/url]</code>.
                        </p>
                <h3 id="email_button"><?php echo $email ?> Bouton courriel</h3>
                        <p>
                        Si vous avez sélectionné du texte avant de cliquer sur le bouton courriel, il sera considéré comme étant l'intitulé du lien et vous devrez définir l'adresse électronique. Vous devrez indiquer une adresse valide (contenant un <code>@</code> et un <code>.</code>). Si vous n'avez sélectionné aucun texte, vous devrez définir les deux éléments, adresse électronique et intitulé (facultatif).<br />
                        Vous obtiendrez quelque chose ressemblant à ça : <code>[email=email@indique.com]L'intitulé[/email]</code>.
                        </p>
                <h3 id="image_button"><?php echo $image ?> Bouton image</h3>
                        <p>
                        Si vous avez sélectionné du texte avant de cliquer sur le bouton image, vous verrez apparaître une fenêtre contenant le texte alternatif (l'attribut <code>alt</code> en HTML) et demandant l'URL de l'image. Si rien n'a été sélectionné, il faudra définir les deux éléments, le texte alternatif (facultatif) et l'URL de l'image.<br />
                        Vous obtiendrez quelque chose ressemblant à ça : <code>[img=Votre texte alternatif]http://url_image.fr[/img]</code>.
                        </p>
                <h3>Résumé</h3>
                        <table>
                                <tbody>
                                        <tr>
                                        <th>Boutons</th>
                                         <td><?php echo $link ?></td>
                                        <td><?php echo $email ?></td>
                                        <td><?php echo $image ?></td>
                                        </tr>
                                        <tr>
                                        <th>Utilisation</th>
                                        <td>Un lien vers une page Web, une discussion, un message, un forum ou le profil d'un utilisateur</td>
                                        <td>Un lien pour envoyer un message</td>
                                        <td>Une image</td>
                                        </tr>
                                        <tr>
                                        <th>Balises BBCode</th>
                                        <td><code>[url=http://siteweb.com]…[/url], [topic=id]…[/topic], [post=id]…[/post], [forum=id]…[/forum], [user=id]…[/user]</code></td>
                                        <td><code>[email=votre_email@quelquepart.com]…[/email]</code></td>
                                        <td><code>[img=Texte alternatif]…[/img]</code></td>
                                        </tr>
                                        <tr>
                                        <th>Balises HTML</th>
                                        <td><code>&lt;a href="http://…"&gt;…&lt;/a&gt;</code></td>
                                        <td><code>&lt;a href="mailto:…"&gt;…&lt;/a&gt;</code></td>
                                        <td><code>&lt;img src="…" alt="…" /&gt;</code></td>
                                        </tr>
                                </tbody>
                        </table>
        
        <h2>Boutons citation et code</h2>
                <h3 id="quote_button"><?php echo $quote ?> Bouton citation</h3>
                        <p>
                        Dans la fenêtre popup qui apparaît, vous pouvez définir l'auteur (facultatif) d ela citation et le texte que vous souhaitez citer. Si avant de cliquer un texte avait été sélectionné, ce texte sera ajouté à la zone de texte prévue à cet effet.<br />
                        Vous obtiendrez quelque chose ressemblant à ça :<br />
                        <code>[quote=Nom de l'auteur]<br />
                        Citation<br />
                        [/quote]</code>
                        </p>
                <h3 id="code_button"><?php echo $code ?> Bouton code</h3>
                        <p>
                        La fenêtre popup qui s'affiche en cliquant sur ce bouton fournit un menu déroulant dans lequel vous pourrez choisir le langage (php, html, Javascript… - facultatif) et une zone de texte dans laquelle vous pourrez coller les lignes de codes que vous souhaitez ajouter. Si quelque chose a été sélectionné avant le clic, ce texte sera considéré comme étant le code.<br />
                        Vous obtiendrez quelque chose ressemblant à ça :<br />
                        <code>[code]<br />
                        [== langage ==]<br />
                        Code<br />
                        [/code]</code>
                        </p>
                <h3>Résumé</h3>
                        <table>
                                <tbody>
                                        <tr>
                                        <th>Boutons</th>
                                        <td><?php echo $quote ?></td>
                                        <td><?php echo $code ?></td>
                                        </tr>
                                        <tr>
                                        <th>Utilisation</th>
                                        <td>Citation</td>
                                        <td>Code</td>
                                        </tr>
                                        <tr>
                                        <th>Balises BBCode</th>
                                        <td><code>[quote=Nom de l'auteur]…[/quote]</code></td>
                                        <td><code>[code]…[/code]</code></td>
                                        </tr>
                                        <tr>
                                        <th>HTML tags</th>
                                        <td><code>&lt;cite&gt;…&lt;/cite&gt;&lt;blockquote&gt;…&lt;/blockquote&gt;</code></td>
                                        <td><code>&lt;pre&gt;&lt;code&gt;…&lt;/code&gt;&lt;/pre&gt;</code></td>
                                        </tr>
                                </tbody>
                        </table>
        
        <h2 id="list_buttons">Boutons liste</h2>
                <h3>Utilisation</h3>
                <p>
                Si vous avez sélectionné plusieurs lignes et cliqué sur le bouton liste, chaque ligne sera considérée comme étant un élément de liste. Par exemple, si vous avez sélectionné 3 lignes, vous obtiendrez une liste comportant 3 éléments. Si vous n'avez rien sélectionné, on vous demandera dans un premier temps le premier élément de la liste. Ensuite vous pourrez ajouter des éléments à votre liste en cliquant sur le lien «&nbsp;Ajouter un élément&nbsp;». Lorsque vous aurez constitué votre liste d'éléments, vous pourrez valider en cliquant sur le bouton adéquat (les champs laissés vides seront ignorés).
                </p>
                <h3>Résumé</h3>
                        <table>
                                <tbody>
                                        <tr>
                                        <th>Boutons</th>
                                        <td><?php echo $l_unordered ?></td>
                                        <td><?php echo $l_ordered ?></td>
                                        <td><?php echo $l_a_ordered ?></td>
                                        </tr>
                                        <tr>
                                        <th>Utilisation</th>
                                        <td>Une liste à puce</td>
                                        <td>Une liste numéroté</td>
                                        <td>Une liste alphabétique</td>
                                        </tr>
                                        <tr>
                                        <th>Balises BBCode</th>
                                        <td style="text-align: left;"><code>[list=*]<br />[*]…[/*]<br />[*]…[/*]<br />[*]…[/*]<br />[/list]</code></td>
                                        <td style="text-align: left;"><code>[list=1]<br />[*]…[/*]<br />[*]…[/*]<br />[*]…[/*]<br />[/list]</code></td>
                                        <td style="text-align: left;"><code>[list=a]<br />[*]…[/*]<br />[*]…[/*]<br />[*]…[/*]<br />[/list]</code></td>
                                        </tr>
                                        <tr>
                                        <th>Balises HTML</th>
                                        <td style="text-align: left;"><code>&lt;ul&gt;<br />&lt;li&gt;…&lt;/li&gt;<br />&lt;li&gt;…&lt;/li&gt;<br />&lt;li&gt;…&lt;/li&gt;<br />&lt;/ul&gt;</code></td>
                                        <td style="text-align: left;"><code>&lt;ol&gt;<br />&lt;li&gt;…&lt;/li&gt;<br />&lt;li&gt;…&lt;/li&gt;<br />&lt;li&gt;…&lt;/li&gt;<br />&lt;/ol&gt;</code></td>
                                        <td style="text-align: left;"><code>&lt;ol type="a"&gt;<br />&lt;li&gt;…&lt;/li&gt;<br />&lt;li&gt;…&lt;/li&gt;<br />&lt;li&gt;…&lt;/li&gt;<br />&lt;/ol&gt;</code></td>
                                        </tr>
                                </tbody>
                        </table>

         <h2 id="smilies">Émoticônes</h2>
                <table>
                                <tbody>
                                        <tr>
                                        <th>BBCode</th>
                                        <td><code>:)</code><br />ou<br /><code>=)</code></td>
                                        <td><code>:|</code><br />ou<br /><code>=)</code></td>
                                        <td><code>:(</code><br />ou<br /><code>=(</code></td>
                                        <td><code>:D</code><br />ou<br /><code>=D</code></td>
                                        <td><code>:o</code><br />ou<br /><code>:O</code></td>
                                        <td><code>;)</code></td>
                                        <td><code>:/</code></td>
                                        <td><code>:P</code><br />ou<br /><code>:p</code></td>
                                        <td><code>:lol:</code></td>
                                        <td><code>:mad:</code></td>
                                        <td><code>:rolleyes:</code></td>
                                        <td><code>:cool:</code></td>
                                        </tr>
                                        <tr>
                                        <th>Émoticônes par défaut de FluxBB</th>
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
                                         <th>Émoticônes personnalisées EZBBC</th>
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
                                        <th>BBCode</th>
                                        <td><code>O:)</code><br />ou<br /><code>:angel:</code></td> 
                                        <td><code>8.(</code><br />ou<br /><code>:cry:</code></td> 
                                        <td><code>]:D</code><br />ou<br /><code>:devil:</code></td> 
                                        <td><code>8)</code><br />ou<br /><code>:glasses:</code></td>
                                        <td><code>{)</code><br />ou<br /><code>:kiss:</code></td>
                                        <td><code>8o</code><br />ou<br /><code>:monkey:</code></td> 
                                        <td><code>:8</code><br />ou<br /><code>:ops:</code></td>
                                        </tr>
                                        <tr>
                                        <th>Émoticônes par défaut de FluxBB</th>
                                        <td>O:)</td> 
                                        <td>8.(</td> 
                                        <td>]:D</td> 
                                        <td>8)</td>
                                        <td>{)</td>
                                        <td>8o</td> 
                                        <td>:8</td>
                                        </tr>
                                        <tr>
                                         <th>Émoticônes personnalisées EZBBC</th>
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
	<h2 id="advanced">Fonctionnalités avancées</h2>
		<p>Des fonctionnalités avancées sont disponibles dans EZBBC Toolbar. Vous pouvez avoir un aperçu de ces fonctionnalités ci-dessous si l'administrateur des forums les a activées.</p>
		
		<?php if ($ezbbc_config['h_id'] == 'h_id'): ?>
		<h3>Ajout d'un attribut <code>id</code> à la balise de titre</h3>
		<p>Vous pouvez ajoutez une <code>id</code> à vos titres. Voyez la copie d'écran ci-dessous pour avoir un aperçu de ce que vous pouvez définir :</p>
		<p class="screenshot"><img src="images/heading_window.png" alt="Heading window" /></p>
		<p>Ces données seront restituées sous forme de BBCode ainsi&#160;:</p>
		<p><code>[h=title01]First title[/h]</code></p>
		<p>Voici le code HTML généré&#160:</p>
		<p><code>&lt;h5 id=&quot;title01&quot;&gt;&lt;a href=&quot;#title01&quot;&gt;#&lt;/a&gt; First title&lt;/h5&gt;</code></p>
		<?php endif; ?>
		
		<?php if ($ezbbc_config['video'] == 'video'): ?>
		<h3>Balise video</h3>
		<p>Vous pouvez ajouter des vidéos (en provenance de Youtube et Dailymotion) en utilisant des balises video. Une capture d'écran de la fenêtre vidéo&#160:</p>
		<p class="screenshot"><img src="images/video_window.png" alt="Video window" /></p>
		<p>Ces données seront restituées sous forme de BBCode ainsi&#160:</p>
		<p><code>[video=560,315][url]http://youtu.be/yyIK0dwg6rM[/url][/video]</code></p>
		<p>Voici le code HTML généré :</p>
		<p><code>&lt;iframe width=&quot;560&quot; height=&quot;315&quot; src=&quot;http://www.youtube.com/embed/yyIK0dwg6rM?rel=0&quot; frameborder=&quot;0&quot; allowfullscreen&gt;&lt;/iframe&gt;</code></p>
		<?php endif; ?>
		
		<?php if ($ezbbc_config['img_upload'] == 'img_upload'): ?>
		<h3>Envoi d'image</h3>
		<p>Vous pouvez envoyer des images à afficher sur le forum. Les formats d'images acceptés sont&#160: gif, png, jpg, and jpeg. Vous devez cliquer sur le bouton suivant pour accéder au formulaire d'envoi d'image&#160: <?php echo $image ?>.</p>
		<p>Une copie d'écran de la fenêtre d'ajout d'image avec des images déjà envoyées&#160:</p>
		<p class="screenshot"><img src="images/image_window.png" alt="Image window" /></p>
		<p>Pour envoyer des images, cliquez sur le bouton "Parcourir" et recherchez dans votre explorateur de fichiers l'image puis cliquez sur le bouton "Envoyer le fichier". Ajoutez un texte alternatif (facultatif) puis cliquez sur le bouton "OK". Si la fonctionnalité de listing a été activée par l'administrateur, vous pourrez voir et gérer les images que vous aurez déjà envoyées. Cliquez sur la première icône pour la visualiser. Cliquez sur la deuxième pour la supprimer. En cliquant sur la troisième icône, vous ajouterez l'url au champ correspondant (si vous souaitez ajouter l'image au message).</p>
		<?php endif; ?>
		
		<?php if($ezbbc_config['doc_upload'] == 'doc_upload'): ?>
		<h3>Envoi de document</h3>
		<p>Vous pouvez envoyer des documents pour les rendre disponible par l'insertion d'un lien dans le message. Les formats de document autorisés sont&#160: <?php echo $ezbbc_config['allowed_ext'] ?>. Vous devez cliquer sur le bouton suivant pour accéder au formulaire d'envoi de documents&#160: <?php echo $link ?>.</p>
		<p>Une copie d'écran de la fenêtre d'ajout de document avec des documents déjà envoyés&#160:</p>
		<p class="screenshot"><img src="images/doc_window.png" alt="URL window with doc upload field" /></p>
		<p>Pour envoyer des documents, cliquez sur le bouton "Parcourir" et recherchez dans votre explorateur de fichiers le document puis cliquez sur le bouton "Envoyer le fichier". Ajoutez un intitulé (facultatif) puis cliquez sur le bouton "OK". Si la fonctionnalité de listing a été activée par l'administrateur, vous pourrez voir et gérer les documents que vous aurez déjà envoyés. Cliquez sur la première icône pour le visualiser. Cliquez sur la deuxième pour le supprimer. En cliquant sur la troisième icône, vous ajouterez l'url au champ correspondant (si vous souaitez ajouter le lien poinant vers le document au message).</p>
		<?php endif; ?>
</div>
</div>
</div>
</div>
</body>
</html>
