<!--begin inside content-->
<div class="folder top">
	<!--begin title-->
	<div class="folder-header">
		<h1>quản trị theme</h1>
		<div class="header-menu">
			<ul>
				<li><a class="header-menu-active new-icon" href=""><span>Cài theme</span></a></li>					
			</ul>
		</div>
	</div>
	<!--end title-->
	<div class="folder-content form">
		<div>
	        <input type="button" class="button" value="Danh sách banner" style="width:180px;" onClick="parent.location='<?php echo Yii::app()->createUrl('admin/banner')?>'"/>
	        <div class="line top bottom"></div>	
	    </div>
	    <div class="notice">Đảm bảo themes đúng cấu trúc trước khi upload!: <span>css ; js; flash; index.html</span></div>
		<?php
			foreach(Yii::app()->user->getFlashes() as $key => $message) {
				echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
			}
 		?>
		<!--begin left content-->
		<?php echo CHtml::form('','post',array('enctype'=>'multipart/form-data')); ?>
		<div class="fl" style="width:480px;">
			<ul>
				<div class="row">
					<li>
						<label for="file">Theme name</label>
						<input id="Theme_name" name="Theme_name" type="text" />
					</li>
				</div>
				<div class="row">
					<li>
						<label for="file">Theme file</label>
						<input type="file" name="Theme_file" id="Theme_file" />
					</li>
				</div>
                <li>
					<input type="reset" class="button" value="Hủy thao tác" style="margin-left:153px; width:125px;" />	
					<input type="submit" class="button" value="Upload" style="margin-left:20px; width:125px;" />					
				</li>
			</ul>
		</div>
		<!--end left content-->
		<div class="clear"></div>          
	</div>
</div>
<!--end inside content-->