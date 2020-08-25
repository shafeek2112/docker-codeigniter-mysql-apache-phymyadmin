<?php
class Langswitch extends CI_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
    }

    function switchLanguage($language = "") {
        $language = ($language != "") ? $language : "english";
        
        $this->session->set_userdata('site_lang', $language);
		$currentURL  = "";
		
		if(isset($_SERVER["HTTP_REFERER"])){
			$currentURL  = $_SERVER["HTTP_REFERER"];
		}
		
		if($currentURL == "")
			redirect(base_url());
		else
			redirect($currentURL);
    }
}
?>