<?php $form=$this->beginWidget('CActiveForm', array('id'=>'menu-form','enableAjaxValidation'=>true,'clientOptions'=>array('validationUrl'=>$this->createUrl('adminMenu/validate')))); ?>	
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
                    <div class="row">
                    <li>
                        <?php echo $form->labelEx($model,'parent_id'); ?>
                        <?php
                        	$view_parent_nodes=array('0'=>'Gốc');
                        	foreach ($model->list_nodes as $id=>$level){
                        	 	$node=AdminMenu::model()->findByPk($id);
								$view = "";
								for($i=1;$i<$level;$i++){
									$view .="--";
								}
								$view_parent_nodes[$id]=$view." ".$node->name." ".$view;
							}
                        	echo $form->dropDownList($model,'parent_id',$view_parent_nodes,array('style'=>'width:300px'));
                        ?>
                  		<?php echo $form->error($model, 'parent_id'); ?>
					</li>
                    </div>
                    <div class="row">
                    <li>
                        <?php echo $form->labelEx($model,'status'); ?>
                        <?php
                        	$list=array(AdminMenu::STATUS_ENABLE=>'Hiện',AdminMenu::STATUS_DISABLE=>'Ẩn');
                        	echo $form->dropDownList($model,'status',$list,array('style'=>'width:300px'));
                        ?>
                  		<?php echo $form->error($model, 'status'); ?>
					</li>
                    </div>
                    <div class="row">
						<li>
                       		<?php echo $form->labelEx($model,'key_url'); ?>
                        	 <?php                  
                        	echo $form->dropDownList($model,'key_url',AdminMenu::$view_config_url,array('style'=>'width:300px'));
                        	?>
                   			<?php echo $form->error($model, 'key_url'); ?>
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
                   	<li>
                    	<?php 
                    	if($action=="update") 
                    	{ 
                    		$label_button="Cập nhật menu";     
                    	}
                    	else $label_button="Thêm menu";
                    	
						echo '<input type="submit" value="'.$label_button.'" style="margin-left:153px; width:125px;" id="write-menu" class="button">';  
    					if($action=="update") 
                    	{   
    						echo '<input type="submit" value="Tạo menu mới" style="margin-left:10px; width:125px;" id="create-menu" class="button">'; 
                    	}
    					?>  
                    </li>
				</ul>
			</div>
			<?php $this->endWidget(); ?>