<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_user_course_relation extends CI_Migration
{

	public function up()
	{
		$this->dbforge->drop_table('cm_users_courses',TRUE);
//		Considering the situation of retaking the course, so set id as the primary key
		$this->dbforge->add_field('id');
		$fields = array(
			'user_id' => array(
				'type' => 'INT'
			),
			'semester' => array(
				'type' => 'VARCHAR',
				'constraint' => '20',
			),
			'course_id' => array(
				'type' => 'INT'
			),
			'level' => array(
				'type' => 'VARCHAR',
				'constraint' => '5',
			),
			'point' => array(
				'type' => 'INT'
			),
			'assessment_method' => array(
				'type' => 'VARCHAR',
				'constraint' => '10',
			),
			'en_assessment_method' => array(
				'type' => 'VARCHAR',
				'constraint' => '20',
			)
		);
		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('id');

		$this->dbforge->create_table('cm_users_courses', TRUE);
		$sql_1 = 'ALTER TABLE cm_users_courses ADD FOREIGN KEY (user_id) REFERENCES cm_users(id)';
		$this->db->query($sql_1);
		$sql_2 = 'ALTER TABLE cm_users_courses ADD FOREIGN KEY (course_id) REFERENCES cm_courses(id)';
		$this->db->query($sql_2);

	}

	public function down()
	{
		$this->dbforge->drop_table('cm_users_courses',TRUE);
	}

}
?>
