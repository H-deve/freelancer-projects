<?php

class manager_model extends CI_Model {
	
	function signup()
	{
		$q="SELECT * FROM users where email=?";
		$sql=$this->db->query($q,array($this->input->post('email'))); 
		if ($sql->num_rows > 0)
           { return 0;}
		else {
		$this->db->trans_begin();
		
			$key = pack('H*', "bcb04b4a8b6a0cffe54763945cef08bc88abe000fdebae5e1d417e2ffb2a12a3");
			
			# show key size use either 16, 24 or 32 byte keys for AES-128, 192
			# and 256 respectively
			
			$plaintext = $this->input->post('password');

			
			$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
			$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
			
			$ciphertext = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key,$plaintext, MCRYPT_MODE_CBC, $iv);

			
			$ciphertext = $iv . $ciphertext;
			
			
			$ciphertext_base64 = base64_encode($ciphertext);
		
		
		$npass=$ciphertext_base64;
			
			
			$new_insert_data = array(
			'name'=> $this->input->post('res_name'),
			'description'=>$this->input->post('disc'),
			'category_id'=>$this->input->post('type'),
			'phone_nbr'=>$this->input->post('phone1'),
			'price_range'=>$this->input->post('min'),
			);				
			
			$insert = $this->db->insert('restaurant', $new_insert_data);
			$i=mysql_insert_id();
			
			if(!empty($_FILES['fic']['name']))
			{
					$ext=explode(".",strtolower($_FILES['fic']['name']));
		 			$extension=array_pop($ext);
				 	$file_name =$i.".".$extension;
				
				    $file_size =$_FILES['fic']['size'];
				    $file_tmp =$_FILES['fic']['tmp_name'];
				    $file_type=$_FILES['fic']['type'];
					/*
					if (!file_exists ($path."/uploads/res".$this->session->userdata('res_id')))
						mkdir($path."/uploads/res".$this->session->userdata('res_id'),0777,TRUE);
					
					$location=realpath($_SERVER['DOCUMENT_ROOT'])."/burger_restapi/uploads/res".$i."/".$file_name;
	        	 	*/
					$location=realpath($_SERVER['DOCUMENT_ROOT'])."/burger_restapi/uploads/".$file_name;
					move_uploaded_file($file_tmp, $location);
					$d = $this->compress($location, $location, 30);

			}
			else{
				$file_name='default.jpg';
			}
			
			$new_insert_data = array(
			'email'=>$this->input->post('email'),
			'password'=>$npass,
			'first_name'=> $this->input->post('first_name'),
			'last_name'=>$this->input->post('last_name'),
			'phone'=>$this->input->post('mobile_num'),
			'gender'=>$this->input->post('gender')
			);				
			
			$insert = $this->db->insert('users', $new_insert_data);
			$k=mysql_insert_id();

			
			$q="UPDATE restaurant SET logo='".$file_name."' , owner_id ='".$k."' where id=? ";		   
			$this->db->query($q,$i);

			$new_insert_data = array(
			'user_id'=> $k,
			'group_id'=>'2'
			);	
			$insert = $this->db->insert('users_groups', $new_insert_data);
		if ($this->db->trans_status() === FALSE)
					 {
						$this->db->trans_rollback();
					 }
					 else
					 {
						$this->db->trans_commit();
						$a[0]=$this->input->post('first_name')." ".$this->input->post('last_name');
						$a[1]=$i;
						return $a;
					 }	
		}			 
	}
		
	function delete_res($id)
	{
			$this->db->trans_begin();
				$sql=$this->db->query("SELECT * FROM restaurant WHERE id = '".$id."'");
				foreach ($sql->result() as $raw ) {
					$data[]=$raw;
				}
				/* delete meals and lists and unlink meals*/
				$this->db->query("DELETE FROM restaurant WHERE id = '".$id."'");
				$files = glob(realpath($_SERVER['DOCUMENT_ROOT'])."/burger_restapi/uploads/*"); // get all file names
				foreach($files as $file){ // iterate files
				  if(is_file($file) && ($file == realpath($_SERVER["DOCUMENT_ROOT"])."/burger_restapi/uploads/".$data[0]->res_logo))
				  
					unlink($file); // delete file
				}
				
				
				
			if ($this->db->trans_status() === FALSE)
					 {
						$this->db->trans_rollback();
					 }
					 else
					 {
						$this->db->trans_commit();
					 }	
	}	
	
	function get_res()
	{
		$sql=$this->db->query("SELECT restaurant.accept ,restaurant.id,phone_nbr,restaurant.name as r_name,res_category.name as c_name FROM restaurant inner join res_category where res_category.id=restaurant.category_id ");
				foreach ($sql->result() as $raw ) {
					$data[]=$raw;
				}
		if ($sql->num_rows > 0)
           { 
			 return $data; 
		}
		else {
			$f=FALSE;	
			return $f;
		}		
	}
	
	function view_res($id)
	{
		$sql=$this->db->query("SELECT *,restaurant.name as r_name,res_category.name as c_name FROM restaurant inner join res_category on res_category.id = restaurant.category_id inner join users on users.id=restaurant.owner_id WHERE restaurant.id = '".$id."'");
				foreach ($sql->result() as $raw ) {
					$data[]=$raw;
				}
		$sql1=$this->db->query("SELECT * FROM branch where restaurant_id = '".$id."'");
				foreach ($sql1->result() as $raw ) {
					$data1[]=$raw;
				}

		if ($sql->num_rows > 0)
           { 
			 	$res[1]=$data;
				if ($sql1->num_rows == 0)
					$res[2]=false;
				else 
					$res[2]=true;
				$res[3]=$sql1->num_rows;
			 return $res; 
		}
		else {
			$f[1]=FALSE;	
			$f[2]=FALSE;
			$f[3]=0;			
			return $f;
		}		
	}
	

	
	function active($id)
	{
		$q="UPDATE restaurant SET 
		   accept =1 where id=? ";
		   
		$sql=$this->db->query($q,$id);
	}
	
	function de_active($id)
	{
			$q="UPDATE restaurant SET 
		   accept =0 where id=? ";
		   
		$sql=$this->db->query($q,$id);
	}
	
	function get_types()
	{
		$sql=$this->db->query("SELECT * FROM res_category");
				foreach ($sql->result() as $raw ) {
					$data[]=$raw;
				}
		if ($sql->num_rows > 0)
           { 
			 return $data; 
		}
		else {
			$f=FALSE;	
			return $f;
		}		
	}
	
	function add_type()
	{
		$new_insert_data = array(
			'name'=> $this->input->post('name')
			);				
			$insert = $this->db->insert('res_category', $new_insert_data);
	}
	
	function get_type($id)
	{
		$sql=$this->db->query("SELECT * FROM res_category where id='".$id."'");
				foreach ($sql->result() as $raw ) {
					$data[]=$raw;
				}
		if ($sql->num_rows > 0)
           { 
			 return $data; 
		}
		else {
			$f=FALSE;	
			return $f;
		}		
	}
	
	function update_type($id)
	{
		$q="UPDATE res_category SET name=? where id='".$id."' ";
		   
		$sql=$this->db->query($q,$this->input->post('name'));
	}
	
	function delete_type($id)
	{
		$this->db->query("DELETE FROM res_category WHERE id = '".$id."'");
	}

	function get_lists()
	{
		$sql=$this->db->query("SELECT * FROM lists");
				foreach ($sql->result() as $raw ) {
					$data[]=$raw;
				}
		if ($sql->num_rows > 0)
           { 
			 return $data; 
		}
		else {
			$f=FALSE;	
			return $f;
		}	
	}
	
	function get_groups($k=0){
		if($k==0)
			$sql=$this->db->query("SELECT * FROM groups");
		else
			$sql=$this->db->query("SELECT * FROM groups where id>2");
				foreach ($sql->result() as $raw ) {
					$data[]=$raw;
				}
		if ($sql->num_rows > 0)
           { 
			 return $data; 
		}
		else {
			$f=FALSE;	
			return $f;
		}	
	}
	
	function add_group(){
		$new_insert_data = array(
			'name'=> $this->input->post('name'),
			'description'=> $this->input->post('description'),
			);				
			$insert = $this->db->insert('groups', $new_insert_data);
	}
	
	function get_group($id)
	{
		$sql=$this->db->query("SELECT * FROM groups where id='".$id."'");
				foreach ($sql->result() as $raw ) {
					$data[]=$raw;
				}
		if ($sql->num_rows > 0)
           { 
			 return $data; 
		}
		else {
			$f=FALSE;	
			return $f;
		}		
	}
	
	function update_group($id)
	{
			$q="UPDATE groups SET name=?,description=? where id='".$id."' ";
		   
		$sql=$this->db->query($q,array($this->input->post('name'),$this->input->post('description')));
	}
	
	function delete_group($id)
	{
	$this->db->trans_begin();
		$this->db->query("DELETE FROM groups WHERE id = '".$id."'");
		$this->db->query("DELETE FROM  users_groups WHERE group_id = '".$id."'");
	if ($this->db->trans_status() === FALSE)
					 {
						$this->db->trans_rollback();
					 }
					 else
					 {
						$this->db->trans_commit();
					 }		
	}
	
	function get_customaization(){
		$sql=$this->db->query("SELECT * FROM spec");
				foreach ($sql->result() as $raw ) {
					$data[]=$raw;
				}
		if ($sql->num_rows > 0)
           { 
			 return $data; 
		}
		else {
			$f=FALSE;	
			return $f;
		}	
	}
	
	function get_customaize($id){
		$sql=$this->db->query("SELECT * FROM spec where id='".$id."'");
				foreach ($sql->result() as $raw ) {
					$data[]=$raw;
				}
		if ($sql->num_rows > 0)
           { 
			 return $data; 
		}
		else {
			$f=FALSE;	
			return $f;
		}	
	}
	
	function add_customaization(){
		$new_insert_data = array(
			'name'=> $this->input->post('name'),
			'description'=> $this->input->post('description'),
			'type'=> $this->input->post('type')
			);				
			$insert = $this->db->insert('spec', $new_insert_data);
	}
	
	function update_spec($id){
		$q="UPDATE spec SET name=?,description=?,type=? where id='".$id."' ";
		   
		$sql=$this->db->query($q,array($this->input->post('name'),$this->input->post('description'),$this->input->post('type')));
	}
	
	function delete_spec($id){
		$this->db->trans_begin();
		$this->db->query("DELETE FROM spec WHERE id = '".$id."'");
		$this->db->query("DELETE FROM  spec_meal WHERE spec_id= '".$id."'");
		if ($this->db->trans_status() === FALSE)
					 {
						$this->db->trans_rollback();
					 }
					 else
					 {
						$this->db->trans_commit();
					 }
	}
	
	function get_allcustomaize($id){
		$sql=$this->db->query("SELECT * FROM spec where type='".$id."'");
				foreach ($sql->result() as $raw ) {
					$data[]=$raw;
				}
		if ($sql->num_rows > 0)
           { 
			 return $data; 
		}
		else {
			$f=FALSE;	
			return $f;
		}	
	}
	
	function compress($source, $destination, $quality) {

		$info = getimagesize($source);

		if ($info['mime'] == 'image/jpeg') 
			$image = imagecreatefromjpeg($source);

		elseif ($info['mime'] == 'image/gif') 
			$image = imagecreatefromgif($source);

		elseif ($info['mime'] == 'image/png') 
			$image = imagecreatefrompng($source);

		imagejpeg($image, $destination, $quality);

		return $destination;
	}
}