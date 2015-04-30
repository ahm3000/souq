<div class="col-lg-12" style="border: 1px solid #ccc;padding-bottom: 15px;">           
<?php
echo form_open ( base_url ( "users/search" ), 'method="post"' );
?>
<div class="form-group">
		<div class="col-lg-3">
			<label>البحث في المستخدمين :</label>
		</div>
		
		<div class="col-lg-6">
			<input class="form-control" name="name" id="name" placeholder="كلمة البحث" type="text" />
		</div>

		<div class="col-lg-1">
			<input class="btn btn-default" name="action" id="name" value="ابحث"
				type="submit" />
		</div>
</div>
<?php
echo form_close();
?>

</div>