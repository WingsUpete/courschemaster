<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Modify_cm_departments_table extends CI_Migration{

	public function up(){

		$fields = array(
			'en_name' => array(
				'name' => 'en_name',
				'type' => 'VARCHAR',
				'constraint' => 128,
			),
		);
		$this->dbforge->modify_column('cm_departments', $fields);

	}

	public function down(){

		$fields = array(
			'en_name' => array(
				'name' => 'en_name',
				'type' => 'VARCHAR',
				'constraint' => 45,
			),
		);
		$this->dbforge->modify_column('cm_departments', $fields);

	}
}
?>
