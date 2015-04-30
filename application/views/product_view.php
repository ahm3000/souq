



<div class="col-lg-12 text-center">
	<a href="<?php echo base_url($img);?>" data-lightbox="roadtrip">
		<img width="200" src="<?php echo base_url($img);?>" />
	</a>
</div>
<?php 
foreach ($imgs as $img){

?>
<div class="col-lg-3 text-center" >
	<div class="panel panel-default" style="padding: 5px;">
		<a href="<?php echo base_url($img['img']);?>" data-lightbox="roadtrip">
			<img width="160" src="<?php echo base_url($img['img']);?>" height="120">
		</a>
	</div>
</div>
<?php 
}
?>
<div class="col-lg-12 text-primary">
	<h3><?php echo $name;?></h3>
</div>
<!-- <div class="col-lg-12 text-right text-warning">السعر : <?php echo $price;?> ريال سعودي</div>-->
<?php if ($price0>0) {?>
<div class="col-lg-12 text-right text-warning" style="margin:0 10px;color: red;">قبل : <span style="text-decoration: line-through;"><?php echo $price0;?></span> ريال سعودي</div>
<?php }?>
<div class="col-lg-12 text-right text-warning" style="margin:0 10px;">الآن : <?php echo $price;?> ريال سعودي</div>

<?php if ($no_orders>0) {
	?>
	<div class="col-lg-12 text-justify text-muted">عدد الطلبات المسجلة   : <?php echo ($no_orders);?></div>
	<?php 
}?>

<div class="col-lg-12 text-justify text-muted">عدد الطلبات المتاحة   : <?php echo ($all_no - $no_orders);?></div>
<div class="col-lg-12 text-justify text-info"><?php echo nl2br($text);?></div>

<div class="col-lg-12 text-center">
<div class="form-group">
	<a class="btn btn-primary" href="<?php echo base_url('orders/add/'.$id)?>">اطلب المنتج</a>
</div>
</div>



