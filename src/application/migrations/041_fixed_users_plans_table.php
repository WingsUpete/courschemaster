
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Fixed_users_plans_table extends CI_Migration{

	public function up(){

		$this->db->query('ALTER TABLE `cm_users_plans` 
			DROP FOREIGN KEY `fk_cm_users_plans_cm_colleges1`;');

		$this->db->query('ALTER TABLE `cm_users_plans` 
			CHANGE COLUMN `id_colleges` `id_users` INT(11) NOT NULL ,
			ADD INDEX `fk_cm_users_plans_cm_users1_idx` (`id_users` ASC) VISIBLE,
			DROP INDEX `fk_cm_users_plans_cm_colleges1_idx` ;');

		$this->db->query('ALTER TABLE `cm_users_plans`
			ADD CONSTRAINT `fk_cm_users_plans_cm_users1`
  			FOREIGN KEY (`id_users`)
  			REFERENCES `cm_users` (`id`);');

	}

	public function down(){
		$this->db->query('ALTER TABLE `cm_users_plans` 
			DROP FOREIGN KEY `fk_cm_users_plans_cm_users1`;');

		$this->db->query('ALTER TABLE `cm_users_plans` 
			CHANGE COLUMN `id_users` `id_colleges` INT(11) NOT NULL ,
			ADD INDEX `fk_cm_users_plans_cm_colleges1_idx` (`id_colleges` ASC) VISIBLE,
			DROP INDEX `fk_cm_users_plans_cm_users1_idx` ;');

		$this->db->query('ALTER TABLE `cm_users_plans` 
			ADD CONSTRAINT `fk_cm_users_plans_cm_colleges1`
  			FOREIGN KEY (`id_colleges`)
  			REFERENCES `cm_colleges` (`id`);');
	}
}
?>
