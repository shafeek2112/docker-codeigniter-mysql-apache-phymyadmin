<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Homepage extends Public_Controller {

    public function __construct()
    {
        parent::__construct();
		//$this->load->model('home_model');
    }

    public function index() {
        $content_data = '';
        $this->template->set_theme("frontend");
        $this->template->set_layout('frontend');
        $this->template->title('Homepage');
        $this->template->meta_keywords('Homepage');
        $this->template->meta_keywords('Homepage');
        $this->template->html_wf_page('5bff4f228c8d95184fdbfa24');
        $this->template->html_wf_site('5bff4f228c8d9578ccdbfa23');
        $this->template->set_partial('header', 'frontend/partials/header');
        $this->template->set_partial('footer', 'frontend/partials/footer');
        $this->template->set_partial('sidebar', 'frontend/partials/sidebar');
		$this->template->build('frontend/homepage', $content_data);
		
    }
}

/* End of file Homepage.php */