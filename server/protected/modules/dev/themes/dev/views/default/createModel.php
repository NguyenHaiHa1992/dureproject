<!--begin inside content-->

<div class="folder top">

	<!--begin title-->

	<div class="folder-header">

		<h1>quản trị model</h1>

		<div class="header-menu">

			<ul>

				<li><a class="header-menu-active new-icon" href=""><span>Tạo mới model</span></a></li>					

			</ul>

		</div>

	</div>

	<!--end title-->

	<div class="folder-content form">

		<div>

	        <input type="button" class="button" value="Tạo mới model" style="width:180px;" onClick="parent.location='<?php echo Yii::app()->createUrl('admin/IHB/createModel')?>'"/>

	        <div class="line top bottom"></div>	

	    </div>

	    <div class="notice">Đảm bảo  tên model và dịch nghĩa model chính xác: <span>Viết hoa chữ cái đầu tiên của model, ví dụ "News"</span></div>

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

						<label>Model translation</label>

						<input id="Model_translation" name="Model_translation" type="text" />

					</li>

				</div>

                <li>

					<input type="reset" class="button" value="Hủy thao tác" style="margin-left:153px; width:125px;" />	

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