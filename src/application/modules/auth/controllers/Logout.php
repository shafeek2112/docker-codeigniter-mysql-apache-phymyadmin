<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends MY_Controller {


    public function __construct()
    {
        parent::__construct();
    }

    function index() {
            $tracking_id = $this->session->userdata('tracking_id');
            $tracking_data = array();
            $tracking_data['logout_time'] = date('Y-m-d H:i:s');
            $wher_column_name = 'id';
            $table = "tracking_master";
            grid_data_updates($tracking_data,$table,$wher_column_name,$tracking_id);
    		$this->session->sess_destroy();
            setcookie("unique_token", null, time() - 60*60*24*3, '/', $_SERVER['SERVER_NAME'], false, false);
            redirect('/auth/login');
    }
}

/* End of file logout.php */