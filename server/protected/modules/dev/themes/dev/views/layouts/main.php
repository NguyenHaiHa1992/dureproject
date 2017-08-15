<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="<?php echo Yii::app()->theme->baseUrl?>/images/favicon.ico" type="image/x-icon" />
<link href="<?php echo Yii::app()->theme->baseUrl?>/css/standard.css" rel="stylesheet" type="text/css" media="screen, projection" />
<link href="<?php echo Yii::app()->theme->baseUrl?>/css/ja.cssmenu.css" rel="stylesheet" type="text/css" media="screen, projection" />
<link href="<?php echo Yii::app()->theme->baseUrl?>/css/jquery.alerts.css" rel="stylesheet" type="text/css" media="screen, projection" />
<link href="<?php echo Yii::app()->theme->baseUrl?>/css/sprite.css" rel="stylesheet" type="text/css" media="screen, projection" />

<script src="<?php echo Yii::app()->theme->baseUrl?>/js/jquery-1.7.1.min.js" type="text/javascript" ></script>
<script src="<?php echo Yii::app()->theme->baseUrl?>/js/iphoenix.js" language="javascript" type="text/javascript"></script>
<script src="<?php echo Yii::app()->theme->baseUrl?>/js/csspopup.js" type="text/javascript" ></script>
<script src="<?php echo Yii::app()->theme->baseUrl?>/js/popup.js" type="text/javascript" ></script>
<script src="<?php echo Yii::app()->theme->baseUrl?>/js/jquery.alerts.js" type="text/javascript" ></script>
<title>.:: Trang quản trị developer| IHB Việt Nam - iPhoenix ::.</title>
<!--[if IE]>
<style type="text/css" media="screen, projection">
#menu ul li {float: left; width:100%;}
</style>
<![endif]-->
<!--[if lt IE 7]>
<style type="text/css" media="screen, projection">
#menu ul li a { height: 1%; }
#menu a, #menu h2 { font: bold 0.7em/1.4em; }
</style>
<![endif]-->
</head>

<body id="home">
<div id="blanket" style="display: none;"></div>
<!--begin top panel-->
<div id="TP_fixed_header" style="position:absolute; top:0%;">
	<div id="TP_container">
		<div id="TP_inner">
			<!--begin left content-->
			<div id="TP_left_panel" class="TP_toolbar_item">
				<img src="<?php echo Yii::app()->theme->baseUrl?>/images/tp_title.png" />
			</div>
			<!--end left content-->
			<div id="TP_feed" class="TP_toolbar_item">
			</div>
			<!--begin right content-->
			<div id="TP_right_panel" class="TP_toolbar_item">
				<a href="<?php echo Yii::app()->createUrl('/dev/default/logout');?>">Đăng xuất</a> (<a target="_blank"><span style="color:#d9251d;"><?php echo Yii::app()->user->name;?></span></a></a>) 
				<p style="font-size:11px; margin-top:2px;"><?php echo date(" H:i, d/m/Y").'&nbsp &nbsp &nbsp &nbsp'; ?></p>
			</div>
			<!--end right content-->
			<!--begin menuBar-->
			<div id="menuBar">
				<ul id="ja-cssmenu">
					<li>
						<a id="1" class="first" href="<?php echo Yii::app()->createUrl('/dev/adminMenu/index');?>">Menu trang quản trị</a>
					</li>
					<li>
						<a id="1" href="<?php echo Yii::app()->createUrl('/dev/role/index');?>">Quyền</a>
					</li>
					<li>
						<a id="1" href="<?php echo Yii::app()->createUrl('/dev/operation/index');?>">Chức năng</a>
					</li>
					<li>
						<a id="1" href="<?php echo Yii::app()->createUrl('/dev/setting/index');?>">Tham số</a>
					</li>
					<li>
						<a id="1" class="last">Tạo mới Model</a>
						<ul>
							<li>
								<a id="1" href="<?php echo Yii::app()->createUrl('/dev/IHB/createNewsModel');?>">Tạo mới News Model</a>
							</li>
							<li>
								<a id="1" href="<?php echo Yii::app()->createUrl('/dev/IHB/createCategoryModel');?>">Tạo mới Category Model</a>
							</li>
						</ul>
					</li>
				</ul>
			</div>
		<!--end menuBar-->
		</div>
	</div>
</div>
<!--end top panel-->
<!--begin page content-->
<div id="shell" class="forShell">
<?php echo $content; ?>
<div class="clear"></div>
	<!--begin footer-->
	<div id="footer" class="top">
		<p>© 2013 <a href="http://ihbvietnam.com">IHB Việt Nam</a>. All rights reserved</p>
	</div>
	<!--end footer-->
</div>
<!--end page content-->
</body>
</html>