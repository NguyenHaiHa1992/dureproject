<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>AM Precision Tool | Order Tracking System</title>
		<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
		<!-- Bootstrap 3.3.2 -->
		<link href="<?php echo Yii::app()->baseUrl;?>/../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<!-- FontAwesome 4.3.0 -->
		<!-- <link href="amp/css/font-awesome.min.css" rel="stylesheet" type="text/css" /> -->
		<!-- <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet"> -->
		<!-- Ionicons 2.0.0 -->
		<link href="<?php echo Yii::app()->baseUrl;?>/../amp/css/ionicons.min.css" rel="stylesheet" type="text/css" />
		<!-- DATA TABLES -->
		<link href="<?php echo Yii::app()->baseUrl;?>/../plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css">
		<!-- Theme style -->
		<link href="<?php echo Yii::app()->baseUrl;?>/../dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
		<!-- AdminLTE Skins. Choose a skin from the css/skins
		folder instead of downloading all of them to reduce the load. -->
		<link href="<?php echo Yii::app()->baseUrl;?>/../amp/css/skin-amp.css" rel="stylesheet" type="text/css" />
		<!-- iCheck -->
		<link href="<?php echo Yii::app()->baseUrl;?>/../plugins/iCheck/square/blue.css" rel="stylesheet" type="text/css" />
		<!-- Morris chart -->
		<link href="<?php echo Yii::app()->baseUrl;?>/../plugins/morris/morris.css" rel="stylesheet" type="text/css" />
		<!-- jvectormap -->
		<link href="<?php echo Yii::app()->baseUrl;?>/../plugins/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
		<!-- Date Picker -->
		<link href="<?php echo Yii::app()->baseUrl;?>/../plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
		<!-- Daterange picker -->
		<link href="<?php echo Yii::app()->baseUrl;?>/../plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
		<!-- bootstrap wysihtml5 - text editor -->
		<link href="<?php echo Yii::app()->baseUrl;?>/../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />

		<!-- my css -->
		<link href="<?php echo Yii::app()->baseUrl;?>/../amp/css/amp.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo Yii::app()->baseUrl;?>/../amp/css/jquery-ui.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo Yii::app()->baseUrl;?>/../amp/css/sweet-alert.css" rel="stylesheet" type="text/css">
		<link href="<?php echo Yii::app()->baseUrl;?>/../amp/css/chosen.css" rel="stylesheet" type="text/css">
		<link href="<?php echo Yii::app()->baseUrl;?>/../amp/css/chosen-spinner.css" rel="stylesheet" type="text/css">
		<!-- <link href="amp/css/select.css" rel="stylesheet" type="text/css" /> -->
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
		<![endif]-->
	</head>
	<body class="skin-amp sidebar-collapse" style="min-height: 100%; height: 100%">
		<div class="wrapper" id="login_wrapper" style="min-height: 100%; height: 100%">

			
			<!-- Right side column. Contains the navbar and content of the page -->
			<?php echo $content;?>

			<footer class="main-footer">
				<div class="pull-right hidden-xs">
					<b>Version</b> 1.0
				</div>
				<strong>Copyright &copy; 2015 <a href="#">AMP</a>.</strong> All rights reserved.
			</footer>

			<div class="modal" id="loadingModal" tabindex="-1" role="dialog" aria-labelledby="loadingModalLabel" aria-hidden="true" >
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="loading"></div>
					</div>
				</div>
			</div>

		</div><!-- ./wrapper -->

		<!-- jQuery 2.1.3 -->
		<script src="<?php echo Yii::app()->baseUrl;?>/../plugins/jQuery/jQuery-2.1.3.min.js"></script>

		<!-- Chosen 1.1.0 -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.1.0/chosen.jquery.min.js"></script>
		<!-- jQuery UI 1.11.2 -->
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js" type="text/javascript"></script>

		<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
		<script>
			$.widget.bridge('uibutton', $.ui.button);
		</script>

		<!-- Bootstrap 3.3.2 JS -->
		<script src="<?php echo Yii::app()->baseUrl;?>/../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
		<style>
		html, body, .fullheight {
		    min-height: 100% !important;
		    height: 100%;
		}
		#login_wrapper .main-footer {
		  background: none;
		  border-top: 1px solid #444;
		  color: #888;
		  position: fixed;
		  width: 100%;
		  bottom: 0;
		}
		</style>
	</body>
</html>