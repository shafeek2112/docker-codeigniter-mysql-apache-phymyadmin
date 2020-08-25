<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Courses_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
	

	public function get_course_list($venue_id=0,$course_id=0,$language_id=0) {
	
      
        $this->db->select('course_schedule.*,course.course_title,course.course_img,course.descripation,course_schedule_detail.date as course_date,course_schedule_detail.am_start_time,course_schedule_detail.am_end_time,course_schedule_detail.pm_start_time,course_schedule_detail.pm_end_time,language.language');
        $this->db->from('course_schedule');
        $this->db->join('course','course_schedule.course_id = course.id','left');
        $this->db->join('course_schedule_detail','course_schedule.id = course_schedule_detail.course_schedule_id','left');
        $this->db->join('language','language.id = course_schedule.language_id','left');
        $this->db->where('course_schedule.status','A');

      	if($venue_id != 0 && $venue_id != '')
        {
            $this->db->where('course_schedule.venue_id',$venue_id);
        }
		if($course_id != 0 && $course_id != '')
		{
			$this -> db -> where('course_schedule.course_id',$course_id);
		}
		if($language_id != 0 && $language_id != '')
		{
			$this -> db -> where('course_schedule.language_id',$language_id);
        }
		$this->db->group_by('course_schedule.id');
    	$query = $this->db->get();
    	// echo $this->db->last_query();
    	// exit();
			
    	if($query->num_rows() > 0) {
    		return $query->result_array();
    	}
    }


    public function get_course_data_by_course_schedule_id($course_schedule_id=0) {
    
      
        $this->db->select('course_schedule.*,course.course_title,course.course_img,course.descripation,course_schedule_detail.date as course_date,course_schedule_detail.am_start_time,course_schedule_detail.am_end_time,course_schedule_detail.pm_start_time,course_schedule_detail.pm_end_time,language.language,venue.area as venue_name');
        $this->db->from('course_schedule');
        $this->db->join('course','course_schedule.course_id = course.id','left');
        $this->db->join('course_schedule_detail','course_schedule.id = course_schedule_detail.course_schedule_id','left');
        $this->db->join('language','language.id = course_schedule.language_id','left');
        $this->db->join('venue','venue.id = course_schedule.venue_id','left');
        $this->db->where('course_schedule.status','A');

       
        if($course_schedule_id != 0 && $course_schedule_id != '')
        {
            $this -> db -> where('course_schedule.id',$course_schedule_id);
        }
        $this->db->group_by('course_schedule.id');
        $query = $this->db->get();
        // echo $this->db->last_query();
        // exit();
            
        if($query->num_rows() > 0) {
            return $query->row_array();
        }
    }



    public function get_course_fees($course_id=0) {
    
      
        $this->db->select('course_fees.*,');
        $this->db->from('course_fees');
        $this->db->where('course_fees.course_id',$course_id);
        $this->db->where('course_fees.effective_date < ',@date('Y-m-d'));
        $this->db->order_by('course_fees.effective_date','desc');
        $query = $this->db->get();
      
        $effective_date_arr = '';
        if($query->num_rows() > 0) {
           return $query->result_array();
        }
    }

	
}

/* End of file list_user_model.php */
