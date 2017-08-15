<div class="login-logo">
	<a ui-sref="home"></a>
</div><!-- /.login-logo -->
<div class="login-box" style="font-size: 15px;">
	<div class="login-box-body">
		<?php
		    foreach(Yii::app()->user->getFlashes() as $key => $message) {
		        echo '<div class="alert alert-success alert-dismissable flash-' . $key . '">' . $message . "</div>\n";
		    }
		?>

		<a class="none" href="<?php echo Yii::app()->baseUrl;?>/../#/login">Login to AMP</a>

	</div><!-- /.login-box-body -->
</div><!-- /.login-box -->