<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class List_User_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_users($limit = 0, $offset = 0, $order_by = "username", $sort_order = "asc", $search_data) {
		
		if (!empty($search_data)) {
    		!empty($search_data['user_id']) ? $data['users.user_id'] = $search_data['user_id'] : "";
			!empty($search_data['staff_name']) ? $data['staff_name'] = str_replace(" ","",trim($search_data['staff_name'])) : "";
			!empty($search_data['user_roll_name']) ? $data['user_roll.user_roll_name'] = $search_data['user_roll_name'] : "";
    		!empty($search_data['users.cell_phone']) ? $data['users.cell_phone'] = $search_data['users.cell_phone'] : "";
    		
    	}
		$this->session->set_userdata('export_var', $search_data);
				
    	$this->db->select('users.*,
						  user_profile.*,
						  CONCAT_WS(" ",users.first_name,users.middle_name,users.last_name) AS staff_name,
						  user_roll.user_roll_name,
						  users.user_id,
						  countries.nationality,u1.username as c_users,u2.username as u_users
						 ',FALSE);
    	$this->db->from('users');
		$this->db->join('user_profile', 'user_profile.user_id = users.user_id','left');
		$this->db->join('user_roll', 'user_roll.user_roll_id = users.user_roll_id','left');
		$this->db->join('countries', 'countries.id = user_profile.nationality','left');
		$this->db->join('users u1', 'u1.user_id = users.created_by','left');
		$this->db->join('users u2', 'u2.user_id = users.updated_by','left');
		$this->db->where('users.user_roll_id','1');
		
    	//!empty($data) ? $this->db->like($data) : "";
    	if(!empty($data))
        {
			$filter_selection = " AND ";
			if(isset($search_data["global_search"]) && $search_data["global_search"] == 1)
				$filter_selection = " OR ";
				
        	$str_data_or_like = "";
        	foreach($data AS $data_key=>$data_val)
        	{
				if($data_key == "staff_name")
				{
					$str_data_or_like .= "(CONCAT_WS('',trim(users.first_name),trim(users.middle_name),trim(users.last_name)) LIKE '%".$data_val."%' OR CONCAT_WS('',trim(users.first_name),trim(users.last_name)) LIKE '%".$data_val."%')".$filter_selection;
				}
				else
				{
					$str_data_or_like .= " $data_key LIKE '%$data_val%'".$filter_selection;	
				}
        	}
        	$str_data_or_like = trim(trim($str_data_or_like),$filter_selection);
        	
        	if($str_data_or_like != "")
        		$this->db->where("(".$str_data_or_like.")", null, false);
        }
		
		if($order_by != "")
			$this->db->order_by($order_by, $sort_order);
		
		if($limit > 0)
			$this->db->limit($limit, $offset);
    
    	$query = $this->db->get();
		//echo $this->db->last_query();exit();
		
		if($limit == 0)
			return $query->num_rows();
			
    	if($query->num_rows() > 0) {
    		return $query;
    	}
    }

    public function get_user_profile($user_id) {
		$this->db->select('users.*,users.user_id as user_unique_id,user_profile.*,countries.nationality as nationality_name,user_roll.user_roll_name,CONCAT_WS(" ",users.first_name,users.middle_name,users.last_name) as staff_name',FALSE);
    	$this->db->from('users');
		$this->db->join('user_profile', 'user_profile.user_id = users.user_id','left');
		$this->db->join('countries', 'countries.id = user_profile.nationality','left');
		$this->db->join('user_roll', 'user_roll.user_roll_id = users.user_roll_id','left');
		$this->db->where('users.user_id',$user_id);
		$query = $this->db->get();
		//echo $this->db->last_query();
    	
		if($query->num_rows() > 0) {
    		return $query->row();
    	}
		
		return false;
	}
	
	public function check_user_profile_exist($user_id) {
		$this->db->select('*');
    	$this->db->from('user_profile');
		$this->db->where('user_profile.user_id',$user_id);
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
    		return $query->row();
    	}
		
		return false;
	}
		
	public function update_user_profileid($userid, $table, $table_profile_field='profile_id', $table_where_field='user_id') {
        $sql = "UPDATE ".$table." LEFT JOIN user_profile ON(user_profile.user_id = ".$table.".".$table_where_field.") SET ".$table_profile_field." = user_profile_id WHERE ".$table.".".$table_where_field." = ".$userid;
		$this->db->query($sql);
		//echo $sql;exit;
    }
	
	public function set_password($password,$user_id) {
        $this->load->helper('password');
        $new_nonce = md5(uniqid(mt_rand(), true));
        $data = array(
               'password' => hash_password($password, $new_nonce),
               'nonce' => $new_nonce
            );

        $this->db->where('user_id', $user_id);
        $this->db->update('users', $data);

        if ($this->db->affected_rows() == 1) {
            return true;
        }
        return false;
    }
	
	function upload_profile_pic($user_id,$data){
		$this->db->where('user_id', $user_id);
		$this->db->update('users', $data);
		return $this->db->affected_rows();
	}
	
	public function get_existing_privilege($user_roll_id) {
    	$this->db->select('*');
    	$this->db->from('user_privilege');
    	$this->db->where('user_roll_id',$user_roll_id);
    	$query = $this->db->get();
    	$menu_data = $query->result_array();
    	
    	$user_roll_id = array();
    	$i = 0;
    	$action_arr = array();
    	foreach ($menu_data as $menu_datas){
    		$this->db->select('*');
    		$this->db->from('menu_action');
    		$this->db->where('menu_action_id',$menu_datas['menu_action_id']);
    		$querys = $this->db->get();
    		$menuaction = $querys->result_array();
    		foreach ($menuaction as $menuactions){
    			$action_arr[] = $menuactions['menu_id'].'_'.$menuactions['rights'];
    		}
    		$i++;
    	}
    	return ($action_arr);
    }
	
	public function create_single_user_privilege($user_id, $action) {
    	$this->db->where('user_id',$user_id);
    	$delete = $this->db->delete('user_custom_privilege');
		
		if(is_array($action) && count($action) > 0)
		{
			for($i=0;$i<count($action);$i++){
				if($action[$i]){
					$actArr = explode('_', $action[$i]);
					$menu_id = $actArr[0];
					$rights = $actArr[1];
					
					$this->db->select('*');
					$this->db->from('menu_action');
					$this->db->where('menu_id',$menu_id);
					$this->db->where('rights',$rights);
					$query = $this->db->get();
					$menu_action = $query->result_array();
					if($menu_action){
						foreach ($menu_action as $menu_actions){
							
							$data = array(
									'user_id' => $user_id,
									'menu_action_id' => $menu_actions['menu_action_id']
							);
							$this->db->insert('user_custom_privilege', $data);
						}
					}
					
				}
			
			}
		}	
		return true;
    }
	
	public function get_user_roll($user_id) {
		$this->db->select('user_roll_id');
    	$this->db->from('users');
		$this->db->where('user_id',$user_id);
		$query = $this->db->get();
    	if($query->num_rows() > 0) {
    		$data = $query->row();
			return $data->user_roll_id;
    	}
		
		return false;
	}
    
    public function get_user_by_id($user_id) {
        $this->db->select('*');
        $this->db->from('users');
       
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        //echo $this->db->last_query();

        if ($query->num_rows() > 0) {
            return $query->row(0);
        }

        return false;
    }

}

/* End of file list_user_model.php */
