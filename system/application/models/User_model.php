<?php 
class User_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	
	 
	 public function getAllUsers()
	 {
		 	$this->db->select("U.*");
			$this->db->from("users AS U");
			$this->db->where("user_status", "Active");
			$this->db->order_by('U.first_name ASC');
			$this->db->order_by('U.last_name ASC');
			$query_customer = $this->db->get();
			if($query_customer->num_rows()>0)
			{
				return $query_customer->result_array();
			}
			else
			{
				return array();
			}
	 }
	 
	 public function addUser($data)
	 {
		 	$this->db->insert("users", $data); 
		   return $this->db->insert_id();
	 }
	 
	 public function updateUser($data_update,$id)
	 {
		 $this->db->where("uid", $id);
		 $this->db->update("users", $data_update); 
		 return $id;
	 }
	 
	 public function getUser($uid)
	 {
			$this->db->select("U.*");
			$this->db->from("users AS U");
			$this->db->where("U.uid",$uid);
			$query_user = $this->db->get();
			//echo $this->db->last_query();die;
			if($query_user->num_rows()>0)
			{
				return $query_user->result_array();
			}
			else
			{
				return false;
			}
	 }
	 
	 public function delete_single_user($uid)
	 {
		 	 $this->db->where("uid", $uid);
			 $data_update = array('user_status' => 'In-Active');
		 	 $this->db->update("users", $data_update);
			 return 1;
	 }
	 
	 public function getUsersPerRole($role)
	 {
		 	$this->db->select("U.uid, U.first_name, U.last_name");
			$this->db->from("users AS U");
			$this->db->where("user_role", $role);
			$this->db->where("user_status", "Active");
			$this->db->order_by('U.first_name ASC');
			$this->db->order_by('U.last_name ASC');
			$query_customer = $this->db->get();
			if($query_customer->num_rows()>0)
			{
				return $query_customer->result_array();
			}
			else
			{
				return array();
			}
	 }
	 
	 /* Get the all pending notifications */
	 public function getUserNotifications(){
	        $today = date('Y-m-d 23:59:59');
	 		$this->db->select("N.*, U.first_name, U.last_name");
			$this->db->from("notifications AS N");
			$this->db->join("users AS U", 'U.uid = N.uid');
			if($this->session->userdata('userrole') != 'Admin'){
				$this->db->where("N.uid",$this->session->userdata('userid'));
			}
			$this->db->where("N.reminder_date <= ",$today);
			$this->db->where("N.read_flag",'Pending');
			$this->db->order_by('N.reminder_date ASC');
			$query_notifications = $this->db->get();
			//echo $this->db->last_query();die;
			if($query_notifications->num_rows()>0)
			{
				return $query_notifications->result_array();
			}
			else
			{
				return array();
			}
	 }
	 
	 
  /* Update the notification flag as "Read" based on the nitification id and logged in user id*/
	 
	 public function updateNotification($id){
	     $data_update['read_flag'] = 'Read'; 
	 	 $this->db->where("id", $id);
		 $this->db->where("uid", $this->session->userdata('userid'));
		 $this->db->limit(1);
		 $this->db->update("notifications", $data_update);
		 //echo $this->db->last_query();die;
		 $afftectedRows = $this->db->affected_rows();
		 return $afftectedRows;
			
	 }
	 
	
	 /* Get the all parties having communication scheduled today for the logged in users */
	 public function getTodaysCommunications(){
	        $todayStart = date('Y-m-d 00:00:00');
			$todayEnd = date('Y-m-d 23:59:59');
	 		$this->db->select(" CC.* , C.comp_name, C.comp_id");
			$this->db->from("comp_communication AS CC");
			$this->db->join("clients AS C", 'C.comp_id = CC.client_id');
			
			if($this->session->userdata('userrole') != 'Admin'){
				$this->db->where("CC.user_id",$this->session->userdata('userid'));
			}
			$this->db->where("CC.ndate >= ",$todayStart);
			$this->db->where("CC.ndate <= ",$todayEnd);
			$this->db->order_by('CC.ndate DESC');
			$query_communication = $this->db->get();
			//echo $this->db->last_query();die;
			if($query_communication->num_rows()>0)
			{
				return $query_communication->result_array();
			}
			else
			{
				return array();
			}
	 }
	 
	 /* Get the all supplier communication scheduled today for the logged in users */
	 public function getTodaysSupplierCommunications(){
	        $todayStart = date('Y-m-d 00:00:00');
			$todayEnd = date('Y-m-d 23:59:59');
	 		$this->db->select(" SC.* , S.supl_comp, S.supl_id");
			$this->db->from("supl_communication AS SC");
			$this->db->join("suppliers AS S", 'S.supl_id = SC.supl_id');
			
			if($this->session->userdata('userrole') != 'Admin'){
				$this->db->where("SC.user_id",$this->session->userdata('userid'));
			}
			$this->db->where("SC.ndate >= ",$todayStart);
			$this->db->where("SC.ndate <= ",$todayEnd);
			$this->db->order_by('SC.ndate DESC');
			$query_communication = $this->db->get();
			//echo $this->db->last_query();die;
			if($query_communication->num_rows()>0)
			{
				return $query_communication->result_array();
			}
			else
			{
				return array();
			}
	 }
	 
	 /* Get the all parties having due payment date for today */
	 public function getTodaysDuePayments(){
	        $today = date('Y-m-d');
			
	 		$this->db->select(" IP.invoice_number, IP.invoice_amount, IP.reminder_date, C.comp_name, C.comp_id, C.primary_phone, C.primary_mobile, C.primary_contact");
			$this->db->from("invoice_payments AS IP");
			$this->db->join("clients AS C", 'C.comp_id = IP.client_id ');
			$this->db->join("users AS U", 'U.uid = IP.order_by');
			$this->db->where("IP.status  ",'Pending');
			$this->db->where("IP.reminder_date !=",'0000-00-00');
			$this->db->where("IP.reminder_date <=",$today);
			$this->db->order_by('IP.payment_id  ASC');
			$query_duepayments = $this->db->get();
			//echo $this->db->last_query();die;
			if($query_duepayments->num_rows()>0)
			{
				return $query_duepayments->result_array();
			}
			else
			{
				return array();
			}
	 }
	 
	 public function getAllPendingOrders(){
	
		   $this->db->select('CO.order_id,CO.order_number, CO.uid, CO.order_status, CO.po_ref, CO.po_date, CO.order_date, C.comp_name, U.first_name, U.last_name');
			$this->db->from('client_orders AS CO');
			$this->db->join('users AS U','U.uid = CO.uid');
			$this->db->join('clients AS C','C.comp_id = CO.comp_id');
			$this->db->where("CO.order_type ",'Order');
			$this->db->where("CO.order_status ",'Pending');
			if($this->session->userdata('userrole') == 'Sales'){
				$this->db->where("CO.uid",$this->session->userdata('userid'));
			}
			$this->db->order_by('CO.order_status DESC');
			$this->db->order_by('CO.order_date DESC');
			$query_pending_orders = $this->db->get();
			//echo $this->db->last_query();die; // 
			if($query_pending_orders->num_rows()>0)
			{
				return $query_pending_orders->result_array();
			}
			else
			{
				return array();
			}
	}
	 
	 
	 
}
?>