<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Language_setting_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->helper('file');
    }

    /**
     *
     * get_members: get the members data
     *
     * @param int $limit db limit (members per page)
     * @param int $offset db offset (current page)
     * @param int $order_by db sort order
     * @param string $sort_order asc or desc
     * @param array $search_data search input
     * @return mixed
     *
     */

    public function get_language_setting($limit = 0, $offset = 0, $order_by = "lang_key_info", $sort_order = "asc", $search_data) {

         $this->session->set_userdata('language_export_var', $search_data);
        if (!empty($search_data)) {
            !empty($search_data['lang_key_info']) ? $data['lang_key_info'] = $search_data['lang_key_info'] : "";
            !empty($search_data['english']) ? $data['english'] = $search_data['english'] : "";
            !empty($search_data['chinese']) ? $data['chinese'] = $search_data['chinese'] : "";
            !empty($search_data['thai']) ? $data['thai'] = $search_data['thai'] : "";    
            !empty($search_data['vietnamese']) ? $data['vietnamese'] = $search_data['vietnamese'] : "";    
            !empty($search_data['filipino']) ? $data['filipino'] = $search_data['filipino'] : "";    
            !empty($search_data['burmese']) ? $data['burmese'] = $search_data['burmese'] : "";    
        }
        $this->db->select('*');
        $this->db->from('language_setting');        
        !empty($data) ? $this->db->or_like($data) : "";
        $this->db->order_by($order_by, $sort_order);
		
		if($limit > 0)
			$this->db->limit($limit, $offset);

        $query = $this->db->get();
		
		if($limit == 0)
			return $query->num_rows();
		
        if($query->num_rows() > 0) {
            return $query;
        }
    }

    public function updatelangfile($my_lang){

        $arr_lan = get_data_from_table_list($table="language_setting",$where=array(),$condition ='id',$order= 'ASC');

        $lang=array();
        $langstr="<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
                /**
                *
                * Created:  2018-11-12 by Manish
                *
                * Description:  ".$my_lang." language file for general views
                *
                */"."\n\n\n";

        foreach ($arr_lan as $key => $value){
			$lang_val = addslashes(trim($value[$my_lang]));
			
            $langstr.= "\$lang['".$value['lang_key']."'] = \"$lang_val\";"."\n";
        }
        write_file('./application/language/'.$my_lang.'/messages_lang.php', $langstr);

    }
    
    public function count_all_language_setting($search_data)
    {
    	if (!empty($search_data)) {
            !empty($search_data['slug']) ? $data['slug'] = $search_data['slug'] : "";
             !empty($search_data['english']) ? $data['english'] = $search_data['english'] : "";
            !empty($search_data['arabic']) ? $data['arabic'] = $search_data['arabic'] : "";
            !empty($search_data['category']) ? $data['category'] = $search_data['category'] : "";    
            
            
        }
        $this->db->select('*');
        $this->db->from('language_setting');        
        !empty($data) ? $this->db->or_like($data) : "";
        
        $query = $this->db->get();
        return $query->num_rows();
		
    }

   
    public function get_language_setting_data_by_id($language_id){
    	$this->db->select('*')->from('language_setting')->where('id', $language_id);
    	$query = $this->db->get();
    	if($query->num_rows() == 1) {
    		$row = $query->row();
    		return $row;
    	}
    	return false;
    }
}

/* End of file list_members_model.php */