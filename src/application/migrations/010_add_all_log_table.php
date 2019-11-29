<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_all_log_table extends CI_Migration{
    
	public function up(){
        //
        $this->db->query(
            'CREATE TABLE `all_log` (
                `id_users` INT NOT NULL,
                `operation` VARCHAR(45) NOT NULL,
                `input` VARCHAR(128) NOT NULL,
                `output` VARCHAR(128) NOT NULL,
                `timestamp` DATETIME NOT NULL,
                PRIMARY KEY (`id_users`, `operation`, `input`, `output`, `timestamp`),
                CONSTRAINT `fk_all_log_cm_users`
                  FOREIGN KEY (`id_users`)
                  REFERENCES `cm_users` (`id`)
                  ON DELETE NO ACTION
                  ON UPDATE NO ACTION);');
	}

	public function down(){
		$this->db->query('DROP TABLE all_log');
	}
}
?>