<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/*
* Check Dat exist
* $table = Table Name
* $where = array(); condition
* ColumnID = column_id != $ID id
*/
function check_data_exist($table = Null,$where = array(),$ColumnID = Null,$ID = Null)
{
    $ci =& get_instance();
    $ci->db->select('*');
    $ci->db->from($table);
    $ci->db->where($where);
    if(!empty($ColumnID))
    {
        $ci->db->where("$ColumnID !=", "$ID");
    }
    return $ci->db->get()->row_array();
}

if (!function_exists('get_users_list')) {
    function get_users_list() {
        $ci =& get_instance();
        $ci->db->select('*,CONCAT_WS(" ",users.first_name,users.middle_name,users.last_name) AS staff_name', false);
        $ci->db->from('users');
        $ci->db->order_by('first_name', 'ASC');
        $query = $ci->db->get();
        $_data = $query->result_array();
        $_arr = array();
        $_arr[0] = '--Please Select--';
        foreach ($_data as $__data) {
            $_arr[$__data['user_id']] = $__data['staff_name'];
        }
        return $_arr;
    }
}
if (!function_exists('get_hr_list')) {
    function get_hr_list() {
        $ci =& get_instance();
        $ci->db->select('*,CONCAT_WS(" ",users.first_name,users.middle_name,users.last_name) AS staff_name', false);
        $ci->db->from('users');
        $ci->db->where('users.user_roll_id', 4);
        $ci->db->order_by('first_name', 'ASC');
        $query = $ci->db->get();
        $_data = $query->result_array();
        $_arr = array();
        $_arr[0] = '--Please Select--';
        foreach ($_data as $__data) {
            $_arr[$__data['user_id']] = $__data['staff_name'];
        }
        return $_arr;
    }
}

if (!function_exists('get_user_roll')) {
    /**
     *
     * get_section: it's used to get list of teacher
     *
     * @param
     * @return array
     *
     */
    function get_user_roll() {
        $ci =& get_instance();
        $ci->db->select('user_roll.*');
        $ci->db->from('user_roll');
        $ci->db->where_not_in('user_roll.user_roll_id', array('1'));
        $query = $ci->db->get();
        $user_roll_data = $query->result_array();
        $user_roll_arr = array();
        $user_roll_arr[0] = '--Please Select--';
        foreach ($user_roll_data as $user_roll_datas) {
            $user_roll_arr[$user_roll_datas['user_roll_id']] = $user_roll_datas['user_roll_name'];
        }
        return $user_roll_arr;
    }
}

if (!function_exists('check_access')) {
    /**
     *
     * check_access: it's used to get list of teacher
     *
     * @param
     * @return array
     *
     */
    function check_access() {
        $arrController = array();
        $ci =& get_instance();
        $usr_role = $ci->session->userdata('role_id');
        $login_type = $ci->session->userdata('login_type');
        $cotroller = $ci->router->fetch_class();
        $action = $ci->router->fetch_method();

        if($login_type == 'tutor'){
            $tutor_array = array('trainer_portal', 'attendance', 'academic_management', 'post_course_evaluation');
            if(in_array($cotroller, $tutor_array)){
                return true;
            }

        }
        if($login_type == 'student'){
            $stu_array = array('student_portal','client_logout');
            if(in_array($cotroller, $stu_array)){
                return true;
            }

        }
        if($login_type == 'corporate'){
            $co_array = array('corporate_portal','client_logout');
            if(in_array($cotroller, $co_array)){
                return true;
            }

        }
        if ($action != "no_access" && $usr_role != '1' && $cotroller != "login" && $cotroller != "logout" &&
                $cotroller != "profile" && $cotroller != "reset_password" && $cotroller != "forgot_password" &&
                $action != "update_password"
                && $action != "upload_profile_pic" && $action != "reset"
                && $action != "delete" &&
                $cotroller != "general" && $cotroller != "assessment" && $cotroller != "live_chat" && $action != "evaluation_form" && $action != 'form_submit'
        ) 
		{

			if (get_priviledge_action($cotroller, $action)) {
                return true;
            } else {
                if($ci->input->is_ajax_request())
                    return true;
                else
                    redirect("/home/no_access/".$cotroller.'-'.$action);
                    //redirect("/home/no_access");//return true;
            }
        }
    }
}

