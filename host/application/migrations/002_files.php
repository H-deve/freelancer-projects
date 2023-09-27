<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_files extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_field(array(
			'id' => array(
				'type'=>'int',
				'constraint'=>11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'user_id' => array(
				'type'=>'int',
				'constraint'=>11,
			),
			'url' => array(
				'type'=>'varchar',
				'constraint'=>200,
			),
			'description' => array(
				'type'=>'TEXT',
			)
		)); 	  
		$this->dbforge->add_key('id',TRUE);
		$this->dbforge->create_table('files',TRUE);
//===================================================================================
		$this->dbforge->add_field(array(
			'id' => array(
				'type'=>'int',
				'constraint'=>11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'user_id'=>array(
				'type'=>'int',
				'constraint'=>11,
			),
			'date'=>array(
				'type'=>'date',
			),
			'url' => array(
				'type'=>'varchar',
				'constraint'=>200,
			),
			'description' => array(
				'type'=>'TEXT',
			)
		)); 	  
		$this->dbforge->add_key('id',TRUE);
		$this->dbforge->create_table('updated_files',TRUE);
//===================================================================================


$sql="INSERT INTO user (id, user_name, first_name, last_name, password, group_id) VALUES
(1, 'administrator', 'amer', 'alhosary', 'DpFzfUFRjuuNocd+XIhF+wONQvsOi2rPoEJMLzTp9Yw=', 1),
(2, 'ameralhosary', 'amer', 'alhosary', 'DpFzfUFRjuuNocd+XIhF+wONQvsOi2rPoEJMLzTp9Yw=', 1)";
		$insert = $this->db->query( $sql);
		
//========================================================

$sql="INSERT INTO permition (p_id, p_name) VALUES
(1, 'files'),
(2, 'groups'),
(3, 'users'),
(4, 'updated_user'),
(5, 'updated_files')";

$insert = $this->db->query( $sql);

//=============================================================
$sql="INSERT INTO group VALUES(1, 'admin')";
$insert = $this->db->query( $sql);

$sql="INSERT INTO group VALUES(2, 'user')";
$insert = $this->db->query( $sql);
//=============================================================


$sql="INSERT INTO group_permition (g_p_id, group_id, permition_id) VALUES
(0, 1, 1),
(1, 1, 2),
(3, 1, 3),
(7, 2, 2),
(8, 1, 4)";
$insert = $this->db->query( $sql);
}

	public function down()
	{
		$this->dbforge->drop_table('files');
		$this->dbforge->drop_table('updated_files');
	}
}