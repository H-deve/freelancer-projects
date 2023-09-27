<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . '/libraries/REST_Controller.php';
//require APPPATH . '/libraries/form_validation.php';
/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class Test extends REST_Controller {


function get_user($name,$password){

$this->db->model("isUserExisted");

}
	function koko_get()
	{
		$id=$this->get("id");
		$user=$this->get("user");
		$data = array('username' => $user,"id"=>$id );
		echo $this->response($data,200);
	}
	function koko_post()
	{
		$this->post("ioio");
		echo "amer";
	}
    
}
	// function register_get()
  //  {
 //       $this->load->libraries('validation.php');
        /* What you have done that i don't know */
        /*
        $json = array('status' => false );
        if($this->input->post()==null){
            $this -> response($json, 200);
        }
        */

        /* This is Form Validation */
    //    $this->validation->set_rules('first_name', 'FirstName', 'valid_email|required');
      //  $this->validation->set_rules('last_name', 'LastName', 'required');
        //$this->validation->set_rules('password', 'Password', 'required');

        /* Here you mistake $this->post('post var')*/
        //$firstname = $this->input->post("first_name");
        //$lastname = $this->input->post("last_name");
       // $password = $this->input->post("password");

        /** YOUR PROCESS for REGISTER **/
        /*
        LIKE
        */
      //  if ($this->validation->run() == TRUE)
        //{
          //  if(/* REGISTRATION SUCCESSFUL */)
            //{
              //  $data = array('result' => 'success', 'msg' => 'Registered Successfully...');
            //}
            //else
            //{
              //  $data = array('result' => 'error', 'msg' => 'Email Already Used or Invalid - Unable to Create Account' );
            //}
        //}
        //else
        //{
          //  $data = array('result' => 'error','msg' => preg_replace("/[\n\r]/",".",strip_tags(validation_errors())));
       // }

        //echo json_encode($data);

        /*
        if(!$firstname || !$lastname || !$password){
            $json['status'] = "wrong insert";
            $this -> response($json, 200);
        }

        $this->load->model('Data_model');
        $result = $this->Data_model->search($firstname, $lastname);

        if($result)
        {
            $this->Data_model->insert($firstname,$lastname,$password);
            $json['status'] = true;

        }
        // here if false..
        $this -> response($json, 200);
        */
  


