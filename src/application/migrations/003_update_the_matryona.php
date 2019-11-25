<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Update_the_matryona extends CI_Migration
{

	public function up()
	{
		if( $this->db->field_exists('description', 'cm_courschemas')){
			$this->dbforge->drop_column('cm_courschemas', 'description');
		}
		$field = [
			'matryona' => [
				'type' => 'MEDIUMTEXT'
			],
			'description' => [
				'type' => 'TINYTEXT'
			],
			'en_description' => [
				'type' => 'TINYTEXT'
			],
			'version' => [
				'type' => 'VARCHAR',
				'constraint' => 45
			],
			'group' => [
				'type' => 'VARCHAR',
				'constraint' => 512
			]
		];
		$this->dbforge->add_column('cm_courschemas',  $field);

		$this->db->update('cm_courschemas', ['matryona' => 'null']);

	}

	public function down()
	{
		if( $this->db->field_exists('matryona', 'cm_courschemas')){
			$this->dbforge->drop_column('cm_courschemas', 'matryona');
		}
		if( $this->db->field_exists('description', 'cm_courschemas')){
			$this->dbforge->drop_column('cm_courschemas', 'description');
		}
		if( $this->db->field_exists('en_description', 'cm_courschemas')){
			$this->dbforge->drop_column('cm_courschemas', 'en_description');
		}
		if( $this->db->field_exists('version', 'cm_courschemas')){
			$this->dbforge->drop_column('cm_courschemas', 'version');
		}
		if( $this->db->field_exists('group', 'cm_courschemas')){
			$this->dbforge->drop_column('cm_courschemas', 'group');
		}

		$field = [
			'description' => [
				'type' => 'VARCHAR',
				'constraint' => 45
			]
		];
		$this->dbforge->add_column('cm_courschemas',  $field);
	}

}
?>
