<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
* Excel library for Code Igniter applications
* Based on: Derek Allard, Dark Horse Consulting, www.darkhorse.to, April 2006
* Tweaked by: Moving.Paper June 2013
*/
class Export{
	
   public function to_excel($result,$filename) {
   	$ci =& get_instance();
		$ci-> load -> library('excel');
		$ci->excel->setActiveSheetIndex(0);
		$ci->excel->getActiveSheet()->setTitle($filename);
		//$ci->excel->getActiveSheet()->setcellvalue('A1', 'Category' );
		//$ci->excel->getActiveSheet()->fromArray($result, NULL, 'A2');
		
		foreach ($result as $key => $row_data) {
			 $col = 0;
			 foreach($row_data as $i => $value) {
		        $ci->excel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $i);
		        $col++;
			 }
		}
		
		$row =2; // 1-based index
		foreach ($result as $row_data) {
			 $col = 0;
			 foreach($row_data as $key=>$value) {
		        $ci->excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value);
		        $col++;
			 }
			$row ++;
		}
		   
        $filename= $filename.'.xlsx'; //save our workbook as this file name
 
        header('Content-Type: application/vnd.ms-excel'); //mime type
 
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
 
        header('Cache-Control: max-age=0'); //no cache
                    
 
        $objWriter = PHPExcel_IOFactory::createWriter($ci->excel, 'Excel2007'); 
 
        $objWriter->save('php://output');
     }

}
?>