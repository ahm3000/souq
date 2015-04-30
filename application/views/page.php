<div class="widget">
	<div class="widget-header">
		<i class="icon-home"></i>
		<h3><?php echo $pagetitle;?></h3>
	</div>
	

	<div id="alert" style="display: none;" class="alert <?php echo $this->session->flashdata('message_type');?>">
		<button type="button" class="close" data-dismiss="alert">×</button>
		<span class="confirm-div"></span>
	</div>
	
	<br class="clearfix" />
	<div class="widget-content">
		<?php echo $content;?>
	</div>
	<div class="col-lg-12" style="height: 20px;">
	</div>
</div>