<!--begin right content-->
<div class="fl menu-tree" style="width: 370px;">
<ul>
	<li><label><b>Cấu trúc cây</b></label></li>
	<li>
		<?php 
		$list_style=array('color:red','color:blue','color:black');
		$list_nodes=AuthItem::getList_all_roles();
		foreach ($list_nodes as $name=>$level){
			$blank = "&nbsp";
			$prefix = "--";
			$style = $list_style[$level-1];
			for($i=1;$i<$level;$i++){
				$blank .= "&nbsp &nbsp &nbsp";
				$prefix .= "---";
			}
			$view =$blank."|".$prefix;
			echo "<div><label style=".$style.">".$view." ".$name."</label><a id='".$name."' class='i16 i16-statustext'></a><a id='".$name."'class='i16 i16-trashgray'></a></div>";
		}
		?>           
		</li>
</ul>
</div>
<!--end right content-->
