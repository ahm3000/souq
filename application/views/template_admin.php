<!DOCTYPE html>
<!--[if lt IE 7 ]> <html class="ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie8" lang="en"> <![endif]-->
<!--[if IE 9 ]>    <html class="ie9" lang="en"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html class="" lang="en"> <!--<![endif]-->
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">


<title> مدارس الأقصى -  <?php echo $pagetitle;?></title>

<!-- Bootstrap core CSS -->
<link href="<?php echo base_url("theme/sb-admin")?>/css/bootstrap.css?e=<?php echo rand(1000, 9999)?>"
	rel="stylesheet">

<!-- Add custom CSS here -->
<link href="<?php echo base_url("theme/sb-admin")?>/css/sb-admin.css?e=<?php echo rand(1000, 9999)?>"
	rel="stylesheet">
<link rel="stylesheet" href="<?php echo base_url("theme/sb-admin")?>/css/lightbox.css">
<link rel="stylesheet" href="<?php echo base_url("theme/sb-admin")?>/font-awesome/css/font-awesome2.css">
<!--     <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet"> -->
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
	
</head>

<body>
	<div id="wrapper">


		<!-- Sidebar -->
		<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse"
					data-target=".navbar-ex1-collapse">
					<span class="sr-only">Toggle navigation</span> <span
						class="icon-bar"></span> <span class="icon-bar"></span> <span
						class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="<?php echo base_url("admin");?>">مدارس الأقصى - العروض الخاصة بالعاملين</a>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse navbar-ex1-collapse">
				<ul class="nav navbar-nav side-nav">
					<!--  -->
					<li><a href="<?php echo base_url("page/view/1");?>"> <i
							class="fa fa-info-circle"></i> نبذة عن النظام
					</a></li>
					<!--  -->
					<?php if (in_array('1051' , $permissions) || in_array('1052' , $permissions) || in_array('1053' , $permissions) || in_array('1054' , $permissions)){?>
					<li><a href="<?php echo base_url("pages");?>"> <i
							class="fa fa-file-text-o"></i> الصفحات
					</a></li>
					<?php }?>
					<!--  -->
					<?php if (in_array('1041' , $permissions) || in_array('1042' , $permissions) || in_array('1043' , $permissions) || in_array('1044' , $permissions)){?>
					<li><a href="<?php echo base_url("products");?>"> <i
							class="fa fa-th-large"></i> المنتجات
					</a></li>
					<?php }?>
					<!--  -->
					<?php if (in_array('2001' , $permissions) || in_array('2002' , $permissions) || in_array('2003' , $permissions) || in_array('2004' , $permissions)){?>
					<li><a href="<?php echo base_url("users");?>"> <i
							class="fa fa-user-md"></i> الأعضاء 
					</a></li>
					<?php }?>
					<?php if (!in_array('1100' , $permissions)){?>
					<li><a href="<?php echo base_url("market");?>"> <i
							class="fa fa-desktop"></i> المعرض 
					</a></li>
					
					<?php }?>
					<!--  -->
					<?php if (!in_array('1100' , $permissions)){?>
					<li><a href="<?php echo base_url("orders");?>"> <i
							class="fa fa-shopping-cart"></i> طلباتي 
					</a></li>
					
					<?php }?>
					<!--  -->
					<li><a href="<?php echo base_url("logout");?>"> <i
							class="fa fa-power-off"></i> تسجيل الخروج 
					</a></li>
				</ul>

				<ul class="nav navbar-nav navbar-right navbar-user">
					<li><a href="#"><i class="fa fa-user"></i> مرحباً بك : <?php echo $username;?></a></li>
				</ul>
			</div>
			<!-- /.navbar-collapse -->
		</nav>

		<div id="page-wrapper">
			<div class="row">
				<div class="col-lg-12">
					<ol class="breadcrumb">
						<li><a href="<?php echo base_url('market');?>"><i class="fa fa-dashboard"></i> الرئيسية</a></li>
						<li class="active"><i class="fa fa-table"></i> <?php echo $pagetitle;?></li>
					</ol>
				</div>
			</div>
			<!-- /.row -->


			<div class="bs-example">
				<ul class="nav nav-pills">
				<?php
// 				print_r($sub_menu); 
				if (is_array($sub_menu)) 
				foreach ($sub_menu as $menu_link=>$menu_text){
					echo "<li class=\"active\"><a href=\"".base_url($menu_link)."\">$menu_text</a></li>";
}
				
				?>
<!-- 					<li class="active"><a href="#">Home</a></li> -->
<!-- 					<li class="active"><a href="#">Profile</a></li> -->
				</ul>
			</div>
        

		<?php echo $content;?>
        
      </div>
		<!-- /#page-wrapper -->

	</div>
	<!-- /#wrapper -->

	<!-- JavaScript -->
	<script
		src="<?php echo base_url("theme/sb-admin")?>/js/jquery-1.10.2.js"></script>

	  <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
		
	<script src="<?php echo base_url("theme/sb-admin")?>/js/bootstrap.js"></script>

	<!-- Page Specific Plugins -->
	<script
		src="<?php echo base_url("theme/sb-admin")?>/js/tablesorter/jquery.tablesorter.js"></script>
	<script src="<?php echo base_url("theme/sb-admin")?>/js/tablesorter/tables.js"></script>
	<script src="<?php echo base_url("theme/sb-admin")?>/js/lightbox.js"></script>
	<script>
	// assumes you're using jQuery
	$(document).ready(function() {
		$('#checkAll').click(function () {    
		    $('.permissions').prop('checked', this.checked);    
		});
		$('#alert').hide();
		<?php if($this->session->flashdata('message')){ ?>
		$('#alert').show();
		$('.confirm-div').html('<?php echo $this->session->flashdata('message'); ?>').show();
		<?php } ?>
		$('#alert').delay(3000).fadeOut(3000);

		$( ".datepicker" ).datepicker({ 
			dateFormat: "yy-mm-dd",
			isRTL: true, 
			minDate: new Date(<?php echo date("Y")?>, <?php echo date("m")?> - 1, <?php echo date("d")?>)
				});
	});

	(function ($) {
	    "use strict";

	    // Detecting IE
	    var oldIE;
	    if ($('html').is('.ie6, .ie7, .ie8')) {
	        oldIE = true;
	    }

	    if (oldIE) {
	        alert("متصفحك غير متوافق مع النسخة الحالية من النظام ... نأسف لذلك");
	        window.location = "<?php echo base_url("logout")?>";
	    } else {
	        // ..And here's the full-fat code for everyone else
	    }

	}(jQuery));
	</script>
<div style="clear: both;border-top: 1px dotted #ccc;margin: 15px;padding: 20px;text-align: center">
	<p class="text-muted">جميع الحقوق محفوظة لمدارس الأقصى &copy; 2014</p>
</div>
</body>
</html>