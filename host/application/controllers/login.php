<?php
require(APPPATH.'libraries/REST_Controller.php');
class login extends REST_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('login_model');
		 header('Content-Type: text/html; charset=utf-8');
	}
	
	function index_get()
	{
		$this->load->view('login');
	}
	
	function user_get()
	{
	
		$this->load->view('login');
			
	}
	function log_in_post()
	{
		 $input_data = json_decode(trim(file_get_contents('php://input')));
		 //var_dump($input_data);
		 $username = $input_data->username; 
		 //var_dump($username);die();
		 $password=$input_data->password;
		$a=$this->login_model->validate($username,$password);
 
        	
		if($a==false)
		{
			 $this->response(array('error' => true,'message'=>"user not found"), 200);
		}
		else
		{
		//var_dump($a);
		$message = array('error'=>false,'message' => 'logged in successfully','user'=>$a);
		$this->response($message, 200);	
		}
	}
	function signup_post()
	{
	 $input_data = json_decode(trim(file_get_contents('php://input')));
		 //var_dump($input_data);
		 $username = $input_data->username; 
		 $email= $input_data->email; 
		 //var_dump($username);die();
		 $password=$input_data->password;
		$a=$this->login_model->signup($username,$password,$email);
		if($a!=false)
		{
		//var_dump($a);
		$message = array('error'=>false,'message' => 'signup  successfully','user_id'=>$a);
		//	$message = array('message' => 'sign in successfully','user_id'=>$a);
		$this->response($message, 200);	
		}
		else{
			 $this->response(array('error' =>true,'message' => 'signup faild'), 200);
		}
			
	}
	function logout_get()
	{
		$sess_data=array(
					'logged_in'=>0,
					'user_id'=>0,
					'name'=>0,
					'group_id'=>0,
					);
				$this->session->set_userdata($sess_data);
		session_unset();
		session_destroy();
		
		redirect("login/user");
	}
	

}