<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title> مدارس الأقصى </title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url("theme/sb-admin")?>/css/bootstrap.css" rel="stylesheet">

    <!-- Add custom CSS here -->
    <link href="<?php echo base_url("theme/sb-admin")?>/css/sb-admin.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url("theme/sb-admin")?>/font-awesome/css/font-awesome2.css">
<!--     <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet"> -->
  </head>

  <body>
 
	<div class="container">
        <div class="row">
        	<div  style="text-align: center;"><img alt="login" src="<?php echo base_url("theme/images/50.jpg")?>"></div>
            <div class="col-md-4 col-md-offset-4">
				
            
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">تسجيل الدخول</h3>
                    </div>
                    <div class="panel-body">
                     <?php if (strlen($message)>0) {?>
                    <div id="alert1" class="alert alert-danger">
						<button type="button" class="close" data-dismiss="alert">×</button>
						<span class="confirm-div"><?php echo $message;?></span>
					</div>
                        <?php 
}
                        echo form_open(base_url("login"));
                        ?>
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="اسم المستخدم" name="login" type="text" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="كلمة المرور" name="password" type="password" value="">
                                    
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <input class="btn btn-lg btn-success btn-block" value="دخول" name="submit_action" type="submit">
                            </fieldset>
                            <input class="form-control" placeholder="كلمة المرور" name="redirect" type="hidden" value="<?php echo $_GET['redirect'];?>">
                        <?php 
                        echo form_close();
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="<?php echo base_url("theme/sb-admin")?>/js/jquery-1.10.2.js"></script>
    <script src="<?php echo base_url("theme/sb-admin")?>/js/bootstrap.js"></script>

    <!-- Page Specific Plugins -->
    <script src="<?php echo base_url("theme/sb-admin")?>/js/tablesorter/jquery.tablesorter.js"></script>
    <script src="<?php echo base_url("theme/sb-admin")?>/js/tablesorter/tables.js"></script>
	
  </body>
</html>