<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
	public $arrAction;
    public function __construct()
    {
        parent::__construct();
		$this->db->query('SET sql_mode= ""'); 
		 $this->output->enable_profiler(FALSE);
        if (Settings_model::$db_config['disable_all'] == 1 && $this->session->userdata('role_id') != 1 && $this->uri->segment(2) != "login") {
            $this->session->sess_destroy();
            redirect('site_offline');
        }
        $this->load->helper('general_function');
        $this->load->helper('grid_function');

        /*if($this->session->userdata('login_type') !== 'corporate' && $this->session->userdata('login_type') !== 'student'  && $this->session->userdata('login_type') !== 'tutor' && $this->session->userdata('login_type') !== 'agent')
        {*/
        check_access();
        $controller_name = "";
        $controller_name = $this->router->fetch_class();
        $action = $this->router->fetch_method();
        $this->arrAction = get_priviledge_action($controller_name,$action,1);
        // }
       

        $controller_name = $this->router->fetch_class();
        $action = $this->router->fetch_method();
        $url_array=explode("/",$_SERVER['REQUEST_URI']);  
        $url = current_url();
        $pera = $this->uri->segment(3);
        $get_data = json_encode($_GET);
        $post_data = json_encode($_POST);
        $trecking_array = array();
		
		if(!empty($this->session->userdata('tracking_id')))
		{
			$trecking_array['master_id'] = $this->session->userdata('tracking_id');
			$trecking_array['controller_name'] = $controller_name;
			$trecking_array['action'] = $action;
			$trecking_array['additional_action'] = ($pera)? $pera : '';
			$trecking_array['url'] = $url;
			$trecking_array['get_data'] = $get_data;
			$trecking_array['post_data'] = $post_data;
			$trecking_table = 'tracking_data';
			if($controller_name !== "general")
			{
				tracking_add_data($trecking_array,$trecking_table);
			}
		}
    }

    /**
     *
     * process_partial: load the default view when no view exists in the current theme's views folder
     *
     * send_username: send the username to the member e-mail
     * @param $name string the name of the partial
     * @param $path the path to the correct view file
     *
     */

    public function process_partial($name, $path) {
        if (file_exists(APPPATH .'views/themes/'. Settings_model::$db_config['default_theme'] .'/'. $path .'.php')) {
            $this->template->set_partial($name, 'themes/'. Settings_model::$db_config['default_theme'] .'/'. $path);
        }else{
            $this->template->set_partial($name, 'themes/default/'. $path);
        }
    }

    public function process_template_build($path, $data = null) {
        if (file_exists(APPPATH .'views/themes/'. Settings_model::$db_config['default_theme'] .'/'. $path .'.php')) {
            $this->template->build('themes/'. Settings_model::$db_config['default_theme'] .'/'. $path, $data);
        }else{
            $this->template->build('themes/default/'. $path, $data);
        }
    }

}
/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */