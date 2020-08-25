<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class List_user extends Private_Controller {

    public function __construct()
    {
        parent::__construct();
        // pre-load
        $this->load->helper('form');
        $this->load->library('form_validation');
		$this->load->model('list_user_model');
		$this->load->helper('general_function');
		$this->load->model('add_privilege/privilege_model');
    }

    public function index() {
        $content_data = array();

        // set layout data
        $this->template->set_theme(Settings_model::$db_config['default_theme']);
        $this->template->set_layout('school');
        
        $this->template->title('List User');
        $this->template->set_partial('header', 'header');
        $this->template->set_partial('sidebar', 'sidebar');
        $this->template->set_partial('footer', 'footer');
        $this->template->build('list_user', $content_data);
    }
    
    public function index_json($order_by = "username", $sort_order = "asc", $search = "all", $offset = 0) {
    	/* Array of database columns which should be read and sent back to DataTables. Use a space where
    	 * you want to insert a non-database field (for example a counter or static image)
    	*/


    	$aColumns = array('users.user_id',
                        'users.user_id',
                        'username',
						'staff_name',
						'email',
						'email_2',
						'birth_date',
						'contact_number_1',
						'contact_number_2',
						'user_roll_name',
                        'c_users',
						'users.created_date',
                        'u_users',
                        'users.updated_date');
    	$grid_data = get_search_data($aColumns);
    	$sort_order = $grid_data['sort_order'];
		$order_by = $grid_data['order_by'];
    	/*
    	 * Paging
    	*/
    	$per_page =  $grid_data['per_page'];
    	$offset =  $grid_data['offset'];
    
    	$data = $this->list_user_model->get_users($per_page, $offset, $order_by, $sort_order, $grid_data['search_data']);
    	$count = $this->list_user_model->get_users(0, 0, "", "", $grid_data['search_data']);
		/*
    	 * Output
    	*/
    	$output = array(
    			"sEcho" => intval($_GET['sEcho']),
    			"iTotalRecords" => $count,
    			"iTotalDisplayRecords" => $count,
    			"aaData" => array()
    	);
    
    	if($data){
    		foreach($data->result_array() AS $result_row){
                
                $action = $action_list = '';
                if($this->session->userdata('role_id') == '1' || in_array("edit",$this->arrAction)) {
                    $action_list .= '<li><a href="list_user/add/'.$result_row['user_id'].'/1" data-target="#modal-default" data-toggle="modal" class="modal-link"><i class="fa fa-gear"></i> Edit</a></li>';
                } 
                if($this->session->userdata('role_id') == '1' || in_array("profile",$this->arrAction)) {
                    $action_list .= '<li><a href="'.base_url().'/profile/view_profile/'.encrypt_decrypt('e', $result_row["user_id"]).'/" class=""><i class="fa fa-gear"></i> View Profile</a></li>';
					
					//$action_list .= '<li><a href="#" onclick=dt_login("'.encrypt_decrypt('e',$result_row['user_id']).'"); class=""><i class="fa fa-gear"></i> Login</a></li>';
                }
                if($this->session->userdata('role_id') == '1' || in_array("delete",$this->arrAction)) {
                    $delete_table['table'] = array('users');
                    $delete_table['wher_column_name'] = array('user_id');
                    $delete_table['where_id'] = array($result_row['user_id']);

                     $action_list .= "<li class='divider'></li><li class='bg-master-lighter'><a href='#' onclick=dt2_delete('".json_encode($delete_table)."','grid_corporate'); class='text-danger bold'><i class='fa fa-times-circle'></i> Delete</a></li>";
                }
                if ($action_list <> '') {
                    $action .= '<div class="dropdown">';
                    $action .= '<button aria-expanded="false" aria-haspopup="true" class="btn btn-info" data-toggle="dropdown" type="button"><i class="fa fa-sort-amount-desc"></i></button>';
                    $action .= '<ul role="menu" class="dropdown-menu profile-dropdown">';
                    $action .= $action_list;
                    $action .= '</ul>';
                    $action .= '</div>';
                }
    			$row = array();
                $row[] = $result_row['user_id'];
                $row[] = $action;
				$row[] = $result_row['username'];
				$row[] = $result_row['staff_name'];
				$row[] = $result_row['email'];
				$row[] = $result_row['email_2'];
				$row[] = make_dp_date($result_row['birth_date']);
				$row[] = $result_row['contact_number_1'];
				$row[] = $result_row['contact_number_2'];
				$row[] = $result_row['user_roll_name'];
                $row[] = $result_row['c_users'];
                $row[] = make_user_system_date($result_row['created_date']);
				$row[] = $result_row['u_users'];
                $row[] = make_user_system_date($result_row['updated_date']);
    			$output['aaData'][] = $row;
    		}
    	}
    
    	echo json_encode( $output );
    }

    public function check_register_email_ajax(){
        $email = $_GET['email'];
        $id = isset($_GET['id']) ? $_GET['id'] : 0;
        $data = array('email' => $email);
        $this ->db-> select('*');
        $this ->db-> from('users');
        $this ->db-> where($data);
        if ($id > 0) {
            $this -> db -> where('id != ',$id);
        }
        $result =  $this -> db -> get() -> result_array();
        // echo $this->db->last_query();
        // exit();
        if(!empty($result)){
            echo "false";
        }else{
            echo "true";
        }
    }

    public function check_register_username_ajax(){
        $username = $_GET['username'];
        $id = isset($_GET['id']) ? $_GET['id'] : 0;
        $data = array('username' => $username);
        $this ->db-> select('*');
        $this ->db-> from('users');
        $this ->db-> where($data);
        if ($id > 0) {
            $this -> db -> where('id != ',$id);
        }
        $result =  $this -> db -> get() -> result_array();
        // echo $this->db->last_query();
        // exit();
        if(!empty($result)){
            echo "false";
        }else{
            echo "true";
        }
    }


    public function export_to_excel()
    {
        ini_set('memory_limit','1024M');
        /* Array of database columns which should be read and sent back to DataTables. Use a space where
         * you want to insert a non-database field (for example a counter or static image)
        */
        $where = array();
        $where1 = array();
        $search_data = $this->session->userdata('export_var');
        $aColumns = array('users.user_id',
                        'staff_name',
                        'email',
                        'email_2',
                        'birth_date',
                        'contact_number_1',
                        'contact_number_2',
                        'user_roll_name',
                        'users.created_date',
                        'users.updated_date');

        $grid_data = get_search_data($aColumns);
        $sort_order = $grid_data['sort_order'];
        $order_by = $grid_data['order_by'];

        /*
         * Paging
        */
        $per_page =  $grid_data['per_page'];
        $offset =  $grid_data['offset'];
        $data = $this->list_user_model->get_users($per_page, $offset, $order_by, $sort_order, $grid_data['search_data']);
                $result = array();
        $no = 1;
        
        if($data){
            foreach($data->result_array() as $key => $value){    
                $gender = '';
                if($value['gender'] == 'M')
                {
                    $gender = 'Male';
                }else{
                    $gender = 'Female';
                }
                
                $result[$key]['#'] = $no;
                $result[$key]['Staff Name'] = addslashes(trim($value['staff_name']));
                $result[$key]['Email'] = addslashes(trim($value['email']));
                $result[$key]['Email 2'] = addslashes(trim($value['email_2']));
                $result[$key]['Birth Date'] = addslashes(trim($value['birth_date']));
                $result[$key]['Contact Number 1'] = addslashes(trim($value['contact_number_1']));
                $result[$key]['Contact Number 2'] =  addslashes(trim($value['contact_number_2']));
                $result[$key]['User Roll '] = addslashes(trim($value['user_roll_name']));
                $result[$key]['Created Date'] = make_user_system_date($value['created_date']);
                $result[$key]['Updated Date'] = make_user_system_date($value['updated_date']);
                $no ++;
            }
        }
         $filename = "User List";
        $this->export->to_excel($result,$filename);
    }
    
    public function add($id = null){
       
        $content_data['other_user_roll'] = get_other_user_roll();
    	$content_data['gender_list'] = gender_list();
    	$content_data['id'] = $id;
    	$rowdata = array();
    	if($id){
    		$rowdata = $this->list_user_model->get_user_profile($id);
    	}
    	 
    	$content_data['rowdata'] = $rowdata;
    	if($this->input->post()){
    		$nonce = md5(uniqid(mt_rand(), true));
            $first_name = $this->input->post('first_name');
            $middle_name = $this->input->post('middle_name');
            $last_name = $this->input->post('last_name');
            $gender = $this->input->post('gender');            
            $birth_date = $this->input->post('birth_date');   		
    		$email = $this->input->post('email');
    		$email_2 = $this->input->post('email_2');    		
    		$user_system_date_format = $this->input->post('user_system_date_format');    		
    		$contact_number_1 = $this->input->post('contact_number_1');
    		$contact_number_2 = $this->input->post('contact_number_2');
            $user_roll_id = $this->input->post('user_roll_id');
            $username = $this->input->post('username');
    		$password = $this->input->post('password');
            $data = array();
            $data['first_name'] = $first_name;
            $data['middle_name'] = $middle_name;
            $data['last_name'] = $last_name;
            $data['gender'] = $gender;
			if($birth_date != "")
				$data['birth_date'] = make_db_date($birth_date);
            $data['email'] = $email;
            $data['email_2'] = $email_2;
            $data['user_system_date_format'] = $user_system_date_format;
            $data['contact_number_1'] = $contact_number_1;
            $data['contact_number_2'] = $contact_number_2;
            $data['user_roll_id'] = $user_roll_id;              
            
            
            $data['updated_date'] = date('Y-m-d H:i:s');
            $data['updated_by'] = $this->session->userdata('user_id');
    		$error = "";
    		$error_seperator = "<br>";
            $table = 'users';
            $wher_column_name = 'user_id';
    		if($id){
    			 
    			$this->form_validation->set_rules('first_name', 'first name', 'trim|required|max_length[40]|min_length[2]');
                        $this->form_validation->set_rules('last_name', 'last name', 'trim|required|max_length[40]|min_length[2]');
		        $this->form_validation->set_rules('email', 'email', 'trim|required|max_length[255]|is_valid_email|is_existing_field[users.email^users.user_id !=^'.$id.']');
				
		       	if (!$this->form_validation->run()) {
    				if (form_error('first_name')) {
    					$error .= form_error('first_name').$error_seperator;
    				}elseif (form_error('email')) {
    					$error .= form_error('email').$error_seperator;
    				}elseif (form_error('last_name')){
                        $error .= form_error('last_name').$error_seperator;
                    }
    				echo $error;
    				exit();
    			}    			
				
                $old_roll_id = $this->list_user_model->get_user_roll($id);
				if($old_roll_id != $user_roll_id && $user_roll_id > 0) {
					$roll_privilege = array();
					$this->list_user_model->create_single_user_privilege($id, $roll_privilege);
				}
                $changed_data = array();
                $changed_data['first_name'] = $first_name;
                $changed_data['middle_name'] = $middle_name;
                $changed_data['last_name'] = $last_name;
                $changed_data['gender'] = $gender;
                if($birth_date != "")
                    $changed_data['birth_date'] = make_db_date($birth_date);
                $changed_data['email'] = $email;
                $changed_data['email_2'] = $email_2;
                $changed_data['user_system_date_format'] = $user_system_date_format;
                $changed_data['contact_number_1'] = $contact_number_1;
                $changed_data['contact_number_2'] = $contact_number_2;
                $changed_data['user_roll_id'] = $user_roll_id;
                $action = "Edit"; 
                        
                save_table_log_by_id("users_log","users","user_id",$id,$changed_data,$action);
    			grid_data_updates($data,$table,$wher_column_name,$id);
                echo "update";
    		}else{
    			$this->form_validation->set_rules('first_name', 'first name', 'trim|required|max_length[40]|min_length[2]');
                        $this->form_validation->set_rules('last_name', 'first name', 'trim|required|max_length[40]|min_length[2]');
		        $this->form_validation->set_rules('email', 'e-mail', 'trim|required|max_length[255]|is_valid_email|is_existing_unique_field[users.email]');
				$this->form_validation->set_rules('username', 'username', 'trim|required|max_length[50]|min_length[6]|is_existing_unique_field[users.username]');
		        $this->form_validation->set_rules('password', 'password', 'trim|required|max_length[64]|matches[password_confirm]');
		        $this->form_validation->set_rules('password_confirm', 'repeat password', 'trim|required|max_length[64]');

		       	if (!$this->form_validation->run()) {
    				if (form_error('first_mame')) {
    					$error .= form_error('first_mame').$error_seperator;
                    } elseif (form_error('last_mame')) {
                        $error .= form_error('last_mame').$error_seperator;
    				}elseif (form_error('email')) {
    					$error .= form_error('email').$error_seperator;
    				}elseif (form_error('username')) {
    					$error .= form_error('username').$error_seperator;
    				}elseif (form_error('password')) {
    					$error .= form_error('password').$error_seperator;
    				}elseif (form_error('password_confirm')) {
    					$error .= form_error('password_confirm').$error_seperator;
    				}
    				echo $error;
    				exit();
    			}
                $data['username'] = $username;
                $data['password'] = hash_password($password, $nonce);
                $data['nonce'] = $nonce;
                $data['status'] = '1';
                $data['created_date'] = date('Y-m-d H:i:s');
                $data['created_by'] = $this->session->userdata('user_id');
                
    			$user_id = grid_add_data($data,$table);
                $table = 'user_profile';
                $wher_column_name = 'user_id';
                $profile_data['user_id'] = $user_id;
                grid_add_data($profile_data,$table);
                echo "insert";
    		}
    		exit;
    	}

    	$this->template->build('add_user_datatable', $content_data);
    }
	
    public function save_user_pass(){
        $pass = $this->input->post('user_password');
        $user_id = $this->input->post('user_id');
        
        if($user_id > 0 && $pass != "")
        {
            $this->list_user_model->set_password($pass,$user_id);
            
            echo "Password Updated Successfully";
        }
        else        
        {
            echo "Password Not Updated Successfully";
        }
    }
	
	public function upload_profile_pic(){
    	
    	if($_FILES['uploadpic']['error'] == 0){
    		$curr_dir = str_replace("\\","/",getcwd()).'/';
    		//upload and update the file
    		$config['upload_path'] = $curr_dir.'uploads/profile_picture/original/';
    		$config['allowed_types'] = 'gif|jpg|png';
    		$config['overwrite'] = false;
    		$config['remove_spaces'] = true;
            $config['encrypt_name'] = TRUE;
    		//$config['max_size']	= '100';// in KB
    	
    		//load upload library
    		$this->load->library('upload', $config);
    		$this->load->library('image_lib');
    		if ( ! $this->upload->do_upload('uploadpic')){
    			$this->session->set_flashdata('message', $this->upload->display_errors('<p class="error">', '</p>'));
    		}
    		else
    		{
    			$data1 = array('upload_data' => $this->upload->data());
    			$image= $data1['upload_data']['file_name'];
    			
    			$configBig = array();
				
				$configBig['image_library'] = 'gd2';
				$configBig['source_image']    = $curr_dir.'uploads/profile_picture/original/'.$image;;
				$configBig['new_image'] = $curr_dir.'uploads/profile_picture/thumb7575/'.$image;;
				$configBig['maintain_ratio'] = TRUE;
				$configBig['width']     = 75;
				$configBig['height']    = 75;

				$this->image_lib->initialize($configBig); 

				if ( ! $this->image_lib->resize())
				{
					echo $this->image_lib->display_errors();
				}
				$this->image_lib->clear();
				unset($configBig);
				
				$configBig = array();
				
				$configBig['image_library'] = 'gd2';
				$configBig['source_image']    = $curr_dir.'uploads/profile_picture/original/'.$image;;
				$configBig['new_image'] = $curr_dir.'uploads/profile_picture/thumb150150/'.$image;;
				$configBig['maintain_ratio'] = TRUE;
				$configBig['width']     = 150;
				$configBig['height']    = 150;

				$this->image_lib->initialize($configBig); 

				if ( ! $this->image_lib->resize())
				{
					echo $this->image_lib->display_errors();
				}
				$this->image_lib->clear();
				unset($configBig);
				
				//$user_id = $this->session->userdata('user_id');
				$user_id = $this->input->post('user_id');
				$data = array('profile_picture' => $image);

                $config['upload_path'] = $curr_dir.'uploads/'.$user_id.'/';
                $config['allowed_types'] = 'jpg|jpeg|pdf|png|doc|docx';
                $config['overwrite'] = true;
                $config['remove_spaces'] = true;
                $config['max_size'] = '9048';// in KB
                //load upload library
                $this->load->library('upload', $config);
                
            
    			
    		}
    	}
    	 
    }
}

/* End of file list_user.php */