<!-- Main popup -->
<div class="form-setting popup-wrapper">
	<div class="main-popup">
		<a class="popup-close" onclick="hidenPopUp('form-setting');return false;"></a>
		<div class="content-popup">
			<div class="popup_title">Chỉnh sửa tham số</div>
			<div class="folder-content">
				<?php $form=$this->beginWidget('CActiveForm', array('id'=>'form-setting','action'=>Yii::app()->createUrl('admin/setting/write'),'method'=>'post','enableClientValidation'=>true)); ?>	
				<!--begin left content-->
				<div class="fl" style="width:320px; min-height: 180px">
					<ul>
						<?php echo $form->hiddenField($model,'id');?>
						<div class="row">
		                    <li>
		                        <?php echo $form->labelEx($model,'type'); ?>
		                        <?php echo $form->dropDownList($model,'type',$model->list,array('style'=>'width:150px')); ?>
		                  		<?php echo $form->error($model, 'type'); ?>
		                    </li>
	                    </div>
					    <div class="row">
		                    <li>
		                        <?php echo $form->labelEx($model,'name'); ?>
		                        <?php echo $form->textField($model,'name',array('style'=>'width:150px')); ?>
		                  		<?php echo $form->error($model, 'name'); ?>
		                    </li>
	                    </div>
	                   	<div class="row">
		                    <li>
		                        <?php echo $form->labelEx($model,'value'); ?>
		                        <?php echo $form->textField($model,'value',array('style'=>'width:150px')); ?>
		                  		<?php echo $form->error($model, 'value'); ?>
		                    </li>
	                    </div>
					</ul>
				</div>
				<div class="fr" style="width:280px;">
					<ul>	
						<div class="row">
							<li>
	                       		<?php echo $form->labelEx($model,'description'); ?>
	                        	<?php echo $form->textArea($model,'description',array('style'=>'width:280px;','rows'=>6)); ?>
	                   			<?php echo $form->error($model, 'description'); ?>
	                    	</li>
						</div>	
					</ul>
				</div>
				<div class="clear"></div>
				<div>
					<ul>
				        <li>
							<input type="reset" class="button" value="Hủy thao tác" style="margin-left:15px; width:125px;" />	
							<input type="submit" class="button create" value="Thêm mới" style="margin-left:20px; width:125px;" />	
							<input type="submit" class="button update" value="Cập nhật" style="margin-left:20px; width:125px;" />
						</li>
					</ul>
				</div>
				<!--end left content-->
				<?php $this->endWidget(); ?>
			</div>
		</div>
	<!--content-popup-->
	</div>
</div>
<!--main-popup-->
<script type="text/jscript">
	$('#form-setting').submit(function(){
		jQuery.ajax({
			'data': $(this).serialize(),
			'dataType': 'json',
			'success':function(data){
				if(data.success){
					hidenPopUp('form-setting');		
					$.fn.yiiGridView.update('setting-list');		
				}		
				else{
					$.each(data.errors, function(key, val) {
						$("#form-setting #Setting_"+key+"_em_").parent().parent().addClass('error');
                    	$("#form-setting #Setting_"+key+"_em_").text(val[0]);                                                    
                   		$("#form-setting #Setting_"+key+"_em_").show();
                    });
				}
			},
			'type':'GET',
			'url':'<?php echo Yii::app()->createUrl('dev/setting/write')?>',
			'cache':false
		});
		return false;
	});
	function resetSettingForm(){
		$("#form-setting #Setting_type").val('');
		$("#form-setting #Setting_name").val('');											
		$("#form-setting #Setting_value").val('');
		$("#form-setting #Setting_description").val('');
		$("#form-setting #Setting_id").val('');
       	$("#form-setting .create").hide();
       	$("#form-setting .update").hide();
	}
</script>