<?php 
class Suppliers_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	
	 
	 public function getAllSuppliers()
	 {
		 	$this->db->select("S.*");
			$this->db->from("suppliers AS S");
			if($this->session->userdata('userrole') == 'Purchase'){
				//$this->db->where("S.handling_person",$this->session->userdata('userid'));
			}
			$this->db->where("S.supplier_type",'Supplier');
			$this->db->order_by('S.supl_comp ASC');
			//$this->db->limit(2);
			$suppliersQuery = $this->db->get();
			//echo $this->db->last_query();die;
			if($suppliersQuery->num_rows()>0)
			{
				return $suppliersQuery->result_array();
			}
			else
			{
				return array();
			}
	 }
	 
	  /*
	   Get the list of supplier leads
	 */
	 
	 public function getAllLeads()
	 {
		 	$this->db->select("S.*");
			$this->db->from("suppliers AS S");
			$this->db->where("S.supplier_type",'Lead');
			$this->db->order_by('S.supl_comp ASC');
			//$this->db->limit(2);
			$suppliersQuery = $this->db->get();
			//echo $this->db->last_query();die;
			if($suppliersQuery->num_rows()>0)
			{
				return $suppliersQuery->result_array();
			}
			else
			{
				return array();
			}
	 }
	 
	 
	 /*
	   Get the client details
	 */
	  public function getSupplierInfo($id)
	 {
			$this->db->select("S.*");
			$this->db->from("suppliers AS S");
			$this->db->where("S.supl_id",$id);
			$this->db->limit(1);
			$query_supplier = $this->db->get();
			//echo $this->db->last_query();die;
			if($query_supplier->num_rows()>0)
			{
				return $query_supplier->result_array();
			}
			else
			{
				return false;
			}
	 }
	 
	 
	 /*
	   update clients handling person in client tabel
	 */
	 
	 	 public function updateHandlingPerson($supplierId, $userId=0)
	 {
		 	$this->db->where("supl_id", $supplierId);
			 $data_update = array('handling_person' => $userId);
		 	 $this->db->update("suppliers", $data_update);
			 return 1;
	 }
	 /*
	  Add client into database
	 */
	 function addSupplier($data){
	 	$this->db->insert("suppliers", $data); 
	    return $this->db->insert_id();
	 }
	 
	 /*
	 Update client into database
	 */ 
	  public function updateSupplier($data_update,$supplierId)
	 {
		 if($supplierId > 0){
			 $this->db->where("supl_id", $supplierId);
			 $this->db->update("suppliers", $data_update); 
			 $this->db->limit(1);
			// echo $this->db->last_query();die;
			 return $supplierId;
		 }
	 }
	 /*
	   get list of all states
	 */
	 public function getCountryStates($countryId=99)
	 {
		 	 $this->db->select("CC.*");
			 $this->db->from("country_cities AS CC");
			 $this->db->where("country_id", $countryId);
			 $this->db->group_by('CC.state_name');
			 $this->db->order_by('CC.state_name ASC');
		     $stateQuery = $this->db->get();
			 
		 	 if($stateQuery->num_rows()>0)
			{
				return $stateQuery->result_array();
			}
			else
			{
				return array();
			}
	 }
	 
	 
	 /*
	   get list of all cities based on state
	 */
	 public function getStateCities($stateName)
	 {
		 if($stateName != ''){	 
			 $this->db->select("CC.district_name");
			 $this->db->from("country_cities AS CC");
			 $this->db->where("state_name", $stateName);
			 $this->db->group_by('CC.district_name');
			 $this->db->order_by('CC.district_name ASC');
		     $cityQuery = $this->db->get();
			 
		 	 if($cityQuery->num_rows()>0)
			{
				return $cityQuery->result_array();
			}
			else
			{
				return array();
			}
	    }else {
		   return array();
		}
	 }
	 
	 // get all the purchased products from the supplier
	  public function getPurchasedProducts($supplier_id){
			 $this->db->select("DISTINCT(PS.pid)");
			 $this->db->from("product_stock AS PS");
			 $this->db->where("su_id", $supplier_id);
			
		     $query_purchased_products = $this->db->get();
			 
		 	 if($query_purchased_products->num_rows()>0)
			{
				return $query_purchased_products->result_array();
			}
			else
			{
				return array();
			}
	  }
	  
	  /* Get the last batch of product from the supplier with Batch details*/
	  
	  public function getPurchasedProductsInfo($supplier_id, $pid){
			 $this->db->select("PS.id, PS.`pid`, PS.`su_id`, PS.`inw_qty`, PS.`rate`, PS.`on_date`, PS.`firm_id`, PS.batch_desc, P.product_name");
			 $this->db->from("product_stock AS PS");
			 $this->db->from("product AS P");
			 $this->db->where("PS.su_id", $supplier_id);
			 $this->db->where("PS.pid", $pid);
			 $this->db->order_by("PS.id DESC ");
			 $this->db->limit(1);
			
		     $query_purchased_products_info = $this->db->get();
			 
		 	 if($query_purchased_products_info->num_rows()>0)
			{
				return $query_purchased_products_info->result_array();
			}
			else
			{
				return array();
			}
	  }
	  
	  /*
	   get list of all communication records for client
	 */
	 public function supplierCommunication($supplier_id)
	 {
		 if($supplier_id != ''){	 
			 $this->db->select("SC.*");
			 $this->db->from("supl_communication AS SC");
			 $this->db->where("supl_id", $supplier_id);
			 $this->db->order_by('SC.com_date DESC');
		     $cityQuery = $this->db->get();
			 // echo $this->db->last_query();die;
		 	 if($cityQuery->num_rows()>0)
			{
				return $cityQuery->result_array();
			}
			else
			{
				return array();
			}
	    }else {
		   return array();
		}
	 }
	 
	 /*
	  Add communication entry into database.
	 */
	 public function addSupplierCommunication($data){
	    // Update the notification table for communication 
		$this->load->model('Orders_model', 'orders');
		// add notification
			$notificationArray = array();
			$supplierInfo = $this->getSupplierInfo($data['supl_id']);
			$today = date("Y-m-d");
			$notificationArray['uid'] = $this->session->userdata('userid');
			$notificationArray['message_text'] = 'You scheduled a call with '.$supplierInfo[0]['supl_comp'].' on '. date('d M Y H:i',strtotime($data['ndate']));
			$notificationArray['added_on'] = $today;
			$notificationArray['reminder_date'] = $data['ndate'] ;
			$notificationArray['read_flag'] = 'Pending';
			
            $this->orders->add_notification($notificationArray);
		// add the communication
	 	$this->db->insert("supl_communication", $data); 
	    return $this->db->insert_id();
	 } 
	
}
?>