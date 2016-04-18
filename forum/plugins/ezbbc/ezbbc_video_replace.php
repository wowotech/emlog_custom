<?php 
// DailyMotion videos
$replace[] = '<iframe width="480" height="360" src="http://www.dailymotion.com/embed/video/$4"></iframe>';
$replace[] = '<iframe width="$1" height="$2" src="http://www.dailymotion.com/embed/video/$6"></iframe>';
// Youtube Videos
$replace[] = '<iframe width="480" height="360" src="http://www.youtube.com/embed/$4"></iframe>';
$replace[] = '<iframe width="$1" height="$2" src="http://www.youtube.com/embed/$6"></iframe>';
// Vimeo Videos
$replace[] = '<iframe width="480" height="360" src="http://player.vimeo.com/video/$4"></iframe>';
$replace[] = '<iframe width="$1" height="$2" src="http://player.vimeo.com/video/$6"></iframe>';
?>
