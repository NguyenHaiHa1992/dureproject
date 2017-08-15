<?php $form=$this->beginWidget('CActiveForm', array('id'=>'category-form','enableAjaxValidation'=>true,'clientOptions'=>array('validationUrl'=>$this->createUrl('sample/validate')))); ?>	
<input type="hidden" name="id" id="current_id" value="<?php echo isset($model->id)?$model->id:'0';?>" /> 
<div class="fl" style="width:500px;">
	<ul>
		<?php if($model->id > 0):?>
		<div class="row">
			<li>
				<?php echo $form->labelEx($model,'id'); ?>
				<?php echo $model->id;?>
			</li>
		</div>
		<?php endif;?>
		<div class="row">
			<li>
				<?php echo $form->labelEx($model,'name'); ?>
				<?php echo $form->textField($model,'name',array('style'=>'width:300px;','maxlength'=>'256')); ?>
				<?php echo $form->error($model, 'name'); ?>
			</li>
		</div>                                                
		  <div class="row" <?php if(Sample::MAX_RANK == 1) echo'style="display:none"'?>>
		<li>
			<?php echo $form->labelEx($model,'parent_id'); ?>
			<?php
				$view_parent_nodes=array('0'=>'Gốc');
				foreach ($model->list_nodes as $id=>$level){
					$node=Sample::model()->findByPk($id);
					$view = "";
					for($i=1;$i<$level;$i++){
						$view .="--";
					}
					$view_parent_nodes[$id]=$view." ".$node->name." ".$view;
				}
				echo $form->dropDownList($model,'parent_id',$view_parent_nodes,array('style'=>'width:200px'));
			?>
			<?php echo $form->error($model, 'parent_id'); ?>
		</li>
		</div>
		<div class="row">
		<li>
			<?php echo $form->labelEx($model,'status'); ?>
			<?php
				$list=array(Sample::STATUS_ENABLE=>iPhoenixLang::admin_t('Show','main'),Sample::STATUS_DISABLE=>iPhoenixLang::admin_t('Hide','main'));
				echo $form->dropDownList($model,'status',$list,array('style'=>'width:200px'));
			?>
			<?php echo $form->error($model, 'status'); ?>
		</li>
		</div>
		<?php if(!$model->isNewRecord):?>
		<div class="row">
		<li>
			<?php echo $form->labelEx($model,'order_view'); ?>
			<?php 
				$list_order=array(); 
				$max_order=$model->list_order_view;
				for($i=1;$i<=sizeof($max_order);$i++){
					$list_order[$i]=$i;
				}                
				echo $form->dropDownList($model,'order_view',$list_order,array('style'=>'width:300px')); 
			?>
			<?php echo $form->error($model, 'order_view'); ?>
		</li>  
		</div>
		<?php endif;?>  	
		<div class="row">
			<li>
				<?php echo $form->labelEx($model,'meta_title'); ?>
				<?php echo $form->textArea($model,'meta_title',array('style'=>'width:300px; height:80px','maxlength'=>'256')); ?>		
				<?php echo $form->error($model, 'meta_title'); ?>
			</li>
		</div>		
		<div class="row">
				<li>
					<?php echo $form->labelEx($model,'meta_keyword'); ?>
					<?php echo $form->textArea($model,'meta_keyword',array('style'=>'width:300px; height:80px','maxlength'=>'256')); ?>		
					<?php echo $form->error($model, 'meta_keyword'); ?>
				</li>
		</div>	
		<div class="row">
				<li>
					<?php echo $form->labelEx($model,'meta_description'); ?>
					<?php echo $form->textArea($model,'meta_description',array('style'=>'width:300px; height:80px','maxlength'=>'256')); ?>		
					<?php echo $form->error($model, 'meta_description'); ?>
				</li>
		</div>				         
		<li>
			<?php 
			if($action=="update") 
			{ 
				$label_button = iPhoenixLang::admin_t('Update','main');
			}
			else $label_button= iPhoenixLang::admin_t('Add','main');;
			
			echo '<input type="submit" value="'.$label_button.'" style="margin-left:153px; width:125px;" id="write-category" class="button">';
			if($action=="update") 
			{   
				echo '<input type="submit" value="'.iPhoenixLang::admin_t('Add','main').'" style="margin-left:10px; width:125px;" id="create-category" class="button">'; 
			}
			?>  
		</li>
	</ul>
</div>
<?php $this->endWidget(); ?>