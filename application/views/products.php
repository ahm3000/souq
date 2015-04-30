<?php

$disabled = '';
switch ($mode){
	case 'view':
		$url = "products";
		$submit_action = "عرض";
		$disabled = 'disabled';
		break;
	case 'add':
		$url = "products/add";
		$submit_action = "إضافة";
		$name='';$img='';$text='';$price='';$all_no='';$last_reg=date("Ymd");
		break;
	case 'edit':
		$url = "products/edit/".$id;
		$submit_action = "تعديل";
		break;
	case 'delet':
		$url = "products/delete/".$id;
		$submit_action = "حذف";
// 		$hidden = array('con')
		break;
}
?>

<div class="page-header">
	<h2 id="progress"><?php echo $submit_action;?> منتج</h2>
</div> 
<div class="col-lg-12">           
<?php 
echo form_open_multipart(base_url($url),'method="post"');
?>

<div class="col-lg-6">
	<div class="form-group">
		<label>اسم المنتج</label> 
		<input class="form-control" name="name" id="name" value="<?php echo $name;?>" type="text" <?php echo $disabled;?>/>
	</div>
</div>

<div class="col-lg-6">
	<div class="form-group">
		<label>التصنيف</label> 
		<?php echo form_dropdown('cat_id', $cats, $cat_id , 'id="cat_id" class="form-control" '.$disabled);?>
	</div>
</div>

<div class="col-lg-6">
	<div class="form-group">
		<label>السعر الحالي</label> 
		<input class="form-control" name="price" id="price" value="<?php echo $price;?>" type="text" <?php echo $disabled;?> />
	</div>
</div>

<div class="col-lg-6">
	<div class="form-group">
		<label>السعر السابق</label> 
		<input class="form-control" name="price0" id="price0" value="<?php echo $price0;?>" type="text" <?php echo $disabled;?> />
	</div>
</div>

<div class="col-lg-6">
	<div class="form-group">
		<label>العدد المطلوب</label> 
		<input class="form-control" name="all_no" id="all_no" value="<?php echo $all_no;?>" type="text" <?php echo $disabled;?> />
	</div>
</div>

<div class="col-lg-6">
	<div class="form-group">
		<label>آخر موعد للحجز	</label> 
		<input class="form-control datepicker" name="last_reg" id="last_reg" value="<?php echo date_int2string($last_reg);?>" type="text" <?php echo $disabled;?> />
	</div>
</div>

<div class="col-lg-6">
	<div class="form-group">
		<label>عرض في الرئيسية</label> 
		<?php echo form_dropdown('homepage', array(0=>'لا',1=>'نعم'), $homepage , 'id="homepage" class="form-control" '.$disabled);?>
	</div>
</div>

<div class="col-lg-12">
	<div class="form-group">
		<label>وصف المنتج</label> 
		<textarea rows="4" class="form-control" name="text" id="text" <?php echo $disabled;?>><?php echo $text;?></textarea>
	</div>
</div>
<?php 
if (file_exists($img)){
	?>
<div class="col-lg-4">
		<div class=form-group>
			<label>الصورة الحالية</label><br>
			<img width="150" src="<?php echo base_url($img);?>"><br>
			<?php if (!$disabled) {?>
			<a class="btn btn-danger" href="<?php echo base_url("products/removeimg/".$id)?>"><i class="fa fa-trash-o"></i> إزالة الصورة</a>
			<?php }?>
		</div>
</div>

	<?php 
}
else {
?>
<div class="col-lg-6">
		<label>صورة المنتج</label> 
		<input class="form-control" name="img" id="img" type="file"  <?php echo $disabled;?>/><br/>
		الحد الأقصى : <?php echo ini_get("upload_max_filesize");?>
</div>
<?php 
}

?>
<div class="col-lg-12">
<label>صور إضافية</label>
</div>
<div class="col-lg-12">
	<div class="row">
		 
		<?php 
	foreach ($imgs as $img){
// 		print_r($img);
		?>
		<div class="col-lg-3 text-center" >
		<div class="panel panel-default" style="padding: 5px;">
		<img width="160" src="<?php echo base_url($img['img']);?>" height="120">
			<?php if (!$disabled) {?>
			<a class="btn btn-danger" href="<?php echo base_url("imgs/delete/".$img['id'])?>"><i class="fa fa-trash-o"></i></a>
			<?php }
			?>
			</div>
			</div>
			<?php 
}
?>
<?php if (!$disabled) {?>
			<div class="col-lg-3"><a class="btn btn-primary" href="<?php echo base_url("imgs/add/".$id)?>"><i class="fa fa-plus"></i></a><br><br></div>
			<?php }?>
	</div>
</div>

<div class="col-lg-12">
	<?php if (strlen($disabled)>0){?>
	<button class="btn btn-default" onclick="goBack()">رجوع</button>
	<?php }
	else {?>
	<input class="btn btn-default" name="submit_action" id="name" value="<?php echo $submit_action;?>" type="submit" <?php echo $disabled;?> />
	<?php }?>
</div>

<?php 
echo form_close();
?>

</div>
<br />