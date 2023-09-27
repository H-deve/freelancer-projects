<?php
class push_notification extends CI_Controller{

public function send_notification(){
$this->load->model("push_notification_model");


if(isset($_POST["Token"])){

$token=$_POST["Token"];

	$url='https://fcm.googleapis.com/fcm/send';
	$fields= array(
'registration_ids' => $tokens,
'data'=> $message


		);
	$headre= array(
'Authorization:key = AAAAuz5syYg:APA91bHEMWi-JKQ8Ggl8cBjyG0heD3uSrSea79Fg_3V-nhtz6eSiPPWuuErn4wRB-rWFWFWeOa-wZVp6_N-bG-OHtZzOtwWPyaVrhzzh1l8uO06GNaIcPEs0Gmr8WfZE0uwccAmggfkn',
'Content_type : applecation/json'

		);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, $url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $$headre);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS , json_encode($fields));
$result = curl_exec($ch);
if($result === false){


	die('Curl faild :' .curl_error($ch));
}
curl_close($ch);
return $result;
$message = array('message' => "FCM PUSH NOTIFICATION TEST MESSAGE" );
$message_status= send_notification($tokens,$message);
echo $message_status;
}


}



}
?> 