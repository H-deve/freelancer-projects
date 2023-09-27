<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');


class admin_co extends CI_Controller
{
	function __construct()
	{

parent::__construct();

$this->load->library('Grocery_CRUD');
	}

public function index()
{
	$this->load->view('index');
}

public function users(){
$crud = new grocery_CRUD();

$crud->set_table('users');
$data['output']=$crud->render();
$this->load->view('index', $data);

}
public function danger_noti(){
$crud = new grocery_CRUD();
 
$crud->set_table('dangerous_notification');
$data['output']=$crud->render();
$this->load->view('index', $data);

}
public function danger_place(){
$crud = new grocery_CRUD();
 
$crud->set_table('danger_place');
$data['output']=$crud->render();
$this->load->view('index', $data);
}
public function sh_users(){
$crud = new grocery_CRUD();
 $crud->unset_add();
$crud->unset_edit();
$crud->set_table('users');
$data['output']=$crud->render();
$this->load->view('index', $data);
}
public function sh_danger_place(){
$crud = new grocery_CRUD();
 $crud->unset_add();
$crud->unset_edit();
$crud->set_table('danger_place');
$data['output']=$crud->render();
$this->load->view('index', $data);
}
public function sh_danger_noti(){
$crud = new grocery_CRUD();
 $crud->unset_add();
$crud->unset_edit();
$crud->set_table('dangerous_notification');
$data['output']=$crud->render();
$this->load->view('index', $data);
}
}

?>