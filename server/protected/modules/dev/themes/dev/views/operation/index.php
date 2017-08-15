<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/jquery.jeditable.mini.js');
?>
	<!--begin inside content-->
	<div class="folder top">
		<!--begin title-->
		<div class="folder-header">
			<h1>Quản trị chức năng</h1>
			<div class="header-menu">
				<ul>
					<li class="ex-show"><a class="activities-icon" href=""><span>Danh sách chức năng</span></a></li>
				</ul>
			</div>
		</div>
		<!--end title-->
		<div class="folder-content">
			<div>
            	<input type="button" class="button" value="Thêm chức năng" style="width:180px;" onclick="showPopUp('form-operation');resetAuthItemForm();$('#form-operation .create').show();return false;"/>
                <div class="line top bottom"></div>	
            </div>
             <!--begin box search-->
         	<?php 
			Yii::app()->clientScript->registerScript('search', "
				$('#operation-search').submit(function(){
				$.fn.yiiGridView.update('operation-list', {
					data: $(this).serialize()});
					return false;
				});");
			?>
            <div class="box-search">            
                <h2>Tìm kiếm</h2>
                <?php $form=$this->beginWidget('CActiveForm', array('method'=>'get','id'=>'operation-search')); ?>
                <!--begin left content-->
                <div class="fl" style="width:600px;">
                    <ul>
                        <li>
                         	<?php echo $form->label($model,'name'); ?>
                         	<?php $this->widget('CAutoComplete', array(
                         	'model'=>$model,
                         	'attribute'=>'name',
							'url'=>array('/dev/operation/suggestName'),
							'htmlOptions'=>array(
								'style'=>'width:230px;',
								),
						)); ?>								
                        </li>
                        <li>
                        <?php 
							echo CHtml::submitButton('Lọc kết quả',
    						array(
    							'class'=>'button',
    							'style'=>'margin-left:153px; width:95px;',
    							''
    						)); 						
    					?>
                        </li>
                    </ul>
                </div>
                <!--end left content-->             
                <?php $this->endWidget(); ?>
                <div class="clear"></div>
                <div class="line top bottom"></div>
            </div>
            <!--end box search-->		
           <?php 
			$this->widget('iPhoenixGridView', array(
				'iclass' => 'AuthItem',
  				'id'=>'operation-list',
  				'dataProvider'=>$model->search(),		
  				'columns'=>array(
					array(
      					'class'=>'CCheckBoxColumn',
      					'value'=>'$data->name',
						'selectableRows'=>2,
						'headerHtmlOptions'=>array('width'=>'2%','class'=>'table-title'),
						'checked'=>'in_array($data->name,Yii::app()->session["checked-operation-list"])'
    				),			
    				array(
						'name'=>'name',
						'headerHtmlOptions'=>array('width'=>'10%','class'=>'table-title'),
					),
					array(
						'name'=>'bizrule',
						'headerHtmlOptions'=>array('width'=>'20%','class'=>'table-title'),
                		'type'=>'html',
                		'value' => '"<a class=\'edit-bizrule-".$data->name."\'>$data->bizrule</a>"',
					), 	
					array(
						'name'=>'data',
						'headerHtmlOptions'=>array('width'=>'20%','class'=>'table-title'),
                		'type'=>'html',
                		'value' => '"<a class=\'edit-data-".$data->name."\'>$data->data</a>"',
					), 					
					array(
						'name'=>'description',
						'headerHtmlOptions'=>array('width'=>'20%','class'=>'table-title'),
                		'type'=>'html',
                		'value' => '"<a class=\'edit-description-".$data->name."\'>$data->description</a>"',
					), 																   	   
					array(
						'header'=>'Nhóm công cụ thao tác',
						'class'=>'iPhoenixToolButtonColumn',
    					'template'=>'{update}{delete}',
    					'deleteConfirmation'=>'Bạn muốn xóa chức năng này?',
						'afterDelete'=>'function(link,success,data){ if(success) jAlert("Bạn đã xóa thành công"); }',
    					'buttons'=>array
    					(
    						'update' => array(
    							'label'=>'Chỉnh sửa chức năng',
    							'url'=>'Yii::app()->createUrl("dev/operation/updateForm", array("name"=>$data->name))',
    							'click'=>'function(){
									var th=this;									
									jQuery.ajax({
										type:"GET",
										dataType:"json",
										url:$(this).attr("href"),
										success:function(data) {
											resetAuthItemForm();
											$("#form-operation #type").val("update");											
											$("#form-operation #AuthItem_bizrule").val(data.bizrule);
											$("#form-operation #AuthItem_name").val(data.name);	
											$("#form-operation #AuthItem_name").attr("readonly", true);																					
											$("#form-operation #AuthItem_data").val(data.data);
											$("#form-operation #AuthItem_description").val(data.description);
							               	$("#form-operation .update").show();
											showPopUp("form-operation");
										},
										});
									return false;
								}',
    						),
        					'delete' => array(
    							'label'=>'Xóa chức năng',
    							'url'=>'Yii::app()->createUrl("dev/operation/delete",array("name"=>$data->name))'
    						),
        				),
						'headerHtmlOptions'=>array('width'=>'10%','class'=>'table-title'),
					), 			
 	 			),
 	 			'template'=>'{displaybox}{checkbox}{summary}{items}{pager}',
  				'summaryText'=>'Có tổng cộng {count} chức năng',
 	 			'pager'=>array('class'=>'CLinkPager','header'=>'','prevPageLabel'=>'< Trước','nextPageLabel'=>'Sau >','htmlOptions'=>array('class'=>'pages fr')),
				'actions'=>array(
 	 				'delete'=>array(
						'action'=>'delete',
						'label'=>'Xóa',
						'imageUrl' => Yii::app()->theme->baseUrl.'/images/delete.png',
						'url'=>'dev/operation/checkbox'
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
			$("a[class^=edit-data-]").editable("<?php echo Yii::app()->createUrl('dev/operation/edit')?>", {
				submitdata : function (value,settings){
								return {"name":$(this).attr("class").substr("10"),"attribute":"data"};
							},
				indicator : "Saving...",
				width : '80%',
				tooltip   : "Click to edit...",
				type : "text",
				submit   : "Lưu",
				name: 'value',
				ajaxoptions : {"type":"GET"}
			 });
		});
	
		$("a[class^=edit-data-]").editable("<?php echo Yii::app()->createUrl('dev/operation/edit')?>", {
			submitdata : function (value,settings){
							return {"name":$(this).attr("class").substr("10"),"attribute":"data"};
						},
			indicator : "Saving...",
			width : '80%',
			tooltip   : "Click to edit...",
			type : "text",
			submit   : "Lưu",
			name: 'value',
			ajaxoptions : {"type":"GET"}
		 });
	</script>	
	
	<script type="text/javascript">
		$("body").ajaxComplete(function() {
			$("a[class^=edit-description-]").editable("<?php echo Yii::app()->createUrl('dev/operation/edit')?>", {
				submitdata : function (value,settings){
								return {"name":$(this).attr("class").substr("17"),"attribute":"description"};
							},
				indicator : "Saving...",
				width : '80%',
				tooltip   : "Click to edit...",
				type : "text",
				submit   : "Lưu",
				name: 'value',
				ajaxoptions : {"type":"GET"}
			 });
		});
	
		$("a[class^=edit-description-]").editable("<?php echo Yii::app()->createUrl('dev/operation/edit')?>", {
			submitdata : function (value,settings){
							return {"name":$(this).attr("class").substr("17"),"attribute":"description"};
						},
			indicator : "Saving...",
			width : '80%',
			tooltip   : "Click to edit...",
			type : "text",
			submit   : "Lưu",
			name: 'value',
			ajaxoptions : {"type":"GET"}
		 });
	</script>		

	<script type="text/javascript">
		$("body").ajaxComplete(function() {
			$("a[class^=edit-bizrule-]").editable("<?php echo Yii::app()->createUrl('dev/operation/edit')?>", {
				submitdata : function (value,settings){
								return {"name":$(this).attr("class").substr("13"),"attribute":"bizrule"};
							},
				indicator : "Saving...",
				width : '80%',
				tooltip   : "Click to edit...",
				type : "text",
				submit   : "Lưu",
				name: 'value',
				ajaxoptions : {"type":"GET"}
			 });
		});
	
		$("a[class^=edit-bizrule-]").editable("<?php echo Yii::app()->createUrl('dev/operation/edit')?>", {
			submitdata : function (value,settings){
							return {"name":$(this).attr("class").substr("13"),"attribute":"bizrule"};
						},
			indicator : "Saving...",
			width : '80%',
			tooltip   : "Click to edit...",
			type : "text",
			submit   : "Lưu",
			name: 'value',
			ajaxoptions : {"type":"GET"}
		 });
	</script>		