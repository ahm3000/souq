


<div class="col-lg-3">
	<div class="well">           
		<div  class="col-lg-12 text-center text-primary"><?php echo $name;?></div>
		<div  class="col-lg-12 text-center"><a href="<?php echo base_url('market/view/'.$id);?>"><img width="120" height="90" src="<?php echo base_url($img);?>" /></a></div>
		<div  class="col-lg-12 text-center text-warning">
			<?php if ($price0>0) {?>
			<div style="margin:0 10px;color: red;">قبل : <span style="text-decoration: line-through;"><?php echo $price0;?></span></div>
			<?php }?>
			<div style="margin:0 10px;">الآن : <?php echo $price;?></div>
		</div>
		<div class="clearfix"></div>
	</div>
	
</div>
