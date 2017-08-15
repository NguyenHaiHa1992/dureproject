<?php

/**
 * This is the model class for table "{{menu}}".
 *
 * The followings are the available columns in table '{{menu}}':
 * @property integer $id
 * @property integer $type
 * @property integer $status
 * @property string $name
 * @property integer $parent_id
 * @property integer $order_view
 * @property string $other
 * @property string $url
 * @property integer $created_by
 * @property integer $created_time
 */
class AdminMenu extends CActiveRecord
{
	public $old_order_view;
	public $old_parent_id;	
	const MAX_RANK=10;
	
	const STATUS_DISABLE=0;
	const STATUS_ENABLE=1;
	
	const DELETE_OK=1;
	const DELETE_HAS_CHILD=2;
	
	/*
	* Get view config url
	*/
	static $view_config_url=array(
		'privilege_index'=>'Admin Privileges',
		'job_create'=>'Create job',
		'job_createnormal'=>'Create normal job',
		'job_index'=>'List jobs',
		'image_index'=>'Hình ảnh - Danh sách hình ảnh',
		'cpm_index'=>'List cpm',
		'category_index'=>'List category',
		'vendor_index'=>'List vendor',

		'city_index'=>'List cities',
		'distance_index'=>'List distances',
		'skidload_index'=>'Skid load management',
		'state_index'=>'State management',
		'zone_index'=>'Zone management',

		'news_index'=>'Tin tức - Danh sách tin tức',
		'news_create'=>'Tin tức - Thêm tin tức mới',
		'newsCategory_index'=>'Tin tức - Danh mục tin tức',

		'healthNews_index'=>'Tin tức sức khỏe - Danh sách',
		'healthNews_create'=>'Tin tức sức khỏe - Thêm mới',
		'healthNewsCategory_index'=>'Tin tức sức khỏe - Danh mục',

		'advisor_index'=>'Ban cố vấn - Danh sách',
		'advisor_create'=>'Ban cố vấn - Thêm mới',

		'intro_index'=>'Giới thiệu - Danh sách giới thiệu',
		'intro_create'=>'Giới thiệu - Thêm tin giới thiệu',
		'introCategory_index'=>'Giới thiệu - Danh mục giới thiệu',
		
		'plan_index'=>'Dự án - Danh sách dự án',
		'plan_create'=>'Dự án - Thêm dự án mới',
		'planCategory_index'=>'Dự án - Danh mục dự án',

		'qa_index'=>'Hỏi đáp - Danh sách hỏi đáp',
		'qa_create'=>'Hỏi đáp - Thêm hỏi đáp mới',
		//'qaCategory_index'=>'Hỏi đáp - Danh mục hỏi đáp',
		
		'share_index'=>'Chia sẻ - Danh sách chia sẻ',
		'share_create'=>'Chia sẻ - Thêm chia sẻ',
		//'shareCategory_index'=>'Tin tức - Danh mục tin tức',
		
		'color_index'=>'Màu SP - Danh sách màu',
		'color_create'=>'Màu SP - Thêm màu',
			
		'video_index'=>'Video - Danh sách video',
		'video_create'=>'Video - Thêm video mới',
		'videoCategory_index'=>'Video - Danh mục video',

		'audio_index'=>'Audio - Danh sách audio',
		'audio_create'=>'Audio - Thêm audio mới',
		'audioCategory_index'=>'Audio - Danh mục audio',			
			
		'clip_index'=>'Clip - Danh sách clip',
		'clip_create'=>'Clip - Thêm clip mới',
		'clipCategory_index'=>'Clip - Danh mục clip',
		
		'city_index'=>'City - Danh sách city',
		'city_create'=>'City - Thêm mới city',

		'album_index'=>'Album - Danh sách album',
		'album_create'=>'Album - Thêm album mới',
		'albumCategory_index'=>'Album - Danh mục album',
		
		'adminMenu_index'=>'Menu - Menu trang quản trị',
		'userMenu_index'=>'Menu - Menu trang front-end',
		
		'banner_index'=>'Banner - Quản lý banner',
		
		'supporter_index'=>'Tư vấn viên - Quản lý tư vấn viên',
		
		'contact_index'=>'Liên hệ - Quản lý liên hệ',
		
		'comment_index' => 'Bình luận - Quản lý bình luận',
		
		'user_index'=>'User - Quản lý user',
		'customer_index'=>'Khách hàng - Quản lý khách hàng',
	
		'product_index' => 'Sản phẩm - Danh sách sản phẩm',
		'product_create' => 'Sản phẩm - Thêm sản phẩm mới',
		'productCategory_index' => 'Sản phẩm - Danh mục sản phẩm',
		'productCityCategory_index' => 'Sản phẩm - Danh mục Tỉnh/TP',

		'store_index' => 'Kho hàng - Danh sách kho hàng',
		'store_create' => 'Kho hàng - Thêm kho hàng',

		'partner_index' => 'Đối tác - Danh sách đối tác',
		'partner_create' => 'Đối tác - Thêm đối tác mới',
		'partnerCategory_index' => 'Đối tác - Danh mục đối tác',

		'order_index' => 'Đơn hàng - Quản trị đơn hàng',
		
		'setting_seo' => 'Nhóm tham số SEO',
		'setting_information' => 'Nhóm tham số thông tin liên hệ',
		'setting_index'=>'Nhóm tham số',
		
		'help_index' => 'Hướng dẫn sử dụng',
		
		'site_home'=>'Trang dashboard',
		
		'google_analytics'=>'Thống kê google analystic',

		'document_index'=>'Tài liệu - Danh sách tài liệu',
		'document_create'=>'Tài liệu - Thêm mới tài liệu',
		'documentCagegory_index'=>'Tài liệu - Danh mục tài liệu',

		//Dispatcher
		'job_dispatcher'=>'Dispatcher | List jobs',
		'dispatcher_create'=>'Dispatcher | Create quick quote',
		'dispatcher_createNormal'=>'Dispatcher | Create RFQ',

		//Project
		'project_index'=>'Project | List projects',
	);
	
