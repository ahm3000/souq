<?php

$disabled = '';
switch ($mode){
	case 'add':
		$url = "imgs/add/".$product_id;
		$submit_action = "إضافة";
		$name='';$img='';$text='';$price='';$all_no='';$last_reg=date("Ymd");
		break;
}
?>

<div class="page-header">
	<h2 id="progress"><?php echo $submit_action;?> صورة لمنتج</h2>
</div> 
<div class="col-lg-12">           
<?php 
echo form_open_multipart(base_url($url),'method="post"');
?>

<div class="col-lg-6">
	<div class="form-group">
		<label>عنوان الصورة </label> 
		<input class="form-control" name="name" id="name" value="<?php echo $name;?>" type="text" <?php echo $disabled;?>/>
	</div>
</div>


<div class="col-lg-6">
		<label>ملف الصورة </label> 
		<input class="form-control" name="img" id="img" type="file"  <?php echo $disabled;?>/><br/>
		الحد الأقصى : <?php echo ini_get("upload_max_filesize");?>
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