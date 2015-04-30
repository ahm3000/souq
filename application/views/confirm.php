
<?php 

$func = (isset($func) && strlen($func)>0) ?$func:"delete";
?>

<div class="col-lg-12">
	<div class="panel panel-danger">
		<div class="panel-heading">
			<h3 class="panel-title">رسالة تأكيد</h3>
		</div>
		<div class="panel-body">
			<p><?php echo $message;?></p>
			<p>
				<a class="btn btn-danger" href="<?php echo base_url("$controler_name/$func/$id/1")?>">نعم</a>
				<a class="btn btn-success" href="<?php echo base_url("$controler_name")?>">لا</a>
			</p>
		</div>
	</div>
</div>
