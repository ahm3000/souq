<?php

$disabled = '';
switch ($mode){
	case 'view':
		$url = "cats";
		$submit_action = "عرض";
		$disabled = 'disabled';
		break;
	case 'add':
		$url = "cats/add";
		$submit_action = "إضافة";
		break;
	case 'edit':
		$url = "cats/edit/".$id;
		$submit_action = "تعديل";
		break;
	case 'delet':
		$url = "cats/delete/".$id;
		$submit_action = "حذف";
// 		$hidden = array('con')
		break;
}
?>

<div class="page-header">
	<h2 id="progress"><?php echo $submit_action;?> تصنيف</h2>
</div> 
<div class="col-lg-12">           
<?php 
echo form_open_multipart(base_url($url),'method="post"');
?>

<div class="col-lg-6">
	<div class="form-group">
		<label>اسم التصنيف</label> 
		<input class="form-control" name="name" id="name" value="<?php echo $name;?>" type="text" <?php echo $disabled;?>/>
	</div>
</div>
<div class="col-lg-6">
	<div class="form-group">
		<label>حالة التصنيف</label> 
		<?php echo form_dropdown('active', array(0=>'غير مفعل',1=>'مفعل'), $active , 'id="active" class="form-control" '.$disabled);?>
	</div>
</div>
<div class="col-lg-12">
	<div class="form-group">
		<label>وصف التصنيف</label> 
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
			<a class="btn btn-danger" href="<?php echo base_url("cats/removeimg/".$id)?>"><i class="fa fa-trash-o"></i> إزالة الصورة</a>
			<?php }?>
		</div>
</div>

	<?php 
}
else {
?>
<div class="col-lg-6">
		<label>صورة التصنيف</label> 
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