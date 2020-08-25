<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->output->enable_profiler(FALSE);
    }

    /**
     *
     * get_profile: get the member pages
     *
     * @return array
     *
     */

   // public function get_profile($user_id) {
    public function get_profile($user_id) {
        $this->db->select('users.*,
                          users.user_id as user_unique_id,
                          user_profile.*,
                          countries.nationality as nationality_name,
                          user_roll.user_roll_name,
                          CONCAT_WS(" ",users.first_name,users.middle_name,users.last_name) as staff_name,
                          CONCAT_WS(" ",user_created.first_name,user_created.middle_name,user_created.last_name) AS created_name
                          ',FALSE);
        $this->db->from('users');
        $this->db->join('user_profile', 'user_profile.user_id = users.user_id','left');
        $this->db->join('users as user_created', 'user_created.user_id = users.created_by','left');
        $this->db->join('countries', 'countries.id = user_profile.nationality','left');
        $this->db->join('user_roll', 'user_roll.user_roll_id = users.user_roll_id','left');
        $this->db->where('users.user_id',$user_id);
        $query = $this->db->get();
        //echo $this->db->last_query();
        
        if($query->num_rows() > 0) {
            return $query->row();
        }
        return false;
    }

      public function get_id_by_parents($student_id) {
    
        $this->db->select('parents.*,student_relation.name as student_relation_name');
        $this->db->from('parents');
        $this->db->join('student_parent','student_parent.parent_id = parents.id');
        $this->db->join('student_relation','student_relation.id = parents.relationship');
        $this->db->where('parents.id',$student_id);
        $query = $this->db->get();
        //echo $this->db->last_query();
        
        if($query->num_rows() > 0) {
          return $query->row();
        }
        
        return false;
  }

  public function get_id_by_student($student_id,$course_id=null) {

    $this->db->select('student.*,center.center_name,countries.id  as country_id,countries.id as nationality_id , countries.nationality as nationality_name  , c1.country as country_name,c1.id as s_countries_id,
              course.course_id as receommended_course, course.course_name AS receommended_course_name',FALSE);
    $this->db->from('student');
        $this->db->join('center','center.center_id = student.center_id');
        $this->db->join('countries','countries.id = student.nationality','left');
    $this->db->join('countries c1','c1.id = student.country_id','left');
    if(empty($course_id))
    {
      $this->db->join('course','course.course_id = student.receommended_course','left');
    }
    else
    {
      $this->db->join('course','course.course_id = '.$course_id,'left');
    }
       
    
    $this->db->where('student.id',$student_id);
    $query = $this->db->get();
    ///echo $this->db->last_query();exit();
      
    if($query->num_rows() > 0) {
        return $query->row();
      }
    
    return false;
  }


  public function clone_parents_information_on_insert_parent($parent_id,$student_id)
  {
    $query = "INSERT INTO student_parent (`id`, `student_id`, `parent_id`) 
          SELECT '', `student_id`, $parent_id FROM releted_student  
          WHERE student_id = $student_id OR releted_student_id = $student_id
          ON DUPLICATE Key Update  create_date = now()";
      $this->db->query($query);
    
  }

  public function get_parents_student_profile($student_id) {
        
      $this->db->select('parents.*,student_relation.name as relation_name');
    $this->db->from('parents');
    $this->db->join('student_relation', 'student_relation.id = parents.relationship','left');
    $this->db->join('student_parent', 'student_parent.parent_id = parents.id','left');
    $this->db->join('student', 'student_parent.student_id = student.id','left');
    $this->db->where('student_id',$student_id);
    

    return $this->db->get()->result_array();
  }

    public function get_center_data($user_id){
        $this->db->select('uc.center_id');
        $this->db->from('users_center uc');
        $this->db->where('uc.user_id', $user_id);
        $this->db->join('users u','u.user_id = uc.user_id','left');
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }

        return false;
    }

    public function get_id_by_center($teacher_id) {

    $this->db->select('teacher_centers_details.*,',FALSE);
      $this->db->from('teacher_centers_details');
  
    $this->db->where('teacher_centers_details.teacher_id',$teacher_id);
    $query = $this->db->get();
    // echo $this->db->last_query();
      
    if($query->num_rows() > 0) {
        return $query->row();
      }
    
    return false;
  }

    /**
     *
     * set_password: update member password
     *
     * @param string $password
     * @return boolean
     *
     */

    public function set_password($password) {
        $this->load->helper('password');
        $new_nonce = md5(uniqid(mt_rand(), true));
        $data = array(
               'password' => hash_password($password, $new_nonce),
               'nonce' => $new_nonce
            );

        $this->db->where('user_id', $this->input->post('user_id'));
        $this->db->update('users', $data);

        if ($this->db->affected_rows() == 1) {
            return true;
        }
        return false;
    }

    public function get_teacher_profile($teacher_id) {

        $this->db->select('teacher.*,',FALSE);
        $this->db->from('teacher');
    
        $this->db->where('teacher.id',$teacher_id);
        $query = $this->db->get();
        //echo $this->db->last_query();
        
        if($query->num_rows() > 0) {
            return $query->row();
        }
        
        return false;
    }



    public function get_parent_profile($parent_id) {

        $this->db->select('parents.*,',FALSE);
        $this->db->from('parents');
    
        $this->db->where('parents.id',$parent_id);
        $query = $this->db->get();
        //echo $this->db->last_query();
        
        if($query->num_rows() > 0) {
            return $query->row();
        }
        
        return false;
    }


    public function get_student_profile($parent_id) {

        $this->db->select('student.*,parents.email',FALSE);
        $this->db->from('student');
       $this->db->join('parents', 'parents.relationship = student.id','left');
        $this->db->where('student.id',$parent_id);
        $query = $this->db->get();
        //echo $this->db->last_query();
        
        if($query->num_rows() > 0) {
            return $query->row();
        }
        
        return false;
    }
    


    
    
	
}   

/* End of file profile_model.php */