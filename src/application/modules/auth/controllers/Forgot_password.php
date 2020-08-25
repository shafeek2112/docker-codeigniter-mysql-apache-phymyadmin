<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Forgot_password extends MX_Controller {

    public function __construct()
    {
        parent::__construct();
        // pre-load
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('database_tools_model');
        $this->load->model('forgot_password_model');

    }

    public function index() {
        $this->template->set_theme(Settings_model::$db_config['default_theme']);
        $this->template->set_layout('school');
        $this->template->title('forgot password');
        $this->template->set_partial('header', 'membership/header');
        $this->template->set_partial('footer', 'membership/footer');
		$this->template->set_partial('sidebar', 'membership/sidebar');
        $this->template->build('forgot_password');
    }

    /**
     *
     * send_password: send the reset member password link
     *
     *
     */

    public function send_password() {
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('email', 'e-mail', 'trim|required|is_valid_email');

        if (!$this->form_validation->run()) {
            if (form_error('email')) {
                $this->session->set_flashdata('errormessage', form_error('email'));
            }
            redirect('auth/login');
            exit();
        }
        $data = $this->database_tools_model->get_data_by_email($this->input->post('email'));
        if (isset($data['status']) && $data['status'] != 1) {
            $this->session->set_flashdata('errormessage', $this->lang->line('is_account_inactive'));
            redirect('auth/login');
        }elseif (!empty($data)){
            $token = hash_hmac('ripemd160', md5($data['nonce'] . uniqid(mt_rand(), true)), SITE_KEY);
            $this->forgot_password_model->delete_tokens_by_email($this->input->post('email'));

            if ($this->forgot_password_model->insert_recover_password_data($data['id'], $token, $this->input->post('email'))) {
                $this->load->helper('send_email');
                $this->load->library('email', load_email_config(Settings_model::$db_config['email_protocol']));
                /*$this->email->from(Settings_model::$db_config['admin_email_address'], $_SERVER['HTTP_HOST']);
                $this->email->to($this->input->post('email'));
                $this->email->subject($this->lang->line('forgot_password_subject'));*/


                $message = "<p> Hello ".$data['first_name'].",</p>";
                $message .= "<br>";
                $message .= "<p>We have received a request to reset your password. Please click below   link to recover your password.
                            </p>";
                $message .= "<div> ". $this->lang->line('forgot_password_message') ."\r\n\r\n". base_url() ."auth/user_reset_password/reset/". urlencode($this->input->post('email')) ."/". $token." </div>";
                $message .= "<br>";
                $message .= "<div>If you ignore this email, your password won’t be changed.<br><br>
                                <b>Need Help? </b><br><br>
                                Call (65) 6269 5269 Or email sales@thtc.com.sg for assistance.
                            </div>";
                $message .= "</div>";
                $message .= "<div style='text-align: right;margin-top: 30px;'>";
                $message .= "</div>";
                $message .= "<p>Thanks & Regards,</p>";
                $message .= "<p> Wavelink Maritime Institute</p>";
                $message .= "<br>";

                //echo $message; exit();

                $from_email = "";
                $from_emiil_user = "Wavelink Maritime Institute";
                $to_email =  $this->input->post('email');
                $subject = $this->lang->line('wongfong_your_recover_password');

                send_mail_funciton($message,$from_email,$from_emiil_user,$to_email,$subject);

                /*$this->email->message($this->lang->line('email_greeting') ." ". $data['username'] . $this->lang->line('forgot_password_message') ."\r\n\r\n". base_url() ."auth/reset_password/reset/". urlencode($this->input->post('email')) ."/". $token);
                exit();*/
                //$this->email->send();
                $this->session->set_flashdata('message', $this->lang->line('forgot_password_success'));
            }else{
                $this->session->set_flashdata('errormessage', $this->lang->line('forgot_password_failed_db'));
            }

            redirect('auth/login');
        }else{
            $this->session->set_flashdata('errormessage', $this->lang->line('email_not_found'));
        }

        $this->session->set_flashdata('email', $this->input->post('email'));
        redirect('auth/login');
    }
    
}

/* End of file forgot_password.php */