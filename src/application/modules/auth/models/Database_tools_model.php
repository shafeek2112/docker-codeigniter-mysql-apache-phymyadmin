<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
     *
     * Database_tools_model: contains generic functions, used in several controllers
     *
     */

class Database_tools_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     *
     * get_data_by_email: get member data by e-mail address
     *
     * @param string $email the e-mail address to be verified with
     * @return mixed
     *
     */

    public function get_data_by_email($email) {

        $this->db->select('user_id, username, nonce, status,first_name');
        $this->db->from('users');
        $this->db->where('username', $email);
        $this->db->or_where('email', $email);
        $this->db->limit(1);

        $query = $this->db->get();

        if($query->num_rows() == 1) {
            $row = $query->row();
            return array('id' => $row->user_id, 'username' => $row->username, 'nonce' => $row->nonce, 'status' => $row->status,'first_name'=>$row->first_name);
        }
        return "";
    }


    public function get_data_by_teacher_email($email) {

        $this->db->select('id, email, nonce');
        $this->db->from('teacher');
        $this->db->where('email', $email);
        //$this->db->or_where('email', $email);
        $this->db->limit(1);

        $query = $this->db->get();

        if($query->num_rows() == 1) {
            $row = $query->row();
            return array('id' => $row->id, 'email' => $row->email, 'nonce' => $row->nonce);
        }
        return "";
    }



    public function get_data_by_client_email($email) {

        $this->db->select('id, email, nonce,type,status');
        $this->db->from('portal_user');
        $this->db->where('email', $email);
        //$this->db->or_where('email', $email);
        $this->db->limit(1);

        $query = $this->db->get();

        if($query->num_rows() == 1) {
            $row = $query->row();
            return array('id' => $row->id, 'email' => $row->email, 'nonce' => $row->nonce,'type' => $row->type,'status'=> $row->status);
        }
        return "";
    }

}

/* End of file database_tools_model.php */
/* Location: ./application/models/database_tools_model.php */