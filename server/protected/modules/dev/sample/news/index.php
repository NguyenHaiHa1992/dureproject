<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/jquery.jeditable.mini.js');
?>
<!--begin inside content-->
<div class="folder top">
	<!--begin title-->
	<div class="folder-header">
		<h1><?php echo iPhoenixLang::admin_t('SAMPLe_TRANSLATE management');?></h1>
		<div class="header-menu">
			<ul>
				<li class="ex-show"><a class="activities-icon"><span><?php echo iPhoenixLang::admin_t('List SAMPLe_TRANSLATEs');?></span></a></li>
			</ul>
		</div>
	</div>
	<!--end title-->
	<div class="folder-content">
		<div>
			<input type="button" class="button" value="<?php echo iPhoenixLang::admin_t('SAMPLe_TRANSLATE categories');?>" style="width:180px;" onClick="parent.location='<?php echo iPhoenixUrl::createUrl('admin/SAMPLe_Category/index')?>'"/>
			<input type="button" class="button" value="<?php echo iPhoenixLang::admin_t('Add SAMPLe_TRANSLATE');?>" style="width:180px;" onClick="parent.location='<?php echo iPhoenixUrl::createUrl('admin/sample/create')?>'"/>
			<div class="line top bottom"></div>	
		</div>
		 <!--begin box search-->
	 	<?php 
		Yii::app()->clientScript->registerScript('search', "
			$('#sample-search').submit(function(){
			$.fn.yiiGridView.update('sample-list', {
				data: $(this).serialize()});
				return false;
			});");
		?>
		<div class="box-search">            
			<h2><?php echo iPhoenixLang::admin_t('Search','main');?></h2>
			<?php $form=$this->beginWidget('CActiveForm', array('method'=>'get','id'=>'sample-search')); ?>
			<!--begin left content-->
			<div class="fl" style="width:600px;">
				<ul>
					<li>
						<?php echo $form->label($model,'title'); ?>
						<?php $this->widget('CAutoComplete', array(
						'model'=>$model,
						'attribute'=>'title',
						'url'=>array('sample/suggestTitle'),
						'htmlOptions'=>array(
							'style'=>'width:230px;',
							),
					)); ?>								
					</li>   
					<?php 
					$list=array(''=>iPhoenixLang::admin_t('All categories','main'));
					foreach ($list_category as $id=>$level){
						$cat=SAMPLe_Category::model()->findByPk($id);
						$view = "";
						for($i=1;$i<$level;$i++){
							$view .="---";
						}
						$list[$id]=$view." ".$cat->name." ".$view;
					}
					?>
					<li>
						<?php echo $form->label($model,'cat_id'); ?>
						<?php echo $form->dropDownList($model,'cat_id',$list,array('style'=>'width:200px')); ?>
					</li>					                              
				</ul>
			</div>
			<!--end left content-->
			<!--begin right content-->
			<div class="fr" style="width:600px;">
				<ul>                   
					<li>
						<?php echo $form->label($model,'status',array('style'=>'width:200px')); ?>
						<?php echo $form->dropDownList($model,'status',array(''=>iPhoenixLang::admin_t('All','main'), 0=>iPhoenixLang::admin_t('Hide','main'),1=>iPhoenixLang::admin_t('Show','main')),array('style'=>'width:200px')); ?>
					</li>
					<li>
						<?php echo $form->label($model,'new',array('style'=>'width:200px')); ?>
						<?php echo $form->dropDownList($model,'new',array(''=>iPhoenixLang::admin_t('All','main'), 1=>iPhoenixLang::admin_t('Display in new SAMPLe_TRANSLATE')),array('style'=>'width:200px')); ?>
					</li>
					<li>
						<?php echo $form->label($model,'home',array('style'=>'width:200px')); ?>
						<?php echo $form->dropDownList($model,'home',array(''=>iPhoenixLang::admin_t('All','main'), 1=>iPhoenixLang::admin_t('Display in home page')),array('style'=>'width:200px')); ?>
					</li>
				</ul>
			</div>
			<div>
			<div class="row"></div>
				<?php 
					echo CHtml::submitButton(iPhoenixLang::admin_t('Filter'),
					array(
						'class'=>'button',
						''
					));
				?>
			</div>
			<?php $this->endWidget(); ?>
			<div class="clear"></div>
			<div class="line top bottom"></div>
		</div>
		<!--end box search-->		
		<?php 
		$this->widget('iPhoenixGridView', array(
			'iclass'=>'Sample',
			'id'=>'sample-list',
			'dataProvider'=>$model->search(),		
			'columns'=>array(
				array(
					'class'=>'CCheckBoxColumn',
					'selectableRows'=>2,
					'headerHtmlOptions'=>array('width'=>'2%','class'=>'table-title'),
					'checked'=>'in_array($data->id,Yii::app()->session["checked-sample-list"])'
				),			
				array(
					'name'=>'title',
					'headerHtmlOptions'=>array('width'=>'20%','class'=>'table-title'),		
				),
				array(
					'name'=>'cat_id',
					'value'=>'$data->category->name',
					'headerHtmlOptions'=>array('width'=>'10%','class'=>'table-title'),		
				), 		
				array(
					'name'=>'order_view',
					'type'=>'html',
					'value' => '"<a class=\'edit-order-view-".$data->id."\'>$data->order_view</a>"',
					'headerHtmlOptions'=>array('width'=>'6%','class'=>'table-title'),		
				), 	
				array(
					'name'=>'created_by',
					'value'=>'isset($data->author)?$data->author->fullname:""',
					'headerHtmlOptions'=>array('width'=>'10%','class'=>'table-title'),		
				), 						
				array(
					'name'=>'created_time',
					'value'=>'date("H:i d/m/Y",$data->created_time)',
					'headerHtmlOptions'=>array('width'=>'10%','class'=>'table-title'),		
				), 	
				array(
					'name'=>'visits',
					'headerHtmlOptions'=>array('width'=>'5%','class'=>'table-sample'),		
				),
				array(
					'header'=>iPhoenixLang::admin_t('Display','main'),
					'class'=>'iPhoenixStatusButtonColumn',
					'template'=>'{reverse_status}{reverse_new}{reverse_home}',
					'buttons'=>array
					(
						'reverse_status' => array
						(
							'label'=>$model->getAttributeLabel('status'),
							'imageUrl'=>'$data->imageStatus',
							'url'=>'iPhoenixUrl::createUrl("admin/sample/reverseStatus", array("id"=>$data->id))',
							'click'=>'function(){
								var th=this;									
								jQuery.ajax({
									type:"POST",
									dataType:"json",
									url:$(this).attr("href"),
									success:function(data) {
										if(data.success){
											$(th).find("img").attr("src",data.src);
											}
									},
									error: function (request, status, error) {
										jAlert(request.responseText);
									}
									});
							return false;}',
						),
						'reverse_new' => array
						(
							'label'=>$model->getAttributeLabel('new'),
							'imageUrl'=>'$data->imageNew',
							'url'=>'iPhoenixUrl::createUrl("admin/sample/reverseNew", array("id"=>$data->id))',
							'click'=>'function(){
								var th=this;									
								jQuery.ajax({
									type:"POST",
									dataType:"json",
									url:$(this).attr("href"),
									success:function(data) {
										if(data.success){
											$(th).find("img").attr("src",data.src);
											}
									},
									error: function (request, status, error) {
											jAlert(request.responseText);
									}
									});
							return false;}',
						),
						'reverse_home' => array
						(
							'label'=>$model->getAttributeLabel('home'),
							'imageUrl'=>'$data->imageHome',
							'url'=>'iPhoenixUrl::createUrl("admin/sample/reverseHome", array("id"=>$data->id))',
							'click'=>'function(){
								var th=this;									
								jQuery.ajax({
									type:"POST",
									dataType:"json",
									url:$(this).attr("href"),
									success:function(data) {
										if(data.success){
											$(th).find("img").attr("src",data.src);
											}
									},
									error: function (request, status, error) {
											jAlert(request.responseText);
									}
									});
							return false;}',
						),
					),
					'headerHtmlOptions'=>array('width'=>'10%','class'=>'table-sample'),
				),    	   										   	   
				array(
					'header'=>iPhoenixLang::admin_t('Function','main'),
					'class'=>'iPhoenixToolButtonColumn',
					'template'=>'{clipboard}{copy}{update}{delete}',
					'deleteConfirmation'=>iPhoenixLang::admin_t('Are you sure you want to delete this item?','main'),
					'afterDelete'=>'function(link,success,data){ if(success) jAlert("'.iPhoenixLang::admin_t("Delete successfully","main").'"); }',
					'buttons'=>array
					(
						'update' => array(
							'label'=>iPhoenixLang::admin_t('Update','main'),
							'url'=>'iPhoenixUrl::createUrl("admin/sample/update",array("id"=>$data->id))'
						),
						'delete' => array(
							'label'=>iPhoenixLang::admin_t('Delete','main'),
							'url'=>'iPhoenixUrl::createUrl("admin/sample/delete",array("id"=>$data->id))'
						),
						'copy' => array
						(
							'label'=>iPhoenixLang::admin_t('Copy','main'),
							'imageUrl'=>Yii::app()->theme->baseUrl.'/images/copy.png',
							'url'=>'iPhoenixUrl::createUrl("admin/sample/copy", array("id"=>$data->id))',
						),
						'clipboard' => array
						(
							'label'=>iPhoenixLang::admin_t('Copy to clipboard','main'),
							'url'=>'$data->detail_url',
							'imageUrl'=>Yii::app()->theme->baseUrl.'/images/clipboard.png',
							'options'=>array(
								'class'=>'clipboard'
							)
						),
					),
					'headerHtmlOptions'=>array('width'=>'10%','class'=>'table-title'),
				),    				
			),
			'template'=>'{displaybox}{checkbox}{summary}{items}{pager}',
			'summaryText'=>'{count} '.iPhoenixLang::admin_t('SAMPLe_TRANSLATE'),
			'pager'=>array('class'=>'CLinkPager','header'=>'','prevPageLabel'=>'< '.iPhoenixLang::admin_t('Previous'),'nextPageLabel'=>iPhoenixLang::admin_t('Next').' >','htmlOptions'=>array('class'=>'pages fr')),
			'actions'=>array(
				'delete'=>array(
					'action'=>'delete',
					'label'=>iPhoenixLang::admin_t('Delete','main'),
					'imageUrl' => Yii::app()->theme->baseUrl.'/images/delete.png',
					'url'=>'admin/sample/checkbox'
				),
				'copy'=>array(
					'action'=>'copy',
					'label'=>iPhoenixLang::admin_t('Copy','main'),
					'imageUrl' => Yii::app()->theme->baseUrl.'/images/copy.png',
					'url'=>'admin/sample/checkbox'
				)
			),
			)); ?>
	</div>
