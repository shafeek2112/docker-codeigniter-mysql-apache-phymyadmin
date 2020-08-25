<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends MX_Controller {

    public function __construct()
    {
        parent::__construct();
        if($this->session->userdara('login_type') == 'user' || $this->session->userdara('login_type') == 'tutor' ){
        	redirect('/auth/login');
        }else{
        	redirect('/auth/client_login');
        }
        
    }

    

}

/* End of file auth.php */