	/*
	 * Get config url
	 */
	 public function getConfig_url(){
	 	return array(
	 		'privilege_index'=>iPhoenixUrl::createUrl('admin/privilege/index'),
	 		'job_create'=>iPhoenixUrl::createUrl('admin/job/create'),
	 		'job_createnormal'=>iPhoenixUrl::createUrl('admin/job/createNormal'),
	 		'job_index'=>iPhoenixUrl::createUrl('admin/job/indexNormal'),
	 		'image_index'=>iPhoenixUrl::createUrl('admin/image/index'),
	 		'vendor_index'=>iPhoenixUrl::createUrl('admin/vendor/index'),
	 		'category_index'=>iPhoenixUrl::createUrl('admin/category/index'),

			'skidload_index'=>iPhoenixUrl::createUrl('admin/skidload/index'),
			'state_index'=>iPhoenixUrl::createUrl('admin/state/index'),
			'zone_index'=>iPhoenixUrl::createUrl('admin/zone/index'),
			'cpm_index'=>iPhoenixUrl::createUrl('admin/cpm/index'),
		
			'city_index'=>iPhoenixUrl::createUrl('admin/city/index'),
			'distance_index'=>iPhoenixUrl::createUrl('admin/distance/index'),

			'news_index'=>iPhoenixUrl::createUrl('admin/news/index'),
			'news_create'=>iPhoenixUrl::createUrl('admin/news/create'),
			'newsCategory_index'=>iPhoenixUrl::createUrl('admin/newsCategory/index'),

			'healthNews_index'=>iPhoenixUrl::createUrl('admin/healthNews/index'),
			'healthNews_create'=>iPhoenixUrl::createUrl('admin/healthNews/create'),
			'healthNewsCategory_index'=>iPhoenixUrl::createUrl('admin/healthNewsCategory/index'),

			'advisor_index'=>iPhoenixUrl::createUrl('admin/advisor/index'),
			'advisor_create'=>iPhoenixUrl::createUrl('admin/advisor/create'),

			'intro_index'=>iPhoenixUrl::createUrl('admin/intro/index'),
			'intro_create'=>iPhoenixUrl::createUrl('admin/intro/create'),
			'introCategory_index'=>iPhoenixUrl::createUrl('admin/introCategory/index'),
			
			'plan_index'=>iPhoenixUrl::createUrl('admin/plan/index'),
			'plan_create'=>iPhoenixUrl::createUrl('admin/plan/create'),
			'planCategory_index'=>iPhoenixUrl::createUrl('admin/planCategory/index'),

 			'qa_index'=>iPhoenixUrl::createUrl('admin/qa/index'),
 			'qa_create'=>iPhoenixUrl::createUrl('admin/qa/create'),
 			//'qaCategory_index'=>iPhoenixUrl::createUrl('admin/qaCategory/index'),
			
 			'share_index'=>iPhoenixUrl::createUrl('admin/share/index'),
 			'share_create'=>iPhoenixUrl::createUrl('admin/share/create'),
 			//'shareCategory_index'=>iPhoenixUrl::createUrl('admin/shareCategory/index'),
	 	
	 		'color_index'=>iPhoenixUrl::createUrl('admin/color/index'),
 			'color_create'=>iPhoenixUrl::createUrl('admin/color/create'),
	 	
			'video_index'=>iPhoenixUrl::createUrl('admin/video/index'),
			'video_create'=>iPhoenixUrl::createUrl('admin/video/create'),
			'videoCategory_index'=>iPhoenixUrl::createUrl('admin/videoCategory/index'),

			'audio_index'=>iPhoenixUrl::createUrl('admin/audio/index'),
			'audio_create'=>iPhoenixUrl::createUrl('admin/audio/create'),
			'audioCategory_index'=>iPhoenixUrl::createUrl('admin/audioCategory/index'),

			'clip_index'=>iPhoenixUrl::createUrl('admin/clip/index'),
			'clip_create'=>iPhoenixUrl::createUrl('admin/clip/create'),
			'clipCategory_index'=>iPhoenixUrl::createUrl('admin/clipCategory/index'),
			
			'city_index'=>iPhoenixUrl::createUrl('admin/city/index'),
			'city_create'=>iPhoenixUrl::createUrl('admin/city/create'),
			
			'album_index'=>iPhoenixUrl::createUrl('admin/album/index'),
			'album_create'=>iPhoenixUrl::createUrl('admin/album/create'),
			'albumCategory_index'=>iPhoenixUrl::createUrl('admin/albumCategory/index'),
			
			'adminMenu_index'=>iPhoenixUrl::createUrl('admin/adminMenu/index'),
			'userMenu_index'=>iPhoenixUrl::createUrl('admin/userMenu/index'),
			
			'banner_index'=>iPhoenixUrl::createUrl('admin/banner/index'),
			
			'supporter_index'=>iPhoenixUrl::createUrl('admin/supporter/index'),
			
			'contact_index'=>iPhoenixUrl::createUrl('admin/contact/index'),	
			
			'comment_index'=>iPhoenixUrl::createUrl('admin/comment/index'),
			
			
			'user_index'=>iPhoenixUrl::createUrl('admin/user/administrator'),
			'customer_index'=>iPhoenixUrl::createUrl('admin/customer/index'),
					
			'product_index' => iPhoenixUrl::createUrl('admin/product/index'),
			'product_create' => iPhoenixUrl::createUrl('admin/product/create'),
			'productCategory_index' => iPhoenixUrl::createUrl('admin/productCategory/index'),
			'productCityCategory_index' => iPhoenixUrl::createUrl('admin/productCityCategory/index'),

			'store_index' => iPhoenixUrl::createUrl('admin/store/index'),
			'store_create' => iPhoenixUrl::createUrl('admin/store/create'),

			'partner_index' => iPhoenixUrl::createUrl('admin/partner/index'),
			'partner_create' => iPhoenixUrl::createUrl('admin/partner/create'),
			'partnerCategory_index' => iPhoenixUrl::createUrl('admin/partnerCategory/index'),

			'order_index' => iPhoenixUrl::createUrl('admin/order/index'),
			
			'setting_seo' => iPhoenixUrl::createUrl('admin/setting/index',array('category'=>'SEO')),
			'setting_information' => iPhoenixUrl::createUrl('admin/setting/index',array('category'=>'INFORMATION')),
			'setting_index' => iPhoenixUrl::createUrl('admin/setting/index'),
			
			'help_index' => iPhoenixUrl::createUrl('admin/help/index'),
			
			'site_home'=>iPhoenixUrl::createUrl('admin/site/home'),
			
			'google_analytics'=>'http://www.google.com/analytics/',

			'document_index'=> iPhoenixUrl::createUrl('admin/document/index'),
			'document_create'=> iPhoenixUrl::createUrl('admin/document/create'),
			'documentCategory_index'=> iPhoenixUrl::createUrl('admin/documentCategory/index'),

			//Dispatcher
			'job_dispatcher'=>iPhoenixUrl::createUrl('admin/job/dispatcherIndexNormal'),
			'dispatcher_create'=>iPhoenixUrl::createUrl('admin/job/dispatcherCreate'),
			'dispatcher_createNormal'=>iPhoenixUrl::createUrl('admin/job/dispatcherCreateNormal'),

			'project_index'=>iPhoenixUrl::createUrl('admin/project/index'),
		);
	 }
	
