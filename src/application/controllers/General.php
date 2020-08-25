<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class General extends Private_Controller {

    public function __construct() {
        parent::__construct();
		// $this->load->helper(array('form','invoice_helper'));
        $this->load->library('form_validation');
        $this->load->helper('general_function');
    }

    public function index() {
        redirect('home');
    }

    public function delete() {

        $table = $this->input->get('table');
        $where_col = $this->input->get('where_col');
        $where_col_id = $this->input->get('where_col_id');
        $table2 = $this->input->get('table1');
        $where_col2 = $this->input->get('where_col1');

        if ($where_col_id != '' && $where_col_id != 0) {

            $result = get_data_from_table($table,array($where_col => $where_col_id));
            save_or_update_system_log('',$table,serialize($result),'','Delete','','');
            echo grid_delete($table, $where_col, $where_col_id);

        }

       
        return;
    }

    public function preset_date_format()
    {
        $preset_date_format = preset_date_format();
        $result = array();
        $no = 0;
        foreach ($preset_date_format as $key => $value) {
            $result[$no]['id'] = $key;
            $result[$no]['value'] = $value["display"]." (Ex: ".$value["example"].")";
            $no++;
        }

        echo json_encode($result);
    }

    public function GetAgeByDOB()
    {
        $age = "";
        $dob = $this->input->get('dob');
        if(!empty($dob))
        {
            $age = get_age(date('Y-m-d',strtotime($dob)));
        }
        
        echo $age;
    }


    public function delete2() {
       
        $table = $this->input->get('table');
        $where_col = $this->input->get('wher_column_name');
        $where_id = $this->input->get('where_id');
        $delete_count = count($table);

        for ($i=0; $i < $delete_count ; $i++) {
           grid_delete($table[$i], $where_col[$i], $where_id[$i]);
        }
        return ;
    }
}

/* End of file general.php */