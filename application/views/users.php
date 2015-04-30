<?php

$disabled = '';
switch ($mode){
	case 'view':
		$url = "users";
		$submit_action = "عرض";
		$disabled = 'disabled';
		break;
	case 'add':
		$url = "users/add";
		$name ='';$login='';$mobile='';$email='';$password='';
		$submit_action = "إضافة";
		break;
	case 'edit':
		$url = "users/edit/".$id;
		$submit_action = "تعديل";
		break;
	case 'delet':
		$url = "users/delete/".$id;
		$submit_action = "حذف";
// 		$hidden = array('con')
		break;
}
?>

<div class="page-header">
	<h2 id="progress"><?php echo $submit_action;?> عضو</h2>
</div> 
<div class="col-lg-12">           
<?php 
echo form_open(base_url($url),'method="post"');
?>

<div class="col-lg-6">
	<div class="form-group">
		<label>اسم العضو</label> 
		<input class="form-control" name="name" id="name" value="<?php echo $name;?>" type="text" <?php echo $disabled;?>/>
	</div>
</div>
<div class="col-lg-6">
	<div class="form-group">
		<label>اسم الدخول</label> 
		<input class="form-control" name="login" id="login" value="<?php echo $login;?>" type="text" <?php echo $disabled;?>/>
	</div>
</div>

<div class="col-lg-6">
	<div class="form-group">
		<label>الجوال</label> 
		<input class="form-control" name="mobile" id="mobile" value="<?php echo $mobile;?>" type="text" <?php echo $disabled;?>/>
	</div>
</div>

<div class="col-lg-6">
	<div class="form-group">
		<label>البريد الالكتروني</label> 
		<input class="form-control" name="email" id="email" value="<?php echo $email;?>" type="text" <?php echo $disabled;?>/>
	</div>
</div>

<div class="col-lg-6">
	<div class="form-group">
		<label>كلمة المرور</label> 
		<input class="form-control" name="password" id="password" value="" type="password" <?php echo $disabled;?>/>
	</div>
</div>
<div class="col-lg-12">
		<label>الصلاحيات</label>
	<div class="form-group">
	<?php
foreach ( $permissions as $permission ) {
	
	$attributes = array (
			'class' => 'lable' 
	);

	?>
	<div class="col-lg-3">
			<?php 
			$input = array (
					'name' => 'perm[]',
					'id' => 'perm_' . $permission ['id'],
					'class' => 'permissions',
					'value' => $permission ['id'],
					'checked' => (in_array($permission['id'], $users_permissions)?true:false),
			);
			echo form_label (form_checkbox ( $input ).'<span> </span>'.$permission ['text'], 'perm_' . $permission ['id'], $attributes );
			?>
	</div>
	
	<?php 
	if (intval(substr($permission ['id'], 3, 1))==4) {
		echo '<div style="clear:both;"><hr></div>';
	}
	
}
echo '<label for="checkAll" class="lable"><input type="checkbox" name="checkAll" value="0" id="checkAll"> تحديد الكل</label>';
?>
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