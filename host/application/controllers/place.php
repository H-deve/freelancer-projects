<?php
require(APPPATH.'libraries/REST_Controller.php');
class place extends REST_Controller {

public function __construct() {
parent::__construct();
$this->load->model("place_model");
}

// Load view page
//public function index() {
//$this->load->view("view_form");
//}
function i_get(){

echo "ok";

}
// Fetch user data and convert data into json
public function data_submitted_post() {

// Store user submitted data in array
	var_dump( $_POST["latidue_place"]);
$data = array(
'latidue' => $this->input->post('latidue_place'),
'longitude' => $this->input->post('longitude_place'),
'description' => $this->input->post('description_place'),
);

// Converting $data in json
$json_data['location_info'] = json_encode($data);

// Send json encoded data to model
$return = $this->place_model->insert_json_in_db($data);
if ($return == true) {
$data['result_msg'] = 'Json data successfully inserted into database !';
} else {
$data['result_msg'] = 'Please configure your database correctly';
}

// Load view to show message
//$this->load->view("view_form", $data);
//}
}
public function save_post(){

	$data = array(
'latidue' => $this->input->post('lat'),
'longitude' => $this->input->post('lang'),
'place_name' => $this->input->post('place_name'),
'type' => $this->input->post('type'),
'description' => $this->input->post('description'),
);

 $this->place_model->insert_in_db($data);
$data['message'] = 'Data Inserted Successfully';

}
}








?>
