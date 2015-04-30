<?php

$disabled = '';
switch ($mode){
	case 'view':
		$url = "pages";
		$submit_action = "عرض";
		$disabled = 'disabled';
		break;
	case 'add':
		$url = "pages/add";
		$submit_action = "إضافة";
		$name='';$img='';$text='';$price='';$all_no='';$last_reg=date("Ymd");
		break;
	case 'edit':
		$url = "pages/edit/".$id;
		$submit_action = "تعديل";
		break;
	case 'delet':
		$url = "pages/delete/".$id;
		$submit_action = "حذف";
// 		$hidden = array('con')
		break;
}
?>

<div class="page-header">
	<h2 id="progress"><?php echo $submit_action;?> صفحة</h2>
</div> 
<div class="col-lg-12">           
<?php 
echo form_open_multipart(base_url($url),'method="post"');
?>

<div class="col-lg-6">
	<div class="form-group">
		<label>اسم الصفحة</label> 
		<input class="form-control" name="name" id="name" value="<?php echo $name;?>" type="text" <?php echo $disabled;?>/>
	</div>
</div>


<div class="col-lg-12">
	<div class="form-group">
		<label>محتوى الصفحة</label> 
		<textarea rows="4" class="form-control" name="text" id="text" <?php echo $disabled;?>><?php echo $text;?></textarea>
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