	private $config_other_attributes=array('key_url');	
	
	/**
	 * PHP setter magic method for other attributes
	 * @param $name the attribute name
	 * @param $value the attribute value
	 * set value into particular attribute
	 */
	public function __set($name,$value)
	{
		if(in_array($name,$this->config_other_attributes)){
			$other=$this->other;
			$other[$name]=$value;
			$this->other=$other;
		}
		else 
			parent::__set($name,$value);
	}
	
	/**
	 * PHP getter magic method for other attributes
	 * @param $name the attribute name
	 * @return value of {$name} attribute
	 */
	public function __get($name)
	{
		if(in_array($name,$this->config_other_attributes))
			if(isset($this->other[$name])) 
				return $this->other[$name];
			else 
		 		return null;
		else
			return parent::__get($name);
	}
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AdminMenu the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{admin_menu}}';
	}
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('status, name, parent_id, key_url', 'required'),
			array('parent_id','validatorParent'),
			array('order_view','validatorOrder_view'),
			array('status, parent_id, order_view', 'numerical', 'integerOnly'=>true),	
			array('name', 'length', 'max'=>256),
		);
	}

	/**
	 *
	 * Function validator parent
	 */
	public function validatorParent($attributes,$params){
		if(!$this->isNewRecord){
			$black_list=array();
			$black_list[]=$this->id;
			//Remove all child of menu
			$list_child_nodes=$this->child_nodes;
			$max=0;
			foreach ($list_child_nodes as $node_id=>$level){
				$black_list[]=$node_id;
				if($level>$max)
					$max=$level;
			}
			if(in_array($this->parent_id,$black_list))
				$this->addError('parent_id', 'Parent_id invalid');
			
			$parent_level=($this->parent_id > 0)?$this->parent->level:0;
			if(($max+1+$parent_level) > self::MAX_RANK)
				$this->addError('parent_id', 'Max rank');
		}
	}
	
	/**
	 *
	 * Function validator order view
	 */
	public function validatorOrder_view($attributes,$params){
		if($this->isNewRecord){
			//Check order view
			if($this->order_view > (sizeof($this->list_order_view)+1))
				$this->addError('order_view', 'Order_view invalid');
		}
		else{
			if($this->old_parent_id == $this->parent_id){
				//Check order view
				if($this->order_view > (sizeof($this->list_order_view)))
					$this->addError('order_view', 'Order_view invalid');
			}
			else{
				//Check order view
				if($this->order_view > (sizeof($this->list_order_view)+1))
					$this->addError('order_view', 'Order_view invalid');
			}
		}
	}	
		

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'author'=>array(self::BELONGS_TO,'User','created_by'),
			'parent'=>array(self::BELONGS_TO,'AdminMenu','parent_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'status' => 'Trạng thái',
			'name' => 'Nhãn',
			'parent_id' => 'Menu cha',
			'order_view' => 'Thứ tự hiển thị',
			'url' => 'URL',
			'key_url' => 'Chọn URL'
		);
	}
	
	
	/**
	 * This event is raised after the record is instantiated by a find method.
	 * @param CEvent $event the event parameter
	 */
	protected function afterFind(){		
				
		if(isset($this->other))
			$this->other=json_decode($this->other,true);
		
		//Store old order view
		$this->old_order_view=$this->order_view;
		//Store old parent id
		$this->old_parent_id=$this->parent_id;
	
		return parent::afterFind();
	}
	
	/**
	 * This method is invoked before saving a record (after validation, if any).
	 * The default implementation raises the {@link onBeforeSave} event.
	 * You may override this method to do any preparation work for record saving.
	 * Use {@link isNewRecord} to determine whether the saving is
	 * for inserting or updating record.
	 * Make sure you call the parent implementation so that the event is raised properly.
	 * @return boolean whether the saving should be executed. Defaults to true.
	 */
	protected function beforeSave()
	{
		if(parent::beforeSave()){
			if($this->isNewRecord)
			{
				$this->created_time=time();
				$this->created_by=Yii::app()->user->id;				
				if(!is_array($this->other))
					$this->other=array();
			}
			$this->other = json_encode( $this->other );		
			return true;
		}
	}
	
	protected function afterSave()
	{
		$this->updateOrderView();
		
		if(isset($this->other))
			$this->other=json_decode($this->other,true);
		
		//Store old order view
		$this->old_order_view=$this->order_view;
		//Store old parent id
		$this->old_parent_id=$this->parent_id;

	    parent::afterSave();
	}
	
	/**
	 * Returns all menus
	 * @return array $result all menus
	 */
	static function getList_nodes(){
		$result=array();
		$criteria=new CDbCriteria;
		$criteria->compare('parent_id', 0);
		$criteria->order='order_view';
		$list_nodes=self::model()->findAll($criteria);
		foreach ($list_nodes as $node){
			$result += array($node->id => 1);
			//$this->tmp_list=array();
			$result += self::treeTraversal($node->id, 1, PHP_INT_MAX);
			//$result += $this->tmp_list;
		}
		return $result;
	}
	
	/**
	 * Returns all nodes in the type
	 * @return array $result all nodes in the type
	 */
	public function getList_active_nodes(){
		$list_nodes=$this->getList_nodes();
		foreach ($list_nodes as $id=>$level) {
			$node=self::model()->findByPk($id);	
			if($node->status == self::STATUS_DISABLE){
				unset($list_nodes[$id]);	
				foreach($node->child_nodes as $child_node_id => $level){
					unset($list_nodes[$child_node_id]);	
				}			
			}		
		}
		return $list_nodes;
	}
	
	/**
	 * Returns all sub-menus of the menu.
	 * @return array $result array of sub-menus of this node
	 */
	public function getChild_nodes(){
		return self::treeTraversal($this->id, 0, PHP_INT_MAX);
	}
	
	/**
	 * Return ancestor menus of the menu
	 * @return array $result array of ancestor menus of this menu
	 */
	public function getAncestor_nodes(){
		$result=array();
		$check=true;
		$current_id=$this->id;
		while ($check&&$current_id>0){
			$current=self::model()->findByPk($current_id);
			$result[]=$current_id;
			if($current->parent_id==0){
				$check=false;
			}
			else
				$current_id=$current->parent_id;
		}
		return $result;
	}
		
	/**
	 * Returns order view of brother nodes
	 * @return array $result, the array sibling of this node
	 */
	public function getList_order_view(){
		$result=array();
		$criteria=new CDbCriteria;
		$criteria->compare('parent_id', $this->parent_id);
		$list=self::model()->findAll($criteria);
	
		foreach ($list as $cat){
			$result[$cat->id]=$cat->order_view;
		}
		return $result;
	}
	
	/**
	 * Recursive algorithms for tree traversals
	 */
	static function treeTraversal($node_id,$level,$rank){
		$tmp_list=array();
		if($node_id > 0){
			$new_level=$level+1;
			$criteria=new CDbCriteria;
			$criteria->compare('parent_id', $node_id);
			$criteria->order='order_view';
			$list_menu=self::model()->findAll($criteria);
			foreach ($list_menu as $menu){
				//Get route and params if type is menu
				//$this->tmp_list[$menu->id]=$new_level;
				$tmp_list[$menu->id]=$new_level;
				if($new_level<$rank){
					$tmp_list += self::treeTraversal($menu->id, $new_level, $rank);
				}
			}
		}
		return $tmp_list;
	}
	
	/*
	 * Returns the level of the node in group
	*/
	public function getLevel(){
		$list_nodes=$this->list_nodes;
		foreach ($list_nodes as $id=>$level) {
			if($this->id==$id) return $level;
		}
	}
	
	/**
	 * Update order view of a menu
	 */
	public function changeOrderview($new_order_view) {
		$table_name=$this->tableName();
		$sql='UPDATE '.$table_name.' SET order_view = '.$new_order_view.' WHERE id = '.$this->id;
		$command=Yii::app()->db->createCommand($sql);
		if($command->execute()) 
			return true;
		else 
			return false;
	}
	
	/**
	 * Change order view of a menu
	 * @return boolean false if it is not changed successfully
	 * otherwise, it changed the order of this menu
	 */
	
	public function updateOrderView() {
		if($this->isNewRecord)
		{
			//Fix order view in new parent menu
			$list_order_view=$this->list_order_view;
			foreach ( $list_order_view as $id => $order ) {
				if ($id != $this->id && $order >= $this->order_view) {
					$menu = self::model ()->findByPk ( $id );
					if($order < sizeof($list_order_view)){
						$order_view = $order + 1;
						$menu->changeOrderview($order_view);
					}
				}
			}
		}
		else{
			//Change order view
			if ($this->parent_id == $this->old_parent_id) {
				if ($this->order_view < $this->old_order_view) {
					$list_order_view=$this->list_order_view;
					foreach ( $list_order_view as $id => $order ) {
						if ($id != $this->id && $order >= $this->order_view) {
							$menu = self::model ()->findByPk ( $id );
							if ($menu->order_view < $this->old_order_view ){
								if($order < sizeof($list_order_view)){
									$order_view = $order + 1;
									$menu->changeOrderview($order_view);
								}
							}
						}
					}
				}
				
				if ($this->order_view > $this->old_order_view) {
					$list_order_view=$this->list_order_view;
					foreach ( $list_order_view as $id => $order ) {
						if ($id != $this->id && $order <= $this->order_view) {
							$menu = self::model ()->findByPk ( $id );
							if ($menu->order_view > $this->old_order_view ){
								if($order > 1){
									$order_view = $order - 1;
									$menu->changeOrderview($order_view);
								}
							}
						}
					}
				}
			} 
			else {
				//Fix order view in old parent menu
				$list = self::model ()->findAll ( 'parent_id=' . $this->old_parent_id );
				foreach ( $list as $menu ) {
					if ($menu->order_view > $this->old_order_view) {
						if($menu->order_view > 1){
							$order_view = $menu->order_view - 1;
							$menu->changeOrderview($order_view);
						}
					}
				}
				//Fix order view in new parent menu
				$list_order_view=$this->list_order_view;
				foreach ( $list_order_view as $id => $order ) {
					if ($id != $this->id && $order >= $this->order_view) {
						$menu = self::model ()->findByPk ( $id );
						if($order < sizeof($list_order_view)){
							$order_view = $order + 1;
							$menu->changeOrderview($order_view);
						}
					}
				}
			}
		}
	}
	public function checkDelete($id){
		$list_menu=self::model()->findAll('parent_id = '.$id);
		if(sizeof($list_menu)>0){
			return self::DELETE_HAS_CHILD;
		}
		return self::DELETE_OK;
	}
	
	/**
	 * Get active menu
	 * @return array $result, the active menu in admin board
	 */
	public function findActiveMenu(){
		$list=$this->list_nodes;	
		$result=array();
		foreach ($list as $id=>$level){
			$menu=self::model()->findByPk($id);
			$list_url=array();
			$list_url[]=Yii::app()->request->url;
			if(in_array($menu->url,$list_url))
			{
				$result=$menu->ancestor_nodes;
			}
		}
		return $result;
	}
	
	/*
	 * Get url
	 */
	 public function getUrl(){
	 	$config_url=$this->config_url;
		if(isset($config_url[$this->key_url]))
			return $config_url[$this->key_url];
	 }
}