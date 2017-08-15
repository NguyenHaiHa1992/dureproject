<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/jquery.jeditable.mini.js');
?>
	<!--begin inside content-->
	<div class="folder top">
		<!--begin title-->
		<div class="folder-header">
			<h1>Quản trị tham số</h1>
			<div class="header-menu">
				<ul>
					<li class="ex-show"><a class="activities-icon" href=""><span>Danh sách tham số</span></a></li>
				</ul>
			</div>
		</div>
		<!--end title-->
		<div class="folder-content">
			<div>
            	<input type="button" class="button" value="Thêm tham số" style="width:180px;" onclick="showPopUp('form-setting');resetSettingForm();$('#form-setting .create').show();return false;"/>
                <div class="line top bottom"></div>	
            </div>
             <!--begin box search-->
         	<?php 
			Yii::app()->clientScript->registerScript('search', "
				$('#setting-search').submit(function(){
				$.fn.yiiGridView.update('setting-list', {
					data: $(this).serialize()});
					return false;
				});");
			?>
            <div class="box-search">            
                <h2>Tìm kiếm</h2>
                <?php $form=$this->beginWidget('CActiveForm', array('method'=>'get','id'=>'setting-search')); ?>
                <!--begin left content-->
                <div class="fl" style="width:600px;">
                    <ul>
                        <li>
                         	<?php echo $form->label($model,'name'); ?>
                         	<?php $this->widget('CAutoComplete', array(
                         	'model'=>$model,
                         	'attribute'=>'name',
							'url'=>array('setting/suggestName'),
							'htmlOptions'=>array(
								'style'=>'width:230px;',
								),
						)); ?>								
                        </li>
                    </ul>
                </div>
                <!--end left content-->   
                <!--begin right content-->
                <div class="fr" style="width:600px;">
                    <ul>
						<li>
							<?php echo $form->label($model,'type'); ?>
							<?php echo $form->dropDownList($model,'type',array(''=>'Tất cả')+$model->list,array('style'=>'width:200px')); ?>
						</li>                    
                    </ul>
                </div>
                <div>
                <div class="row"></div>
						<?php 
							echo CHtml::submitButton('Lọc kết quả',
    						array(
    							'class'=>'button',
    							''
    						)); 						
    					?>   
                </div>
                <!--end right content-->             
                <?php $this->endWidget(); ?>
                <div class="clear"></div>
                <div class="line top bottom"></div>
            </div>
            <!--end box search-->		
           <?php 
			$this->widget('iPhoenixGroupGridView', array(
				'iclass' => 'Setting',
  				'id'=>'setting-list',
  				'extraRowColumns' => array('type'),
  				'dataProvider'=>$model->search(),		
  				'columns'=>array(		
					array(
      					'class'=>'CCheckBoxColumn',
						'selectableRows'=>2,
						'headerHtmlOptions'=>array('width'=>'2%','class'=>'table-title'),
						'checked'=>'in_array($data->id,Yii::app()->session["checked-setting-list"])'
    				),
    				array(
						'name'=>'language',
						'headerHtmlOptions'=>array('width'=>'2%','class'=>'table-title'),
					),
    				array(
						'name'=>'name',
						'headerHtmlOptions'=>array('width'=>'10%','class'=>'table-title'),
                		'type'=>'html',
                		'value' => '"<a class=\'edit-name-".$data->id."\'>$data->name</a>"',
					),
					/*
					array(
						'header'=>$model->getAttributeLabel('type'),
						'headerHtmlOptions'=>array('width'=>'10%','class'=>'table-title'),
                		'type'=>'html',
                		'value' => '"<a class=\'edit-type-".$data->id."\'>$data->type</a>"',
					), 		
					*/
					array(
						'name'=>'value',
						'headerHtmlOptions'=>array('width'=>'20%','class'=>'table-title'),
                		'type'=>'html',
                		'value' => '"<a class=\'edit-value-".$data->id."\'>$data->value</a>"',
					), 			
					array(
						'name'=>'description',
						'headerHtmlOptions'=>array('width'=>'20%','class'=>'table-title'),
                		'type'=>'html',
                		'value' => '"<a class=\'edit-description-".$data->id."\'>$data->description</a>"',
					), 																   	   
					array(
						'header'=>'Nhóm công cụ thao tác',
						'class'=>'iPhoenixToolButtonColumn',
    					'template'=>'{update}{delete}',
    					'deleteConfirmation'=>'Bạn muốn xóa tham số này?',
						'afterDelete'=>'function(link,success,data){ if(success) jAlert("Bạn đã xóa thành công"); }',
    					'buttons'=>array
    					(
    						'update' => array(
    							'label'=>'Chỉnh sửa tham số',
    							'url'=>'Yii::app()->createUrl("dev/setting/updateForm", array("id"=>$data->id))',
    							'click'=>'function(){
									var th=this;									
									jQuery.ajax({
										type:"GET",
										dataType:"json",
										url:$(this).attr("href"),
										success:function(data) {
											resetSettingForm();
											$("#form-setting #Setting_type").val(data.type);
											$("#form-setting #Setting_name").val(data.name);											
											$("#form-setting #Setting_value").val(data.value);
											$("#form-setting #Setting_description").val(data.description);
											$("#form-setting #Setting_id").val(data.id);
							               	$("#form-setting .update").show();
											showPopUp("form-setting");
										},
										});
									return false;
								}',
    						),
        					'delete' => array(
    							'label'=>'Xóa tham số',
    							'url'=>'Yii::app()->createUrl("dev/setting/delete",array("id"=>$data->id))'
    						),
        				),
						'headerHtmlOptions'=>array('width'=>'10%','class'=>'table-title'),
					), 			
 	 			),
 	 			'template'=>'{displaybox}{checkbox}{summary}{items}{pager}',
  				'summaryText'=>'Có tổng cộng {count} tham số',
 	 			'pager'=>array('class'=>'CLinkPager','header'=>'','prevPageLabel'=>'< Trước','nextPageLabel'=>'Sau >','htmlOptions'=>array('class'=>'pages fr')),
				'actions'=>array(
 	 				'delete'=>array(
						'action'=>'delete',
						'label'=>'Xóa',
						'imageUrl' => Yii::app()->theme->baseUrl.'/images/delete.png',
						'url'=>'dev/setting/checkbox'
					),				
				),
 	 			)); ?>
		</div>
	</div>
	<!--end inside content-->
	<div class="bg-overlay"></div>
	<?php	echo $this->renderPartial('_form',array('model'=>$model));?>
	
	<script type="text/javascript">
		$("body").ajaxComplete(function() {
			$("a[class^=edit-name-]").editable("<?php echo Yii::app()->createUrl('dev/setting/edit')?>", {
				submitdata : function (value,settings){
								return {"id":$(this).attr("class").substr("10"),"attribute":"name"};
							},
				indicator : "Saving...",
				tooltip   : "Click to edit...",
				type : "text",
				submit   : "Lưu",
				name : "value",
				ajaxoptions : {"type":"GET"}
			 });
		});
	
		$("a[class^=edit-name-]").editable("<?php echo Yii::app()->createUrl('dev/setting/edit')?>", {
			submitdata : function (value,settings){
							return {"id":$(this).attr("class").substr("10"),"attribute":"name"};
						},
			indicator : "Saving...",
			tooltip   : "Click to edit...",
			type : "text",
			submit   : "Lưu",
			name : "value",
			ajaxoptions : {"type":"GET"}
		 });
	</script>		
	
	<script type="text/javascript">
		$("body").ajaxComplete(function() {
			$("a[class^=edit-value-]").editable("<?php echo Yii::app()->createUrl('dev/setting/edit')?>", {
				submitdata : function (value,settings){
								return {"id":$(this).attr("class").substr("11"),"attribute":"value"};
							},
				indicator : "Saving...",
				width : '80%',
				tooltip   : "Click to edit...",
				type : "text",
				submit   : "Lưu",
				name : "value",
				ajaxoptions : {"type":"GET"}
			 });
		});
	
		$("a[class^=edit-value-]").editable("<?php echo Yii::app()->createUrl('dev/setting/edit')?>", {
			submitdata : function (value,settings){
							return {"id":$(this).attr("class").substr("11"),"attribute":"value"};
						},
			indicator : "Saving...",
			width : '80%',
			tooltip   : "Click to edit...",
			type : "text",
			submit   : "Lưu",
			name : "value",
			ajaxoptions : {"type":"GET"}
		 });
	</script>	
	
	<script type="text/javascript">
		$("body").ajaxComplete(function() {
			$("a[class^=edit-description-]").editable("<?php echo Yii::app()->createUrl('dev/setting/edit')?>", {
				submitdata : function (value,settings){
								return {"id":$(this).attr("class").substr("17"),"attribute":"description"};
							},
				indicator : "Saving...",
				width : '80%',
				tooltip   : "Click to edit...",
				type : "text",
				submit   : "Lưu",
				name : "value",
				ajaxoptions : {"type":"GET"}
			 });
		});
	
		$("a[class^=edit-description-]").editable("<?php echo Yii::app()->createUrl('dev/setting/edit')?>", {
			submitdata : function (value,settings){
							return {"id":$(this).attr("class").substr("17"),"attribute":"description"};
						},
			indicator : "Saving...",
			width : '80%',
			tooltip   : "Click to edit...",
			type : "text",
			submit   : "Lưu",
			name : "value",
			ajaxoptions : {"type":"GET"}
		 });
	</script>		

	<script type="text/javascript">
		$("body").ajaxComplete(function() {
			$("a[class^=edit-type-]").editable("<?php echo Yii::app()->createUrl('dev/setting/edit')?>", {
				submitdata : function (value,settings){
								return {"id":$(this).attr("class").substr("14"),"attribute":"type"};
							},
				indicator : "Saving...",
				tooltip   : "Click to edit...",
				type : "select",
				data: <?php echo json_encode($model->list)?>,
				submit   : "Lưu",
				name : "value",
				ajaxoptions : {
					"type":"GET",
					}
			 });
		});
	
		$("a[class^=edit-type-]").editable("<?php echo Yii::app()->createUrl('dev/setting/edit')?>", {
			submitdata : function (value,settings){
							return {"id":$(this).attr("class").substr("14"),"attribute":"type"};
						},
			indicator : "Saving...",
			tooltip   : "Click to edit...",
			type : "select",
			data: <?php echo json_encode($model->list)?>,
			submit   : "Lưu",
			name : "value",
			ajaxoptions : {
				"type":"GET",
				}
		 });
	</script>		