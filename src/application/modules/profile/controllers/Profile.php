<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends Private_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('profile_model');
		$this->load->model('list_user/list_user_model');
    }

    public function index($user_id = 0) {
        $user_id = encrypt_decrypt('d', $user_id);
        $content_data = array();
		
		$content_data["user_system_date_format"] = getTableField($table="users", $select_col="user_system_date_format", $where_col="user_id", $where_col_val=$user_id);

        $user_data = $this->profile_model->get_profile($user_id);
		
        if(!$user_data)
            redirect('list_user');

        if(!$this->list_user_model->check_user_profile_exist($user_id))
        {

            $first_insert_profile_data = array('user_id' => $user_id);
            $profile_id = grid_add_data($first_insert_profile_data,'user_profile');
        }

        $profile_picture = get_profile_pic($user_id);
        $profile_picture_150 = $profile_picture[150];
        $profile_picture_75 = $profile_picture[75];


        
        // set content data
        $content_data['user_id'] = $user_id;
        $content_data['user_data'] = $user_data;
        
        $content_data['profile_picture_150'] = $profile_picture_150;
        $content_data['profile_picture_75'] = $profile_picture_75;
        $content_data['gender_list'] = gender_list();
        $content_data['nationality_list'] = get_nationality_list();

		
	
		$user_experience = array();
		$user_experience_count = 0;


      
		
        $this->template->set_theme(Settings_model::$db_config['default_theme']);
        $this->template->set_layout('school');
        $this->template->title('Profile');
        $this->template->set_partial('header', 'header');
        $this->template->set_partial('sidebar', 'sidebar');
        $this->template->set_partial('footer', 'footer');

            $this->template->build('profile', $content_data);
        
        
    }

    public function update_account($view_profile=0) {
        $user_id = $this->input->post('user_id');
        // $arrCandidatesAction = get_priviledge_action("candidates","",false);
        $table = 'users';
        $wher_column_name = 'user_id';
        $user_roll_id = getTableField($table, 'user_roll_id', $wher_column_name,$user_id);

        // form input validation
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('first_name', 'first name', 'trim|required|max_length[40]|min_length[2]');
        $this->form_validation->set_rules('last_name', 'last name', 'trim|required|max_length[40]|min_length[2]');
        $this->form_validation->set_rules('email', 'email', 'trim|max_length[255]|is_valid_email|is_existing_field[users.email^users.user_id !=^'.$user_id.']');
        //$this->form_validation->set_rules('password', 'password', 'trim|required|is_member_password');
        
        if (!$this->form_validation->run())
        {
            if (form_error('first_name')) {
                $this->session->set_flashdata('errormessage', form_error('first_name'));
            }elseif (form_error('last_name')) {
                $this->session->set_flashdata('errormessage', form_error('last_name'));
            }elseif (form_error('email')) {
                $this->session->set_flashdata('errormessage', form_error('email'));
            }elseif (form_error('password')) {
                $this->session->set_flashdata('errormessage', form_error('password'));
            }
			// redirect to profile on fail with error
            if($view_profile == 1)
            {
                redirect('profile/view_profile/'.encrypt_decrypt('e', $user_id));
                exit();    
            }
            else
            {
               redirect('profile/'.encrypt_decrypt('e', $user_id));
                exit();     
            }
        }
        
        $data['first_name'] = $this->input->post('first_name');
        $data['middle_name'] = $this->input->post('middle_name');
        $data['last_name'] = $this->input->post('last_name');
        $data['gender'] = $this->input->post('gender');
        $data['birth_date'] = make_db_date($this->input->post('birth_date'));
        //$data['username'] = $this->input->post('email');
        $data['email'] = $this->input->post('email');
        $data['email_2'] = $this->input->post('email_2');        
        $data['contact_number_1'] = $this->input->post('contact_number_1');
        $data['contact_number_2'] = $this->input->post('contact_number_2');
        $data['marital_status'] = $this->input->post('marital_status');
        $data['language_known'] = "";
		
        $data['updated_date'] = date('Y-m-d H:i:s');
        grid_data_updates($data,$table,$wher_column_name,$user_id);
        
        $profile_data['skype_id'] = $this->input->post('skype_id');
        $profile_data['nationality'] = $this->input->post('nationality');  
        $profile_data['notes'] = $this->input->post('notes');    
        
        if($this->session->userdata('role_id') == '1' || in_array('edit', $arrCandidatesAction) || $user_id == $this->session->userdata('user_id')) {
            $table = 'user_profile';
            $wher_column_name = 'user_id';
            grid_data_updates($profile_data,$table,$wher_column_name,$user_id);
        }   

        $this->session->set_flashdata('message', $this->lang->line('account_updated'));

        if($view_profile == 1)
        {
            redirect('profile/view_profile/'.encrypt_decrypt('e', $user_id));
            exit();    
        }
            else
            {

    			// grid_delete('user_qualification','user_id',$user_id);
    			
			
           redirect('profile/'.encrypt_decrypt('e', $user_id));
            exit();     
        }
    }
	
	public function update_settings() {
		$user_id = $this->input->post('user_id');
		$data['user_system_date_format'] = $this->input->post('user_system_date_format');
        
        $data['updated_by'] = $this->session->userdata('user_id');
        $data['updated_date'] = date('Y-m-d H:i:s');
		
		grid_data_updates($data,$table="users",$wher_column_name="user_id",$user_id);
	}

    public function teacher_update_account($view_profile=0) {

        $user_id = $this->input->post('user_id');
        // $arrCandidatesAction = get_priviledge_action("candidates","",false);
        $table = 'teacher';
        $wher_column_name = 'id';
        //$user_roll_id = getTableField($table, 'user_roll_id', $wher_column_name,$user_id);
        $error = "";
        $error_seperator = "<br>";
        // form input validation
        if($this->input->post()){
            // $this->form_validation->set_rules('type', 'Teacher Type', 'required');
                $this->form_validation->set_rules('first_name', 'First Name', 'required');
                $this->form_validation->set_rules('last_name', 'Last Name', 'required');
                $this->form_validation->set_rules('email', 'Email', 'required|is_valid_email'); 
                $this->form_validation->set_rules('center_email', 'Center Email', 'required|is_valid_email');
                $this->form_validation->set_rules('contact', 'Contact Number', 'required');
                $this->form_validation->set_rules('dob', 'Date Of Birth', 'required');
              
                

        //$this->form_validation->set_rules('password', 'password', 'trim|required|is_member_password');
        
                 if (!$this->form_validation->run()) {
                    // if (form_error('type')) {
                    //     $error .= form_error('type').$error_seperator;
                    // }else
                    if (form_error('first_name')){
                        $error .= form_error('first_name').$error_seperator;
                    }elseif (form_error('last_name')) {
                        $error .= form_error('last_name').$error_seperator;
                    }elseif (form_error('email')) {
                        $error .= form_error('email').$error_seperator;
                    }elseif (form_error('center_email')) {
                        $error .= form_error('center_email').$error_seperator;
                    }elseif (form_error('contact')) {
                        $error .= form_error('contact').$error_seperator;
                    }elseif (form_error('dob')) {
                        $error .= form_error('dob').$error_seperator;
                    }
            // redirect to profile on fail with error
          // redirect('profile/teacher_profile/'.encrypt_decrypt('e', $user_id));
           
         
        }
        
      $data = array();
          
            $gender = $this->input->post('gender');
            $dob =  $this->input->post('dob');
           // $data['center_id'] = $this->input->post('center_id');
            $data['teacher_id'] = $this->input->post('teacher_id');
            // $data['type'] = $this->input->post('type');
            $data['first_name'] = $this->input->post('first_name');
            $data['mid_name'] = $this->input->post('mid_name');            
            $data['last_name'] = $this->input->post('last_name');           
            $data['display_name'] = $this->input->post('display_name');
            $data['gender'] = $gender;
            if($dob != "")
                $data['dob'] = make_db_date($dob);
            
            $data['email'] = $this->input->post('email');
            $data['center_email'] = $this->input->post('center_email');
            $data['contact'] = $this->input->post('contact');
            $data['color_code'] = $this->input->post('color_code');
            // $data['status'] = $this->input->post('status');
            $data['country_of_origin'] = $this->input->post('country_of_origin');
            $data['nationality'] =  $this->input->post('nationality');
            $data['highest_qualification'] = $this->input->post('highest_qualification');
            $data['qualification_area'] = $this->input->post('qualification_area');
           // $data['nonce'] = $nonce;
            if($this->input->post('working_days'))
            {
                  $array = $this->input->post('working_days');
                  $data['working_days'] = implode(',',$array);
            }
            else
            {
                 $data['working_days'] = 0;
            }
           
            $data['address_blk'] = $this->input->post('address_blk');
            $data['address_building'] = $this->input->post('address_building');
            $data['address_unit_no'] = $this->input->post('address_unit_no');
            $data['address_street'] = $this->input->post('address_street');
            $data['address_country'] = $this->input->post('address_country');
            $data['address_postal_code'] = $this->input->post('address_postal_code');
            $data['city_id'] = $this->input->post('city_id');
            $data['home_blk'] = $this->input->post('home_blk');
            $data['home_building'] = $this->input->post('home_building');
            $data['home_unit_no'] = $this->input->post('home_unit_no');
            $data['home_street'] = $this->input->post('home_street');
            $data['home_country'] = $this->input->post('home_country');
            $data['home_postal_code'] = $this->input->post('home_postal_code');
            $data['h_city_id'] = $this->input->post('h_city_id');
            $data['passbook'] = $this->input->post('passbook');
            $data['IDPNo'] = $this->input->post('IDPNo');
        
        $data['updated_date'] = date('Y-m-d H:i:s');
        grid_data_updates($data,$table,$wher_column_name,$user_id);
        $data_teacher_center_table = 'teacher_centers_details';
                $wher_column_name = 'id'; 
                $data_teacher_center = array();
                $data_teacher_center['center_id'] = $this->input->post('center_id');
                $data_teacher_center['teacher_id'] = $user_id;
                $data_teacher_center['created_datetime'] = date('Y-m-d H:i:s');
                $changed_data_teacher_center = array();
                $changed_data_teacher_center['center_id'] = $this->input->post('center_id');
                $changed_data_teacher_center['teacher_id'] = $user_id;
                $changed_data_teacher_center['created_datetime'] = date('Y-m-d H:i:s');
                $action = "Edit";
              //save_table_log_by_id("teacher_centers_details_log","teacher_centers_details","id",$user_id,$changed_data_teacher_center,$action);
            //  $center_table_id = grid_data_updates($data_teacher_center,$data_teacher_center_table,$wher_column_name,$user_id);

        echo 'update';
    }

        // redirect('profile/teacher_profile/'.encrypt_decrypt('e', $user_id));
    }


    public function student_update_account($view_profile=0) {
        

        // pd($this->input->post());
        $user_id = $this->input->post('user_id');
        // $arrCandidatesAction = get_priviledge_action("candidates","",false);
        $table = 'student';
        $wher_column_name = 'id';
        //$user_roll_id = getTableField($table, 'user_roll_id', $wher_column_name,$user_id);
        // form input validation
        $this->form_validation->set_rules('center_id', 'Center Id', 'required');
        $this->form_validation->set_rules('school', 'School', 'required');
        $this->form_validation->set_rules('student_name', 'Student Name', 'required');
        $this->form_validation->set_rules('nationality', 'Nationality', 'required');
        $this->form_validation->set_rules('address_line1', 'Address_line 1', 'required'); 
        $this->form_validation->set_rules('country_id', 'Country', 'required'); 
      //  $this->form_validation->set_rules('address_line2', 'Address_line 2', 'required');
        $this->form_validation->set_rules('postal_code', 'Postal Code', 'required');
        // $this->form_validation->set_rules('contact', 'Contact Number', 'required');
        $this->form_validation->set_rules('dob', 'Date Of Birth', 'required');
              
        //$this->form_validation->set_rules('password', 'password', 'trim|required|is_member_password');
        
        $error_seperator = PHP_EOL;
        /* $error1 = '';
         */
        $error = '';
        if (!$this->form_validation->run()) {
            if (form_error('center_id')) {
                $error .= form_error('center_id').$error_seperator;
            }elseif (form_error('school')) {
                $error .= form_error('school').$error_seperator;
            }elseif (form_error('student_name')){
                $error .= form_error('student_name').$error_seperator;
            }elseif (form_error('nationality')) {
                $error .= form_error('nationality').$error_seperator;
            }elseif (form_error('address_line1')) {
                $error .= form_error('address_line1').$error_seperator;
            }elseif (form_error('country_id')) {
                $error .= form_error('country_id').$error_seperator;
            }elseif (form_error('postal_code')) {
                $error .= form_error('postal_code').$error_seperator;
            }elseif (form_error('dob')) {
                $error .= form_error('dob').$error_seperator;
            }

            $this->session->set_flashdata('errormessage',trim($error));
            
            redirect('profile/student_profile/'.encrypt_decrypt('e', $user_id));
            exit();
            
        }

        if(empty($this->input->post('country_id')))
        {
            $error .= 'Country field is required';
            $this->session->set_flashdata('errormessage',trim($error));
            redirect('profile/student_profile/'.encrypt_decrypt('e', $user_id));
            exit();
        }
            $data = array();
          
            $gender = $this->input->post('gender');
            $dob =  $this->input->post('dob');
            $data['center_id'] = $this->input->post('center_id');
           // $data['student_id'] = $this->input->post('student_id');
            $data['school'] = $this->input->post('school');
            $data['student_name'] = $this->input->post('student_name');
            $data['gender'] = $gender;
            if($dob != "")
                $data['dob'] = make_db_date($dob);
            
            $data['nationality'] = $this->input->post('nationality');
            $data['address_line1'] = $this->input->post('address_line1');
            $data['country_id'] = $this->input->post('country_id');
            $data['address_line2'] = $this->input->post('address_line2');
            $data['postal_code'] = $this->input->post('postal_code');
           // $data['contact'] = $this->input->post('contact');
            $data['updated_date'] = date('Y-m-d H:i:s');
            
            grid_data_updates($data,$table,$wher_column_name,$user_id);
        // echo $this->db->last_query();
        // die;
        $this->session->set_flashdata('message', $this->lang->line('account_updated'));

        redirect('profile/student_profile/'.encrypt_decrypt('e', $user_id));
    }



    public function check_teacher_id_ajax(){

        $teacher_id = $_GET['teacher_id'];

        $id = isset($_GET['t_id']) ? $_GET['t_id'] : 0;
        $data = array('teacher_id' => $teacher_id);
        if($id)
         {
             $result = $this->teacher_model->get_id_by_teacher_id_and_id($teacher_id, $id);
         }else
         {
            $result = $this->teacher_model->get_teacher_id($teacher_id, $id);
         }

        if(!empty($result))
        {
            echo "false";
        }else
        {
            echo "true";
        }
    }


     public function check_register_email_ajax(){
        $email = $_GET['email'];
        $id = isset($_GET['id']) ? $_GET['id'] : 0;
        $data = array('email' => $email);
        //$result = $this -> admin_model -> get_table_list_by_value('staff_agent',$data);
        $this -> db -> select('*');
        $this -> db -> from('teacher');
        $this -> db -> where($data);
        if ($id > 0) {
            $this -> db -> where('id != ',$id);
        }
        $result =  $this -> db -> get() -> result_array();
        if(!empty($result)){
            echo "false";
        }else{
            echo "true";
        }
    }


    public function parent_update_account($view_profile=0) {

        $user_id = $this->input->post('user_id');
        // $arrCandidatesAction = get_priviledge_action("candidates","",false);
        $table = 'parents';
        $wher_column_name = 'id';
       // $user_roll_id = getTableField($table, 'user_roll_id', $wher_column_name,$user_id);

        // form input validation
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('parents_name', 'Parents Name', 'required');
        $this->form_validation->set_rules('mobile_no', 'Mobile No', 'required');
        $this->form_validation->set_rules('relationship', 'Relationship', 'required');
        $this->form_validation->set_rules('email', 'email', 'trim|max_length[255]|is_valid_email');
        //$this->form_validation->set_rules('password', 'password', 'trim|required|is_member_password');
        
        if (!$this->form_validation->run())
        {
            if (form_error('parents_name')) {
                $this->session->set_flashdata('errormessage', form_error('parents_name'));
            }elseif (form_error('mobile_no')) {
                $this->session->set_flashdata('errormessage', form_error('mobile_no'));
            }elseif (form_error('relationship')) {
                $this->session->set_flashdata('errormessage', form_error('relationship'));
            }elseif (form_error('email')) {
                $this->session->set_flashdata('errormessage', form_error('email'));
            }
   
               redirect('profile/parent_profile'.encrypt_decrypt('e', $user_id));
                 
            
        }
               
           
        

        $data['parents_name'] = $this->input->post('parents_name');
        $data['email'] = $this->input->post('email');
        $data['relationship'] = $this->input->post('relationship');        
        $data['mobile_no'] = $this->input->post('mobile_no');
        $data['address_blk'] =  $this->input->post('address_blk');
        $data['address_building'] =  $this->input->post('address_building');
        $data['address_unit_no'] =  $this->input->post('address_unit_no');
        $data['address_street'] =  $this->input->post('address_street');
        $data['address_country'] =  $this->input->post('address_country');
        $data['address_postal_code'] =  $this->input->post('address_postal_code');
        $data['city_id'] =  $this->input->post('city_id');
        $data['office_no'] =  $this->input->post('office_no');
        $data['occupation'] =  $this->input->post('occupation');
        $data['company'] =  $this->input->post('company');
        $data['designation'] =  $this->input->post('designation');
        
        $data['updated_date'] = date('Y-m-d H:i:s');
        grid_data_updates($data,$table,$wher_column_name,$user_id);
        $this->session->set_flashdata('message', $this->lang->line('account_updated'));
       redirect('profile/parent_profile/'.encrypt_decrypt('e', $user_id));
              
     
    }


    public function update_password($view_profile=0) {
        $user_id = $this->input->post('user_id');
        $this->form_validation->set_error_delimiters('', '');
        if($this->session->userdata('role_id') == '2')
            $this->form_validation->set_rules('current_password', 'current password', 'trim|required|max_length[64]|is_member_password['.$user_id.']');
        $this->form_validation->set_rules('new_password', 'new password', 'trim|required|max_length[64]|min_length[6]|matches[new_password_again]');
        $this->form_validation->set_rules('new_password_again', 'confirm new password', 'trim|required|max_length[64]|min_length[6]');
        
        if (!$this->form_validation->run())
        {
            if ($this->session->userdata('role_id') == '2' && form_error('current_password')) {
                $this->session->set_flashdata('errormessage', form_error('current_password'));
            }elseif (form_error('new_password')) {
                $this->session->set_flashdata('errormessage', form_error('new_password'));
            }elseif (form_error('new_password_again')) {
                $this->session->set_flashdata('errormessage', form_error('new_password_again'));
            }
            if($view_profile == 1)
            {
                redirect('profile/view_profile/'.encrypt_decrypt('e', $user_id).'#tab_1_3');
                exit();    
            }
            else
            {
               redirect('profile/'.encrypt_decrypt('e', $user_id).'#tab_1_3');
                exit();     
            }
        }

        if ($this->profile_model->set_password($this->input->post('new_password'))) {
            $this->session->set_flashdata('message', $this->lang->line('profile_success'));
        }
        if($view_profile == 1)
        {
            redirect('profile/view_profile/'.encrypt_decrypt('e', $user_id).'#tab_1_3');
            exit();    
        }
        else
        {
           redirect('profile/'.encrypt_decrypt('e', $user_id).'#tab_1_3');
            exit();     
        }
    }
	
	public function rotateImage($user_id = 0,$degrees=90){
		$profile_picture = get_profile_pic_name($user_id);
		
		if($profile_picture != ""){
			$this->load->library('image_lib');
			$configBig = array();
			$configBig['image_library'] = 'gd2';
			$configBig['source_image']    = CURR_DIR.'cenopsys/profile_picture/thumb7575/'.$profile_picture;
			$configBig['new_image'] = CURR_DIR.'cenopsys/profile_picture/thumb7575/'.$profile_picture;
			$configBig['rotation_angle'] = $degrees;

			$this->image_lib->initialize($configBig);

			if ( ! $this->image_lib->rotate())
			{
					echo $this->image_lib->display_errors();
			}	
			
			$this->image_lib->clear();
			unset($configBig);
			
			$configBig = array();
			
			$configBig['image_library'] = 'gd2';
			$configBig['source_image']    = CURR_DIR.'cenopsys/profile_picture/thumb150150/'.$profile_picture;
			$configBig['new_image'] = CURR_DIR.'cenopsys/profile_picture/thumb150150/'.$profile_picture;
			$configBig['rotation_angle'] = $degrees;

			$this->image_lib->initialize($configBig);

			if ( ! $this->image_lib->rotate())
			{
					echo $this->image_lib->display_errors();
			}	
		}
		
		echo $profile_picture;exit;
	}
	
    public function upload_profile_pic($user_id = 0,$view_profile=1){
    	if($_FILES['uploadpic']['error'] == 0 && $user_id > 0){
    		
			//upload and update the file
    		$config['upload_path'] = CURR_DIR.'cenopsys/profile_picture/original/';
    		$config['allowed_types'] = 'gif|jpg|png|jpeg';
    		$config['overwrite'] = false;
    		$config['remove_spaces'] = true;
    		//$config['max_size']	= '100';// in KB
    	
    		//load upload library
    		$this->load->library('upload', $config);
    		$this->load->library('image_lib');
    		if ( ! $this->upload->do_upload('uploadpic')){
    			$this->session->set_flashdata('errormessage', $this->upload->display_errors('<p class="error">', '</p>'));
    		}
    		else
    		{
    			$data1 = array('upload_data' => $this->upload->data());
    			$image= $data1['upload_data']['file_name'];
    			
    			$configBig = array();
				
				$configBig['image_library'] = 'gd2';
				$configBig['source_image']    = CURR_DIR.'cenopsys/profile_picture/original/'.$image;;
				$configBig['new_image'] = CURR_DIR.'cenopsys/profile_picture/thumb7575/'.$image;;
				$configBig['maintain_ratio'] = false;
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
				$configBig['source_image']    = CURR_DIR.'cenopsys/profile_picture/original/'.$image;;
				$configBig['new_image'] = CURR_DIR.'cenopsys/profile_picture/thumb150150/'.$image;;
				$configBig['maintain_ratio'] = false;
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
				$data = array('profile_picture' => $image);
				$this->db->where('user_id', $user_id);
                $this->db->update('users', $data);
                
				if($this->db->affected_rows() == 1) {
                    //$this->session->set_flashdata('message', $this->lang->line('profile_pic_changed_sucess'));
					echo "1";
				}
    			
    		}
    	}
    }


    public function teacher_upload_profile_pic($teacher_id = 0,$view_profile=1){
        if($_FILES['uploadpic']['error'] == 0 && $teacher_id > 0){
            //upload and update the file
            $config['upload_path'] = CURR_DIR.'cenopsys/teacher_profile_picture/original/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['overwrite'] = false;
            $config['remove_spaces'] = true;
            //$config['max_size']   = '100';// in KB
        
            //load upload library
            $this->load->library('upload', $config);
            $this->load->library('image_lib');
            if ( ! $this->upload->do_upload('uploadpic')){
                $this->session->set_flashdata('errormessage', $this->upload->display_errors('<p class="error">', '</p>'));
            }
            else
            {
                $data1 = array('upload_data' => $this->upload->data());
                $image= $data1['upload_data']['file_name'];
                
                $configBig = array();
                
                $configBig['image_library'] = 'gd2';
                $configBig['source_image']    = CURR_DIR.'cenopsys/teacher_profile_picture/original/'.$image;;
                $configBig['new_image'] = CURR_DIR.'cenopsys/teacher_profile_picture/thumb7575/'.$image;;
                $configBig['maintain_ratio'] = false;
                $configBig['width']     = 75;
                $configBig['height']    = 75;

                $this->image_lib->initialize($configBig); 
    
                //$user_id = $this->session->userdata('user_id');
                $data = array('photo' => $image);
                $this->db->where('id', $teacher_id);
                $this->db->update('teacher', $data);

                upload_server_file_to_aws_s3("cenopsys/teacher_profile_picture/original/".$image,"teacher_profile_picture/original/".$image);	
                 
                if($this->db->affected_rows() == 1) {
                    //$this->session->set_flashdata('message', $this->lang->line('profile_pic_changed_sucess'));
                    echo "1";
                }
                
            }
        }
    }

    public function student_upload_profile_pic($teacher_id = 0,$view_profile=1){
        if($_FILES['uploadpic']['error'] == 0 && $teacher_id > 0){
           // $curr_dir = str_replace("\\","/",getcwd()).'/';
            //upload and update the file
            $config['upload_path'] = CURR_DIR.'cenopsys/student_profile_picture/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['overwrite'] = false;
            $config['remove_spaces'] = true;
            //$config['max_size']   = '100';// in KB
        
            //load upload library
            $this->load->library('upload', $config);
            $this->load->library('image_lib');
            if ( ! $this->upload->do_upload('uploadpic')){
                $this->session->set_flashdata('errormessage', $this->upload->display_errors('<p class="error">', '</p>'));
            }
            else
            {
                $data1 = array('upload_data' => $this->upload->data());
                $image= $data1['upload_data']['file_name'];
                
                $configBig = array();
                
                $configBig['image_library'] = 'gd2';
                $configBig['source_image']    = CURR_DIR.'cenopsys/student_profile_picture/'.$image;;
                $configBig['new_image'] = CURR_DIR.'cenopsys/student_profile_picture/'.$image;;
                $configBig['maintain_ratio'] = false;
                $configBig['width']     = 75;
                $configBig['height']    = 75;

                $this->image_lib->initialize($configBig); 
    
                //$user_id = $this->session->userdata('user_id');
                $data = array('photo' => $image);
                $this->db->where('id', $teacher_id);
                $this->db->update('student', $data);
				
                if($this->db->affected_rows() == 1) {
                    //$this->session->set_flashdata('message', $this->lang->line('profile_pic_changed_sucess'));
                    echo "1";
                }
                
            }
        }
    }

    public function view_profile($user_id = 0) {
        $user_id = encrypt_decrypt('d', $user_id);
        $content_data = array();
        $center_data = array();
        $content_data["user_system_date_format"] = getTableField($table="users", $select_col="user_system_date_format", $where_col="user_id", $where_col_val=$user_id);
        $user_data = $this->profile_model->get_profile($user_id);
        $country_data = get_data_from_table('countries',array('id' => $user_data->country_id));
        $center_data_array = $this->profile_model->get_center_data($user_id);
        if (!empty($center_data_array) && count($center_data_array) > 0) {
            foreach ($center_data_array as $key => $_center_data_array) {
                $center_data_id = $_center_data_array['center_id'];
                $center_data[] = get_data_from_table('center',array('center_id' => $center_data_id));
            }
        }
        
        if(!$user_data)
            redirect('home');

        if(!$this->list_user_model->check_user_profile_exist($user_id))
        {
            $first_insert_profile_data = array('user_id' => $user_id);
            $profile_id = grid_add_data($first_insert_profile_data,'user_profile');
        }

        $profile_picture = get_profile_pic($user_id);
        $profile_picture_150 = $profile_picture[150];
        $profile_picture_75 = $profile_picture[75];
        // set content data
        $content_data['user_id'] = $user_id;
        $content_data['user_data'] = $user_data;
        $content_data['country_data'] = $country_data;
        $content_data['center_data'] = $center_data;
        $content_data['profile_picture_150'] = $profile_picture_150;
        $content_data['profile_picture_75'] = $profile_picture_75;
        $content_data['gender_list'] = gender_list();
        $content_data['nationality_list'] = get_nationality_list();    
		$user_experience = array();
		$user_experience_count = 0;		
        $this->template->set_theme(Settings_model::$db_config['default_theme']);
        $this->template->set_layout('school');
        $this->template->title('Profile');
        $this->template->set_partial('header', 'header');
        $this->template->set_partial('sidebar', 'sidebar');
        $this->template->set_partial('footer', 'footer');

            $this->template->build('view_profile', $content_data);
        
    }
    public function teacher_profile($teacher_id=0)
    {

        $teacher_id = encrypt_decrypt('d', $teacher_id);
        $content_data = array();

        $user_data = $this->profile_model->get_teacher_profile($teacher_id);
        $content_data['center_id'] =  $this->profile_model->get_id_by_center($teacher_id);
        $content_data['other_user_roll'] = get_other_user_roll();
        $content_data['dropdown_course_frequency'] = dropdown_course_frequency();
        $content_data['centers'] = get_centers();
        $content_data['countries'] = get_countries();
        $content_data['statuss'] = dropdown_status();
        $content_data['teacher_type'] = get_teacher_Type();
        $content_data['nationality_list'] = get_nationality_list(); 
        $content_data['highest_qualification'] = get_highest_qualification();
        $content_data['user_data'] = $user_data;
        $content_data['teacher_id'] = $teacher_id;
        $this->template->set_theme(Settings_model::$db_config['default_theme']);
        $this->template->set_layout('school');
        $this->template->title('Teacher Profile');
        $this->template->set_partial('header', 'header');
        $this->template->set_partial('sidebar', 'sidebar');
        $this->template->set_partial('footer', 'footer');
        $this->template->build('teacher_profile', $content_data);
    }


    public function student_profile($student_id=0)
    {

        $student_id = encrypt_decrypt('d', $student_id);
        $content_data = array();
        $parentdata = $this->profile_model->get_parents_student_profile($student_id);
        $user_data = $this->profile_model->get_student_profile($student_id);
        $content_data['other_user_roll'] = get_other_user_roll();
        $content_data['dropdown_tested'] = dropdown_tested();
        $content_data['dropdown_course_frequency'] = dropdown_course_frequency();
        $content_data['centers'] = get_centers();
        $content_data['countries'] = get_countries();
        $content_data['statuss'] = dropdown_status();
        $content_data['teacher_type'] = get_teacher_Type();
        $content_data['nationality_list'] = get_nationality_list(); 
        $content_data['highest_qualification'] = get_highest_qualification(); 
        // set content data
        $content_data['user_data'] = $user_data;
        $content_data['parentdata'] = $parentdata;
        $content_data['student_id'] = $student_id;

       

        $this->template->set_theme(Settings_model::$db_config['default_theme']);
        $this->template->set_layout('school');
        $this->template->title('Student Profile');
        $this->template->set_partial('header', 'header');
        $this->template->set_partial('sidebar', 'sidebar');
        $this->template->set_partial('footer', 'footer');
        $content_data['menu'] = 'home';
        $this->template->build('student_profile', $content_data);
    }


     public function add_parents($student_id = Null,$id = Null)
    {
        $content_data['student_id'] = $student_id;
        $content_data['student_data'] = $this->profile_model->get_id_by_student($student_id);
        $content_data['id'] = $id;
        $rowdata = array();
        if($id){
            $rowdata = $this->profile_model->get_id_by_parents($id);
        }
        $content_data['rowdata'] = $rowdata;
        if($this->input->post()){
            $parents_name = $this->input->post('parents_name');
            $relationship = $this->input->post('relationship');
            $email = $this->input->post('email');
            $mobile_country_code = $this->input->post('mobile_country_code');
            $mobile_no = $this->input->post('mobile_no'); 
            
            $data = array();
            if($this->input->post('parent_uniq_id'))
            {
               $data['parent_uniq_id'] = $this->input->post('parent_uniq_id');   
            }else
            {
                $data['parent_uniq_id'] = generateParentsNum();   
            }
            $data['parents_name'] = $parents_name;
            $data['relationship'] = $relationship;
            $data['email'] = $email;
            $data['mobile_country_code'] = $mobile_country_code;  
            $data['mobile_no'] = $mobile_no;            
            $error = "";
            $error_seperator = "<br>";
            $table = 'parents';
            $wher_column_name = 'id';
            if($id){
                 
                $this->form_validation->set_rules('parents_name', 'Parents Name', 'required');
                $this->form_validation->set_rules('relationship', 'Relationship', 'required');
                $this->form_validation->set_rules('email', 'email', 'required|is_valid_email');
                $this->form_validation->set_rules('mobile_country_code','mobile_country_code','required');
                $this->form_validation->set_rules('mobile_no','Mobile No','required');
                
                if (!$this->form_validation->run()) {
                    if (form_error('parents_name')) {
                        $error .= form_error('parents_name').$error_seperator;
                    }elseif(form_error('relationship')) {
                        $error .= form_error('relationship').$error_seperator;
                    }elseif(form_error('email')) {
                        $error .= form_error('email').$error_seperator;
                    }elseif(form_error('mobile_country_code')) {
                        $error .= form_error('mobile_country_code').$error_seperator;
                    }elseif(form_error('mobile_no')) {
                        $error .= form_error('mobile_no').$error_seperator;
                    }
                    echo $error;
                    exit();
                  
                }               
                $data['updated_date'] = date('Y-m-d H:i:s');
                $data['updated_by'] =  $this->session->userdata('student_id');
                $changed_data = array();
                $changed_data['parents_name'] = $parents_name;
                $changed_data['relationship'] = $relationship;
                $changed_data['email'] = $email;
                $changed_data['mobile_country_code'] = $mobile_country_code;
                $changed_data['mobile_no'] = $mobile_no;
                $action = "Edit";            
                save_table_log_by_id("parents_log","parents","id",$id,$changed_data,$action);
                grid_data_updates($data,$table,$wher_column_name,$id);
                echo "update";
                exit;
            }else{
                $this->form_validation->set_rules('parents_name', 'Parents Name', 'required');
                $this->form_validation->set_rules('relationship', 'Relationship', 'required');
                $this->form_validation->set_rules('email', 'email', 'required|is_valid_email');
                $this->form_validation->set_rules('mobile_no','Mobile No','required');
                // $this->form_validation->set_rules('password','Password','required'); 
                if (!$this->form_validation->run()) {
                    if (form_error('parents_name')) {
                        $error .= form_error('parents_name').$error_seperator;
                    }elseif(form_error('relationship')) {
                        $error .= form_error('relationship').$error_seperator;
                    }elseif(form_error('email')) {
                        $error .= form_error('email').$error_seperator;
                    }elseif(form_error('mobile_country_code')) {
                        $error .= form_error('mobile_country_code').$error_seperator;
                    }elseif(form_error('mobile_no')) {
                        $error .= form_error('mobile_no').$error_seperator;
                    }
                     echo $error;
                    exit();
                }               
                $data['created_date'] = date('Y-m-d H:i:s');
                $data['created_by'] =  $this->session->userdata('student_id');

                $parent_id = grid_add_data($data,$table);
                $studentparentdata['student_id'] = $student_id;
                $studentparentdata['parent_id'] = $parent_id;
                grid_add_data($studentparentdata,'student_parent');
                $this->profile_model->clone_parents_information_on_insert_parent($parent_id,$student_id);
                echo "insert";
                exit;
            }
           exit();
        }
        $this->template->build('add_parents',$content_data);
    }




    public function parent_profile($parent_id=0)
    {

        $parent_id = encrypt_decrypt('d', $parent_id);
        $content_data = array();

        $user_data = $this->profile_model->get_parent_profile($parent_id);
        $content_data['other_user_roll'] = get_other_user_roll();
        $content_data['dropdown_tested'] = dropdown_tested();
        $content_data['dropdown_course_frequency'] = dropdown_course_frequency();
        $content_data['relationship'] = get_student_reletion();
        $content_data['countries'] = get_countries();
        $content_data['statuss'] = dropdown_status();
        $content_data['teacher_type'] = get_teacher_Type();
        $content_data['nationality_list'] = get_nationality_list(); 
        $content_data['highest_qualification'] = get_highest_qualification(); 
        // set content data
        $content_data['user_data'] = $user_data;
        $content_data['parent_id'] = $parent_id;

       

        $this->template->set_theme(Settings_model::$db_config['default_theme']);
        $this->template->set_layout('school');
        $this->template->title('Parent Profile');
        $this->template->set_partial('header', 'header');
        $this->template->set_partial('sidebar', 'sidebar');
        $this->template->set_partial('footer', 'footer');
        $this->template->build('parent_profile', $content_data);
    }
}

/* End of file profile.php */