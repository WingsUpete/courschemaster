<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_id_courschemas_field_in_users extends CI_Migration{

	public function up(){

        $this->db->query('ALTER TABLE `cm_users` 
            ADD COLUMN `id_courschemas` INT NULL AFTER `id_majors`,
            ADD INDEX `fk_cm_users_cm_courschemas_idx` (`id_courschemas` ASC);
        ');

		$this->db->query('ALTER TABLE `cm_users` 
            ADD CONSTRAINT `fk_cm_users_cm_courschemas`
            FOREIGN KEY (`id_courschemas`)
            REFERENCES `cm_courschemas` (`id`)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION;
          ');

	}

	public function down(){

        $this->db->query('ALTER TABLE `cm_users` 
            DROP FOREIGN KEY `fk_cm_users_cm_courschemas`;'
        );

		$this->db->query('ALTER TABLE `cm_users` 
            DROP COLUMN `id_courschemas`,
            DROP INDEX `fk_cm_users_cm_courschemas_idx` ;
        ');

	}
}
?>
