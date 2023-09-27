<?php

class place_model extends CI_Model {


function __construct() {
parent::__construct();
}
// Insert json data into database
public function insert_json_in_db($data) {
$this->db->insert('danger_place', $data);
if ($this->db->affected_rows() > 0) {
return true;
} else {
return false;
}
}



public function insert_in_db($data) {

$this->db->insert('new_place', $data);
if ($this->db->affected_rows() > 0) {
return true;
} else {
return false;
}

}
}


?>