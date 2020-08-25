<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH."third_party/fcm/src/Client.php";
require APPPATH."third_party/fcm/vendor/autoload.php";
use sngrl\PhpFirebaseCloudMessaging\Client;
use sngrl\PhpFirebaseCloudMessaging\Message;
use sngrl\PhpFirebaseCloudMessaging\Recipient\Topic;
use sngrl\PhpFirebaseCloudMessaging\Notification;
class Home extends Private_Controller {

    public function __construct()
    {
        parent::__construct();
		// $this->load->helper(array('form','invoice_helper'));
		$this->load->model('home_model');
		// $this->load->model('invoice_management/invoice_management_model');
    }

    public function index() {

		
        $this->template->set_theme(Settings_model::$db_config['default_theme']);
        $this->template->set_layout('school');
        $this->template->title('Dashbord');
        $this->template->set_partial('header', 'header');
		$this->template->set_partial('sidebar', 'sidebar');
        $this->template->set_partial('footer', 'footer');
        $content_data['menu'] = 'Home';

        // $dashboard_box = $this->home_model->get_dashboard_box($user_role);
        // $content_data['dashboard_box'] = $dashboard_box;
		$this->template->build('homepage', $content_data);
		
    }

    public function tag_topic() {

        $server_key = 'AAAAu65CiXU:APA91bFpL1lrXexe2AltADM3lqjh4sgdzjYYZwfeVZqNIkhPfjDrEK3YS1vm644Fo2ksgP8c90La8ElDUsQcqmwppabz-bx6xwjRen-qSNe3JFqlI9MCZcGk6by5l34zMKMhufSNjc69';
        $client = new Client();
        $client->setApiKey($server_key);
        $client->injectGuzzleHttpClient(new \GuzzleHttp\Client());

        $register_token = "cmFRNmSD2FI:APA91bF7iywFfCKCp9k644LR_p2wokK96bzqBPA77dYhm2szwY4fiNx8ctc8v10ywTj52DLtkY7t1zTY8b2p9fQ6Z_PI0Q802FepmEXw54ppHEhllWyfi4rr7g9cXuMOQIB1cBgpJJUm";
        $response = $client->addTopicSubscription('new-topicsss', ['test']);
        var_dump($response->getStatusCode());
        var_dump($response->getBody()->getContents());
    }

    public function test_fcm() {

        $server_key = 'AAAAu65CiXU:APA91bFpL1lrXexe2AltADM3lqjh4sgdzjYYZwfeVZqNIkhPfjDrEK3YS1vm644Fo2ksgP8c90La8ElDUsQcqmwppabz-bx6xwjRen-qSNe3JFqlI9MCZcGk6by5l34zMKMhufSNjc69';
        $client = new Client();
        $client->setApiKey($server_key);
        $client->injectGuzzleHttpClient(new \GuzzleHttp\Client());

        $message = new Message();
        $message->setPriority('high');
        $message->addRecipient(new Topic('testing'));
        $message
            ->setNotification(new Notification('some title11', 'some body11'))
            ->setData(['key' => 'value']);

        $response = $client->send($message);
        var_dump($response->getStatusCode());
        var_dump($response->getBody()->getContents());
    }

	// no access view if user has no privilage
    function no_access($controller = ''){
    	$content_data = array();
    	$content_data['controller'] = $controller;
    	$this->template->set_theme(Settings_model::$db_config['default_theme']);
    	$this->template->set_layout('school');
    	$this->template->title('No Access');
    	$this->template->set_partial('header', 'header');
		$this->template->set_partial('sidebar', 'sidebar');
    	$this->template->set_partial('footer', 'footer');
    	$this->template->build('no_access', $content_data);
    }

    public function get_start_date($month){
        switch($month){
            case 'Jan':
                $date = date('Y-m-d H:i:s',strtotime('01-01-'.date('Y')));
                break;
            
            case 'Feb':
                $date = date('Y-m-d H:i:s',strtotime('01-02-'.date('Y')));
            break;
            
            case 'Mar':
                $date = date('Y-m-d H:i:s',strtotime('01-03-'.date('Y')));
            break;
            
            case 'Apr':
                $date = date('Y-m-d H:i:s',strtotime('01-04-'.date('Y')));
            break;
            
            case 'May':
                $date = date('Y-m-d H:i:s',strtotime('01-05-'.date('Y')));
            break;
            
            case 'Jun':
                $date = date('Y-m-d H:i:s',strtotime('01-06-'.date('Y')));
            break;
            
            case 'Jul':
                $date = date('Y-m-d H:i:s',strtotime('01-07-'.date('Y')));
            break;
            
            case 'Aug':
                $date = date('Y-m-d H:i:s',strtotime('01-08-'.date('Y')));
            break;
            
            case 'Sept':
                $date = date('Y-m-d H:i:s',strtotime('01-09-'.date('Y')));
            break;
            
            case 'Oct':
                $date = date('Y-m-d H:i:s',strtotime('01-10-'.date('Y')));
            break;
                
            case 'Nov':
                $date = date('Y-m-d H:i:s',strtotime('01-11-'.date('Y')));
            break;
            
            case 'Dec':
                $date = date('Y-m-d H:i:s',strtotime('01-12-'.date('Y')));
            break;  
        }
        return $date;
    }
}

/* End of file home.php */