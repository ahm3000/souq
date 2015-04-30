<?php

$disabled = '';
switch ($mode){
	case 'view':
		$url = "product";
		$submit_action = "عرض";
		$disabled = 'disabled';
		break;
	case 'add':
		$url = "product/add";
		$submit_action = "إضافة";
		break;
	case 'edit':
		$url = "product/edit/".$id;
		$submit_action = "تعديل";
		break;
	case 'delet':
		$url = "product/delete/".$id;
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
		<label>السعر</label> 
		<input class="form-control" name="price" id="price" value="<?php echo $price;?>" type="text" <?php echo $disabled;?> />
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
			<a class="btn btn-danger" href="<?php echo base_url("product/removeimg/".$id)?>"><i class="fa fa-trash-o"></i> إزالة الصورة</a>
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