<?php
class store_user_info extends REST_Controller {

public function __construct() {
parent::__construct();
$this->load->model("store_user_model");
}

// Load view page
//public function index() {
//$this->load->view("view_form");
//}

// Fetch user data and convert data into json
public function data_submitted() {

// Store user submitted data in array
$data = array(
'id' => $this->input->post('id_user'),
'username' => $this->input->post('username'),
'longitude' => $this->input->post('longitude_place'),
'description' => $this->input->post('description_place'),
'num_users_notified'=>$this->input->post('addrnum_users_notifiedess'),
'num_users_response'=>$this->input->post('num_users_response'),
'danger_date'=>$this->input->post('danger_date'),

);

// Converting $data in json
$json_data['user_info'] = json_encode($data);

// Send json encoded data to model
$return = $this->store_user_model->insert_json_in_db($json_data);
if ($return == true) {
$data['result_msg'] = 'Json data successfully inserted into database !';
} else {
$data['result_msg'] = 'Please configure your database correctly';
}

// Load view to show message
//$this->load->view("view_form", $data);
//}

}


}


?>