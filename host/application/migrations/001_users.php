<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_users extends CI_Migration {

	public function up()
	{
		$this->load->database();
		$this->dbforge->add_field(array(
			'id' => array(
				'type'=>'int',
				'constraint'=>11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'user_name' => array(
				'type'=>'varchar',
				'constraint'=>40,
			),
			'password' => array(
				'type'=>'varchar',
				'constraint'=>100,
			),
			'first_name' => array(
				'type'=>'varchar',
				'constraint'=>40,
			),
			'last_name' => array(
				'type'=>'varchar',
				'constraint'=>40,
			)
		)); 	  
		$this->dbforge->add_key('id',TRUE);
		$this->dbforge->create_table('user',TRUE);
//===================================================================================
		$this->dbforge->add_field(array(
			'g_id' => array(
				'type'=>'int',
				'constraint'=>11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'g_name' => array(
				'type'=>'varchar',
				'constraint'=>40,
			)
		));
		$this->dbforge->add_key('g_id',TRUE);
		$this->dbforge->create_table('group',TRUE);
//===================================================================================

$this->dbforge->add_field(array(
			'p_id' => array(
				'type'=>'int',
				'constraint'=>11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'p_name' => array(
				'type'=>'varchar',
				'constraint'=>40,
			)
		));
		$this->dbforge->add_key('p_id',TRUE);
		$this->dbforge->create_table('permition',TRUE);
//===================================================================================
		$this->dbforge->add_field(array(
				'g_p_id' => array(
				'type'=>'int',
				'constraint'=>11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'permition_id' => array(
				'type'=>'int',
				'constraint'=>11,
			),
			'group_id' => array(
				'type'=>'int',
				'constraint'=>11,
				)
			)); 	  
			$this->dbforge->add_key('g_p_id',TRUE);
		$this->dbforge->create_table('group_permition',TRUE);
//===================================================================================
		$this->dbforge->add_field(array(
			'u_id' => array(
				'type'=>'int',
				'constraint'=>11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'user_id'=>array(
				'type'=>'int',
				'constraint'=>11,
			),
			'group_id'=>array(
				'type'=>'int',
				'constraint'=>11,
			),
			'date'=>array(
				'type'=>'DATE',
			),
			'user_name' => array(
				'type'=>'varchar',
				'constraint'=>40,
			),
			'password' => array(
				'type'=>'varchar',
				'constraint'=>100,
			),
			'first_name' => array(
				'type'=>'varchar',
				'constraint'=>40,
			),
			'last_name' => array(
				'type'=>'varchar',
				'constraint'=>40,
			)
		)); 	  
		$this->dbforge->add_key('u_id',TRUE);
		$this->dbforge->create_table('updated_user',TRUE);
//===================================================================================
}

	public function down()
	{
		$this->dbforge->drop_table('user');
		$this->dbforge->drop_table('group');
		$this->dbforge->drop_table('permition');
		$this->dbforge->drop_table('group_permition');
		$this->dbforge->drop_table('updated_user');
	}
}