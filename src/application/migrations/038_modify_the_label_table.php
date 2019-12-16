
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Modify_the_label_table extends CI_Migration{

	public function up(){

		$fields = array(
			'label' => array(
				'type' => 'VARCHAR',
				'constraint' => '45'
				)
		);

		$this->dbforge->add_column('cm_course_labels', $fields);

	}

	public function down(){
		$this->dbforge->drop_column('cm_course_labels', 'label');
	}
}
?>
