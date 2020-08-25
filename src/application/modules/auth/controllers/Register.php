<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register extends MX_Controller {

    public function __construct()
    {
        parent::__construct();
        // pre-load
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->helper('general_function');
		$this->load->model('profile/profile_model');
		$this->load->model('list_user/list_user_model');
    }

    public function index() {
        if($this->input->post()){

            $nonce = md5(uniqid(mt_rand(), true));

            $passport_number = $this->input->post('passport_number');
            $first_name = $this->input->post('first_name');
            $middle_name = $this->input->post('middle_name');
            $last_name = $this->input->post('last_name');
            $gender = $this->input->post('gender');            
            $birth_date = $this->input->post('birth_date');                
            $email = $this->input->post('email');
            $email_2 = $this->input->post('email_2');           
            $contact_number_1 = $this->input->post('contact_number_1');
            $contact_number_2 = $this->input->post('contact_number_2');
            $marital_status = $this->input->post('marital_status');
            $language_known = $this->input->post('language_known');
            $user_roll_id = $this->input->post('user_roll_id');
            $username = $email;
            $password = $this->input->post('password');
            
            $data = array();
            $data['passport_number'] = $passport_number;
            $data['first_name'] = $first_name;
            $data['middle_name'] = $middle_name;
            $data['last_name'] = $last_name;            
            $data['gender'] = $gender;
            $data['birth_date'] = make_db_date($birth_date);
            $data['email'] = $email;
            $data['email_2'] = $email_2;
            $data['contact_number_1'] = $contact_number_1;
            $data['contact_number_2'] = $contact_number_2;
            $data['marital_status'] = $marital_status;
            
			$data['language_known'] = "";
			
			if(is_array($this->input->post('language_known')))
				$data['language_known'] = implode(',',$this->input->post('language_known'));
			
            $data['username'] = $username;            
            $data['password'] = hash_password($password, $nonce);
            $data['nonce'] = $nonce;
            $data['active'] = '0';
            $data['user_roll_id'] = '2';
            $data['updated_date'] = date('Y-m-d H:i:s');
            $data['created_date'] = date('Y-m-d H:i:s');
            $data['created_by'] = $this->session->userdata('user_id');

            $profile_data['skype_id'] = $this->input->post('skype_id');
            $profile_data['nationality'] = $this->input->post('nationality');
            $profile_data['first_day_at_py'] =make_db_date( $this->input->post('first_day_at_py'));
            $profile_data['notes'] = $this->input->post('notes');             

            $error = "";
            $error_seperator = "<br>";
                 
            $this->form_validation->set_rules('first_name', 'first name', 'trim|required|max_length[40]|min_length[2]');
                    $this->form_validation->set_rules('last_name', 'first name', 'trim|required|max_length[40]|min_length[2]');
            $this->form_validation->set_rules('email', 'e-mail', 'trim|required|max_length[255]|is_valid_email|is_existing_unique_field[users.email]');
            //$this->form_validation->set_rules('username', 'username', 'trim|required|max_length[50]|min_length[6]|is_existing_unique_field[users.username]');
            $this->form_validation->set_rules('password', 'password', 'trim|required|max_length[64]|matches[password_confirm]');
            $this->form_validation->set_rules('password_confirm', 'repeat password', 'trim|required|max_length[64]');

            if (!$this->form_validation->run()) {
                
                if (form_error('first_name')) {
                    $this->session->set_flashdata('errormessage', form_error('first_name'));
                }elseif (form_error('last_name')) {
                    $this->session->set_flashdata('errormessage', form_error('last_name'));
                }elseif (form_error('email')) {
                    $this->session->set_flashdata('errormessage', form_error('email'));
                }elseif (form_error('password')) {
                    $this->session->set_flashdata('errormessage', form_error('password'));
                }elseif (form_error('password_confirm')) {
                    $this->session->set_flashdata('errormessage', form_error('password_confirm'));
                }
                
                if (isset($_POST) && count($_POST) > 0) {
                    foreach ($_POST as $key => $value) {
                        $this->session->set_flashdata($key, $value);
                    }
                }
                
                redirect('auth/register');
                exit();
            }else{
            
                $table = 'users';
                $wher_column_name = 'user_id';
                $user_id = grid_add_data($data,$table);

                $table = 'user_profile';
                $wher_column_name = 'user_id';
                $profile_data['user_id'] = $user_id;
                grid_add_data($profile_data,$table);

				$experience = $this->input->post('experience');
				$experience_count = count($experience['company']);
				
				
				$qualifications = $this->input->post('qualifications');
				$qualifications_count = count($qualifications['qualification_id']);
				
				if($qualifications_count > 1){
					for($i=0;$i < $qualifications_count -1;$i++){
						$qualification_id = $qualifications['qualification_id'][$i];
						$subject_related = $qualifications['subject_related'][$i];
						$subject = $qualifications['subject'][$i];
						$institute = $qualifications['institute'][$i];
						$graduation_year = $qualifications['graduation_year'][$i];
						
						$created_at = date('Y-m-d H:i:s');
						
						if($qualification_id > 0){
							$user_qualification = array(
								'user_id'       => $user_id,
								'type'       => 'qual',
								'subject'       => $subject,
								'qualification_id'       => $qualification_id,
								'institute'       => $institute,
								'graduation_year'       => $graduation_year,
								'created_at'       => $created_at
							);
							grid_add_data($user_qualification,'user_qualification');
						}
					}
				}

          
   

                
                // document upload
        
                $arrCertificateType = getCertificateType();
                $curr_dir = str_replace("\\","/",getcwd()).'/';
                //upload and update the file
                $config['upload_path'] = $curr_dir.'uploads/'.$user_id.'/';
                $config['allowed_types'] = 'jpg|jpeg|pdf|png|doc|docx|xlsx|xls|zip|csv';
                $config['overwrite'] = true;
                $config['remove_spaces'] = true;
                $config['max_size'] = '9048';// in KB
            
                //load upload library
                $this->load->library('upload', $config);
                
                $dir_exist = true; // flag for checking the directory exist or not
                if(!is_dir($curr_dir.'uploads/'.$user_id))
                {
                    mkdir($curr_dir.'uploads/'.$user_id, 0777, true);
                    $dir_exist = true; // dir not exist
                }
                $data = array();
                $errors = "";
                if($dir_exist)
                {
                    foreach($_FILES as $field => $files)
                    {
                        if(count($files['name']) > 0 && !in_array(4,$files['error']))
                        {
                            $file_names = array();
                            foreach($files['name'] as $file_name) {
                                $file_names[] = $field.'_'.$file_name;
                            }
                            $config['file_name'] = $file_names;
                            $this->upload->initialize($config);
                            if($this->upload->do_multi_upload($field))
                            {
                                $data[$field] = $this->upload->get_multi_upload_data();
                            }else{
                                $errors .= str_replace("_"," ",$field).': '.$this->upload->display_errors()."<br>";
                            }
                            
                        }
                    }
                }
                
               
                
                foreach($_FILES as $field => $files)
                {
                    if(count($files['name']) >0 && $field == 'photo' && isset($data['photo'][0]['file_name']))
                    {
                        unset($config);
                        $curr_dir = str_replace("\\","/",getcwd()).'/';
                        //upload and update the file
                        $config['upload_path'] = $curr_dir.'uploads/profile_picture/original/';
                        $config['allowed_types'] = 'gif|jpg|png';
                        $config['overwrite'] = false;
                        $config['remove_spaces'] = true;
                        $config['encrypt_name'] = TRUE;
                        //$config['max_size']   = '100';// in KB
                    
                        //load upload library
                        $this->load->library('upload', $config);
                        $this->load->library('image_lib');
                        
                        $file_names = array();
                            foreach($files['name'] as $file_name) {
                                $file_names[] = $field.'_'.$file_name;
                            }
                            $config['file_name'] = $file_names;
                            $this->upload->initialize($config);
                            if($this->upload->do_multi_upload($field))
                            {
                                $data[$field] = $this->upload->get_multi_upload_data();
                            }
                            else
                            {
                                $errors .= str_replace("_"," ",$field).': '.$this->upload->display_errors()."<br>";
                            }    

                        $image= $data['photo'][0]['file_name'];
                        $configBig = array();                

                        $configBig['image_library'] = 'gd2';
                        $configBig['source_image']    = $curr_dir.'uploads/profile_picture/original/'.$image;;
                        $configBig['new_image'] = $curr_dir.'uploads/profile_picture/thumb7575/'.$image;;
                        $configBig['maintain_ratio'] = false;
                        $configBig['width']     = 75;
                        $configBig['height']    = 75;

                        $this->image_lib->initialize($configBig); 

                        if ( ! $this->image_lib->resize())
                        {
                            $errors .= str_replace("_"," ",$field).': '.$this->upload->display_errors()."<br>";
                        }
                        $this->image_lib->clear();
                        unset($configBig);
                        
                        $configBig = array();
                        
                        $configBig['image_library'] = 'gd2';
                        $configBig['source_image']    = $curr_dir.'uploads/profile_picture/original/'.$image;;
                        $configBig['new_image'] = $curr_dir.'uploads/profile_picture/thumb150150/'.$image;;
                        $configBig['maintain_ratio'] = false;
                        $configBig['width']     = 150;
                        $configBig['height']    = 150;

                        $this->image_lib->initialize($configBig); 

                        if ( ! $this->image_lib->resize())
                        {
                            $errors .= str_replace("_"," ",$field).': '.$this->upload->display_errors()."<br>";
                        }
                        $this->image_lib->clear();
                        unset($configBig);
                        
                        $data = array('profile_picture' => $image);

                        $this->list_user_model->upload_profile_pic($user_id,$data);

                    }
                }
                
                //Update user profile id in profile_certificate table
                $this->list_user_model->update_user_profileid($user_id, 'profile_certificate');
                
                $this->session->set_flashdata('errormessage', $errors);

                $this->session->set_flashdata('passport_number', '');
                
				//START SEND Registration Email
                send_email_template(2,$user_id);
				//END SEND Registration Email
				
				$this->session->set_flashdata('registration_user_id', $user_id);
                redirect('auth/success_registration');
                exit;
            }
            redirect('auth/register');
            exit();
        }

        $nationality_list = get_nationality_list();
        $nationality_list[''] = 'Nationality';

        $content_data['user_data'] = array();
        $content_data['profile_picture_150'] = CURR_DIR."images/noimage.jpg";
        $content_data['profile_picture_75'] = CURR_DIR."images/noimage.jpg";
        $content_data['gender_list'] = gender_list();
        $content_data['nationality_list'] = $nationality_list;
       

        $this->template->set_theme(Settings_model::$db_config['default_theme']);
        $this->template->set_layout('school');
        $this->template->title('Add Profile');
        $this->template->set_partial('header', 'membership/header');
        $this->template->set_partial('footer', 'membership/footer');
		$this->template->set_partial('sidebar', 'membership/sidebar');
        $this->template->build('auth/register', $content_data);
    }

	public function validate_passport_num() {
		$this->session->set_flashdata('passport_number', '');
        $passport_number = $this->input->post('passport_number');
        $nationality = $this->input->post('nationality');
        $user_id = $this->input->post('user_id');

        $this->form_validation->set_rules('passport_number', 'passport_number', 'trim|is_existing_field[users.passport_number^users.user_id !=^'.$user_id.']');
        //$this->form_validation->set_rules('password', 'password', 'trim|required|is_member_password');
        
        if (!$this->form_validation->run())
        {
            if (form_error('passport_number')) {
                //echo form_error('passport_number');
                echo 'false';
                exit();
            }
        }

        $this->session->set_flashdata('nationality', $nationality);
        echo 'true';
        exit();
    }



}

/* End of file login.php */