if (!function_exists('get_master_menu')) {
    /**
     *
     * get_course_class: it's used to get list of teacher
     *
     * @param
     * @return array
     *
     */
    function get_master_menu($is_active = 1) {
        $menu_master_arr = array();
        $ci =& get_instance();
        if ($ci->session->userdata('role_id') == 1 && $is_active == 0) {
            return $menu_master_arr;
        }
        $ci->db->select('*');
        $ci->db->from('menu_master');
        $ci->db->where('parent_id', '0');
        if ($is_active != '-1') {
            $ci->db->where('menu_master.is_active', "$is_active");
        }
        $query = $ci->db->get();
        $menu_parent = $query->result_array();

        foreach ($menu_parent as $menu_parentes) {
            $menu_master_arr[$menu_parentes['menu_id']] = $menu_parentes['name'];
        }
        return $menu_master_arr;
    }
}
if (!function_exists('get_master_all_menu')) {
    /**
     *
     * get_course_class: it's used to get list of teacher
     *
     * @param
     * @return array
     *
     */
    function get_master_all_menu() {
        $ci =& get_instance();
        $ci->db->select('*');
        $ci->db->where('parent_id', '0');
        $ci->db->from('menu_master');
        $query = $ci->db->get();
        $menu_parent = $query->result_array();
        $menu_master_arr = array();
        $menu_master_arr[0] = '--Please Select--';
        foreach ($menu_parent as $menu_parentes) {
            $ci->db->select('*');
            $ci->db->where('parent_id', $menu_parentes['menu_id']);
            $ci->db->from('menu_master');
            $subquery = $ci->db->get();
            $menu_sub = $subquery->result_array();

            $menu_master_arr[$menu_parentes['menu_id']] = $menu_parentes['name'];

            foreach ($menu_sub as $menu_subs) {
                $menu_master_arr[$menu_subs['menu_id']] = '---' . $menu_subs['name'];
            }
        }
        return $menu_master_arr;
    }
}
if (!function_exists('get_previlege_action')) {
    /**
     *
     * get_course_class: it's used to get list of teacher
     *
     * @param
     * @return array
     *
     */
	function get_menu_permissions(){
		$arrChildMenu = array();
		$ci =& get_instance();
		
		$query = " 	SELECT  
						menu_action.menu_id,
						menu_action.menu_action_id,
						menu_action.permission_name
					FROM menu_action
					ORDER BY menu_action.display_order
				";
		
		$query_res = $ci->db->query($query);
		$arrResMenu = $query_res->result_array();
		
		foreach($arrResMenu AS $row) {
			if($row["permission_name"] != "")
				$arrChildMenu[$row["menu_id"]][$row["menu_action_id"]] = $row["permission_name"];
		}
		
		return $arrChildMenu;
	}
 
    function get_previlege_action() {
        $arrResData = array();
		$arrMenuActionData = array();
		$arrParentMenu = array();
		$arrParentFirstChildMenu = array();
		$arrParentSecondChildMenu = array();
		$arrMenuID = array();
		$ci =& get_instance();
		
		$usr_role = $ci->session->userdata('role_id');
		$user_id = $ci->session->userdata('user_id');
		
		$query = " SELECT  menu_action.*,M1.parent_id,M2.parent_id AS master_parent_id ";

		$query .= " FROM menu_action
					LEFT JOIN menu_master AS M1 ON (M1.menu_id = menu_action.menu_id)
                    LEFT JOIN menu_master AS M2 ON (M2.menu_id = M1.parent_id)       ";

		$query .= " WHERE menu_action.is_active = '1' ";

		$query .= " ORDER BY menu_action.display_order";
		
		$query_res = $ci->db->query($query);
		$arrResMenu = $query_res->result_array();
		
		foreach($arrResMenu AS $row) {
			$arrMenuActionData[$row["menu_id"]][$row["menu_action_id"]] = $row;
			$arrMenuID[$row["menu_id"]] = $row["menu_id"];
			
			if($row["parent_id"] > 0)
                 $arrMenuID[$row["parent_id"]] = $row["parent_id"];
            if($row["master_parent_id"] > 0)
                 $arrMenuID[$row["master_parent_id"]] = $row["master_parent_id"];

		}
		
		$arrResData["permission_name"] = get_menu_permissions();
		
		$strMenuIDs = "";
		
		if(is_array($arrMenuID) && count($arrMenuID) > 0){
			$strMenuIDs = implode(",",$arrMenuID);
			
			$arrParentMenu = get_parent_menu($strMenuIDs);
		}
		
		$strParentMenuIDs = "";
		
		if(isset($arrParentMenu["parentMenuID"]) && is_array($arrParentMenu["parentMenuID"]) && count($arrParentMenu["parentMenuID"]) > 0){
			$arrResData["parent_menu"] = $arrParentMenu["parentMenuData"];
			
			$strParentMenuIDs = implode(",",$arrParentMenu["parentMenuID"]);
			
			$arrParentFirstChildMenu = get_child_menu($strParentMenuIDs,$strMenuIDs);
		}
		
		$strParentMenuIDs = "";
		
		if(isset($arrParentFirstChildMenu["childMenuID"]) && is_array($arrParentFirstChildMenu["childMenuID"]) && count($arrParentFirstChildMenu["childMenuID"]) > 0){
			$arrResData["first_child_menu"] = $arrParentFirstChildMenu["childMenuData"];
			
			$strParentMenuIDs = implode(",",$arrParentFirstChildMenu["childMenuID"]);
			
			$arrParentSecondChildMenu = get_child_menu($strParentMenuIDs,$strMenuIDs);
		}
		
		if(isset($arrParentSecondChildMenu["childMenuData"])){
			$arrResData["second_child_menu"] = $arrParentSecondChildMenu["childMenuData"];
		}
		
		
		return $arrResData;
    }
}

function tracking_add_data($data = array(), $table) {
    $ci =& get_instance();
    $ci->db->insert($table, $data);
    $lastinsertid = $ci->db->insert_id();
    if ($ci->db->affected_rows() == 1) {
        return $lastinsertid;
    }
    return false;
}


function delete($table,$where){
    $ci =& get_instance();
    $ci -> db -> where($where)
              -> delete($table);
}


function tracking_edit_data($data = array(), $table, $wher_column_name, $id) {
    $ci =& get_instance();
    $ci->db->where($wher_column_name, $id);
    $ci->db->update($table, $data);
}

