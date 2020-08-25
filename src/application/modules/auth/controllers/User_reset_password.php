<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_reset_password extends MX_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('password');
        $this->load->model('user_reset_password_model');
        $this->load->library('form_validation');
    }

    public function index() {
       
        $this->template->set_theme(Settings_model::$db_config['default_theme']);
        $this->template->set_layout('school');
        $this->template->title('reset password');
        $this->template->set_partial('header', 'membership/header');
        $this->template->set_partial('footer', 'membership/footer');
        $this->template->set_partial('sidebar', 'membership/sidebar');
        $this->template->build('reset_password');
    }

    public function reset($email, $token) {
        $new_password = $this->_random_letter().
                        $this->_random_symbol().
                        $this->_random_symbol().
                        $this->_random_letter().
                        $this->_random_number().
                        $this->_random_symbol().
                        $this->_random_letter().
                        $this->_random_letter().
                        $this->_random_number();
        $new_password = str_shuffle($new_password);
        $data = $this->user_reset_password_model->verify_token(urldecode($email), $token);
        $this->load->helper('send_email');
        $this->load->library('email', load_email_config(Settings_model::$db_config['email_protocol']));
        if (!empty($data['date_added'])) {
            $time_diff = strtotime($data['date_added'])- strtotime("now") ;
        }

        if (isset($time_diff) && $time_diff > 43200)  { 
        // 12 hours password expired link has expired
            $this->session->set_flashdata('errormessage', ($this->lang->line('reset_password_link_expired')));
            $this->user_reset_password_model->delete_token_data($token);
            redirect("/auth/login");
            exit();
        }elseif (isset($data['token']) && $data['token'] == $token) {
            $this->user_reset_password_model->delete_token_data($token);
            if ($this->user_reset_password_model->update_password_and_nonce(urldecode($email), $new_password)) {
                /*$this->email->from(Settings_model::$db_config['admin_email_address'], $_SERVER['HTTP_HOST']);
                $this->email->to(urldecode($email));
                $this->email->subject($this->lang->line('wongfong_your_recover_password'));*/


                $message = "<p> Hello,</p>";
                
                $message .= "<h3>Your New Email and Password.
                            </h3>";
                
                $message .= "<div> <b>".$this->lang->line('email').":</b>&nbsp;".$data['username'] ." </div>";
                $message .= "<div> <b> ".$this->lang->line('password').":</b>&nbsp;". addslashes($new_password)."</div>";
                $message .= "<br>";
                $message .= "<br>";
                $message .= "<div>
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
                $to_email = $data['username'];
                $subject = $this->lang->line('wongfong_your_recover_password');

                send_mail_funciton($message,$from_email,$from_emiil_user,$to_email,$subject);

                /*$this->email->message($this->lang->line('email_greeting') ." ". $data['username'] . $this->lang->line('reset_password_message'). addslashes($new_password));

                $this->email->send();*/
                $this->session->set_flashdata('message', ($this->lang->line('reset_password_success')));
            }else{
                $this->session->set_flashdata('errormessage', ($this->lang->line('reset_password_failed_db')));
            }
        }else{
            $this->session->set_flashdata('errormessage', ($this->lang->line('reset_password_failed_token')));
        }
        redirect("/auth/login");
    }

    /**
     *
     * _random_symbol: take one random symbol
     *
     *
     */

    private function _random_symbol() {
        $symbol_arr = array("!", "$", ".", "[", "]", "|", "(", ")", "?", "*", "+", "{", "}", "@", "#");
        $i = rand(0, 14);
        return $symbol_arr[$i];
    }

    /**
     *
     * _random_letter: take one random letter
     *
     *
     */

    private function _random_letter() {
        $letter_arr = array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");
        $i = rand(0, 25);
        return $letter_arr[$i];
    }

    /**
     *
     * _random_number: taken one random number
     *
     *
     */

    private function _random_number() {
        $number_arr = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
        $i = rand(0, 9);
        return $number_arr[$i];
    }
}

/* End of file reset_password.php */