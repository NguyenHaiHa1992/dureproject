<div class="login-wrapper">
	<!--begin admin list-->
	<div id="adminBox" class="fl" style="height: 160px; min-height: 160px">
		<div class="icon fl" style="background-position:-46px -92px;"></div>
		<div class="listContent fr">
			<h1>Đăng nhập tài khoản DEV</h1>				
		</div>
		<?php $form=$this->beginWidget('CActiveForm'); ?>
		<div class="form">
	    	<div class="row fl">
	    		<label>Password:</label>
				<?php echo $form->passwordField($model,'password',array('style'=>'width:180px;')); ?>
				<?php echo $form->error($model,'password'); ?>
	    	</div>
	    	<div class="row fl">
	    		<input name="login_submit" type="submit" value="Đăng nhập" class="button btn-login"/>
	    	</div>
		</div>
        <?php $this->endWidget(); ?>
	<!--end admin list-->
	</div>
	<!--end login-wrapper-->
	<div class="clear"></div>
	<!--begin footer-->
	<div id="footer" class="top">
		<p>© 2013 <a href="http://ihbvietnam.com">IHB Việt Nam</a>. All rights reserved</p>
	</div>
	<!--end footer-->
</div>