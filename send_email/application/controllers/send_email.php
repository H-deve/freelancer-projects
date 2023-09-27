<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class send_email extends CI_Controller {


      function __construct() { 
         parent::__construct(); 
         $this->load->library('session'); 
         $this->load->helper('form'); 
      } 
	public function index()
	{
		$this->load->helper('form');
		$this->load->view('email_form');
	}
	 public function send_mail() { 
	 //	echo "string";
         $from_email = "Sam53.hajjo@gmail.com"; 
         $to_email = $this->input->post('mo3tasmhajjo100@gmail.com'); 
  
         //Load email library 
         $this->load->library('email'); 
   
         $this->email->from($from_email, 'sam'); 
         $this->email->to($to_email);

         $this->email->subject('Email Test'); 
         $this->email->message('Testing the email class.'); 
   
         //Send mail 
         if($this->email->send()) 
         $this->session->set_flashdata("email_sent","Email sent successfully."); 
         else 
         $this->session->set_flashdata("email_sent","Error in sending Email."); 
         $this->load->view('email_form'); 

      } 
}