function get_rolewise_priviledge() {
    $arrResData = array();
    $arrMenuActionData = array();
    $arrParentMenu = array();
    $arrParentFirstChildMenu = array();
    $arrParentSecondChildMenu = array();
    $arrMenuID = array();
    $ci =& get_instance();
    
	$usr_role = $ci->session->userdata('role_id');
    $user_id = $ci->session->userdata('user_id');
    
	$query = " SELECT  menu_action.*,M1.parent_id,M2.parent_id AS master_parent_id ";

    if($usr_role == '1') 
	{
        $query .= " FROM menu_action
					LEFT JOIN menu_master AS M1 ON (M1.menu_id = menu_action.menu_id)
					LEFT JOIN menu_master AS M2 ON (M2.menu_id = M1.parent_id) 					
					";
    }
	else 
	{
		$query .= " FROM menu_action
					LEFT JOIN menu_master AS M1 ON (M1.menu_id = menu_action.menu_id) 
					LEFT JOIN menu_master AS M2 ON (M2.menu_id = M1.parent_id) 
					LEFT JOIN user_privilege ON (user_privilege.menu_action_id = menu_action.menu_action_id) ";
    }

    $query .= " WHERE menu_action.is_display = '1' AND menu_action.is_active = '1' ";

    if ($usr_role != '1') {
        $query .= " AND user_privilege.user_roll_id = '$usr_role' ";
    }

    $query .= " ORDER BY menu_action.display_order";
	
	$query_res = $ci->db->query($query);
    $arrResMenu = $query_res->result_array();
    
	foreach($arrResMenu AS $row) {
		$arrMenuActionData[$row["menu_id"]][$row["menu_action_id"]] = $row;
        $arrMenuID[$row["menu_id"]] = $row["menu_id"];
		
		if($row["parent_id"] > 0)
			$arrMenuID[$row["parent_id"]] = $row["parent_id"];
		if($row["master_parent_id"] > 0)
			$arrMenuID[$row["master_parent_id"]] = $row["master_parent_id"];
    }
	
	$strMenuIDs = "";
	
	if(is_array($arrMenuID) && count($arrMenuID) > 0){
		$strMenuIDs = implode(",",$arrMenuID);
		
		$arrParentMenu = get_parent_menu($strMenuIDs);
	}
	
	$strParentMenuIDs = "";
	
	$arrResData["controller"] = array();
	
	if(isset($arrParentMenu["parentMenuID"]) && is_array($arrParentMenu["parentMenuID"]) && count($arrParentMenu["parentMenuID"]) > 0){
		$arrResData["parent_menu"] = $arrParentMenu["parentMenuData"];
		
		if(isset($arrParentMenu["controller"]))
			$arrResData["controller"] = array_merge($arrResData["controller"],$arrParentMenu["controller"]);
	
		$strParentMenuIDs = implode(",",$arrParentMenu["parentMenuID"]);
		
		$arrParentFirstChildMenu = get_child_menu($strParentMenuIDs,$strMenuIDs);
	}
	
	$strParentMenuIDs = "";
	
	if(isset($arrParentFirstChildMenu["childMenuID"]) && is_array($arrParentFirstChildMenu["childMenuID"]) && count($arrParentFirstChildMenu["childMenuID"]) > 0){
		$arrResData["first_child_menu"] = $arrParentFirstChildMenu["childMenuData"];
		
		if(isset($arrParentFirstChildMenu["controller"]))
			$arrResData["controller"] = array_merge($arrResData["controller"],$arrParentFirstChildMenu["controller"]);
	
		$strParentMenuIDs = implode(",",$arrParentFirstChildMenu["childMenuID"]);
		
		$arrParentSecondChildMenu = get_child_menu($strParentMenuIDs,$strMenuIDs);
	}
	
	if(isset($arrParentSecondChildMenu["childMenuData"])){
		$arrResData["second_child_menu"] = $arrParentSecondChildMenu["childMenuData"];
		
		if(isset($arrParentSecondChildMenu["controller"]))
			$arrResData["controller"] = array_merge($arrResData["controller"],$arrParentSecondChildMenu["controller"]);
	}
	
	return $arrResData;
}

function get_parent_menu($strMenuIDs = ""){
	$arrParentMenu = array();
	$ci =& get_instance();
	
	if($strMenuIDs != "")
	{
		$query = " 	SELECT  
						menu_master.*,  
						menu_action.menu_action_id,
						menu_action.controller,
						menu_action.permission_name,
						menu_action.is_display,
						menu_action.default_action,
						menu_action.other_action
					FROM menu_master 
					LEFT JOIN menu_action ON (menu_master.menu_id = menu_action.menu_id)
					WHERE 
						menu_master.menu_id IN($strMenuIDs) 
						AND menu_master.parent_id = 0
						AND menu_master.is_active = '1' 
					ORDER BY menu_master.display_order
				";
		$query_res = $ci->db->query($query);
		$arrResMenu = $query_res->result_array();
		
		foreach($arrResMenu AS $row) {
			
			$arrParentMenu["parentMenuData"][$row["menu_id"]] = $row;
			
			if(!isset($arrParentMenu["parentMenuData"][$row["menu_id"]]["isset"]) && $row["is_display"] == 0){
				$arrParentMenu["parentMenuData"][$row["menu_id"]]["isset"] = 0;
				$arrParentMenu["parentMenuData"][$row["menu_id"]]["default_action"] = "";
			}
			else if($row["is_display"] == 1){
				$arrParentMenu["parentMenuData"][$row["menu_id"]]["isset"] = 1;
				$arrParentMenu["parentMenuData"][$row["menu_id"]]["default_action"] = $row["default_action"];
			}
			
			$arrParentMenu["parentMenuID"][$row["menu_id"]] = $row["menu_id"];
			
			if($row["permission_name"] != "")
				$arrParentMenu["permission_name"][$row["menu_id"]][] = $row["permission_name"];
			
			if($row["controller"] != "")
				$arrParentMenu["controller"][$row["controller"]][$row["menu_id"]] = $row["menu_id"];
		}
	}
	
	return $arrParentMenu;
}

function get_child_menu($strParentMenuIDs = "",$strMenuIDs = ""){
	$arrChildMenu = array();
	$ci =& get_instance();
	
	if($strMenuIDs != "")
	{
		$query = " 	SELECT  
						M1.*,  
						menu_action.menu_action_id,
						menu_action.controller,
						menu_action.permission_name,
						menu_action.default_action,
						menu_action.other_action,
						(SELECT parent_id FROM menu_master AS M2 WHERE M2.menu_id = M1.parent_id) AS master_parent_id
					FROM menu_master AS M1
					LEFT JOIN menu_action ON (M1.menu_id = menu_action.menu_id AND menu_action.is_display = '1')
					WHERE 
						M1.parent_id IN($strParentMenuIDs) 
						AND M1.menu_id IN($strMenuIDs) 
						AND M1.is_active = '1'  
					ORDER BY M1.display_order
				";
		
		$query_res = $ci->db->query($query);
		$arrResMenu = $query_res->result_array();
		
		foreach($arrResMenu AS $row) {
			$arrChildMenu["childMenuData"][$row["parent_id"]][$row["menu_id"]] = $row;
			$arrChildMenu["childMenuID"][$row["menu_id"]] = $row["menu_id"];
			
			if($row["permission_name"] != "")
				$arrChildMenu["permission_name"][$row["menu_id"]][] = $row["permission_name"];
			
			if($row["controller"] != ""){
				$arrChildMenu["controller"][$row["controller"]][$row["menu_id"]] = $row["menu_id"];
				
				if($row["parent_id"] > 0)
					$arrChildMenu["controller"][$row["controller"]][$row["parent_id"]] = $row["parent_id"];
				
				if($row["master_parent_id"] > 0)
					$arrChildMenu["controller"][$row["controller"]][$row["master_parent_id"]] = $row["master_parent_id"];
			}
		}
	}
	
	return $arrChildMenu;
}

