<?php 
class Workers_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	public function getAllWorkers(){
	
		  $this->db->select('E.*');
			$this->db->from('employees AS E');
			$this->db->order_by('E.emp_status ASC');
			$this->db->order_by('E.emp_name ASC');
			
			$query_all_workers = $this->db->get();
			//echo $this->db->last_query();die; // 
			if($query_all_workers->num_rows()>0)
			{
				return $query_all_workers->result_array();
			}
			else
			{
				return array();
			}
	}
	
	public function addWorker($data_insert){
		$this->db->insert("employees", $data_insert); 
	    return $this->db->insert_id();
		//echo $this->db->last_query();die;
	}
	
	/*
	   Get the employee details
	 */
	  public function getWorkerInfo($id)
	 {
			$this->db->select("E.*");
			$this->db->from("employees AS E");
			$this->db->where("E.emp_id",$id);
			$this->db->limit(1);
			$query_employee = $this->db->get();
			//echo $this->db->last_query();die;
			if($query_employee->num_rows()>0)
			{
				return $query_employee->result_array();
			}
			else
			{
				return false;
			}
	 }
	 
	 /*
	 Update client into database
	 */ 
	  public function updateWorker($data_update,$emp_id)
	 {
		 $this->db->where("emp_id", $emp_id);
		 $this->db->update("employees", $data_update); 
		 $this->db->limit(1);
		 //echo $this->db->last_query();die;
		 return $emp_id;
	 }
	 
	 public function getWorkerAttendance($stardate, $enddate, $emp_id){
	
		  $this->db->select('EA.*');
			$this->db->from('employee_attendance AS EA');
			$this->db->where('EA.emp_id ', $emp_id );
			$this->db->where("EA.atn_date >=",$stardate);  
			$this->db->where("EA.atn_date <=",$enddate);
			$this->db->order_by('EA.atn_date ASC');
			
			$query_worker_attendance = $this->db->get();
			//echo $this->db->last_query();die; // 
			if($query_worker_attendance->num_rows()>0)
			{
				return $query_worker_attendance->result_array();
			}
			else
			{
				return array();
			}
	}
}
?>