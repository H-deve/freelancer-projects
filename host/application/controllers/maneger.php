<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class maneger extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		parent::__construct();

		$this->load->database();
		$this->load->helper('url');
		$this->load->model('student_model');
		$this->load->library('grocery_CRUD');
	}

	public function index()
	{
		//$this->_example_output((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
	}
	
	public function students()
	{
		$crud = new grocery_CRUD();
		$crud->set_theme('datatables');
		$crud->set_table('student');
		$crud->set_subject('Students');
		$crud->set_field_upload('url','uploads');
		//$crud->unset_add();
		$output = $crud->render();
		 $data['output'] = $output;
			 //$data['main_content'] = 'our_example';	
			 $this->load->view('our_example',$data);
	}
	
	public function read_FromExcel()
	{
		$file = './uploads/Book1.xlsx';
 
		//load the excel library
		$this->load->library('excel');
		 
		//read file from path
		$objPHPExcel = PHPExcel_IOFactory::load($file);
		 
		//get only the Cell Collection
		
		$count=$objPHPExcel->getSheetCount();
		for($i=0;$i<$count;$i++)
		{
			$objPHPExcel->setActiveSheetIndex($i);
			$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
		 $header=array();
		 $arr_data=array();
		//extract to a PHP readable array format
			foreach ($cell_collection as $cell) {
				$column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
				$row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
				$data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
			 
				//header will/should be in row 1 only. of course this can be modified to suit your need.
				if ($row == 1) {
					$header[$row][$column] = $data_value;
				} else {
					$arr_data[$row][$column] = $data_value;
				}
			}
			$data['header'][] = $header;
			$data['values'][] = $arr_data;
		}
		
		echo "<pre>";
		print_r($data['values']);
		$j=1;
		foreach($data['values'] as $students)
		{
			echo $j."<br>";
			foreach($students as $student)
			{
				if(isset($student["A"]) && $student["A"]!="")
				{
					$this->db->insert("student",array("student_name"=>$student["A"],"level"=>"$j"));
					
				}
			}
			$j++;
		}
		 echo $this->db->last_query();
		//send the data in an array format
	
		//print_r($data['values']);
	}
}