function get_priviledge_action($controller_name, $action = "",$retActions=0) {

    if ($controller_name == "") {
        return array();
    }

    $arrMenu = array();
    $ci =& get_instance();
    $usr_role = $ci->session->userdata('role_id');
    $user_id = $ci->session->userdata('user_id');
    
	$query = " SELECT  menu_action.*,M1.parent_id,M2.parent_id AS master_parent_id ";

    $query = "
		SELECT
			menu_action.controller AS controller,
			menu_action.menu_action_id,
			menu_action.permission_name,
			menu_action.default_action,
			menu_action.other_action
		FROM user_privilege
		LEFT JOIN menu_action ON (user_privilege.menu_action_id = menu_action.menu_action_id)
		WHERE user_privilege.user_roll_id = '$usr_role'
	";

    $query .= " AND (menu_action.controller  = '$controller_name') ";
    
    $query_res = $ci->db->query($query);
    $arrResMenu = $query_res->result_array();

    foreach ($arrResMenu AS $row) {
		$arrMenu[] = $row["default_action"];
        
        if($row["other_action"] != "") {
           $tempArr = explode(",",$row["other_action"]);
		   
		   if(is_array($tempArr) && count($tempArr) > 0)
		   {
				foreach($tempArr AS $controllerMethodName){
					$controllerMethodName = trim($controllerMethodName);
					
					$arrMenu[] = $controllerMethodName;				
				}
		   }
		}
    }

	if($retActions == 1){
		return $arrMenu;
	}
    if ($action != "" && count($arrMenu) > 0) {
		if($action == "index"){
			return count($arrMenu);
		}
		if(!in_array($action,$arrMenu)) {

            return false;
        }
		
        return true;
    }
	
    if($action == "" && count($arrMenu) == 0) {
        if(!in_array("index",$arrMenu)) {

            return false;
        }
		
        return true;
		
    } 
	else {
        return count($arrMenu);
    }
}

function get_priviledge_action_user($controller_name, $action) {

    if ($controller_name == "") {
        return array();
    }

    $ci =& get_instance();

    $query = "
    SELECT
    users.user_id,CONCAT_WS(' ',users.first_name,users.middle_name,users.middle_name2,users.last_name) AS staff_name
    FROM users
    LEFT JOIN user_privilege ON (users.user_roll_id = user_privilege.user_roll_id)
    LEFT JOIN menu_action ON (user_privilege.menu_action_id = menu_action.menu_action_id)
    ";

    $query .= " WHERE users.status IN (12,13)";
    $query .= " AND users.user_roll_id NOT IN (1,4)";
    $query .= " AND menu_action.controller = '" . $controller_name . "' AND menu_action.action = '" . $action . "'";
    //$query .= " ORDER BY users.first_name ASC";

    $query .= " UNION ";

    $query .= "
    SELECT
    users.user_id,CONCAT_WS(' ',users.first_name,users.middle_name,users.middle_name2,users.last_name) AS staff_name
    FROM users
    ";

    $query .= " WHERE users.status IN (12,13)";
    $query .= " AND users.user_roll_id NOT IN (1,4)";
    $query .= " AND menu_action.controller = '" . $controller_name . "' AND menu_action.action = '" . $action . "'";
    //$query .= " ORDER BY users.first_name ASC";

    $query = $ci->db->query($query);
    //echo $ci->db->last_query();

    $student_data = $query->result_array();
    $student_arr = array();
    $student_arr[0] = '--Please Select--';
    foreach ($student_data as $_student_data) {
        $student_arr[$_student_data['user_id']] = $_student_data['staff_name'];
    }
    asort($student_arr);
    return $student_arr;
}

if (!function_exists('get_other_user_roll')) {
    /**
     *
     * get_other_user_roll: it's used to get list of teacher
     *
     * @param
     * @return array
     *
     */
    function get_other_user_roll($default_option = 1, $for_staff = false) {
        $ci =& get_instance();
        $ci->db->select('user_roll.*');
        $ci->db->from('user_roll');
        if ($for_staff == 1) {
            $ci->db->where_not_in('user_roll.user_roll_id', array('1','2'));
        } else {
            $ci->db->where_not_in('user_roll.user_roll_id', array('2'));
        }
        
        $query = $ci->db->get();
        // echo $ci->db->last_query();
        // exit;
        $user_roll_data = $query->result_array();
        $user_roll_arr = array();
        if ($default_option == 1) {
            $user_roll_arr[''] = 'Select a Role';
        }
        foreach ($user_roll_data as $user_roll_datas) {
            $user_roll_arr[$user_roll_datas['user_roll_id']] = $user_roll_datas['user_roll_name'];
        }
        return $user_roll_arr;
    }
}
if (!function_exists('hash_password')) {
    /**
     *
     * hash_password: obscure password with specially designed salt - site_key combo in sha512
     *
     * @param string $password the password to be validated
     * @param string $nonce the nonce that is unique to this member
     * @return string
     *
     */
    function hash_password($password, $nonce) {
        return hash_hmac('sha512', $password . $nonce, SITE_KEY);
    }
}

function get_user_roll_templets($id,$box_id='') {
    $ci =& get_instance();
    $ci->db->select('user_roll_template.*');
    $ci->db->from('user_roll_template');
    $ci->db->where('user_roll_template.role_id',$id);
    if($box_id > 0)
    {
       $ci->db->where('user_roll_template.box_id',$box_id); 
    }
    $ci->db->where('user_roll_template.type','box');    
    $query = $ci->db->get();
    if($query->num_rows() > 0)
    {
        $row = $query->row();
        return $row;
    }
    return false;
}


function getTableField($table, $select_col, $where_col, $where_col_val) {
    $ci =& get_instance();

    $ci->db->select('' . $select_col . '', false);
    $ci->db->from($table);

    if (isset($where_col) && $where_col_val != "") {
        $ci->db->where($where_col, $where_col_val);
    }

    $query = $ci->db->get();
    if ($query->num_rows() > 0) {
        $row = $query->row();
        return $row->$select_col;
    }
    return "";
}

