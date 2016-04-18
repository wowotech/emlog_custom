<?php 
// DayliMotion Videos
$pattern[] = '%\[video\](\[url\])?([^\[<]*?)/(video|dai\.ly)/([^_\[<]*?)(_([^\[<]*?))?(\[/url\])?\[/video\]%ms';
$pattern[] = '%\[video=([0-9]+),([0-9]+)\](\[url\])?([^\[<]*?)/(video|dai\.ly)/([^_\[<]*?)(_([^\[<]*?))?(\[/url\])?\[/video\]%ms';
// Youtube Videos
$pattern[] = '%\[video\](\[url\])?([^\[<]*?)/(youtu\.be/|watch\?v=|watch\?[^\s]+v=)([^\[<]*?)(\[/url\])?\[/video\]%ms';
$pattern[] = '%\[video=([0-9]+),([0-9]+)\](\[url\])?([^\[<]*?)/(youtu\.be/|watch\?v=|watch\?[^\s]+v=)([^\[<]*?)(\[/url\])?\[/video\]%ms';
// Vimeo videos
$pattern[] = '%\[video\](\[url\])?([^\[<]*?)/(vimeo\.com/)([^\[<]*?)(\[/url\])?\[/video\]%ms';
$pattern[] = '%\[video=([0-9]+),([0-9]+)\](\[url\])?([^\[<]*?)/(vimeo\.com/)([^\[<]*?)(\[/url\])?\[/video\]%ms';
?>
