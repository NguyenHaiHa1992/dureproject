<?php
class EmployeeService extends iPhoenixService{
	public static function createInit(){
		$result= array();
		$get_empty_employee= EmployeeService::getEmptyEmployee();
		$result['employee']= $get_empty_employee['employee'];
		$get_empty_employee_error= EmployeeService::getEmptyEmployeeError();
		$result['employee_error']= $get_empty_employee_error['employee_error'];
		$result['success']= true;
		return $result;
	}
	
	public static function getEmptyEmployee(){
		$result= array();
		$employee= array(
					'id'=> '',
					'name'=> '',
					'status'=> '',
					'created_time'=> '',
					);
		
		$result['employee']= $employee;
		$result['success']= true;
		return $result;
	}
	
	public static function getEmptyEmployeeError(){
		$result= array();
		$employee= array(
					'id'=> array(),
					'name'=> array(),
					'status'=> array(),
					'created_time'=> array(),
					);
		
		$result['employee_error']= $employee;
		$result['success']= true;
		return $result;
	}
	
	public static function getAll($data){
		$result= array();

		$result = array();
		if(!isset($data['limitstart']) && !isset($data['limitnum'])){
			$data['limitstart']= '0';
			$data['limitnum']= Employee::model()->count();
		}
		if(!isset($data['sort_attribute']) && !isset($data['sort_type'])){
			$data['sort_attribute']= 'created_time';
			$data['sort_type']= 'DESC';
		}

		$sql= '';
		$sql_order_by= '';
		$sql_order_by='Order By tbl_employee.'.$data['sort_attribute'].' '.$data['sort_type'];
		
		
		$sql= "Select tbl_employee.*
			   From tbl_employee";
		$sql= $sql."
			   		Where tbl_employee.status= 1 ";

		if(isset($data['name']) && $data['name']!= ''){
			$sql= $sql."And tbl_employee.name LIKE '%".$data['name']."%'";
		}

		$sql= $sql.$sql_order_by;
		$sql= $sql." Limit ".$data['limitstart'].", ".$data['limitnum'];
		$employees= Employee::model()->findAllBySql($sql);

		$criteria = new CDbCriteria();
		$criteria->compare('status', 1);
		if(isset($data['name']) && $data['name']!= ''){
			$criteria->compare('name', $data['name'], true);
		}

		$total = Employee::model()->count($criteria);

		if($employees!= null){
			$result['success']= true;
			$result['employees']=self::convertListEmployee($employees, $data);
			$result['totalresults']= $total;
			$result['start_employee']= (int)$data['limitstart']+ 1;
			$result['end_employee']= (int)$data['limitstart']+ count($employees);
		}
		else{
			$result['success']= true;
			$result['employees']= array();
			$result['totalresults']= $total;
			$result['start_employee']= 0;
			$result['end_employee']= 0;
		}

		return $result;
	}

	public static function getEmployeeById($data){
		$result= array();
		$get_empty_employee_error= EmployeeService::getEmptyEmployeeError();
		$result['employee_error']= $get_empty_employee_error['employee_error'];
		$employee= Employee::model()->findByPk($data['id']);

		if($employee){
			$result['success']= true;
			$result['employee']= self::convertEmployee($employee);
		}
		else{
			$result['success']= false;
			$result['message']= 'Employee \'s not found!';
		}
		return $result;
	}
	
	public static function create($data){
		$result= array();
		
		$employee= new Employee();
		$employee->attributes= $data;

		if($employee->validate()){
			$employee->save();
			$result['success']= true;
			$result['id']= $employee->id;
		}
		else{
			$empty_employee_error= EmployeeService::getEmptyEmployeeError();
			$result['employee_error']= $empty_employee_error['employee_error']; 
			foreach ($employee->getErrors() as $key => $error_array) {
				$result['employee_error'][$key]= $error_array;
			}
			$result['success']= false;
			$result['message']= 'Creating employee has some errors';
		}
		return $result;
	}
	
	public static function update($data){
		$result= array();
		if(isset($data['id'])){
			$employee= Employee::model()->findByPk((int)$data['id']);
			if($employee){
				$employee->attributes= $data;

				if($employee->validate()){
					$employee->save();
					$result['success']= true;
					$result['id']= $employee->id;
					$employee_array= EmployeeService::getEmployeeById(array('id'=>$employee->id));
					$result['employee']= $employee_array['employee'];
					$result['message']= 'Employee updated!';
				}
				else{
					$empty_employee_error= EmployeeService::getEmptyEmployeeError();
					$result['employee_error']= $empty_employee_error['employee_error']; 
					foreach ($employee->getErrors() as $key => $error_array) {
						$result['employee_error'][$key]= $error_array;
					}
					$result['success']= false;
					$result['message']= 'Update employee has some errors';
				}
			}
			else{
				$result['success']= false;
				$result['message']= 'Employee \'s not found!';
			}
		}
		else{
			//Create new employee
			$employee = new Employee();
			$employee->attributes= $data;

			if($employee->validate()){
				$employee->save();
				$result['success']= true;
				$result['id']= $employee->id;
				$employee_array= EmployeeService::getEmployeeById(array('id'=>$employee->id));
				$result['employee']= $employee_array['employee'];
				$result['message']= 'Employee created!';
			}
			else{
				$empty_employee_error= EmployeeService::getEmptyEmployeeError();
				$result['employee_error']= $empty_employee_error['employee_error']; 
				foreach ($employee->getErrors() as $key => $error_array) {
					$result['employee_error'][$key]= $error_array;
				}
				$result['success']= false;
				$result['message']= 'Create employee has some errors';
			}
		}
		
		
		return $result;
	}
	
	public static function convertListEmployee($employees, $data){
		$result= array();
		if($employees!= null && count($employees)>0){
			foreach($employees as $employee){
				$result[]= self::convertEmployee($employee);
			}
		}
		return $result;
	}
	
	public static function convertEmployee($employee){
		$result= array(
					'id'=> $employee->id,
					'name'=> $employee->name,
					'status'=> $employee->status,
					'created_time'=> date('d-m-Y', $employee->created_time),
					
					);

		return $result;
	}

	public static function removeEmployee($data){
		$result= array();
		$employee = Employee::model()->findByPk((int)$data['id']);
		$employee->attributes= $data;

		if($employee->delete()){
			$result['success'] = true;
			$result['message'] = 'Employee deleted!';
		}
		else{
			$result['success']= false;
			$result['message']= CHtml::errorSummary($employee);
		}
		
		return $result;
	}
}