function encrypt_decrypt($action, $string) {
    $output = false;

    $encrypt_method = "AES-256-CBC";
    $secret_key = '9S2R492UI4';
    $secret_iv = '4D9H8';

    // hash
    $key = hash('sha256', $secret_key);

    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    if ($action == 'e') {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    } else if ($action == 'd') {
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }

    return $output;
}

function autoVersioning($path) {
	$ci =& get_instance();
    if ($path <> '') {
		
		if(file_exists(CURR_DIR.$path)) {
            return MASTER_URL.$path . '?v=' . filemtime(CURR_DIR.$path);
        } else {
            echo ' File not found : ' . $path;
            exit();
        }
    }
    return $path;
}

function gender_list($id = null, $for_filter = 0) {
    $_arr = array('' => '--Please Select--',
            'M' => 'Male',
            'F' => 'Female'
    );

    if ($for_filter == 1) {
        $ci =& get_instance();

        $ci->db->select('DISTINCT gender AS filter_id', false);
        $ci->db->from('users');

        $query = $ci->db->get();
        $data = $query->result_array();
        $_arrRes = array();
        foreach ($data as $_data) {
            if ($_data['filter_id'] != "") {
                $_arrRes[$_data['filter_id']] = (isset($_arr[$_data['filter_id']])) ? $_arr[$_data['filter_id']] : '';
            }
        }

        return $_arrRes;
    }

    if ($id <> null) {
        return (isset($_arr[$id])) ? $_arr[$id] : '';
    }
    return $_arr;
}

function convert_number_to_day($no)
{
    switch ($no) {
        case '1':
             $day = 'MON';
            break;
        case '2':
             $day = 'TUE';
            break;
        case '3':
             $day = 'WED';
            break;
        case '4':
             $day = 'THU';
            break;
        case '5':
             $day = 'FRI';
            break;
        case '6':
             $day = 'SAT';
            break;
        case '7':
             $day = 'SUN';
            break;
    }

    return $day;
}


function get_data_from_table_list_like($table,$like,$condition,$order,$data_table="",$data_table_column=""){
    $ci =& get_instance();
    $ci -> db -> select("$table.*")
                -> from($table);
	
	if($data_table != "" && $data_table != ""){
		$ci->db->join($data_table, "$table.$condition = $data_table.$data_table_column", "inner");
		$ci -> db -> group_by($condition);
	}
	
    if(!empty($like)){
        $ci -> db -> like($like);
    }    
    $ci -> db -> order_by($condition,$order);
    return $ci -> db -> get() -> result_array();
}

function get_data_from_table($table,$where,$order ='',$condition = '',$field = '',$limit = ''){
    $ci =& get_instance();
    if(empty($field))
    {
        $field = '*';
    }
    $ci -> db -> select($field)
        -> from($table)
        -> where($where);
    if($limit){
        $ci->db->limit($limit);
    }
    if(!empty($order)){
        $ci -> db -> order_by($order,$condition);
    }    
    return $ci -> db -> get() -> row_array();
}
function get_data_from_table_list($table,$where,$condition,$order){
    $ci =& get_instance();
    $ci -> db -> select('*')
                -> from($table);
    if(!empty($where)){
        $ci -> db -> where($where);
    }	
    $ci -> db -> order_by($condition,$order);
    return $ci -> db -> get() -> result_array();            
}
function get_table_data($table,$condition,$order){
    $ci =& get_instance();
    $ci -> db -> select('*')
                -> from($table);
    $ci -> db -> order_by($condition,$order);
    return $ci -> db -> get() -> result_array();            
}

function get_count_from_table_list($table,$where){
    $ci =& get_instance();
    $ci -> db -> select('*')
                -> from($table);
    if(!empty($where)){
        $ci -> db -> where($where);
    }	
	
	return $ci -> db -> get() -> num_rows();            
}

function get_data_from_table_list_like_where($table,$where,$like,$condition,$order){
    $ci =& get_instance();
    $ci -> db -> select('*')
                -> from($table);
    if(!empty($where)){
        $ci -> db -> where($where);
    }            
    if(!empty($like)){
        $ci -> db -> like($like);
    }   
    $ci -> db -> order_by($condition,$order);
    return $ci -> db -> get() -> result_array();
}


function get_data_from_table_list_like_where_not($table,$where,$like,$condition,$order){
    $ci =& get_instance();
    $ci -> db -> select('*')
                -> from($table);
    if(!empty($where)){
        $ci -> db -> where_not_in($where);
    }            
    if(!empty($like)){
        $ci -> db -> like($like);
    }   
    $ci -> db -> order_by($condition,$order);
    return $ci -> db -> get() -> result_array();
}


function get_data_from_table_list_like_where_join($table,$where,$like,$condition,$order,$join_table,$join_table_condition){
    $ci =& get_instance();
    $ci -> db -> select('*')
                -> from($table);
    if(!empty($where)){
        $ci -> db -> where($where);
    }            
    if(!empty($like)){
        $ci -> db -> like($like);
    }   
	
	if($join_table != "" && $join_table != ""){
		$ci->db->join($join_table, "$join_table_condition", "left");
		//$ci -> db -> group_by($condition);
	}
	
    $ci -> db -> order_by($condition,$order);
    return $ci -> db -> get() -> result_array();
}

function update($table,$where,$data){
    $ci =& get_instance();
    $ci -> db -> where($where);
    $ci -> db -> update($table, $data);
    if(!empty($where['id'])) : 
        $id = $where['id'];
        return $id;
    endif;
}



