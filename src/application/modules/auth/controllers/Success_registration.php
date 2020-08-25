<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Success_registration extends MX_Controller {

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
		$content_data = array();
        $this->template->set_theme(Settings_model::$db_config['default_theme']);
        $this->template->set_layout('school');
        $this->template->title('Sucessfully registered');
        $this->template->set_partial('header', 'membership/header');
        $this->template->set_partial('footer', 'membership/footer');
		$this->template->set_partial('sidebar', 'membership/sidebar');
		
		if($this->session->flashdata('registration_user_id') > 0){
			$this->template->build('auth/success_registration', $content_data);
		}	
		else{
			redirect('auth/login');
            exit;
		}
    }
}

/* End of file success_registration.php */