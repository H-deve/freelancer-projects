<?php

class push_notification_model extends CI_model{

public function push_notifi(){

$tokens = array();
$query= "SELECT  Token from fcm_users;";

if(mysql_num_rows($query) > 0){


	while($row =mysql_fetch_assoc($query)){

$tokens = $row["Token"];
	}
}
 

}

}

?> 