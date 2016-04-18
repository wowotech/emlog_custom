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
<html xmlns="http://www.w3.org/1999/xhtml" lang="it">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="<?php echo PUN_ROOT.'style/'.$pun_user['style'].'.css' ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo PUN_ROOT.'plugins/ezbbc/style/'.$ezbbc_config['style_folder'].'/ezbbc.css' ?>" />
<title>Aiuto sulla EZBBC Toolbar</title>
</head>
<body>
<div class="pun">
<div class="punwrap">
<div id="brdmain">
<div  id="ezbbc_help">
        <ul id="menu">
                <li><a href="#common_buttons">Pulsanti comuni</a></li>
                <li><a href="#color_button">Pulsante di colorazione</a></li>
                <li><a href="#heading_button">Pulsante di intestazione</a></li>
                <li><a href="#url_button">Pulsante indirizzo</a></li>
                <li><a href="#email_button">Pulsante email</a></li>
                <li><a href="#image_button">Pulsante immagine</a></li>
                <li><a href="#quote_button">Pulsante citazione</a></li>
                <li><a href="#code_button">Pulsante codice</a></li>
                <li><a href="#list_buttons">Pulsante lista</a></li>
                <li><a href="#smilies">Emoticon</a></li>
                <li><a href="#advanced">Caratteristiche avanzate</a></li>
        </ul>

