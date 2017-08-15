<!-- Main popup -->
<div class="form-operation popup-wrapper">
	<div class="main-popup">
		<a class="popup-close" onclick="hidenPopUp('form-operation');return false;"></a>
		<div class="content-popup">
			<div class="popup_title">Chỉnh sửa tham số</div>
			<div class="folder-content">
				<?php $form=$this->beginWidget('CActiveForm', array('id'=>'form-operation','action'=>Yii::app()->createUrl('admin/operation/write'),'method'=>'post','enableClientValidation'=>true)); ?>	
				<!--begin left content-->
				<div class="fl" style="width:360px; min-height: 180px">
					<ul>
						<input type="hidden" value="create" name="type" id="type">
						<div class="row">
		                    <li>
		                        <?php echo $form->labelEx($model,'name'); ?>
		                        <?php echo $form->textField($model,'name',array('style'=>'width:150px')); ?>
		                  		<?php echo $form->error($model, 'name'); ?>
		                    </li>
	                    </div>
						<div class="row">
		                    <li>
		                        <?php echo $form->labelEx($model,'bizrule'); ?>
		                         <?php echo $form->textField($model,'bizrule',array('style'=>'width:150px')); ?>
		                  		<?php echo $form->error($model, 'bizrule'); ?>
		                    </li>
	                    </div>
	                   	<div class="row">
		                    <li>
		                        <?php echo $form->labelEx($model,'data'); ?>
		                        <?php echo $form->textField($model,'data',array('style'=>'width:150px')); ?>
		                  		<?php echo $form->error($model, 'data'); ?>
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
	$('#form-operation').submit(function(){
		jQuery.ajax({
			'data': $(this).serialize(),
			'dataType': 'json',
			'success':function(data){
				if(data.success){
					hidenPopUp('form-operation');		
					$.fn.yiiGridView.update('operation-list');		
				}		
				else{
					$.each(data.errors, function(key, val) {
						$("#form-operation #AuthItem_"+key+"_em_").parent().parent().addClass('error');
                    	$("#form-operation #AuthItem_"+key+"_em_").text(val[0]);                                                    
                   		$("#form-operation #AuthItem_"+key+"_em_").show();
                    });
				}
			},
			'type':'GET',
			'url':'<?php echo Yii::app()->createUrl('dev/operation/write')?>',
			'cache':false
		});
		return false;
	});
	function resetAuthItemForm(){
		$("#form-operation #type").val('create');
		$("#form-operation #AuthItem_bizrule").val('');
		$("#form-operation #AuthItem_name").val('');											
		$("#form-operation #AuthItem_data").val('');
		$("#form-operation #AuthItem_description").val('');
		$("#form-operation #AuthItem_name").attr("readonly", false);
       	$("#form-operation .create").hide();
       	$("#form-operation .update").hide();
	}
</script>