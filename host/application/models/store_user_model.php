<?php
class store_user_model extends CI_Model {

// Insert json data into database
public function insert_json_in_db($json_data) {
$this->db->insert('users', $json_data);
if ($this->db->affected_rows() > 0) {
return true;
} else {
return false;
}
}

}











?>
