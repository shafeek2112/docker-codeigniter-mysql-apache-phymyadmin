<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Cron extends Private_Controller {

    public function __construct() {
        parent::__construct();
		// $this->load->helper(array('form','invoice_helper'));
        $this->load->library('form_validation');
        $this->load->helper('general_function');
    }

    public function SendStaffCourseConfirmation()
    {
         $this ->db-> select('cadet_plus_course_schedule.*,min(cadet_plus_course_schedule_detail.date) as start,max(cadet_plus_course_schedule_detail.date) as end,cadet_plus_course.course_title,company.company_name as organization_name');
         $this ->db-> from('cadet_plus_course_schedule');
         $this->db->join('cadet_plus_course_schedule_detail','cadet_plus_course_schedule_detail.course_schedule_id = cadet_plus_course_schedule.id','left');
         $this->db->join('cadet_plus_course','cadet_plus_course.id = cadet_plus_course_schedule.course_id','left');
         $this->db->join('company','cadet_plus_course.company_id = company.id','left');
         $result =  $this->db->get()-> result_array();
         if (is_array($result) && !empty($result)) {
             foreach ($result as $key => $value) {
                    $this ->db-> select('cadet_stu_course.*');
                    $this ->db-> from('cadet_stu_course');
                    $this ->db-> where('cadet_stu_course.schedule_id',$value['id']);
                    $this ->db-> where('cadet_stu_course.status',1);
                    $this ->db-> where('cadet_stu_course.send_course_confirmation_email',0);
                    $student_count =  $this->db->get()-> num_rows();
                    if ($value['min_student'] <= $student_count) {
                        $temp_data = get_data_from_table('email_template',array('id' => 3));
                        $bodypart = $temp_data['description'];
                        $get_temp_data = get_email_template_fields();
                        if(!empty($get_temp_data) && count($get_temp_data)>0){
                            foreach ($get_temp_data as $key => $_value) {
                                
                                if ($_value=='organization_name') {
                                    $bodypart = str_replace($key,$value['organization_name'],$bodypart); 
                                }
                                if ($_value=='course_name') {
                                    $bodypart = str_replace($key,$value['course_title'],$bodypart); 
                                }
                                if ($_value=='schedule_date') {
                                    $bodypart = str_replace($key,date('d-M-Y',strtotime($value['start'])).' to '.date('d-M-Y',strtotime($value['end'])),$bodypart); 
                                }
                            }
                            $message = $bodypart;
                            $system_config = get_data_from_table('system_config',array('id'=>1));
                            $from_email = $system_config['sender_email'];
                            $subject = 'Wavelink Maritime Institute : Course Confirmation ';
                            $this ->db-> select('staff.*');
                            $this ->db-> from('staff');
                            $this ->db-> where('staff.status',1);
                            $staff_list =  $this->db->get()-> result_array();
                            foreach ($staff_list as $key => $value) {
                                send_mail_funciton($message,$from_email,"Wavelink Maritime Institute",$value['email'],$subject);
                            }
                       }
                    }
             }
         }
    }

}

/* End of file general.php */