function save_or_update_system_log($id,$table_name,$old_record_data,$new_record_data,$perform_action,$transaction,$desc){
    $ci =& get_instance();
    date_default_timezone_set("Asia/Singapore");
    $created_by = 0;
    $create_by_name = '';
    $session_user = $ci -> session -> userdata('user_id');
    if(empty($session_user)){
        $session_user =  $ci -> session -> userdata('tutor_id');
    }
    $created_by = $session_user;
    if($ci->session->userdata('login_type') == 'student')
    {
         $user = get_data_from_table('student',array('id' => $created_by));
         $create_by_name = $user['username'];
    }elseif($ci->session->userdata('login_type') == 'corporate'){
        $user = get_data_from_table('corporate',array('id' => $created_by));
        $create_by_name = $user['company_name'];
    }elseif($ci->session->userdata('login_type') == 'agent')
    {
         $user = get_data_from_table('agency',array('id' => $created_by));
         $create_by_name = $user['email'];
    }
    elseif($ci->session->userdata('login_type') == 'tutor')
    {       
        $created_by= $ci->session->userdata('portal_id'); 
        $user = get_data_from_table('users',array('user_id' => $created_by));
        $create_by_name = $user['first_name'];
    }
    else
    {
         $user = get_data_from_table('users',array('user_id' => $created_by));
         $create_by_name = $user['username'];
    }
   
    $data = array('id' => $id,
                    'table_name' => $table_name,
                    'old_record_data' => $old_record_data,
                    'new_record_data' => $new_record_data,
                    'perform_action' => $perform_action,
                    'transaction' => $transaction,
                    'description' => $desc,
                    'created_date' => date('Y-m-d H:i:s'),
                    'created_by_name' => $create_by_name,
                    'created_by' => $created_by);

    grid_add_data($data,'system_log');

}




//==================================== images resize 
function image_resize($path, $width, $height, $pathToCopy=""){
	$ci =& get_instance();
	$config['image_library'] = 'gd2';
	$config['source_image'] = $path;
	//$config['create_thumb'] = TRUE;
	
	if(!empty($pathToCopy)) $config['new_image'] = $pathToCopy;
	
	$config['maintain_ratio'] = TRUE;
	$config['width'] = $width;
	$config['height'] = $height;
	
	$ci->image_lib->initialize($config); 
	$ci->image_lib->resize();
} 


function get_age($dateOfBirth)
{
    $today = date("Y-m-d");
    $diff = date_diff(date_create($dateOfBirth), date_create($today));
    if($diff->format('%y')  == 0)
    {
        $age =  $diff->format('%m months old');
    }
    elseif($diff->format('%m')  == 0 && $diff->format('%y')  >= 1 )
    {
        $age =  $diff->format('%y years old');
    }
    else
    {
        $age =  $diff->format('%y years %m months old');
    }
    return $age;
}

function convert_day_to_number($day)
{
    $day = strtoupper($day);
    switch ($day) {
        case 'MON':
             $no = '1';
            break;
        case 'TUE':
             $no = '2';
            break;
        case 'WED':
             $no = '3';
            break;
        case 'THU':
             $no = '4';
            break;
        case 'FRI':
             $no = '5';
            break;
        case 'SAT':
             $no = '6';
            break;
        case 'SUN':
             $no = '7';
            break;
    }

    return $no;
}

function convert_number_to_fullday($no)
{
    switch ($no) {
        case '1':
             $day = 'Monday';
            break;
        case '2':
             $day = 'Tuesday';
            break;
        case '3':
             $day = 'Wednesday';
            break;
        case '4':
             $day = 'Thursday';
            break;
        case '5':
             $day = 'Friday';
            break;
        case '6':
             $day = 'Saturday';
            break;
        case '7':
             $day = 'Sunday';
            break;
    }
    return $day;
}


function conver_different_to_number($start_time,$end_time)
{
    $diff_hr = (strtotime($end_time) - strtotime($start_time))/3600;
    $working_hours =  sprintf('%02d:%02d', (int) $diff_hr, fmod($diff_hr, 1) * 60);
    $array = explode(':',$working_hours);
    $hours = $array[0];
    $minutes = end($array);
    $working_hours = $hours + round($minutes / 60, 2);
    return $working_hours;
}


function print_array($array)
{   
        echo "<pre>";
            print_r($array);
        echo "</pre>";
}

function get_nationality_list($for_filter = 0) {
    $ci =& get_instance();
    $ci->db->select('countries.*');
    $ci->db->from('countries');

    $ci->db->order_by("nationality", "asc");

    $query = $ci->db->get();
    $nationality_data = $query->result_array();
    $nationality_arr = array();
    $nationality_arr[''] = '--Please Select--';
    foreach ($nationality_data as $nationality_datas) {
        $nationality_arr[$nationality_datas['id']] = $nationality_datas['nationality'];
    }

    if ($for_filter == 1) {
        $ci =& get_instance();

        $ci->db->select('DISTINCT nationality AS filter_id', false);
        $ci->db->from('user_profile');

        $query = $ci->db->get();
        $data = $query->result_array();
        $_arrRes = array();
        $_arrRes[''] = 'Select Nationality';
        foreach ($data as $_data) {
            if ($_data['filter_id'] != "" && $_data['filter_id'] > 0) {
                $_arrRes[$_data['filter_id']] =
                        (isset($nationality_arr[$_data['filter_id']])) ? $nationality_arr[$_data['filter_id']] : '';
            }
        }

        return $_arrRes;
    }

    return $nationality_arr;
}

    
function make_user_system_date($date = '') {
    $ci =& get_instance();
    $user_id = $ci->session->userdata('user_id');
    
    $user_system_date_format = getTableField($table="users", $select_col="user_system_date_format", $where_col="user_id", $where_col_val=$user_id);
    
    if ($date == '' || $date == '0000-00-00' || $date == '0000-00-00 00:00:00') {
        return '';
    }
    if($user_system_date_format != ""){
        return date($user_system_date_format,strtotime($date));
    }
    else{
        return date("Y-m-d H:i:s",strtotime($date));
    }
}
    
function make_dp_date_time($date = '') {
    if ($date == '' || $date == '0000-00-00' || $date == '0000-00-00 00:00:00') {
        return '';
    }
    return date('D, d M Y H:i:s', strtotime($date));
}

function make_dp_date($date = '') {
    if ($date == '' || $date == '0000-00-00' || $date == '0000-00-00 00:00:00') {
        return '';
    }
    return date('D, d M Y', strtotime($date));
}

function make_dp_date_withouth_day($date = '') {
    if ($date == '' || $date == '0000-00-00' || $date == '0000-00-00 00:00:00') {
        return '';
    }
    return date('d M Y', strtotime($date));
}

