<?php
class user_model extends CI_Model {
	
	
	public function insert_user($data)
	{
		 $query = $this->db->insert('users', $data);

	}
		
		public function delete_user($id)
	{
		$this->db->where('id',$id);
		$query= $this->db->delete('users');

	}
		

		public	function update_user($id,$data)
	{
		$this->db->where('id',$id);
		$query=$this->db->update('users',$data);

	}
		
		public	function select_user()
	{
		
		$query=$this->db->get('users');
		return $quere->result();

	}

		}