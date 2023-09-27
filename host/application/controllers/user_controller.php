<?php
class user_controller extends CI_Controller {


function insert() {


	$data= array('username' => 'ali' ,

'password' =>'227244'
		);

	    $this->user_model-> insert_user($data);
}


function delete($id){

$this->user_model->delete_user($id);
	
}

function update($id){


	$data= array('username' => 'ali2' ,

'password' =>'11111'
		);
	$this->user_model->update_user($id,$data);
}


function display($id){
$data['users']=$this->user_model->get_user();
$this->load->view('user_view',$data);

	
}




}
?> 