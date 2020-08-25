<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Privilege_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
		
    public function create_privilege($user_roll_id, $action) {
    	if($user_roll_id > 0)
		{
			$this->db->where('user_roll_id',$user_roll_id);
			$delete = $this->db->delete('user_privilege');
			
			for($i=0;$i<count($action);$i++){
				if($action[$i]){
					$actArr = explode('_', $action[$i]);
					$menu_action_id = $actArr[0];
					$rights = $actArr[1];
					
					if($menu_action_id > 0){
						$data = array(
									'user_roll_id' => $user_roll_id,
									'menu_action_id' => $menu_action_id
							);
						$this->db->insert('user_privilege', $data);						
					}
				}
			
			}	
		}
		
		return true;
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
    			$action_arr[] = $menuactions['menu_action_id'].'_'.$menuactions['permission_name'];
    		}
    		$i++;
    	}
    	return json_encode($action_arr);
    
    }
}

/* End of file privilege_model.php */