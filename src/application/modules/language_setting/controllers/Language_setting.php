<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Language_setting extends Private_Controller {

    public function __construct()
    {
        parent::__construct();
        // pre-load
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('language_setting_model');
        $this->load->helper('general_function');
		$this->load->library('export');
        $this->load->library('excel');
        $this->load->library('unzip');
    }

    public function index() {
        
        $content_data = array();
        // set layout data
        $this->template->set_theme(Settings_model::$db_config['default_theme']);
        $this->template->set_layout('school');
        
        $this->template->title('Language Setting');
        $this->template->set_partial('header', 'header');
        $this->template->set_partial('sidebar', 'sidebar');
        $this->template->set_partial('footer', 'footer');
        $this->template->build('language_setting', $content_data);
    }
    
    public function index_json() {
    	/* Array of database columns which should be read and sent back to DataTables. Use a space where
    	 * you want to insert a non-database field (for example a counter or static image)
    	*/
    	$aColumns = array( 'id','id','lang_key_info','english','chinese','thai','vietnamese','filipino','burmese');
    	$grid_data = get_search_data($aColumns);
    	$sort_order = $grid_data['sort_order'];
    	$order_by = $grid_data['order_by'];

        if($order_by == '')
            $order_by = "id";
        if($sort_order == '')
            $sort_order = "asc";
    	/*
    	 * Paging
    	*/
    	$per_page =  $grid_data['per_page'];
    	$offset =  $grid_data['offset'];
    	
    	$data = $this->language_setting_model->get_language_setting($per_page, $offset, $order_by, $sort_order, $grid_data['search_data']);
    	$count = $this->language_setting_model->get_language_setting(0, 0, "", "", $grid_data['search_data']);
    	 
    	/*
    	 * Output
    	*/
    	$output = array(
    			"sEcho" => intval($_GET['sEcho']),
    			"iTotalRecords" => $count,
    			"iTotalDisplayRecords" => $count,
    			"aaData" => array()
    	);
    	
    	if($data){
    		foreach($data->result_array() AS $result_row){
    			$row = array();
                $action = $action_list = '';
                if($this->session->userdata('role_id') == '1' || in_array("edit",$this->arrAction)) {
                    $action_list .= '<li><a href="'.base_url().'language_setting/add/'.$result_row['id'].'" data-target="#modal-default" data-toggle="modal" class="modal-link"><i class="fa fa-gear"></i> Edit</a></li>';
                } 
               
                if($action_list <> '') {
                    $action .= '<div class="dropdown">';
                    $action .= '<button aria-expanded="false" aria-haspopup="true" class="btn btn-info" data-toggle="dropdown" type="button"><i class="fa fa-sort-amount-desc"></i></button>';
                    $action .= '<ul role="menu" class="dropdown-menu profile-dropdown">';
                    $action .= $action_list;
                    $action .= '</ul>';
                    $action .= '</div>';
                }
				
    			$row[] = $result_row["id"];
                $row[] = $action;
    			$row[] = $result_row["lang_key_info"];
                $row[] = $result_row["english"];
                $row[] = $result_row["chinese"];
                $row[] = $result_row['thai'];
				$row[] = $result_row["vietnamese"];
                $row[] = $result_row["filipino"];
                $row[] = $result_row['burmese'];
                $output['aaData'][] = $row;
    		}
    	}
    	
    	echo json_encode( $output );
    }


    public function clear_language()
    {
       $this->session->unset_userdata('language_export_var');
       redirect('language_setting');
    }
    
    public function add($id = null){
    	$content_data['id'] = $id;
    	$rowdata = array();
    	if($id){
    		$rowdata = $this->language_setting_model->get_language_setting_data_by_id($id);
    	}
    
    	$content_data['rowdata'] = $rowdata;
    	if($this->input->post()){
    		$english = $this->input->post('english');
            $chinese = $this->input->post('chinese');
            $thai = $this->input->post('thai');
            $vietnamese = $this->input->post('vietnamese');
            $filipino = $this->input->post('filipino');
            $burmese = $this->input->post('burmese');
    		$error = "";
    		$error_seperator = "<br>";
    		if($id){
    
    			$this->form_validation->set_rules('english', 'English', 'trim|required');
    			$this->form_validation->set_rules('chinese', 'chinese', 'trim|required');
    			$this->form_validation->set_rules('thai', 'thai', 'trim|required');
    			$this->form_validation->set_rules('vietnamese', 'vietnamese', 'trim|required');
    			$this->form_validation->set_rules('filipino', 'filipino', 'trim|required');
    			$this->form_validation->set_rules('burmese', 'burmese', 'trim|required');
    
    			if (!$this->form_validation->run()) {
    				if (form_error('english')) {
    					$error .= form_error('english').$error_seperator;
    				}
					if (form_error('chinese')) {
    					$error .= form_error('chinese').$error_seperator;
    				}
					if (form_error('thai')) {
    					$error .= form_error('thai').$error_seperator;
    				}
					if (form_error('vietnamese')) {
    					$error .= form_error('vietnamese').$error_seperator;
    				}
					if (form_error('filipino')) {
    					$error .= form_error('filipino').$error_seperator;
    				}
					if (form_error('burmese')) {
    					$error .= form_error('burmese').$error_seperator;
    				}
    				echo $error;
    				exit();
    			}
 
    			$data = array();
    			$data['english'] = $english;
                $data['chinese'] = $chinese;
                $data['thai'] = $thai;
                $data['vietnamese'] = $vietnamese;
                $data['filipino'] = $filipino;
                $data['burmese'] = $burmese;
    			$table = 'language_setting';
    			$wher_column_name = 'id';
    			
    			grid_data_updates($data,$table,$wher_column_name,$id);
                
                $file = $this->language_setting_model->updatelangfile('english');        			
                $file = $this->language_setting_model->updatelangfile('chinese');                   
                $file = $this->language_setting_model->updatelangfile('thai');                   
                $file = $this->language_setting_model->updatelangfile('vietnamese');                   
                $file = $this->language_setting_model->updatelangfile('filipino');                   
                $file = $this->language_setting_model->updatelangfile('burmese');                   
    		}
    		exit;
    	}
    	$this->template->build('add_language_datatable', $content_data);
    }
	
	public function export_to_excel()
    {
		ini_set('memory_limit','1024M');
		$per_page =  5000;
        $offset =  0;
        $data = $this->language_setting_model->get_language_setting($per_page, $offset, $order_by="lang_key_info", $sort_order="ASC", $search_data=array());
		
        $result = array();
        $no = 1;
        if($data){
			foreach($data->result_array() as $key => $value){            
				$result[$key]['id'] = $value['id'];
				$result[$key]['lang_key_info'] = addslashes(trim($value['lang_key_info']));
				$result[$key]['english'] = addslashes(trim($value['english']));
				$result[$key]['chinese'] = addslashes(trim($value['chinese']));
				$result[$key]['thai'] = addslashes(trim($value['thai']));
				$result[$key]['vietnamese'] = addslashes(trim($value['vietnamese']));
				$result[$key]['filipino'] = addslashes(trim($value['filipino']));
				$result[$key]['burmese'] = addslashes(trim($value['burmese']));
			
				$no ++;
			}
        }
        $filename = "Language_Settings";
        $this->export->to_excel($result,$filename);
    }
	
	public function update() {
        
        $content_data = array();
        // set layout data
        $this->template->set_theme(Settings_model::$db_config['default_theme']);
        $this->template->set_layout('school');
        
        $this->template->title('Bulk Update | Language Setting');
        $this->template->set_partial('header', 'header');
        $this->template->set_partial('sidebar', 'sidebar');
        $this->template->set_partial('footer', 'footer');
        $this->template->build('update_language', $content_data);
    }
	
	public function bulk_update(){
		$headerValidationMsg = "CSV file firstrow must require : A => id, B => lang_key_info, C => english, D => chinese, E => thai, F => vietnamese, G => filipino, H => burmese";
								
		$arrPredefinedKeys = array
							(
								"A" => "id",
								"B" => "lang_key_info",
								"C" => "english",
								"D" => "chinese",
								"E" => "thai",
								"F" => "vietnamese",
								"G" => "filipino",
								"H" => "burmese"
							);

		$curr_dir = str_replace("\\","/",getcwd()).'/';
		$content_data = array();
		
		$csvfile = $_FILES['csvfile']['name'];
		$filetype = pathinfo($_FILES["csvfile"]["name"]);
		
		if(isset($csvfile) && !empty($csvfile) && $_FILES['csvfile']['error'] != 4 && $filetype['extension'] == 'csv'){
			$csvfile_url = $_FILES['csvfile']['name'];
			$temp_csvfile = explode(".", $csvfile_url);
			$csvfile_name = $temp_csvfile[0];
			$csvfile_extension = end($temp_csvfile);
			$csvfile = $curr_dir.'uploads/csv/language/' .$csvfile_name. '.' . $csvfile_extension;
			move_uploaded_file($_FILES['csvfile']['tmp_name'],$csvfile);

			//================== extract zip file =================
			$folder = $curr_dir.'uploads/csv/language/'.$csvfile_name . '.' . $csvfile_extension;
			
			$objPHPExcel = PHPExcel_IOFactory::load($folder);
			//get only the Cell Collection
			$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
			//extract to a PHP readable array format
			foreach($cell_collection as $cell) {

				$column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();

				$row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
				$data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();

				//header will/should be in row 1 only. of course this can be modified to suit your need.
				if ($row == 1) {
					$header[$column] = $data_value;
				} else {
					$arr_data[$row][$column] = $data_value;
				}
				
			}
			
			$csv_error = 0;
			if(count($header) > 0){
				foreach($header AS $ketName=>$valName){
					if($valName != $arrPredefinedKeys[$ketName]){
						$this->session->set_flashdata('errormessage', $headerValidationMsg);
						$csv_error = 1;
						redirect(base_url().'language_setting/update');exit;
					}
				}
			}
			else{
				$this->session->set_flashdata('errormessage', $headerValidationMsg);
				$csv_error = 1;
				redirect(base_url().'language_setting/update');exit;
			}
			
			if($csv_error == 0 && count($arr_data) > 0){
				foreach($arr_data AS $rowKey=>$columnArr){
					$data = array();
					
					$data['english'] = isset($columnArr["C"])?$columnArr["C"]:"";
					$data['chinese'] = isset($columnArr["D"])?$columnArr["D"]:"";
					$data['thai'] = isset($columnArr["E"])?$columnArr["E"]:"";
					$data['vietnamese'] = isset($columnArr["F"])?$columnArr["F"]:"";
					$data['filipino'] = isset($columnArr["G"])?$columnArr["G"]:"";
					$data['burmese'] = isset($columnArr["H"])?$columnArr["H"]:"";
					$table = 'language_setting';
					$wher_column_name = 'id';
					$id = $columnArr["A"];
					
					if($id > 0)
						grid_data_updates($data,$table,$wher_column_name,$id);
				}
				
				$file = $this->language_setting_model->updatelangfile('english');        			
				$file = $this->language_setting_model->updatelangfile('chinese');                   
				$file = $this->language_setting_model->updatelangfile('thai');                   
				$file = $this->language_setting_model->updatelangfile('vietnamese');                   
				$file = $this->language_setting_model->updatelangfile('filipino');                   
				$file = $this->language_setting_model->updatelangfile('burmese');
				
				redirect(base_url().'language_setting');
			}
		}
		else {
			$this->session->set_flashdata('errormessage', "Please upload CSV file");
			$csv_error = 1;
			redirect(base_url().'language_setting/update');exit;
		}
	}
}

/* End of file language_setting.php */