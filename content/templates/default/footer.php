<?php 
/**
 * 页面底部信息
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
</div><!--end #content-->
<div style="clear:both;"></div>
<div id="footerbar">
	Copyright @ 2013-2015 <a href="http://www.wowotech.net" title="wowotech">蜗窝科技</a> All rights reserved.
	Powered by <a href="http://www.emlog.net" title="采用emlog系统">emlog</a>
	<a href="http://www.miibeian.gov.cn" target="_blank"><?php echo $icp; ?></a> <?php echo $footer_info; ?>
	<?php doAction('index_footer'); ?>
</div><!--end #footerbar-->
</div><!--end #wrap-->
<script>prettyPrint();</script>
</body>
</html>