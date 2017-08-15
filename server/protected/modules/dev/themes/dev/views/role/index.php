	<!--begin inside content-->
	<div class="folder top">
		<!--begin title-->
		<div class="folder-header">
			<h1>Quản trị quyền</h1>
			<div class="header-menu">
				<ul>
					<li><a class="header-menu-active new-icon" href=""><span>Quản trị quyền</span></a></li>					
				</ul>
			</div>
		</div>
		<!--end title-->
		<div class="folder-content form">
			<?php 	
			echo $this->renderPartial('_form', array('model'=>$model,'action'=>$action)); 
			?>
			<?php			
			echo $this->renderPartial('_tree'); 			
			?>			
			<div class="clear"></div>
		</div>
	</div>
	<!--end inside content-->
<div type="hidden" value="" id="popup_value"></div>
<?php 
$lang='vi';
if(isset($_GET['lang'])){
	$lang=$_GET['lang'];
}
$cs = Yii::app()->getClientScript(); 
// Script delete
$cs->registerScript(
  'js-delete-role',
  "jQuery(function($) { $('body').on('click','.i16-trashgray',	
  		function(){
  			$('#popup_value').val(this.id);
  			jConfirm(
  				\"Bạn muốn xóa danh mục này?\",
  				\"Xác nhận xóa danh mục\",
  				function(r){
  					if(r){
  					jQuery.ajax({
  						'data':{name : $(\"#popup_value\").val(), current_name: $(\"#current_name\").val()},
  						'dataType':'json',
  						'success':function(data){
  							if(data.status == true){
								$(\".folder-content\").html(data.content);
								$(\".folder-content\").append('<div class=\"clear\"></div>');
							}
							else {
								jAlert(data.content);
							}
        				},
        				'type':'GET',
        				'url':'".Yii::app()->createUrl('dev/role/delete')."',
        				'cache':false});
        			}
        		}
        	);
        	return false;	
        	});
        })",
  CClientScript::POS_END
);

// Script load form update 
$cs->registerScript(
  'js-update-role',
  "jQuery(
  	function($)
	{ 
		$('body').on(
  			'click',
  			'.i16-statustext',	
  			function(){
  				jQuery.ajax({
  					'data':{name : this.id},
  					'success':function(data){
						$(\".folder-content\").html(data);
						$(\".folder-content\").append('<div class=\"clear\"></div>');
					},
					'type':'GET',
					'url':'".Yii::app()->createUrl('dev/role/update')."',
					'cache':false
				});
				return false;
			}
		);
	}
	);",
  CClientScript::POS_END
);
// Script load form create 
$cs->registerScript(
  'js-create-role',
  "jQuery(
  	function($) 
  	{ 
  		$('body').on(
  			'click',
  			'#create-role',	
  			function(){
  				jQuery.ajax({
  					'success':function(data){
						$(\".folder-content\").html(data);
						$(\".folder-content\").append('<div class=\"clear\"></div>');
        			},
        			'type':'GET',
        			'url':'".Yii::app()->createUrl('dev/role/create')."',
        			'cache':false,
        		});
        		return false;
        	}
        );
     }
    );",
  CClientScript::POS_END
);
// Script update & create role to database
$cs->registerScript(
  'js-write-role',
  "jQuery(
  	function($) { 
  		$('body').on(
  			'click',
  			'#write-role',	
  			function(){
  				jQuery.ajax({
  					'success':function(data){
						$(\".folder-content\").html(data);
						$(\".folder-content\").append('<div class=\"clear\"></div>');
        			},
        			'type':'POST',
        			'url':'".Yii::app()->createUrl('dev/role/write')."',
        			'cache':false,
        			'data':jQuery(this).parents(\"form\").serialize()
        		});
        		return false;
        	}
        );
      }
   );",
  CClientScript::POS_END
);
?>