<?php 
class Login_mod extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function check_login($username,$password)
	{
		    $this->db->where('username', $username);
			$this->db->where('pass', md5($password));
			$this->db->where('user_status', 'active');
			$this->db->limit(1);
			$query = $this->db->get('users');
			//echo $this->db->last_query();die;
			
			if($query->num_rows() > 0)
		    {
				foreach($query->result_array() as $row)
				{
					
					$arr_session = array(
									"username" => $row['first_name'].' '.$row['last_name'],
									"userid"=> $row['uid'],
									"userrole"=> $row['user_role']
								);
					$this->session->set_userdata($arr_session);
				}
				return true;
			}else{
				return false;
			}	
	}
	
	public function change_password($userid,$old_pwd,$new_pwd)
	{
		$data = array('password' => md5($new_pwd));
		$this->db->where('id', $userid);
		$this->db->where('password', md5($old_pwd));	
		$query = $this->db->get('users');
		if($query->num_rows() > 0)
		{
			$this->db->where('id', $userid);
			$this->db->update('admin', $data); 
			if(isset($_COOKIE['user_pwd']))
			{
				setcookie('user_pwd',$new_pwd, time()+(30*60*60*24)); 			
			}
			return true;
		}else{
		    return false;
		}	
	}
	
}
?>