function make_dp_date_withouth_day_date($date = '') {
    if ($date == '' || $date == '0000-00-00' || $date == '0000-00-00 00:00:00') {
        return '';
    }
    return date('M, Y', strtotime($date));
}

function make_db_date($date = '') {
    if ($date == '') {
        return '';
    }
    return date('Y-m-d', strtotime($date));
}

function save_table_log_by_id($table_name_log,$table_name,$where_column_name,$where_column_value,$changed_data,$action=""){
    $ci =& get_instance();
    
    $sql_check_tabel = "SHOW TABLES LIKE '$table_name_log'";
    $query_check_tabel = $ci->db->query($sql_check_tabel);
    $arrRes = $query_check_tabel->result_array();
    if (count($arrRes) == 0) {
        return false;
    }
    $arrColumns = array();
    
    $sql_columns = "SHOW COLUMNS FROM $table_name";
    $query_columns = $ci->db->query($sql_columns);
    $arrRes = $query_columns->result_array();
    
    foreach($arrRes AS $row) {
        if($row["Field"] != "" && $row["Field"] != "migration_pk_id" && $row["Field"] != "migration_id")
            $arrColumns[] = $row["Field"];
    }
    
    $strColumns = implode(",",$arrColumns);
    
    $whereCheckChanges = "";
    
    if(is_array($changed_data) && count($changed_data) > 0)
    {
        foreach($changed_data AS $columnName=>$columnValue)
        {
            $whereCheckChanges .= " $columnName != '$columnValue' OR ";
        }		
    }
    
    $whereCheckChanges = trim(trim($whereCheckChanges),"OR");
    
    if($whereCheckChanges != "")
        $whereCheckChanges = "AND ($whereCheckChanges)";
    
    $query = "INSERT INTO $table_name_log ($strColumns) 
                SELECT $strColumns FROM $table_name WHERE $where_column_name = $where_column_value $whereCheckChanges ";
    
    $ci->db->query($query);
    if($action !== "")
    {
         $last_id = $ci->db->insert_id();
         $query2 = "UPDATE `$table_name_log` SET `log_action`= '$action' WHERE log_id = $last_id ";
        $ci->db->query($query2);

    }

}
    

function make_user_system_date_only($date = '') {
  $ci =& get_instance();
    $user_id = $ci->session->userdata('user_id');
  
  $user_system_date_format = getTableField($table="users", $select_col="user_system_date_format", $where_col="user_id", $where_col_val=$user_id);
  
  if ($date == '' || $date == '0000-00-00' || $date == '0000-00-00 00:00:00') {
      return '';
  }
  if($user_system_date_format != ""){
    if ($user_system_date_format == "d-m-Y H:i:s") {
      $user_system_date_format = "d-m-Y";
    }else if ($user_system_date_format == "Y-m-d H:i:s") {
      $user_system_date_format = "Y-m-d";
    }else if ($user_system_date_format == "D, d M Y H:i:s") {
      $user_system_date_format = "D, d M Y";
    }
    return date($user_system_date_format,strtotime($date));
  }
  else{
    return date("Y-m-d",strtotime($date));
  }
}

/////////////////////////////////////////////////////////////////////////////////////
function send_mail_funciton($message,$from_email,$from_emiil_user,$to_email,$subject,$arrAttachment=null)
{

    $ci =& get_instance();
    $ci -> load -> library('email');
    $config['useragent'] = "CodeIgniter";
    $config['mailpath'] = "/usr/bin/sendmail"; // or "/usr/sbin/sendmail"
    $config['protocol'] = "smtp";
    $config['smtp_host'] = "localhost";
    $config['smtp_port'] = "25";
    $config['mailtype'] = 'html';
    $config['charset']  = 'utf-8';
    $config['newline']  = "\r\n";
    $config['wordwrap'] = TRUE;
    $config['mailtype'] = 'html';
    $ci->email->initialize($config);
    if(empty($from_email))
    {
        $system_config = get_data_from_table('system_config',array('id'=>1));
	    $from_email = $system_config['sender_email'];
    }
    
    $htmls = '<html>';
    $htmls.='<body>';
    $htmls.= $message;
    $htmls.='</body>';
    $htmls.='</html>';
    $ci->email->reply_to($from_email,'Info');     
    $ci->email->from($from_email, $from_emiil_user);
    $ci->email->to($to_email);
    $ci->email->subject($subject);
    $ci->email->message($htmls);
	if(is_array($arrAttachment) && count($arrAttachment) > 0)
	{
		foreach($arrAttachment AS $filePath)
		{
		$ci->email->attach($filePath);
		}
	}	
    $ci->email->send();
}

function start_end_day_week($date) 
{
    $month = date('m', strtotime($date));
    $week = date('W', strtotime($date));
    $year = date('Y', strtotime($date));
    if($month == '12' AND $week == '01')
    {
        $year++;
    }
    $dto = new DateTime();
    $return['start'] = $dto->setISODate($year, $week, 1)->format('Y-m-d');
    $return['end'] = $dto->setISODate($year, $week, 7)->format('Y-m-d');

    return $return;
}
function find_date_difference($date1,$date2)
{
    $date1  =   date_create($date1);
    $date2  =   date_create($date2);
    $diff   =   date_diff($date1,$date2);
    return $difference =  $diff->format("%a");
}

function randomPassword($length=5){
       $string = "";
       $chars = "0123456789";
       $size = strlen($chars);
       for ($i = 0; $i < $length; $i++) {
           $string .= $chars[rand(0, $size - 1)];
       }
       return $string; 
    }   

function month ()
    {
       $month  = '';
       $month  =  array('January','February','March','April','May','June','July','August','September','October','November','December');

        return $month ;

   }

   



	
    

