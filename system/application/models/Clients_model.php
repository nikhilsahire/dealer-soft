<?php 
class Clients_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	
	 
	 public function getAllClients($uid='',$all='')
	 {
		 	$this->db->select("C.*");
			$this->db->from("clients AS C");
			
			if($this->session->userdata('userrole') == 'Sales'){
				$this->db->where("handling_person",$this->session->userdata('userid'));
			}
			$this->db->where("status", "Active");
			if($all == ''){
				$this->db->where("client_type", "Client"); // only fetch the records with type "Client"
			}
			$this->db->order_by('C.comp_name ASC');
			//$this->db->limit(2);
			$clientsQuery = $this->db->get();
			//echo $this->db->last_query();die;
			if($clientsQuery->num_rows()>0)
			{
				return $clientsQuery->result_array();
			}
			else
			{
				return array();
			}
	 }

	 /*
	  Add client into database
	 */
	 function addClient($data){
	 	$this->db->insert("clients", $data); 
	    return $this->db->insert_id();
	 }
	 
	 /*
	 Update client into database
	 */ 
	  public function updateClient($data_update,$client_id)
	 {
		 $this->db->where("comp_id", $client_id);
		 $this->db->update("clients", $data_update); 
		 $this->db->limit(1);
		 //echo $this->db->last_query();die;
		 return $client_id;
	 }
	 
	 
	 /*
	   update clients handling person in client tabel
	 */
	 
	 	 public function updateHandlingPerson($companyId, $userId=0)
	 {
		 	$this->db->where("comp_id", $companyId);
			 $data_update = array('handling_person' => $userId);
		 	 $this->db->update("clients", $data_update);
			 return 1;
	 }
	 
	 /*
	   Get the client details
	 */
	  public function getClientInfo($id)
	 {
			$this->db->select("c.*");
			$this->db->from("clients AS c");
			$this->db->where("c.comp_id",$id);
			$this->db->limit(1);
			$query_client = $this->db->get();
			//echo $this->db->last_query();die;
			if($query_client->num_rows()>0)
			{
				return $query_client->result_array();
			}
			else
			{
				return false;
			}
	 }
	 
	 
	 /*
	   delete clients handling person in client tabel
	 */
	 public function delete_single_customer($cust_id)
	 {
		 	 $this->db->where("id", $cust_id);
			 $data_update = array('delete_flg' => '1');
		 	 $this->db->update("clients", $data_update);
			 return 1;
	 }
	 
	 
	// get the list of ordered/sampled products based on the client
	 public function orderedProducts($client_id){
			$this->db->select('COP.order_pid, COP.order_qty, COP.notes, CO.order_date, P.product_name, P.prod_unit');
			$this->db->from('client_orders AS CO');
			$this->db->join('client_order_prodcts AS COP','COP.order_id = CO.order_id');
			$this->db->join('product AS P','P.pid = COP.order_pid');
			$this->db->where("CO.comp_id",$client_id);
			$this->db->group_by("COP.order_pid");
			//$this->db->order_by("PI.reminder_date ASC");
			$query_ordered_products = $this->db->get();
			// echo $this->db->last_query();die;
			if($query_ordered_products->num_rows()>0)
			{
				return $query_ordered_products->result_array();
			}
			else
			{
				return array();
			}			
	}
	
	
}
?>