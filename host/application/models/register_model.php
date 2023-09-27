<?php

class register_model extends CI_model{

public function insert_fcm(){

$query="INSERT INTO fcm_users(token) VALUES ('$token') ON DUPLICATE KEY Update Token='$token';";
$query="SELECT Token from fcm_users ;";
$this->db->insert_fcm('$query');
}
}

?> 