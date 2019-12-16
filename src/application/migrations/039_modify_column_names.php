
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Modify_column_names extends CI_Migration{

	public function up(){

		$this->db->query('ALTER TABLE `cm_users_courses` 
      DROP FOREIGN KEY `cm_users_courses_ibfk_1`,
      DROP FOREIGN KEY `cm_users_courses_ibfk_2`;
		');

		$this->db->query('ALTER TABLE `cm_users_courses` 
      CHANGE COLUMN `user_id` `id_users` INT(11) NOT NULL ,
      CHANGE COLUMN `course_id` `id_courses` INT(11) NOT NULL ;
		');

		$this->db->query('ALTER TABLE `cm_users_courses` 
      ADD CONSTRAINT `cm_users_courses_ibfk_1`
        FOREIGN KEY (`id_users`)
        REFERENCES `cm_users` (`id`),
      ADD CONSTRAINT `cm_users_courses_ibfk_2`
        FOREIGN KEY (`id_courses`)
        REFERENCES `cm_courses` (`id`);
		');

	}

	public function down(){

		$this->db->query('ALTER TABLE `cm_users_courses` 
			DROP FOREIGN KEY `cm_users_courses_ibfk_1`,
			DROP FOREIGN KEY `cm_users_courses_ibfk_2`;
		');

		$this->db->query('ALTER TABLE `cm_users_courses` 
			CHANGE COLUMN `id_users` `user_id` INT(11) NOT NULL ,
			CHANGE COLUMN `id_courses` `course_id` INT(11) NOT NULL ;
		');

		$this->db->query('ALTER TABLE `cm_users_courses` 
			ADD CONSTRAINT `cm_users_courses_ibfk_1`
			FOREIGN KEY (`user_id`)
			REFERENCES `cm_users` (`id`),
			ADD CONSTRAINT `cm_users_courses_ibfk_2`
			FOREIGN KEY (`course_id`)
			REFERENCES `cm_courses` (`id`);
		');
	}
}
?>
