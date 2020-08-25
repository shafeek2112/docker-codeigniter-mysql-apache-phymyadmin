<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('load_email_config')) {
    /**
     *
     * load_email_config: obscure password with specially designed salt - site_key combo in sha512
     *
     * @param int $i the config type: 1 = PHP mail(); 2 = sendmail; 3 = SMTP
     * @return array
     *
     */
    function load_email_config($i) {
        $config = array();
        switch ($i) {
            case 2:
                $config = array(
                    'protocol' => 'sendmail',
                    'mailpath' => Settings_model::$db_config['sendmail_path'],
                    'charset' => "utf-8",
                    'wordwrap' => TRUE,
                    'newline' => "\r\n"
                );
                break;
            case 3:
                $config = array(
                    'protocol' => 'smtp',
                    'smtp_host' => Settings_model::$db_config['smtp_host'],
                    'smtp_port' => Settings_model::$db_config['smtp_port'],
                    'smtp_user' => $this->encrypt->encode($this->input->post('smtp_user')),
					'smtp_pass' => $this->encrypt->encode($this->input->post('smtp_pass')),
                    'smtp_timeout' => 30,
                    'charset' => "utf-8",
                    'newline' => "\r\n"
                );
        }

        return $config;
    }

	/*function gw_send_sms($sms_config_details) { 
        $user = $sms_config_details['username'];   
        $pass = $sms_config_details['password'];
        $sms_from = $sms_config_details['smsfrom'];
        $sms_to = $sms_config_details['sms_to'];
        $sms_msg = $sms_config_details['sms_msg'];
        $sms_url = $sms_config_details['smsurl'];

        $query_string = "?appid=".$user."&appsecret=".$pass;
        $query_string .= "&receivers=".$sms_to;
        $query_string .= "&content=".rawurlencode(stripslashes($sms_msg)); 
        $query_string .= "&responseformat=JSON";		   
        $url = $sms_url."".$query_string;   
        $fd = @implode ('', file ($url)); 
        if ($fd)  
        { 
            $msg_resp=json_decode($fd,true);
            if(!empty($msg_resp) && isset($msg_resp['result']['status']) && ($msg_resp['result']['status']=="OK")) {
                $ok = "success";
            }        
            else {
                $ok = "fail";
            }
        }           
        else      
        {                                             
            $ok = "fail";       
        } 
        return $ok;  
    }*/
}

/* End of file send_email_helper.php */
/* Location: ./application/helpers/send_email_helper.php */