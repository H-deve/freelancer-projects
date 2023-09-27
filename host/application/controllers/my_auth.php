<?php

class my_auth extends Auth_Controller{

$username = 'benedmunds';
		$password = '12345678';
		$email = 'ben.edmunds@gmail.com';
		$additional_data = array(
								'first_name' => 'Ben',
								'last_name' => 'Edmunds',
								);
		$group = array('1'); // Sets user to admin.

		$this->ion_auth->register($username, $password, $email, $additional_data, $group)
	



}
?>