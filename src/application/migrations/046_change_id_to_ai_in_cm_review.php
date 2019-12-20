<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Change_id_to_ai_in_cm_review extends CI_Migration{

	public function up(){

        if( ! $this->db->table_exists('cm_review')){
            $this->db->query('CREATE TABLE `cm_review` (
                `id` INT NOT NULL,
                `id_courschemas` INT NULL,
                `id_majors` INT NULL,
                `status` VARCHAR(45) NULL,
                PRIMARY KEY (`id`),
                INDEX `fk_review_courschemas_idx` (`id_courschemas` ASC),
                INDEX `fk_review_majors_idx` (`id_majors` ASC),
                CONSTRAINT `fk_review_courschemas`
                  FOREIGN KEY (`id_courschemas`)
                  REFERENCES `cm_courschemas` (`id`)
                  ON DELETE NO ACTION
                  ON UPDATE NO ACTION,
                CONSTRAINT `fk_review_majors`
                  FOREIGN KEY (`id_majors`)
                  REFERENCES `cm_majors` (`id`)
                  ON DELETE NO ACTION
                  ON UPDATE NO ACTION);');
        }

		$this->db->query('ALTER TABLE `cm_review` 
        CHANGE COLUMN `id` `id` INT(11) NOT NULL AUTO_INCREMENT ;');
	}

	public function down(){
        $this->db->query('ALTER TABLE `cm_review` 
        CHANGE COLUMN `id` `id` INT(11) NOT NULL ;
        ');
    }


}
?>