<h1>EZBBC Toolbar</h1>
        
        <h2 id="common_buttons" style="margin-right: 20%;">Pulsanti di formattazione comune</h2>
                <h3>Utilizzo</h3>
                        <p>
                        I pulsanti di formattazione comune servono per aggiungere caratteristiche di uso frequente ai testi. Selezionare il testo da formattare e quindi premere il pulsante desiderato: un marcatore di apertura e uno di chiusura appariranno all'inizio e alla fine del testo. Se non è stato selezionato alcun testo, verranno inseriti i marcatori e il cursore  verrà spostato tra di essi.<br />
                        Esempio di formattazione utilizzando il pulsante Grassetto: <code>[b]Testo selezionato[/b]</code>                        </p>
                        <h3>Sommario</h3>
                        <table>
                                <tbody>
                                        <tr>
                                        <th>Pulsanti</th>
                                        <td><?php echo $bold ?></td>
                                        <td><?php echo $underline ?></td>
                                        <td><?php echo $italic ?></td>
                                        <td><?php echo $strike_through ?></td>
                                        <td><?php echo $delete ?></td>
                                        <td><?php echo $insert ?></td>
                                        <td><?php echo $emphasis ?></td>
                                        </tr>
                                        <tr>
                                        <th>Uso</th>
                                        <td>Grassetto</td>
                                        <td>Sottolineato</td>
                                        <td>Corsivo</td>
                                        <td>Barrato</td>
                                        <td>Cancellato</td>
                                        <td>Inserito</td>
                                        <td>Enfasi</td>
                                        </tr>
                                        <tr>
                                        <th>Marcatori BBCode</th>
                                        <td><code>[b]…[/b]</code></td>
                                        <td><code>[u]…[/u]</code></td>
                                        <td><code>[i]…[/i]</code></td>
                                        <td><code>[s]…[/s]</code></td>
                                        <td><code>[del]…[/del]</code></td>
                                        <td><code>[ins]…[/ins]</code></td>
                                        <td><code>[em]…[/em]</code></td>
                                        </tr>
                                        <tr>
                                        <th>Marcatori HTML</th>
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

        <h2>Pulsanti per colorare e inserire intestazioni (titoli)</h2>
                <h3 id="color_button"><?php echo $colorize ?> Pulsante di colorazione</h3>
                        <p>
                        Il pulsante di colore sar&agrave; usato per colorare il testo selezionato. Selezionare prima il testo al quale cambiare il colore e inserire quindi nella finestra il nome del colore (red, green, blue, purple, …) - per l'elenco completo vedere <a href="http://www.somacon.com/p142.php" onclick="window.open(this.href, 'Color_name', 'height=500, width=310, top=10, left=650, toolbar=no, menubar=no, location=no, resizable=yes, scrollbars=yes, status=no'); return false;">questa pagina</a> - o un codice colore esadecimale (es.: #DDDDDD) - il codice comparir&agrave; automaticamente usando la tavolozza colori. Se nessun testo sar&agrave; selezionato, la frase "Testo da colorare" contenuta nei tag <code>[color]</code> sar&agrave; visualizzata per poterla modificare.<br/>
                        Esempio di formattazione utilizzando il pulsante color: <code>[color=red]Testo selezionato[/color]</code>.</p>
                        <h3 id="heading_button"><?php echo $heading ?> Pulsante di intestazione (titolo)</h3>
                        <p>
                        Il pulsante di intestazione trasforma il testo selezionato in un titolo (intestazione). Selezionare il testo da trasformare in titolo e cliccare sul pulsante. Se non è stato selezionato alcun testo inserire un testo e confermare.                        </p>
                        <h3>Sommario</h3>
                        <table>
                                <tbody>
                                        <tr>
                                        <th>Pulsanti</th>
                                        <td><?php echo $colorize ?></td>
                                        <td><?php echo $heading ?></td>
                                        </tr>
                                        <tr>
                                        <th>Utilizzo</th>
                                        <td>Colorare</td>
                                        <td>Titolo</td>
                                        </tr>
                                        <tr>
                                        <th>Marcatori BBCode</th>
                                        <td><code>[color=color_code]…[/color]</code></td>
                                        <td><code>[h]…[/h]</code></td>
                                        </tr>
                                        <tr>
                                        <th>Marcatori HTML</th>
                                        <td><code>&lt;span style=&quot;color:…&quot; &gt;…&lt;/span&gt;</code></td>
                                        <td><code>&lt;h5&gt;…&lt;/h5&gt;</code></td>
                                        </tr>
                                </tbody>
                        </table>

        <h2>Pulsanti per inserire indirizzi web, email e immagini</h2>
                <h3 id="url_button"><?php echo $link ?> Pulsante indirizzo web </h3>
                        <p>
                        Selezionando del testo prima di cliccare sul pulsante dell'indirizzo apparir&agrave; una finestra col testo stesso come etichetta, alcuni pulsanti di selezione per scegliere il tipo di link da inserire e altri campi in cui inserire l'indirizzo e l'id. Gli indirizzi supportati iniziano con: <code>http://</code>, <code>https://</code>, <code>ftp://</code>, o <code>www.</code>. L'id deve essere un numero intero. Non selezionando alcun testo, cliccando sul pulsante per gli indirizzi apparir&agrave; una finestra dalla quale scegliere il tipo di link (Web, Discussione, Messaggio, Forum, o Utente), l'etichetta dell'indirizzo (opzionale) e l'indirizzo.<br />
                        Esempio di formattazione utilizzando il pulsante url: <code>[url=http://www.indirizzoweb.est]testo da trasformarte in link[/url]</code>.                        </p>
                        <h3 id="email_button"><?php echo $email ?> Pulsante email</h3>
                        <p>
                        Selezionando del testo prima di cliccare sul pulsante dell'indirizzo email apparir&agrave; una finestra col testo stesso come etichetta, sar&agrave; quindi necessario inserire l'indirizzo. &egrave; necessario inserire un indirizzo email valido (contenente una <code>@</code> e un <code>.</code>). Non selezionando alcun testo, cliccando sul pulsante per gli indirizzi email apparir&agrave; una finestra grazie alla quale inserire l'indirizzo email e l'etichetta relativa (opzionale).<br />
                        Esempio di formattazione utilizzando il pulsante email: <code>[email=indirizzo@email.est]mia email[/email]</code>.                        </p>
                        <h3 id="image_button"><?php echo $image ?> Pulsante immagine</h3>
                        <p>
						Selezionando del testo prima di cliccare sul pulsante per inserire immagini apparir&agrave; una finestra col testo stesso come testo alternativo (l'attributo <code>alt</code> nell'HTML), sar&agrave; quindi necessario inserire l'indirizzo dell'immagine. Non selezionando alcun testo, If nothing has been selected, cliccando sul pulsante per l'inserimento immagini apparir&agrave; una finestra grazie alla quale inserire il testo alternativo (opzionale) e l'indirizzo dell'immagine.<br />
                        Esempio di formattazione utilizzando il pulsante di inserimento immagine: <code>[img=testo alternativo]http://www.sito.est/immagine.jpg[/img]</code>.
						</p>
                        <h3>Sommario</h3>
                        <table>
                                <tbody>
                                        <tr>
                                        <th>Pulsanti</th>
                                         <td><?php echo $link ?></td>
                                        <td><?php echo $email ?></td>
                                        <td><?php echo $image ?></td>
                                        </tr>
                                        <tr>
                                        <th>Utilizzo</th>
                                        <td>Indirizzo web </td>
										<td>Link discussione, messaggio, forum o utente</td>
                                        <td>Indirizzo email </td>
                                        <td>Immagine</td>
                                        </tr>
                                        <tr>
                                        <th>Marcatori BBCode</th>
                                        <td><code>[url=http://sitoweb.est]…[/url]</code></td>
										<td><code>[topic=id]…[/topic], [post=id]…[/post], [forum=id]…[/forum], [user=id]…[/user]</code></td>
                                        <td><code>[email=indirizzo@dominio.est]…[/email]</code></td>
                                        <td><code>[img=testo alternativo]…[/img]</code></td>
                                        </tr>
                                        <tr>
                                        <th>Marcatori HTML</th>
                                        <td><code>&lt;a href="http://…"&gt;…&lt;/a&gt;</code></td>
										<td><code>&lt;a href="http://…"&gt;…&lt;/a&gt;</code></td>
                                        <td><code>&lt;a href="mailto:…"&gt;…&lt;/a&gt;</code></td>
                                        <td><code>&lt;img src="…" alt="…" /&gt;</code></td>
                                        </tr>
                                </tbody>
                        </table>
        
        <h2>Pulsanti di citazione e inserimento codice</h2>
                <h3 id="quote_button"><?php echo $quote ?> Pulsante di citazione</h3>
                        <p>
                        Nella finestra che appare &egrave; possibile selezionare il nome dell'autore del testo citato (opzionale) e il testo da citare. Se un testo &egrave; stato selezionato prima di cliccare sul pulsante, sar&agrave; considerato come testo da citare.<br />
                        Esempio di formattazione utilizzando il pulsante di citazione:<br />
                        <code>[quote=nome autore]<br />
                        testo da citare
                        <br />
                        [/quote]</code>
						</p>
                <h3 id="code_button"><?php echo $code ?> Pulsante di inserimento codice</h3>
                        <p>
                        Nella finestra che appare &egrave; possibile scegliere il linguaggio da un menu a tendina (php, html, Javascript… - opzionale) e incollare le linee di codice da inserire. Se un testo &egrave; stato selezionato prima di cliccare sul pulsante, sar&agrave; considerato come codice.<br />
                        Esempio di formattazione utilizzando il pulsante di inserimento codice:<br />
                        <code>[code]<br/>
                        [== linguaggio ==]<br />
                        Codice<br />
                        [/code]</code>.
						</p>
                <h3>Sommario</h3>
                        <table>
                                <tbody>
                                        <tr>
                                        <th>Pulsanti</th>
                                        <td><?php echo $quote ?></td>
                                        <td><?php echo $code ?></td>
                                        </tr>
                                        <tr>
                                        <th>Utilizzo</th>
                                        <td>Citazione</td>
                                        <td>Codice</td>
                                        </tr>
                                        <tr>
                                        <th>Marcatori BBCode</th>
                                        <td><code>[quote=nome autore]…[/quote]</code></td>
                                        <td><code>[code]…[/code]</code></td>
                                        </tr>
                                        <tr>
                                        <th>Marcatori HTML</th>
                                        <td><code>&lt;cite&gt;…&lt;/cite&gt;&lt;blockquote&gt;…&lt;/blockquote&gt;</code></td>
                                        <td><code>&lt;pre&gt;&lt;code&gt;…&lt;/code&gt;&lt;/pre&gt;</code></td>
                                        </tr>
                                </tbody>
                        </table>
        
        <h2 id="list_buttons">Pulsanti per liste </h2>
                <h3>Utilizzo</h3>
                        <p>
                        Selezionare più righe e cliccare sul pulsante: ciascuna di esse sarà automaticamente trasformata in un elemento della lista (puntata, numerica o alfabetica che sia). Se non viene selezionato nulla, apparir&agrave; una finestra nella quale inserire il primo elemento della lista. &Egrave; possibile aggiungere ulteriori elementi cliccando su "aggiungi elemento" o cliccando il tasto "invio". Quando terminato, confermare la lista cliccando sul pulsante destro del mouse (i campi bianchi verranno ignorati).
						</p>
                        <h3>Sommario</h3>
                        <table>
                                <tbody>
                                        <tr>
                                        <th>Pulsanti</th>
                                        <td><?php echo $l_unordered ?></td>
                                        <td><?php echo $l_ordered ?></td>
                                        <td><?php echo $l_a_ordered ?></td>
                                        </tr>
                                        <tr>
                                        <th>Utilizzo</th>
                                        <td>Lista puntata </td>
                                        <td>Lista numerica </td>
                                        <td>Lista alfabetica </td>
                                        </tr>
                                        <tr>
                                        <th>Marcatori BBCode</th>
                                        <td style="text-align: left;"><code>[list=*]<br />[*]…[/*]<br />[*]…[/*]<br />[*]…[/*]<br />[/list]</code></td>
                                        <td style="text-align: left;"><code>[list=1]<br />[*]…[/*]<br />[*]…[/*]<br />[*]…[/*]<br />[/list]</code></td>
                                        <td style="text-align: left;"><code>[list=a]<br />[*]…[/*]<br />[*]…[/*]<br />[*]…[/*]<br />[/list]</code></td>
                                        </tr>
                                        <tr>
                                        <th>Marcatori HTML</th>
                                        <td style="text-align: left;"><code>&lt;ul&gt;<br />&lt;li&gt;…&lt;/li&gt;<br />&lt;li&gt;…&lt;/li&gt;<br />&lt;li&gt;…&lt;/li&gt;<br />&lt;/ul&gt;</code></td>
                                        <td style="text-align: left;"><code>&lt;ol&gt;<br />&lt;li&gt;…&lt;/li&gt;<br />&lt;li&gt;…&lt;/li&gt;<br />&lt;li&gt;…&lt;/li&gt;<br />&lt;/ol&gt;</code></td>
                                        <td style="text-align: left;"><code>&lt;ol type="a"&gt;<br />&lt;li&gt;…&lt;/li&gt;<br />&lt;li&gt;…&lt;/li&gt;<br />&lt;li&gt;…&lt;/li&gt;<br />&lt;/ol&gt;</code></td>
                                        </tr>
                                </tbody>
                        </table>
                        
         <h2 id="smilies">Emoticon</h2>
                <table>
                                <tbody>
                                        <tr>
                                        <th>Marcatori BBCode</th>
                                        <td><code>:)</code><br />                                          o<br />
                                          <code>=)</code></td>
                                        <td><code>:|</code><br />                                          o<br />
                                          <code>=)</code></td>
                                        <td><code>:(</code><br />                                          o<br />
                                          <code>=(</code></td>
                                        <td><code>:D</code><br />                                          o<br />
                                          <code>=D</code></td>
                                        <td><code>:o</code><br />                                          o<br />
                                          <code>:O</code></td>
                                        <td><code>;)</code></td>
                                        <td><code>:/</code></td>
                                        <td><code>:P</code><br />                                          o<br />
                                          <code>:p</code></td>
                                        <td><code>:lol:</code></td>
                                        <td><code>:mad:</code></td>
                                        <td><code>:rolleyes:</code></td>
                                        <td><code>:cool:</code></td>
                                        </tr>
                                        <tr>
                                        <th>Emoticon predefinite (FluxBB)</th>
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
                                         <th>Emoticon personalizzate (EZBBC)</th>
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
                                        <th>Marcatori BBCode</th>
                                        <td><code>O:)</code><br />                                          o<br />
                                          <code>:angel:</code></td> 
                                        <td><code>8.(</code><br />                                          o<br />
                                          <code>:cry:</code></td> 
                                        <td><code>]:D</code><br />                                          o<br />
                                          <code>:devil:</code></td> 
                                        <td><code>8)</code><br />                                          o<br />
                                          <code>:glasses:</code></td>
                                        <td><code>{)</code><br />                                          o<br />
                                          <code>:kiss:</code></td>
                                        <td><code>8o</code><br />                                          o<br />
                                          <code>:monkey:</code></td> 
                                        <td><code>:8</code><br />                                          o<br />
                                          <code>:ops:</code></td>
                                        </tr>
                                        <tr>
                                        <th>Emoticon predefinite (FluxBB)</th>
                                        <td>O:)</td> 
                                        <td>8.(</td> 
                                        <td>]:D</td> 
                                        <td>8)</td>
                                        <td>{)</td>
                                        <td>8o</td> 
                                        <td>:8</td>
                                        </tr>
                                        <tr>
                                         <th>Emoticon personalizzate (EZBBC)</th>
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
           <h2 id="advanced">Caratteristiche avanzate</h2>
		<p>Alcune caratteristiche avanzate sono disponibili all'interno della EZBBC Toolbar. &Egrave; possibile visualizzare una panormica sotto se sono state attivate dall'amministratore del forum.</p>
		
		<?php if ($ezbbc_config['h_id'] == 'h_id'): ?>
		<h3>Aggiungere un attributo <code>id</code> alle intestazioni</h3>
		<p>&Egrave; possibile aggiungere un attributo <code>id</code> alle intestazioni. Lo screenshot seguente mostra una panoramica su ci&ograve; che &egrave; possibile impostare:</p>
		<p class="screenshot"><img src="images/heading_window.png" alt="Inserimento intestazioni" /></p>
		<p>Questo il BBCode utilizzato:</p>
		<p><code>[h=title01]First title[/h]</code></p>
		<p>Questo il codice HTML generato:</p>
		<p><code>&lt;h5 id=&quot;title01&quot;&gt;&lt;a href=&quot;#title01&quot;&gt;#&lt;/a&gt; Primo titolo&lt;/h5&gt;</code></p>
		<?php endif; ?>
		
		<?php if ($ezbbc_config['video'] == 'video'): ?>
		<h3>Tag Video</h3>
		<p>&Egrave; possibile aggiungere video (Youtube e Dailymotion) utilizzando l'apposito tag. Lo screenshot seguente mostra un esempio:</p>
		<p class="screenshot"><img src="images/video_window.png" alt="Inserimento video" /></p>
		<p>Questo il BBCode utilizzato:</p>
		<p><code>[video=560,315][url]http://youtu.be/yyIK0dwg6rM[/url][/video]</code></p>
		<p>Questo il codice HTML generato:</p>
		<p><code>&lt;iframe width=&quot;560&quot; height=&quot;315&quot; src=&quot;http://www.youtube.com/embed/yyIK0dwg6rM?rel=0&quot; frameborder=&quot;0&quot; allowfullscreen&gt;&lt;/iframe&gt;</code></p>
		<?php endif; ?>
		
		<?php if ($ezbbc_config['img_upload'] == 'img_upload'): ?>
		<h3>Caricamento immagini</h3>
		<p>&Egrave; possibile caricare immagini da pubblicare sul forum. I formati permessi sono: gif, png, jpg, and jpeg. Cliccare sul pulsante seguente per accedere al modulo di caricamento: <?php echo $image ?>.</p>
		<p>Uno screenshot della finestra per il caricamento di immagini contenente immagini gi&agrave; caricati:</p>
		<p class="screenshot"><img src="images/image_window.png" alt="Caricamento immagini" /></p>
		<p>Per caricare un'immagine, cliccare sul pulsante "Sfoglia" e selezionare il file desiderato, quindi cliccare sul pulsante "Carica immagine". Inserire un testo alternativo (opzionale) e quindi cliccare sul pulsante "OK". Se l'opzione &egrave; stata attivata dall'amministratore, &egrave; inoltre possibile visualizzare e gestire le immagini caricate. Cliccare sulla prima icona per visualizzare l'immagine. Cliccare sulla seconda per rimuoverla. Cliccare sulla terza aggiunger&agrave; il suo indirizzo al campo corrispondente (se si desidera aggiungere l'immagine al messaggio pubblicato).</p>
		<?php endif; ?>
		
		<?php if($ezbbc_config['doc_upload'] == 'doc_upload'): ?>
		<h3>Caricamento documenti</h3>
		<p>&Egrave; possibile caricare documenti da linkare sul forum. I formati permessi sono: <?php echo $ezbbc_config['allowed_ext'] ?>. Cliccare sul pulsante seguente per accedere al modulo di caricamento: <?php echo $link ?>.</p>
		<p>Uno screenshot della finestra per il caricamento di documenti contenente documenti gi&agrave; caricati:</p>
		<p class="screenshot"><img src="images/doc_window.png" alt="Caricamento documenti" /></p>
		<p>Per caricare un documento, cliccare sul pulsante "Sfoglia" e selezionare il file desiderato, quindi cliccare sul pulsante "Carica file". Inserire una etichetta (opzionale) e quindi cliccare sul pulsante "OK". Se l'opzione &egrave; stata attivata dall'amministratore, &egrave; inoltre possibile visualizzare e gestire i documenti caricati. Cliccare sulla prima icona per visualizzare il documento. Cliccare sulla seconda per rimuoverlo. Cliccare sulla terza aggiunger&agrave; il suo indirizzo al campo corrispondente (se si desidera aggiungere l'url del documento al messaggio pubblicato).</p>
		<?php endif; ?>
</div>
</div>
</div>
</div>
</body>
</html>