function get_email_template_fields()
{
    $retArray = array(
                '{company_logo}' => 'company_logo',
                '{Name}' => 'name',
                '{course_name}' => 'course_name',
                '{language_name}' => 'language_name',
                '{schedule_date}' => 'schedule_date',
                '{schedule_start_date}' => 'schedule_start_date',
                '{schedule_end_date}' => 'schedule_end_date',
                '{current_attendance}' => 'current_attendance',
                '{attendance_percentage}' => 'attendance_percentage',
                '{language_name}' => 'language_name',
                '{venue_name}' => 'venue_name',
        		'{old_schedule_date}' => 'old_schedule_date',
        		'{venue}' => 'venue',
                '{intake_no}' => 'intake_no',
                '{schedule_date}' => 'schedule_date',
                '{schedule_am_time}' => 'schedule_am_time',
                '{schedule_pm_time}' => 'schedule_pm_time',
                '{old_course_name}' => 'old_course_name',
                '{old_language_name}' => 'old_language_name',
                '{old_venue}' => 'old_venue',
                '{old_schedule_date}' => 'old_schedule_date',
                '{old_schedule_am_time}' => 'old_schedule_am_time',
                '{old_schedule_pm_time}' => 'old_schedule_pm_time',
                '{link}' => 'link',
                '{email}' => 'email',
                '{password}' => 'password',
                '{intake_no}' => 'intake_no',
                '{organization_name}' => 'organization_name',
                '{duration}' => 'duration',
                '{schedule_detail_table}' => 'schedule_detail_table'
            );  
    return $retArray;
}


    /**
     *
     * _random_symbol: take one random symbol
     *
     *
     */

    function _random_symbol() {
        $symbol_arr = array("!", "$", ".", "[", "]", "|", "(", ")", "?", "*", "+", "{", "}", "@", "#");
        $i = rand(0, 14);
        return $symbol_arr[$i];
    }

    /**
     *
     * _random_letter: take one random letter
     *
     *
     */

    function _random_letter() {
        $letter_arr = array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");
        $i = rand(0, 25);
        return $letter_arr[$i];
    }

    /**
     *
     * _random_number: taken one random number
     *
     *
     */

    function _random_number() {
        $number_arr = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
        $i = rand(0, 9);
        return $number_arr[$i];
    }
    function get_profile_pic($user_id = 0, $profile_picture = '', $show_from_id = true) {
    $ci =& get_instance();
    $profile_pic = array('150' => MASTER_URL . "images/noimage.jpg", '75' => MASTER_URL . "images/noimage.jpg");

    if ($user_id == 0 && $show_from_id == true) {
        $user_id = $ci->session->userdata('user_id');
    }

    if ($user_id > 0) {
        $ci->db->select('profile_picture');
        $ci->db->from('users');
        $ci->db->join('user_profile', 'user_profile.user_id = users.user_id', 'left');
        $ci->db->where('users.user_id', $user_id);
        $ci->db->limit(1);
        $query = $ci->db->get();
        if ($query->num_rows() == 1) {
            $row = $query->row();
            $profile_picture = $row->profile_picture;
        }
    }

    $filepath = CURR_DIR . 'uploads/profile_picture/thumb7575/' . $profile_picture;

    if (file_exists($filepath) && $profile_picture != '') {
        $profile_picture_150 =  "uploads/profile_picture/thumb150150/" . $profile_picture;
        $profile_picture_75 =  "uploads/profile_picture/thumb7575/" . $profile_picture;
        $profile_pic[150] = $profile_picture_150;
        $profile_pic[75] = $profile_picture_75;
    }

    return $profile_pic;
    }

    
    if (!function_exists('get_other_user_roll')) {
        /**
         *
         * get_other_user_roll: it's used to get list of teacher
         *
         * @param
         * @return array
         *
         */
    function get_other_user_roll($default_option = 1, $for_staff = false) {
        $ci =& get_instance();
        $ci->db->select('user_roll.*');
        $ci->db->from('user_roll');
        if ($for_staff == 1) {
            $ci->db->where_not_in('user_roll.user_roll_id', array('1','2'));
        } else {
            $ci->db->where_not_in('user_roll.user_roll_id', array('2'));
        }
        
        $query = $ci->db->get();
        // echo $ci->db->last_query();
        // exit;
        $user_roll_data = $query->result_array();
        $user_roll_arr = array();
        if ($default_option == 1) {
            $user_roll_arr[''] = 'Select a Role';
        }
        foreach ($user_roll_data as $user_roll_datas) {
            $user_roll_arr[$user_roll_datas['user_roll_id']] = $user_roll_datas['user_roll_name'];
        }
        return $user_roll_arr;
    }
}


function get_user_name($id,$fullname = FALSE)
{
    $user = get_data_from_table('users',['user_id' => $id]);
    if(!empty($user))
    {
        return ($fullname) ? $user['first_name'].' '.$user['middle_name'].' '.$user['last_name']: $user['first_name'];
    }
    return '';
}

/**
 * To Genearte Date Array for schedule creating
 */
function get_recurring_date_array($strDateFrom,$strDateTo,$searchDays,$DateExistArray = array())
{
    $aryRange = array();
    $iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2),     substr($strDateFrom,8,2),substr($strDateFrom,0,4));
    $iDateTo=mktime(1,0,0,substr($strDateTo,5,2),     substr($strDateTo,8,2),substr($strDateTo,0,4));

    if(!empty($DateExistArray))
    {
        if(((in_array(date('Y-m-d',$iDateFrom), $DateExistArray)) == 0))
        {
            array_push($aryRange,date('Y-m-d',$iDateFrom));
        }
       
    }
    else
    {
        array_push($aryRange,date('Y-m-d',$iDateFrom));
    }
    

    while (date('Y-m-d',$iDateFrom)<$strDateTo)
    {
        $iDateFrom+=86400; // add 24 hours

        if(!empty($DateExistArray))
        {
            if (in_array(date('N',$iDateFrom), $searchDays) && ((in_array(date('Y-m-d',$iDateFrom), $DateExistArray)) == 0))
            {
                array_push($aryRange,date('Y-m-d',$iDateFrom));
            }
        }
        else
        {
            if (in_array(date('N',$iDateFrom), $searchDays))
            {
                array_push($aryRange,date('Y-m-d',$iDateFrom));
            } 
        }

        
        
    }

    

    return $aryRange;
}

## For debugging.
function pd($a)
{
    echo '<pre>';print_r($a);echo'</pre>';die;
}
function p($a)
{
    echo '<pre>';print_r($a);echo'</pre>';
}

 
/* End of file general_function_helper.php */
/* Location: ./application/helpers/general_function_helper.php */ 