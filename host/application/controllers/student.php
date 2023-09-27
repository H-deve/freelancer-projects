<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="ar">
</head>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require(APPPATH.'libraries/rest_controller.php');
class student extends REST_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->model('student_model');
		$this->load->library('grocery_CRUD');
	}

	public function index_get()
	{
		redirect(base_url()."student/home_page");
	}
	
	
	public function test_get()
	{
		$data['main_content']='form.html';
		$this->load->view('includes/template',$data);
		
	}
	public function testa_get()
	{
		$data['main_content']='advanced.html';
		$this->load->view('includes/template',$data);
		
	}
	
	
	public function add_student_get($msg='')
	{
		$data['msg']=$msg;
		$data['main_content']='add_student.html';
		$this->load->view('includes/template',$data);
	}
	public function add_student_post()
	{
		$std_id=$this->student_model->add_student();
		redirect(base_url().'student/add_student/'.$std_id);
	}
	function show_student_get()
	{
		$bar_code=$this->get('bar_code');
		$data['student']=$this->student_model->get_student($bar_code);
		if($data['student']==false)
			redirect(base_url().'student/add_student');
		else
		{
			$data['student_info']=$this->student_model->get_student_day($data['student'][0]->id);
			$data['student_table']=$this->student_model->get_student_table($data['student'][0]->id);
			$data['main_content']='student.html';
			$this->load->view('includes/template',$data);
		}
		
	}
	function get_student_table_spec_post()
	{
		$student_id=$this->post('student_id');
		if(isset($student_id))
		{
			$dates=explode('-', $this->post('date'));
			//echo $dates[0].'  '.$dates[1]  ;
			if(is_array($dates)&&(isset($dates[1])))
			{
				$data['student_table']=$this->student_model->get_student_table_dates($student_id,$dates[0],$dates[1]);
				$this->load->view('table.html',$data);
			}
			
		}
	}
	function home_page_get()
	{
		//$data['students']=$this->student_model->get_home();
		$data['main_content']='home_page.html';
		//print_r($data['students']);
		$this->load->view('includes/template',$data);
	}
	function search_get()
	{
		$search_input=$_GET["search_input"];
		$search_by=isset($_GET["search_by"])?$_GET["search_by"]:-1;
		$data['students']=$this->student_model->search($search_input,$search_by);
		$data['main_content']='search.html';
		//print_r($data['students']);
		$this->load->view('includes/template',$data);
	}
	function enter_student_post()
	{
		
		$bar_code=$this->post('bar_code');
		//echo $bar_code."   ---  ";
		$this->student_model->enter_student($bar_code);
	}
	function leave_student_post()
	{
		$bar_code=$this->post('bar_code');
		$pages=$this->post('pages');
		$this->student_model->leave_student($bar_code,$pages);
	}
	function add_new_course_get()
	{
		$summer=$this->get('summer');
		$this->student_model->new_course($summer);
		redirect(base_url().'student/home_page');
	}
	function statistics_get()
	{
		$data['students']=$this->student_model->get_statistics();
		$data['main_content']='statistics.html';
		$data["no_footer"]=true;
		//print_r($data['students']);
		$this->load->view('includes/template',$data);
	}
	function url_origin($s, $use_forwarded_host=false)
	{
		$ssl = (!empty($s['HTTPS']) && $s['HTTPS'] == 'on') ? true:false;
		$sp = strtolower($s['SERVER_PROTOCOL']);
		$protocol = substr($sp, 0, strpos($sp, '/')) . (($ssl) ? 's' : '');
		$port = $s['SERVER_PORT'];
		$port = ((!$ssl && $port=='80') || ($ssl && $port=='443')) ? '' : ':'.$port;
		$host = ($use_forwarded_host && isset($s['HTTP_X_FORWARDED_HOST'])) ? $s['HTTP_X_FORWARDED_HOST'] : (isset($s['HTTP_HOST']) ? $s['HTTP_HOST'] : null);
		$host = isset($host) ? $host : $s['SERVER_NAME'] . $port;
		return $protocol . '://' . $host;
	}
	function full_url($s, $use_forwarded_host=false)
	{
		return $this->url_origin($s, $use_forwarded_host) . $s['REQUEST_URI'];
	}
	function test_url_get()
	{
		$absolute_url = $this->full_url($_SERVER);
		echo $absolute_url.'<br/>';
	}
	function test_date_post()
	{
		$myArray = explode('-', $_POST['date']);
		echo $myArray[0].' pop ';
		echo $myArray[1];
		print_r($myArray);
	}
	
	function fill_page_part_get()
	{
		for($i=2;$i<31;$i++)
		{
			$q="INSERT INTO page (id,part)VALUES(?,?)";
			$sql=$this->db->query($q,array(($i-1)*20+2,$i));
		}
	}
	function fill_page2_part_get()
	{
		for($i=2;$i<=21;$i++)
		{
				$q="INSERT INTO page (id,part)VALUES(?,?)";
				$sql=$this->db->query($q,array($i,1));
		}
		for($i=2;$i<31;$i++)
		{
			$part_page=($i)*20+2;
			$page=($i-1)*20+3;
			
			
			while($page!=$part_page)
			{
				echo $page."   ".$i."<p>";
				$q="INSERT INTO page (id,part)VALUES(?,?)";
				$sql=$this->db->query($q,array($page,$i));
				$page++;
			}
			
		}
	}
}
