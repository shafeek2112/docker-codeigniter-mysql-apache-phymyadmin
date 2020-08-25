<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class System_config extends Private_Controller {

    public function __construct()
    {
        parent::__construct();
        // pre-load
        $this->load->helper(array('form','general_function'));
        $this->load->library('form_validation');
		$this->load->model('system_config_model');
		$this->load->model('add_privilege/privilege_model');
    }

/*******************************************************************************************************
 * *************************************** Invoice Listing *************************************************
 ******************************************************************************************************/
	public function index() {
		$content_data['rowdata'] = get_data_from_table('system_config',array('id'=>1));
        $this->template->set_theme(Settings_model::$db_config['default_theme']);
        $this->template->set_layout('school');
        $this->template->title('System Config');
        $this->template->set_partial('header', 'header');
        $this->template->set_partial('sidebar', 'sidebar');
        $this->template->set_partial('footer', 'footer');
        $this->template->build('index_view', $content_data);
    }

	public function add_system_config(){
        $rowdata = array();
        $rowdata = get_data_from_table('system_config',array('id'=>1));
    	$content_data['rowdata'] = $rowdata;
    	if($this->input->post()){
            $data = array();
			$data['paypal_email'] = $_POST['paypal_email'];
            $data['sender_email'] = $_POST['sender_email'];
            $data['receiver_email'] = $_POST['receiver_email'];
			$data['cancellation_fees'] = $_POST['cancellation_fees'];
			$data['paypal_processing_fees'] = $_POST['paypal_processing_fees'];
			$data['subsidy_claim_reminder_days'] = $_POST['subsidy_claim_reminder_days'];

            $data['name'] = $_POST['name'];
            $data['address'] = $_POST['address'];
            $data['certificate_footer'] = $_POST['certificate_footer'];

    		$error = "";
    		$error_seperator = "<br>";
            $wher_column_name = 'id';
			
            $this->form_validation->set_rules('paypal_email', 'Paypal Email', 'required');
			$this->form_validation->set_rules('sender_email', 'Sender Email', 'required');
            $this->form_validation->set_rules('receiver_email', 'Receiver Email', 'required');
			$this->form_validation->set_rules('cancellation_fees', 'Cancellation Fees', 'required');
	       	if (!$this->form_validation->run()) {
			    if (form_error('paypal_email')) {
                    $error .= form_error('paypal_mail').$error_seperator;
                }elseif (form_error('sender_email')) {
                    $error .= form_error('sender_email').$error_seperator;
                }elseif (form_error('receiver_email')) {
                    $error .= form_error('receiver_email').$error_seperator;
                }elseif (form_error('cancellation_fees')) {
                    $error .= form_error('cancellation_fees').$error_seperator;
                }
				echo $error;
				exit();
			}
			grid_data_updates($data,'system_config','id',1);
            echo "Success";
        	exit;
        }
    }
}

/* End of file list_user.php */