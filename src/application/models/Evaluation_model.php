<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Evaluation_model extends CI_Model 
{
    public function __construct() 
    {
        parent::__construct();
    }
	
	public function get_data_for_pre_evaluation($schedule_id,$student_id){
		$query = "Select sc.*, s.name , c.course_title ,max(cst.date) as last_date, min(cst.date) as first_date, s.id as student_id, cs.language_id , s.nric , l.language , cs.intake_no,
					v.area ,GROUP_CONCAT(DISTINCT t.name) as trainner, c.id as course_id,GROUP_CONCAT(DISTINCT t1.name) as trainner2
				  from stu_course sc 
				  left join student s on s.id = sc.stu_id
				  left join course_schedule cs on cs.id = sc.schedule_id
				  left join course c on c.id = cs.course_id
				  left join course_schedule_detail cst on cst.course_schedule_id = cs.id
				  left join language l on l.id = cs.language_id
				  left join tutor t on t.id = cst.trainer_id
				  left join tutor t1 on t1.id = cst.asst_trainer_id
				  left join venue v on v.id = cs.venue_id
				  where cs.id = $schedule_id
				  and s.id = $student_id";
		return $this -> db -> query($query) -> row_array();		  
	}
	//////////////

    public function get_evaluation_type_list()
	{
		//Students details who taking up this course and the answers if they already answered.
		$this->db->select("*");
		$this->db->from("evaluation_type");
		// $this->db->where("e.id",$id);
		return $this->db->get()->result_array();
	}

	public function get_course_list_by_evaluation($type){
		$this -> db -> select('c.id,c.course_title,c.course_code,e.type,e.id as e_herder_id')
					-> from('evaluation e')
					-> join('course c','c.id = e.course_id','left')
					-> where('e.type',$type)
					-> group_by('e.course_id')
					-> order_by('c.id', 'asc');
		return $this -> db -> get() -> result_array();			
	}

	public function get_language_by_course($course_id){
		$this -> db -> select('e.id,l.language')
					-> from('evaluation e')
					-> join('language l','l.id = e.lang_id','left')
					-> where('e.course_id',$course_id)
					-> order_by('e.lang_id','asc');
		return $this -> db -> get() -> result_array();			
	}
	public function get_language_by_evaluation($id){
		$this -> db -> select('e.*,l.language')
					-> from('evaluation e')
					-> join('language l','l.id = e.lang_id','left')
					-> where('e.type',$id)
					-> order_by('e.lang_id','asc');
		return $this -> db -> get() -> result_array();	
	}

	public function get_evaluation_list($limit = 0, $offset = 0, $order_by = "id", $sort_order = "desc", $search_data)
	{
		$this->session->set_userdata('evalution_export_var', $search_data);
		$this->db->select("e.*,co.company_name,c.course_title,u1.username as c_users,u2.username as u_users");
        $this->db->from('evaluation as e');
        $this->db->join('course c','c.id = e.course_id','left');
        $this->db->join('company co','co.id = e.company_id','left');
		$this->db->join('users u1','u1.user_id = e.created_by','left');
		$this->db->join('users u2','u2.user_id = e.updated_by','left');

		//Search data.
		if(!empty($search_data['company_id']))
		{
			$this -> db -> like('e.company_id', $search_data['company_id']);
		}
        if(!empty($search_data['course_id']))
		{
			$this -> db -> like('e.course_id', $search_data['course_id']);
		}
		
		if($order_by != "")
			$this->db->order_by($order_by, $sort_order);
		
		if($limit > 0)
			$this->db->limit($limit, $offset);
    
		$query = $this->db->get();
		// echo $this->db->last_query();die;
		if($limit == 0)
			return $query->num_rows();
			
    	if($query->num_rows() > 0) {
    		return $query;
    	}
	}

	public function get_evaluation($id,$student_id = 1,$include_answer = 'no')
	{
		//Get evaluation records
		$this->db->select("*");
		$this->db->from("evaluation e");
		$this->db->where("id", $id);
		$return['rowdata'] = $this->db->get()->row_array();
		$centerId = $return['rowdata']['company_id'];

		$coursedetails = get_data_from_table('course',array('id'=>$return['rowdata']['course_id']),'','','course_title');
		$return['rowdata']['course_name'] = $coursedetails['course_title'];

		$companydetails = get_data_from_table('company',array('id'=>$return['rowdata']['company_id']),'','','company_name');
		$return['rowdata']['company_name'] = $companydetails['company_name'];

		
		$question_array = $this->get_question_array($id,$student_id,$include_answer);
		$return['rowdata']['evaluationtype'] = $question_array['rowdata'];
		if(empty($question_array['evaluation_form_id']))
		{
			$this->db->select("id");
			$this->db->from("evaluation_form");
			$this->db->where('evaluation_id',$id);
			$this->db->where('student_id',$student_id);
			$query = $this->db->get();
			$return['rowdata']['evaluation_form_id'] = $query->row_array()['id'];
		}
		else
		{
			$return['rowdata']['evaluation_form_id'] = !empty($question_array['evaluation_form_id']) ? $question_array['evaluation_form_id'] : '';
		}

		return $return;
	}

	public function get_question_array($id,$student_id,$include_answer)
	{
		//Get evaluationtype records
		$this->db->select("id,type type_name");
		$this->db->from("evaluation_type");
		$this->db->where("id", $id);
		$query = $this->db->get();
		// $return['rowdata']['evaluationtype'] = $query->result_array();
		$return['rowdata'] = $query->result_array();
		foreach($return['rowdata'] as $key => $vall)
		{

			//Get evaluationtype questions records
			$this->db->select("id,evaluation_type_id,questions");
			$this->db->from("evaluation_questions");
			$this->db->where("evaluation_type_id", $vall['id']);
			$query =$this->db->get();
			$return['rowdata'][$key]['question_array'] = $query->result_array();

			/* 
			* Below condition is when this function is called for showing data in web form view.
			* That time we need to fetch the anwsers already submitted by user/admin.
			* This is for editing form score.
			* if $include_answer == 'yes' means need to send the answers.
			*/
			if($include_answer == 'yes')
			{
				foreach($return['rowdata'][$key]['question_array'] as $qakey => $qusval) 
				{
					//Get anwser for this question.
					$this->db->select("es.score,ef.id");
					$this->db->from("evaluation_form_score es");
					$this->db->join('evaluation_form as ef','ef.id = es.evaluation_form_id','left');
					$this->db->where('ef.evaluation_id',$id);
					$this->db->where('ef.student_id',$student_id);
					$this->db->where('es.evaluation_question_id', $qusval['id']);
					$query = $this->db->get();
					$return['rowdata'][$key]['question_array'][$qakey]['answer'] = $query->row_array()['score'];
					$return['evaluation_form_id'] = $query->row_array()['id'];
				}
			}
		}

		return $return;
	}

	public function add_evaluation($data)
	{
		$evaluationdata['company_id'] 			= $data['post_data']['company_id'];
		$evaluationdata['course_id'] 			= $data['post_data']['course_id'];
		$evaluationdata['start_date'] 			= $data['post_data']['start_date'];
		$evaluationdata['end_date'] 			= $data['post_data']['end_date'];
		$evaluationdata['status'] 				= $data['post_data']['status'];

		if(empty($data['id']))
		{
			$evaluationdata['created_date'] = date("Y-m-d H:i:s");
			$evaluationdata['created_by'] = $this->session->userdata('user_id');
			$this->db->insert('evaluation', $evaluationdata);
			$evaluationid = $this->db->insert_id();
		}
		else
		{
			$evaluationdata['updated_date'] = date("Y-m-d H:i:s");
			$evaluationdata['updated_by'] = $this->session->userdata('user_id');
			$this->db->where('id',$data['id']);
			$this->db->update('evaluation', $evaluationdata);
			$evaluationid = $data['id'];
		}

		if($evaluationid)
		{
			//Insert record into evaluation_type table.
			$evaluationType['evaluation_id'] = $evaluationid;
			foreach($data['post_data']['title'] as $key => $val)
			{
				if(!empty($val))
				{
					$evaluationType['type_name'] = $val;
					if(!empty($data['post_data']['content_id'][$key]))
					{
						$evaluationType['created_date'] = date("Y-m-d H:i:s");
						$evaluationtypeid = $data['post_data']['content_id'][$key];
						$this->db->where('id',$evaluationtypeid);
						$this->db->update('evaluation_type', $evaluationType);
					}
					else
					{
						$this->db->insert('evaluation_type', $evaluationType);
						$evaluationtypeid = $this->db->insert_id();
					}

					//Insert Questions
					if(count($data['post_data']['title_'.$data['post_data']['content_no'][$key]]) > 0)
					{
						$question['evaluation_type_id'] = $evaluationtypeid;
						foreach($data['post_data']['title_'.$data['post_data']['content_no'][$key]] as $queskey => $quesval)
						{
							$question['questions'] = $quesval;
							if(!empty($data['post_data']['sub_id_'.$data['post_data']['content_no'][$key]][$queskey]))
							{
								$question['created_date'] = date("Y-m-d H:i:s");
								$this->db->where('id',$data['post_data']['sub_id_'.$data['post_data']['content_no'][$key]][$queskey]);
								$this->db->update('evaluation_questions', $question);
							}
							else
							{
								$this->db->insert('evaluation_questions', $question);
							}
						}
					}
					else
					{
						$this->db->where('evaluation_type_id',$evaluationtypeid);
						$this->db->delete('evaluation_questions');
					}
				}
			}
			return $evaluationid;
		}
		
	}

	public function delete($id,$type)
	{
		if($type == 'type')
		{
			$this->db->where('id',$id);
			$this->db->delete('evaluation_type');
			//delete questions for this type.
			$this->db->where('evaluation_type_id',$id);
			$this->db->delete('evaluation_questions');
		}
		elseif($type == 'question')
		{
			$this->db->where('id',$id);
			$this->db->delete('evaluation_questions');
		}
	}

	public function checkdate($data)
	{

		$this->db->select('id');
		$this->db->from('evaluation');
		$extrawhere = (!empty($data['id']) ? ' AND id NOT IN ('.$data['id'].') ' : '');
		$where = "  course_id = '".$data['course_id']."' AND 
					( 
						( start_date <= '".$data['start_date']."' AND end_date >= '".$data['start_date']."' ) 
						OR ( start_date <= '".$data['end_date']."' AND end_date >= '".$data['end_date']."' ) 
					) ".$extrawhere;
		$this->db->where($where);
		$query = $this->db->get();
		// echo $this->db->last_query();
		// exit;
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		} else {
			return 0;
		}
		
	}

	/*
    *   This function is for fetching all the data regarding to show reports.
    *   @param int $id
    */
	public function get_evaluation_form_student_list($id)
	{
		//Students details who taking up this course and the answers if they already answered.
		$this->db->select("s.*");
		$this->db->from("student s");
		$this->db->join("stu_course sc","sc.stu_id = s.id");
		$this->db->join("course_schedule cs","cs.id = sc.schedule_id", "inner");
		$this->db->join("course c","c.id = cs.course_id", "inner");
		$this->db->join("evaluation e","e.course_id = c.id", "inner");
		$this->db->where("e.id",$id);
		// $this->db->get();
		// echo $this->db->last_query();
		return $this->db->get()->result_array();
	}

	/* 
	* Check student already did evaluation or not.
	*/
	public function check_evaluation($evaluation_id, $student_id)
	{
		$query = $this->db->query('SELECT id FROM evaluation_form WHERE evaluation_id="'.$evaluation_id.'" AND student_id = "'.$student_id.'"' );
		return $query->num_rows();
	}

	/* 
	* Get total answer count for each question.
	*/
	public function total_answer_count($id)
	{
		//Get total answer count for each question.
		$query = " SELECT evaluation_question_id,
						SUM(IF(score = 1,1,0)) as one,
						SUM(IF(score = 2,1,0)) as two,
						SUM(IF(score = 3,1,0)) as three,
						SUM(IF(score = 4,1,0)) as four,
						SUM(IF(score = 5,1,0)) as five
					FROM evaluation_form ef 
					INNER JOIN evaluation_form_score es ON es.evaluation_form_id = ef.id 
					WHERE ef.evaluation_id = '$id'
					GROUP BY evaluation_question_id ";
		$qresu = $this->db->query($query);
		return $qresu->result_array();
	}
	
	public function get_student_list_by_schedule_id($schedule_id){
		$query = "Select s.corporate_id,s.mobile,s.id,s.name,s.nric,s.id_type,s.dob,sc.schedule_id,cst.am_start_time,cst.pm_start_time,c.company_name, cst.am_start_time as class_am_time, cst.pm_start_time as class_pm_time,s.photo,s.nric_front,s.nrci_back,min(cst.date) as start_date,max(cst.date) as end_date, cs.course_id
				 	from stu_course sc
			 	 	join student s on s.id = sc.stu_id
				 	left join corporate c on c.id = s.corporate_id
				 	left join company cc on cc.id = s.company_id
				 	left join course_schedule cs on cs.id = sc.schedule_id
				 	left join course_schedule_detail cst on cst.course_schedule_id = sc.schedule_id

				 	where sc.schedule_id = $schedule_id
				 	and sc.status = 1 
				 	and s.status = 1
				 	group by s.id
				 	order by s.name asc";

		return $this -> db -> query($query) -> result_array();			
	}
	public function get_progress_report_form($student_id = 0,$course_id=0)
	{
		$this->db->select("*");
		$this->db->from("evaluation e");
		$this->db->where("course_id", $course_id);
		$return['rowdata'] = $this->db->get()->row_array();
		$return['rowdata']['company_id'] = 1;
		$centerId = $return['rowdata']['company_id'];
		$eva_id = $return['rowdata']['id'];

		$coursedetails = get_data_from_table('course',array('id'=>$return['rowdata']['course_id']),'','','course_title');
		$return['rowdata']['course_name'] = $coursedetails['course_title'];

		$companydetails = get_data_from_table('company',array('id'=>$return['rowdata']['company_id']),'','','company_name');
		$return['rowdata']['company_name'] = $companydetails['company_name'];

		
		$question_array = $this->get_question_array($eva_id,$student_id,$include_answer = 'yes');
		// print_r($question_array);
  //               exit;

		$return['rowdata']['evaluationtype'] = $question_array['rowdata'];
		if(empty($question_array['evaluation_form_id']))
		{
			$this->db->select("id");
			$this->db->from("evaluation_form");
			$this->db->where('evaluation_id',$eva_id);
			$this->db->where('student_id',$student_id);
			$query = $this->db->get();
			$return['rowdata']['evaluation_form_id'] = $query->row_array()['id'];
		}
		else
		{
			$return['rowdata']['evaluation_form_id'] = !empty($question_array['evaluation_form_id']) ? $question_array['evaluation_form_id'] : '';
		}

		return $return;
	}
	
	public function get_student_data($id,$corporate_id){

		$this->db->select("cs.*, s.id as stu_id,course.course_title ,s.name ,l.language ,c.company_name ,co.company_name as comp_name,co.email");
		$this->db->from("student s");
		$this->db->join("corporate c","c.id = s.corporate_id", "left");
		$this->db->join("stu_course sc","sc.stu_id = s.id", "left");
		$this->db->join("course_schedule cs","cs.id = sc.schedule_id", "left");
		$this->db->join("course","course.id = cs.course_id", "left");
		$this->db->join("company co","co.id = s.company_id", "left");
		$this->db->join("language l","l.id = cs.language_id", "left");
		$this->db->where("s.id",$id);

		return $this->db->get()->row();
	}

	public function get_evaluations($course_id){

		$today = date('Y-m-d');
		$this->db->select("e.*");
		$this->db->from("evaluation e");
		$this->db->where("e.course_id", $course_id);
		//$this->db->where("e.start_date <=", $today);
		//$this->db->where("e.end_date >=", $today);
	
		return $this->db->get()->row();
	}
	//////////////
	public function get_evaluation_header($schedule_id){
		$query = "Select c.course_title, max(date) as last_date, min(date) as first_date, l.language as lang, cs.id as course_shcedule_id, c.id as course_id,l.id as lang_id, cs.intake_no, v.area,GROUP_CONCAT(DISTINCT t.name) as trainner
		            ,GROUP_CONCAT(DISTINCT t1.name) as trainner2
				  from course_schedule cs
				  left join course c on c.id = cs.course_id
				  left join course_schedule_detail cst on cst.course_schedule_id = cs.id
				  left join language l on l.id = cs.language_id
				  left join tutor t on t.id = cst.trainer_id
				  left join tutor t1 on t1.id = cst.asst_trainer_id
				  left join venue v on v.id = cs.venue_id
				  where cs.id = $schedule_id
				  group by cs.id";
		return $this -> db -> query($query) -> row_array();		  
	}
	public function get_evaluation_form_header($schedule_id,$type){
		$query = "Select s.id as student_id , sc.schedule_id as schedule_id,s.name ,s.nric , IFNULL((Select feh.id from form_evaluation_header feh where feh.student_id = s.id and evaluation_type = $type and feh.schedule_id = sc.schedule_id group by feh.id limit 0,1),0) as feh_id
					from stu_course sc
					left join student s on s.id = sc.stu_id
					where sc.schedule_id = $schedule_id and sc.status = 1
					group by sc.stu_id
					order by s.name ";
		return $this -> db -> query($query) -> result_array();			
	}
	
	public function get_evaluation_detail_by_type($type,$lang_id,$course_id){
		$query = "Select ed.*, e.lang_id, e.type
				  from evaluation_detail ed
				  left join evaluation e on e.id = ed.header_id
				  where e.type = $type ";
		if($type == 1){
			$query .= " and e.lang_id = $lang_id
				  and e.course_id = $course_id ";
		}	
		$query .= " order by ed.id asc";
		return $this -> db -> query($query) -> result_array();		  
	}
	public function get_evaluation_count_by_question($detail_id,$status,$schedule_id,$type){
		$query = "Select count(fed.id) as result 
				from form_evaluation_detail fed
				left join form_evaluation_header feh on feh.id = fed.header_id
				where fed.evaluation_detail_id = $detail_id 
				and fed.status = $status
				and feh.evaluation_type = $type
				and feh.schedule_id = $schedule_id";
		return $this -> db -> query($query) -> row_array();
	}
	public function get_evalution_detail($header_id,$schedule_id,$type){
		$query = "Select fed.*,ed.question
				  from form_evaluation_detail fed 
				  left join form_evaluation_header feh on feh.id = fed.header_id
				  left join evaluation_detail ed on ed.id = fed.evaluation_detail_id
				  where fed.header_id = $header_id
				  and feh.evaluation_type = $type
				and feh.schedule_id = $schedule_id";
		return $this -> db -> query($query) -> result_array();		  
	}
	public function get_no_of_student_by_schedule($schedule_id){
		$query = "Select count(*) as count
					from stu_course ssc 
					where ssc.schedule_id = $schedule_id
					and ssc.status = 1
					group by ssc.schedule_id";
		return $this -> db -> query($query) -> row_array();
	}
	public function get_no_of_response($schedule_id,$type){
		$query ="Select count('e.id') as count 
					from form_evaluation_header e
					left join stu_course ssc on ssc.schedule_id = e.schedule_id
					where e.schedule_id = $schedule_id and e.evaluation_type = $type
					and ssc.status = 1
					group by e.id
					";
		return $this -> db -> query($query) -> row_array();
	}
	
	public function get_student_evaluation_header($type,$student_id,$schedule_id){
		$query = "Select feh.*,s.name , c.company_name
					from form_evaluation_header feh
					left join student s on s.id = feh.student_id
					left join corporate c on c.id = s.corporate_id
					where feh.student_id =  $student_id and feh.schedule_id = $schedule_id
					and feh.evaluation_type = $type";
		return $this -> db -> query($query) -> row_array();			
	}
	public function get_pre_evaluation_for_edit($evaluation_detail_id,$student_id,$schedule_id,$type){
		$query = "Select fed.*
					from form_evaluation_detail fed
					left join form_evaluation_header feh on feh.id = fed.header_id
					where fed.evaluation_detail_id = $evaluation_detail_id 
					and feh.student_id =  $student_id and feh.schedule_id = $schedule_id
					and feh.evaluation_type = $type";
		return $this -> db -> query($query) -> row_array();			
	}
	public function get_pre_post_evaluation_result($type,$language_id,$course_id,$student_id,$ed_id,$schedule_id)
	{
		$query = "Select ed.id,ffeh.schedule_id,
						IFNULL((Select fed.status from form_evaluation_detail fed left join form_evaluation_header feh on feh.id = fed.header_id where feh.student_id = ffeh.student_id and fed.evaluation_detail_id = $ed_id and feh.evaluation_type = $type group by feh.student_id),0) as result
						from evaluation_detail ed 
						left join evaluation e on e.id = ed.header_id 
						left join form_evaluation_detail ffed on ffed.evaluation_detail_id = ed.id
						left join form_evaluation_header ffeh on ffeh.id = ffed.header_id
						where e.type = 1 
						and e.lang_id = $language_id 
						and e.course_id = $course_id 
						and ed.id = $ed_id
						and ffeh.schedule_id = $schedule_id
						group by ffeh.student_id";
		return $this -> db -> query($query) -> result_array();		  				
	}
	public function get_student_by_id($student_id) {
		
		$query = "Select s.*,c.company_name
					from student s
					left join corporate c on c.id = s.corporate_id
					where s.id = $student_id ";
		return $this -> db -> query($query) -> row_array();	
	}
	public function get_evaluation_sub_by_type_language($type,$lang_id){
		$query = "Select l.language,e.*
				  from evaluation e
				  left join language l on l.id = e.lang_id
				  where e.sub_type = $type
				  and l.id = $lang_id
				  order by l.language";
		return $this -> db -> query($query) -> result_array();		  			
	}
	public function get_evaluation_sub_count_by_question($detail_id,$status,$schedule_id,$type,$trainee_type=0){
		$query = "Select count(fed.id) as result 
				from form_evaluation_detail fed
				left join form_evaluation_header feh on feh.id = fed.header_id
				where fed.evaluation_detail_id  = $detail_id 
				and fed.status = $status
				and feh.evaluation_type = $type
				and feh.schedule_id = $schedule_id";
				if(!empty($trainee_type) && $trainee_type == 5):
				$query .= " and feh.e_radio = 1";		
				endif;
		return $this -> db -> query($query) -> row_array();
	}
	public function get_evalution_sub_detail_report($id,$sub_type,$schedule_id,$type){
		$query = "Select fed.*,esd.question,feh.e_radio
					from form_evaluation_detail fed
					left join form_evaluation_header feh on feh.id = fed.header_id
					left join evaluation_detail esd on esd.id = fed.evaluation_detail_id
					left join evaluation es on es.id = esd.header_id
					where es.sub_type = $sub_type
					and feh.id = $id
					and feh.evaluation_type = $type and feh.schedule_id = $schedule_id";
		return $this -> db -> query($query) -> result_array();
	}
	public function get_evalution_sub_detail($id,$student_id,$schedule_id,$type){
		$query = "Select fed.*
					from form_evaluation_detail fed
					left join form_evaluation_header feh on feh.id = fed.header_id
					where fed.evaluation_detail_id = $id 
					and feh.student_id =  $student_id and feh.schedule_id = $schedule_id
					and feh.evaluation_type = $type";
		return $this -> db -> query($query) -> row_array();		  
	}
	public function get_evaluation_by_question_34($detail_id,$schedule_id,$type,$status){
		$query = "Select count(fed.id) as result 
				from form_evaluation_detail fed
				left join form_evaluation_header feh on feh.id = fed.header_id
				where fed.evaluation_detail_id = $detail_id 
				and feh.evaluation_type = $type
				and feh.schedule_id = $schedule_id
				and fed.status = $status";
		return $this -> db -> query($query) -> row_array();
	}
	public function get_evaluation_form_header_supervisor($schedule_id,$type){
		$query = "Select s.id as student_id , sc.schedule_id as schedule_id,s.name ,s.nric , IFNULL((Select feh.id from form_evaluation_header feh where feh.student_id = s.id and evaluation_type = $type and feh.schedule_id = sc.schedule_id group by feh.id limit 0,1),0) as feh_id,
			 		c.contact_person, c.company_name
					from stu_course sc
					left join student s on s.id = sc.stu_id
					left join corporate c on c.id = s.corporate_id
					where sc.schedule_id = $schedule_id and sc.status = 1
					and s.corporate_id != 0
					order by s.name ";
		return $this -> db -> query($query) -> result_array();			
	}
}

?>