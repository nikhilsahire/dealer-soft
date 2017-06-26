<?php 
class Attendance_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	public function getAllActiveEmployees(){
	
		    $this->db->select('E.*');
			$this->db->from('employees AS E');
			$this->db->where("E.emp_status ",'Active');
			$this->db->order_by('E.emp_name DESC');
			$query_active_employees = $this->db->get();
			//echo $this->db->last_query();die; // 
			if($query_active_employees->num_rows()>0)
			{
				return $query_active_employees->result_array();
			}
			else
			{
				return array();
			}
	}
	
	/* Add attendance entries in database */
	 public function addAttendanceEntries($data_insert, $atnDate){
	 	  // first delete all entries for the day
		    $flag =  0; 
	       $query = $this->db->delete('employee_attendance',array('atn_date'=>$atnDate));		   
		  //  Add data to database
		  foreach($data_insert as $row){
	 	  	 $this->db->insert("employee_attendance", $row); 
			 $flag =  1; 
		  }
		   return $flag;
	 }
	
	/*
		get the working hours for the said date
	*/
	public function getWorkingHrs($emp_id, $attnDate){
	
		    $this->db->select('E.*');
			$this->db->from('employee_attendance AS E');
			$this->db->where("E.emp_id ", $emp_id);
			$this->db->where("E.atn_date ",$attnDate);
			$this->db->limit(1);
			$query_employee_workinghrs= $this->db->get();
			//echo $this->db->last_query();die; // 
			if($query_employee_workinghrs->num_rows()>0)
			{
				return $query_employee_workinghrs->result_array();
			}
			else
			{
				return array('0'=>array('in_time'=>'00:00:00','out_time'=>'00:00:00'));
			}
	}
	
}
?>