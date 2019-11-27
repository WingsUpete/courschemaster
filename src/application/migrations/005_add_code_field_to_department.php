<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_code_field_to_department extends CI_Migration{

	public function up(){
		//
		$field = [
			'code' => [
				'type' => 'VARCHAR',
				'constraint' => '10'
			]
		];

		$this->dbforge->add_column('cm_departments',  $field);
	}

	public function down(){
		$this->drop_column('cm_departments', 'code');
	}

	protected function drop_column($table, $field){
		if( $this->db->field_exists($field, $table)){
			$this->dbforge->drop_column($table, $field);
		}
	}
}


?>
