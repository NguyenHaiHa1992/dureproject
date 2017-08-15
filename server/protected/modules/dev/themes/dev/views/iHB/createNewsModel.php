<!--begin inside content-->
<div class="folder top">
	<!--begin title-->
	<div class="folder-header">
		<h1>quản trị News model</h1>
		<div class="header-menu">
			<ul>
				<li><a class="header-menu-active new-icon" href=""><span>Tạo mới news model</span></a></li>					
			</ul>
		</div>
	</div>
	<!--end title-->
	<div class="folder-content form">
		<div>
	        <input type="button" class="button" value="Tạo mới model" style="width:180px;" onClick="parent.location='<?php echo Yii::app()->createUrl('dev/IHB/createNewsModel')?>'"/>
	        <div class="line top bottom"></div>	
	    </div>
	    <div class="notice">Đảm bảo  model chưa tồn tại, tên model và dịch nghĩa model chính xác (Bằng tiếng Anh): <span>Viết hoa chữ cái đầu tiên của model, ví dụ "News", dịch nghĩa "Tin tức"</span></div>
		<?php
			foreach(Yii::app()->user->getFlashes() as $key => $message) {
				echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
			}
 		?>
		<!--begin left content-->
		<?php if($model_name == ''):?>
		<?php $form=$this->beginWidget('CActiveForm', array('method'=>'post','enableAjaxValidation'=>true)); ?>	
		<div class="fl" style="width:480px;">
			<ul>
				<div class="row">
					<li>
						<label>Model</label>
						<input id="Model_name" name="Model_name" type="text" />
					</li>
				</div>
				<div class="row">
					<li>
						<label>Model Category</label>
						<input type="radio" name="Model_category_type" value="1" class="radio_btn" checked>Tự động tạo category mới
						<input type="radio" name="Model_category_type" value="0" class="radio_btn">Category đã tồn tại
						<br />
						<div id="model_category" style="display: none; margin-top: 10px; padding: 5px; border: 1px solid #CCC; background: #EFEFEF; width: 290px">
							<label>Chọn tên category</label>
							<input id="Model_category" name="Model_category" type="text" />
							<div class="hint" style="color: #000; line-height: 20px"> ví dụ: <b>NewsCategory</b>, <b>ProductCategory</b></div>
						</div>
					</li>
				</div>
				<script type="text/javascript">
					$('.radio_btn').change(function() {
					   if($(this).is(':checked') && $(this).val() == 0) {  $('#model_category').show()}
					   if($(this).is(':checked') && $(this).val() == 1) {  $('#model_category').hide()}
					});
				</script>
				<div class="row">
					<li>
						<label>Tên model (Tiếng Anh)</label>
						<input id="Model_translation" name="Model_translation" type="text" />
					</li>
				</div>
                <li>
					<input type="reset" class="button" value="Hủy thao tác" style="margin-left:0px; width:125px;" />	
					<input type="submit" class="button" value="Tạo" style="margin-left:20px; width:125px;" />					
				</li>
			</ul>
		</div>
		<?php $this->endWidget(); ?>
		<?php endif ?>
		<!--end left content-->
		<div class="clear"></div>
		<?php if($roles != NULL):?>
		<div class="line" style="margin:20px 0 20px 0"></div>
		<div class="list_roles">
			<div class="flash-notice">Please choose Role Operations for auto create</div>
			<?php $form=$this->beginWidget('CActiveForm', array('method'=>'post','enableAjaxValidation'=>true)); ?>	
			<?php foreach ($roles as $index => $role):?>
				<input type="checkbox" name="Role[<?php echo $index?>]" value="<?php echo $role?>" /><?php echo $role?><br />
			<?php endforeach ?>
				<input type="hidden" name="Role_category" value="<?php echo $model_name ?>" />
				<div class="row">
					<input type="submit" class="button" value="Tạo" style="margin-left:20px; width:125px;" />
				</div>
			<?php $this->endWidget(); ?>
		</div>
		<?php endif;?>
	</div>
</div>
<!--end inside content-->