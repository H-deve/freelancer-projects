<?php
	$q=100;
class login_model extends CI_Model {
	
	function signup($username,$password,$email)
	{
		$q="SELECT * FROM users where username=?";
		$sql=$this->db->query($q,array($username)); 
		if ($sql->num_rows > 0)
           { return 0;}
		else {
		$this->db->trans_begin();
		
			$key = pack('H*', "bcb04b4a8b6a0cffe54763945cef08bc88abe000fdebae5e1d417e2ffb2a12a3");
			
			# show key size use either 16, 24 or 32 byte keys for AES-128, 192
			# and 256 respectively
			
			$plaintext = $password;

			
			$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
			$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
			
			$ciphertext = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key,$plaintext, MCRYPT_MODE_CBC, $iv);

			
			$ciphertext = $iv . $ciphertext;
			
			
			$ciphertext_base64 = base64_encode($ciphertext);
		
		
		$npass=$ciphertext_base64;
			
			
			
			$new_insert_data = array(
			'username'=>$username,
			'password'=>$npass,
			'email'=>$email
			
			);				
			
			$insert = $this->db->insert('users', $new_insert_data);
//			echo $this->db->last_query();
			$user_id=$this->db->insert_id();
			//var_dump($user_id);die();
		if ($this->db->trans_status() === FALSE)
					 {
						$this->db->trans_rollback();
						return false;
					 }
		else
					 {
						$this->db->trans_commit();
						return $user_id;
					 }	
		}			 
	}
	
	function validate($username,$password)
	{
		$q="SELECT * FROM users where username='".$username."'";
		$sql=$this->db->query($q);
		
		foreach ($sql->result() as $raw ) {
					$data[]=$raw;
				}
		$user_num=$sql->num_rows();
		if ($sql->num_rows() > 0)
			{	
					$key = pack('H*', "bcb04b4a8b6a0cffe54763945cef08bc88abe000fdebae5e1d417e2ffb2a12a3");
					
					$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
					$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
					
					foreach($data as $temp) {
						$ciphertext_base64=$temp->password;
						$user_id=$temp->user_id;
					}
					
					$ciphertext_dec = base64_decode($ciphertext_base64);
			
					# retrieves the IV, iv_size should be created using mcrypt_get_iv_size()
					$iv_dec = substr($ciphertext_dec, 0, $iv_size);
					
					# retrieves the cipher text (everything except the $iv_size in the front)
					$ciphertext_dec = substr($ciphertext_dec, $iv_size);

					# may remove 00h valued characters from end of plain text
					$ans = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key,$ciphertext_dec, MCRYPT_MODE_CBC, $iv_dec);
					
					$final      = trim($ans, "\0..\32");

				if($password==$final){
						return $data[0];
					}
				else{
						return false;
					}
			}
		else 
			return false;
	}
}