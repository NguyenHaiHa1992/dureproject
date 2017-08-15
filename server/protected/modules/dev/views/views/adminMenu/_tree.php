<div class="fr menu-tree" style="width: 400px;">
<ul>
	<li><label><b>Cấu trúc cây</b></label></li>
	<li>
		<?php 
		$list_style=array('color:red','color:blue','color:black','color:green');
		$list_disable_nodes=array();
		foreach ($list_nodes as $id=>$level){
			$node=AdminMenu::model()->findByPk($id);
			if($node->status == AdminMenu::STATUS_DISABLE){
				$list_disable_nodes[]=$id;
				foreach($node->child_nodes as $id_child=>$level){
					$list_disable_nodes[]=$id_child;	
				}
			}	
		}	
		foreach ($list_nodes as $id=>$level){
			$node=AdminMenu::model()->findByPk($id);
			$blank = "&nbsp";
			$prefix = "--";
			if(in_array($id, $list_disable_nodes))
				$style='color:grey';
			else 
				$style = $list_style[$level-1];
			for($i=1;$i<$level;$i++){
				$blank .= "&nbsp &nbsp &nbsp";
				$prefix .= "---";
			}
			$view =$blank."|".$prefix;
			echo "<div><label style=".$style.">".$view." ".$node->name."</label><a id='".$id."' class='i16 i16-statustext'></a><a id='".$id."'class='i16 i16-trashgray'></a></div>";
		}
		?>           
		</li>
</ul>
</div>