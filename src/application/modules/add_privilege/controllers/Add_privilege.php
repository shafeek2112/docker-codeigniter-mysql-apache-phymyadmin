<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Add_privilege extends Private_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');        
        $this->load->library('form_validation');
        $this->load->helper('general_function');
        $this->load->model('privilege_model');
        
    }

    public function index() {
    	$content_data['user_roll'] = get_user_roll();
    	$content_data['arrMenu'] = get_previlege_action();
        
        $this->template->set_theme(Settings_model::$db_config['default_theme']);
        $this->template->set_layout('school');
        $this->template->title('Add Privilege');
        $this->template->set_partial('header', 'header');
        $this->template->set_partial('sidebar', 'sidebar');
        $this->template->set_partial('footer', 'footer');
        $this->template->build('add_privilege', $content_data);
    }

    /**
     *
     * add: add school year from post data.
     *
     *
     */

    public function add() { 
	
        $this->form_validation->set_error_delimiters('', '');
        
        $this->load->model('privilege_model');
        $this->privilege_model->create_privilege($this->input->post('user_roll_id'), $this->input->post('action'));
        $this->session->set_flashdata('user_roll_id', $this->input->post('user_roll_id'));
        echo "success";
    }
	
    public function get_existing_privilege(){
    	$this->load->model('privilege_model');
    	$role_id = $_POST['role_id'];
    	$data = $this->privilege_model->get_existing_privilege($role_id);
    	echo $data;
    }
}

/* End of file add_school_year.php */