</div>
<!--end inside content-->
<script type="text/javascript">
	$("body").ajaxComplete(function() {
		$("a[class^=edit-order-view-]").editable("<?php echo iPhoenixUrl::createUrl('admin/sample/edit')?>", {
			submitdata : function (value,settings){
							return {"id":$(this).attr("class").substr("16"),"attribute":"order_view"};
						},
			indicator : "<?php echo iPhoenixLang::admin_t('Saving...','main');?>",
			width : '20%',
			tooltip   : "<?php echo iPhoenixLang::admin_t('Click to edit...','main');?>",
			type : "text",
			submit   : "<?php echo iPhoenixLang::admin_t('Save','main');?>",
			name : "value",
			ajaxoptions : {"type":"GET"}
		 });
	});

	$("a[class^=edit-order-view-]").editable("<?php echo iPhoenixUrl::createUrl('admin/sample/edit')?>", {
		submitdata : function (value,settings){
						return {"id":$(this).attr("class").substr("16"),"attribute":"order_view"};
					},
		indicator : "<?php echo iPhoenixLang::admin_t('Saving...','main');?>",
		width : '20%',
		tooltip   : "<?php echo iPhoenixLang::admin_t('Click to edit...','main');?>",
		type : "text",
		submit   : "<?php echo iPhoenixLang::admin_t('Save','main');?>",
		name : "value",
		ajaxoptions : {"type":"GET"}
	 });
</script>