<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class data_excel extends CI_Controller {
	function __construct(){
        parent::__construct();
		
    }

	public function index(){	
		$this->load->library('excel');
       /////////  Tool Php Excel
		$this->excel->load('files/excel.xls');
		$this->excel->setLoadAllSheets();$this->excel->setActiveSheetIndex(0);		
		$response = new stdClass();	
		//// TITLE PERUSAHAAN	
		$ke=1;
		$this->excel->getActiveSheet()->setCellValue('A'.$ke, 'andri');
		$ke++;

		$filename="xxx.xls";
		$this->excel->stream($filename);
    }
}