<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends MX_Controller {

    public function __construct()
    {
        parent::__construct();
        // pre-load
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('login_model');
        $this->load->helper('general_function');
    }

    public function index() {

        $this->template->set_theme(Settings_model::$db_config['default_theme']);
        $this->template->set_layout('school');
        $this->template->title('Login');
        $this->template->set_partial('header', 'membership/header');
        $this->template->set_partial('footer', 'membership/footer');
		$this->template->set_partial('sidebar', 'membership/sidebar');
        $this->template->build('login');
    }

    /**
     *
     * validate: validate login after input fields have met requirements
     *
     */
    public function validate() {
        if (Settings_model::$db_config['disable_all'] == 1 && $this->input->post('username') != ADMINISTRATOR) {
            $this->session->set_flashdata('message', $this->lang->line('site_disabled'));
            redirect('/auth/login');
            exit();
        }
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('username', 'username', 'trim|required|max_length[100]');
        $this->form_validation->set_rules('password', 'password', 'trim|required|max_length[64]');
        if (!$this->form_validation->run())
        {
            if (form_error('username')) {
                $this->session->set_flashdata('errormessage', form_error('username'));
            }elseif (form_error('password')) {
                $this->session->set_flashdata('errormessage', form_error('password'));
            }
            redirect('/auth/login');
            exit();
        }

        $data = $this->login_model->validate_login($this->input->post('username'), $this->input->post('password'));
        pd($data);

        if($data == "username") {
            $this->session->set_flashdata('errormessage', $this->lang->line('username_incorrect'));
            redirect('/auth/login');
        }elseif ($data == "password") {
           $this->session->set_flashdata('errormessage', $this->lang->line('password_incorrect'));
            redirect('/auth/login');
        }elseif (is_array($data)) {

            if($data['status'] == 0) {
				$this->session->set_flashdata('errormessage', $this->lang->line('activate_register_account'));
                redirect('/auth/login');
            }else{
                $this->load->helper('cookie');
                if ($this->input->post('remember_me') && !get_cookie('unique_token')) {
                    setcookie("unique_token", $data['nonce'], time() + Settings_model::$db_config['cookie_expires'], '/', $_SERVER['SERVER_NAME'], false, false);
                }
                $login_type = '';
                if($data['user_roll_id'] == 2)
                {
                    $login_type = 'tutor';
                }else
                {
                    $login_type = 'user';
                }
                
                $this->session->set_userdata('current_company', $data['company_id']);
                $this->session->set_userdata('current_company_name', $data['company_name']);
                $this->session->set_userdata('logged_in', true);
                $this->session->set_userdata('user_id', $data['id']);
                $this->session->set_userdata('login_type',$login_type);
                $this->session->set_userdata('portal_id', $data['portal_id']);
                $this->session->set_userdata('username', $data['username']);
                $this->session->set_userdata('first_name', $data['first_name']);
                $this->session->set_userdata('role_id', $data['user_roll_id']);
                $this->session->set_userdata('user_privilege_per_page', '');
                $trecking_array['user_id'] = $this->session->userdata('user_id');
                $trecking_array['ip'] = $_SERVER['REMOTE_ADDR'];;
                $trecking_array['login_type'] = $this->session->userdata('login_type');
                $trecking_array['login_time'] = date('Y-m-d H:i:s');
                $trecking_array['logout_time'] = '';
                $trecking_table = 'tracking_master';
                $trecking_id = tracking_add_data($trecking_array,$trecking_table);
                $this->session->set_userdata('tracking_id', $trecking_id);
                // reset login attempts to 0
                $this->login_model->reset_login_attempts($data['username']);
                $this->session->unset_userdata('login_attempts');

				if($login_type == 'tutor')
                {
                    redirect('trainer_portal');
                }else
                {
                    redirect('home');
                }
            }
        }else{
            $this->session->set_flashdata('errormessage', $this->lang->line('login_incorrect'));
            $this->session->set_userdata('login_attempts', $data);
            redirect('/auth/login');
        }
    }


}

/* End of file login.php */