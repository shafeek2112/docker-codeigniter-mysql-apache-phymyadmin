<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
	
    public function get_staff_count() {
		
		$this->db->from('users');
		$this->db->where_not_in('users.user_roll_id',array('1','4'));
		//$this->db->where_in('active',array(2,1));
		return $this->db->count_all_results();
    }


    public function get_student_list_count($status)
	{
		$this->db->from('student');
		$this->db->where('status',$status);
		
        return $this -> db -> count_all_results();
	}
	public function get_makeupclass_request_count()
	{
		$this->db->from('makeup_class');
		$this->db->where('status',0);
		
        return $this -> db -> count_all_results();
	}


    public function get_equipment_request_count()
    {
        $this->db->from('tutor_request_equipment');
        $this->db->where('status',1);
        
        return $this -> db -> count_all_results();
    }

	public function get_request_for_class_change_count()
	{
        $status = array('1','2','3');
		$this->db->select('stu_course.*,student.name as student_name',FALSE);
        $this->db->from('stu_course');
        $this->db->join('student', 'student.id = stu_course.stu_id','left');
        $this->db->where_in('stu_course.transfer_status',$status);
        $this->db->group_by('stu_course.id');
		
        return $this->db->get() -> result_array();
	}
	public function get_leave_request_count()
	{
		$this->db->select('tutor_leave_apply.*,tutor.name,tutor.email,leave_type.name as leave_type_name');
		$this->db->from('tutor_leave_apply');
        $this->db->join('tutor','tutor.id = tutor_leave_apply.tutor_id','left');
        $this->db->join('leave_type','leave_type.id = tutor_leave_apply.leave_type','left');
		
        return $this -> db -> count_all_results();
	}
    public function get_fees_by_month($start_date,$end_date){
        $query = "Select IFNULL(sum(amount),0) as receipt_amount 
                  from receipt
                  where pay_date >= '$start_date' and pay_date <= '$end_date'
                  and pay_status = 1";
        return $this -> db -> query($query) -> row_array();          
    }


	public function get_job_reject_trainer_count()
	{
		$this->db->select('tjs.*,',FALSE);
        $this->db->from('trainer_job_status_detail tjs');
        $this->db->where('tjs.status','reject_requested');
        return $this -> db -> count_all_results();
	}
	public function get_student_application_count($status)
	{
		/*$this->db->from('stu_course');
		$this->db->where('status',$status);*/


        $query = "SELECT  * FROM ( 
                SELECT `student`.*, `race`.`name` as `race_name`,`countries`.`nationality` as `nationality_name`, `uc`.`first_name` AS `created_bys`, `ud`.`first_name` AS `updated_bys`, `corporate`.`company_name` as `corporate_company_name`, `cs`.`intake_no`, `company`.`company_name`, `sc`.`id` as `stu_course_id`, `sc`.`long_schedule_id`,`cs`.`id` as `course_schedule_id`,`corporate`.`agent_id`
                FROM `student`
                LEFT JOIN `corporate` ON `corporate`.`id` = `student`.`corporate_id`
                LEFT JOIN `company` ON `company`.`id` = `student`.`company_id`
                LEFT JOIN `stu_course` `sc` ON `sc`.`stu_id` = `student`.`id`
                LEFT JOIN `course_schedule` `cs` ON `cs`.`id` = `sc`.`schedule_id`
                LEFT JOIN `users` as `uc` ON `student`.`created_by` = `uc`.`user_id`
                LEFT JOIN `users` as `ud` ON `student`.`updated_by` = `ud`.`user_id`
                LEFT JOIN `race` ON `student`.`race` = `race`.`id`
                LEFT JOIN `countries` ON `student`.`citizen` = `countries`.`id`
                WHERE `sc`.`long_schedule_id`= 0 AND `sc`.`long_schedule_id` IS NOT NULL";

                if($status == '3')
                {
                    $query.= " AND `sc`.`status` = 3";

                }
                else if($status == 0)
                {

                    $query.= " AND `sc`.`status` = 0";
                }

                if($status != 0)
                {
                    $query.= " GROUP BY `student`.`id`";
                }

               $query.= " UNION SELECT `student`.*, `race`.`name` as `race_name`,`countries`.`nationality` as `nationality_name`, `uc`.`first_name` AS `created_bys`, `ud`.`first_name` AS `updated_bys`, `corporate`.`company_name` as `corporate_company_name`, `cs`.`intake_no`, `company`.`company_name`, `sc`.`id` as `stu_course_id`, `sc`.`long_schedule_id`,`cs`.`id` as `course_schedule_id`,`corporate`.`agent_id`
                FROM `student`
                LEFT JOIN `corporate` ON `corporate`.`id` = `student`.`corporate_id`
                LEFT JOIN `company` ON `company`.`id` = `student`.`company_id`
                LEFT JOIN `stu_course` `sc` ON `sc`.`stu_id` = `student`.`id`
                LEFT JOIN `course_schedule` `cs` ON `cs`.`id` = `sc`.`schedule_id`
                LEFT JOIN `users` as `uc` ON `student`.`created_by` = `uc`.`user_id`
                LEFT JOIN `users` as `ud` ON `student`.`updated_by` = `ud`.`user_id`
                LEFT JOIN `race` ON `student`.`race` = `race`.`id`
                LEFT JOIN `countries` ON `student`.`citizen` = `countries`.`id` WHERE student.id != '' AND `sc`.`long_schedule_id` > 0 ";

                if($status == '3')
                {
                   
                    $query.= " AND `sc`.`status` = 3";

                }
                else if($status == 0)
                {
                    
                    $query.= " AND `sc`.`status`= 0";
                }

                if($status != 0)
                {
                    
                    $query.= " GROUP BY `student`.`id`";
                }
                else
                {
                    $query.= " GROUP BY `sc`.`stu_id`,`sc`.`long_schedule_id`";
                }

        $query.= " ) AS sdata ";
        if($status != 0)
        {
            $query.= "  GROUP BY sdata.id";
        }
        //echo $query; exit();
		$query = $this ->db-> query($query);
        /*echo $this->db->last_query();
        exit;*/
    	if($query->num_rows() > 0) {
    		return $query->num_rows();
    	}
	}
	
	public function get_users_count($role,$except=0) 
	{
		$this->db->select('gender,count(*) AS cnt',FALSE);
		$this->db->from('users');
		
		if($except == 1)
			$this->db->where_not_in('users.user_roll_id',$role);
		else	
			$this->db->where_in('users.user_roll_id',$role);
			
		$this->db->group_by('gender');
		
		$query = $this->db->get();
    	if($query->num_rows() > 0) 
    	{
    		return $query;
    	}
    }

    // public function get_dashboard_box($user_role) 
	// {
	// 	$this->db->select('user_roll_template.*,dashboard_count_box.key',FALSE);
	// 	$this->db->from('user_roll_template');
	// 	$this->db->where('user_roll_template.role_id',$user_role);
	// 	$this->db->where('user_roll_template.status','A');
	// 	$this->db->join('dashboard_count_box','dashboard_count_box.id = user_roll_template.box_id','left');
	// 	$this->db->order_by('user_roll_template.display_order');

	// 	$query = $this->db->get();
    // 	if($query->num_rows() > 0) 
    // 	{
    // 		return $query;
    // 	}
    // }
	
	public function new_users($role) 
    {
		$this->db->select('users.user_id,CONCAT_WS(" ",users.first_name,users.middle_name,users.last_name) AS full_name,users.gender,created_date',FALSE);
		//$this->db->join('school_campus','users.campus_id=school_campus.campus_id','left');
		//$this->db->where_in('active',array(1,2));
		$this->db->where_in('users.user_roll_id',$role);
		$this->db->order_by('users.created_date', 'desc');
		$this->db->limit(7, 0);
		$this->db->from('users');
		
		$query = $this->db->get();
    	if($query->num_rows() > 0) {
    		return $query;
    	}
		
	}

	public function get_fee_by_month($start_date,$end_date){
		$query = "Select IFNULL(sum(amount),0) as receipt_amount 
				  from receipt
				  where pay_date >= '$start_date' and pay_date <= '$end_date'
				  and pay_status = 1";
		return $this -> db -> query($query) -> row_array();		  
	}

	public function get_total_course_receipt_amount($course_id){
		 $query = "Select IFNULL(sum(r.amount),0) as receipt_amount
					from receipt r
					left join invoice i on i.id = r.inv_id
					left join course_schedule cs on cs.id = i.schedule_id
					where cs.course_id = $course_id
					and pay_status = 1";/*exit();*/
		
		return $this -> db -> query($query) -> row_array();		
	}

	public function get_unbill_report_count(){ 

        $this->db->select('cs.intake_no,min(cst.date) as start, max(cst.date) as end,s.name,cor.company_name,s.email,s.mobile,s.register_date');
        $this->db->from('stu_course sc');
        $this->db->join('course_schedule cs','cs.id = sc.schedule_id');
        $this->db->join('course_schedule_detail cst','cs.id = cst.course_schedule_id','left');
        $this->db->join('student s','s.id = sc.stu_id');
        $this->db->join('corporate cor','cor.id = s.corporate_id','left');
        $this->db->where('sc.status',1);
        $this->db->where('s.status',1);
        $this->db->where('sc.id NOT IN (SELECT ivs.stu_course_id FROM invoice_student ivs)');
        
       

        $this -> db -> group_by('sc.id');
        $this -> db -> order_by('sc.id','desc');

       /* if($limit > 0)
        {
            $this->db->limit($limit, $offset);
        }
        
        $query = $this->db->get();

        if($limit == 0 )
        {
           return  $query->num_rows();
        }

        return $query->result_array();*/

         return $this -> db -> count_all_results();
    }
	



}

/* End of file home_model.php */
