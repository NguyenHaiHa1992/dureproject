			<!--begin left content-->
<?php $form=$this->beginWidget('CActiveForm', array('id'=>'role-form','enableAjaxValidation'=>true)); ?>	
<input type="hidden" name="current_name" value="<?php echo isset($model->name)?$model->name:'';?>" id="current_name"/> 
			<div class="fl" style="width:580px;">
				<ul> 
					<div class="row">
						<li>
                       		<?php echo $form->labelEx($model,'name'); ?>
                        	<?php echo $form->textField($model,'name',array('style'=>'width:300px;','maxlength'=>'256')); ?>
                   			<?php echo $form->error($model, 'name'); ?>
                    	</li>
                    </div> 
                    <div class="row">
	                    <li>
	                        <?php echo $form->labelEx($model,'parent_name'); ?>
	                        <?php
	                        	$view_parent_nodes=array(''=>'Gốc');
								$list_nodes=AuthItem::getList_all_roles();
	                        	 foreach ($list_nodes as $name=>$level){
									$view = "";
									for($i=1;$i<$level;$i++){
										$view .="--";
									}
									$view_parent_nodes[$name]=$view." ".$name." ".$view;
								}
	                        	echo $form->dropDownList($model,'parent_name',$view_parent_nodes,array('style'=>'width:200px'));
	                        ?>
	                  		<?php echo $form->error($model, 'parent_name'); ?>
						</li>
                    </div>                       
                    <div class="row">
	                    <li>
	                        <?php echo $form->labelEx($model,'list_operations'); ?>
	                        <?php
	                        	echo $form->dropDownList($model,'list_operations',AuthItem::getList_all_operations(),array('style'=>'width:150px','size'=>'20','multiple' => 'multiple')); 
	                        ?>
	                  		<?php echo $form->error($model, 'list_operations'); ?>
						</li>
                    </div>                                                                                   
                   	<li>
                    	<?php 
                    	if($action=="update") 
                    	{ 
                    		$label_button="Cập nhật quyền";     
                    	}
                    	else $label_button="Thêm quyền";
                    	
						echo '<input type="submit" value="'.$label_button.'" style="margin-left:153px; width:125px;" id="write-role" class="button">';  
    					if($action=="update") 
                    	{   
    						echo '<input type="submit" value="Tạo quyền mới" style="margin-left:10px; width:125px;" id="create-role" class="button">'; 
                    	}
    					?>  
                    </li>
				</ul>
			</div>
			<?php $this->endWidget(); ?>
<!--end left content-->