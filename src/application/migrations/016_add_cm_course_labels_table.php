<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_cm_course_labels_table extends CI_Migration{
    
	public function up(){
        
        $this->db->query('CREATE TABLE `cm_course_labels` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `cn_name` VARCHAR(45) NULL,
            `en_name` VARCHAR(45) NULL,
            PRIMARY KEY (`id`));
            ');

        $this->db->query('CREATE TABLE `cm_course_label_courschemas` (
            `id_courses` INT NOT NULL,
            `id_courschemas` INT NOT NULL,
            `id_labels` INT NOT NULL,
            PRIMARY KEY (`id_courses`, `id_courschemas`, `id_labels`),
            INDEX `fk_clc_courschemas_id_idx` (`id_courschemas` ASC),
            INDEX `fk_clc_label_id_idx` (`id_labels` ASC),
            CONSTRAINT `fk_clc_course_id`
              FOREIGN KEY (`id_courses`)
              REFERENCES `cm_courses` (`id`)
              ON DELETE NO ACTION
              ON UPDATE NO ACTION,
            CONSTRAINT `fk_clc_courschemas_id`
              FOREIGN KEY (`id_courschemas`)
              REFERENCES `cm_courschemas` (`id`)
              ON DELETE NO ACTION
              ON UPDATE NO ACTION,
            CONSTRAINT `fk_clc_label_id`
              FOREIGN KEY (`id_labels`)
              REFERENCES `cm_course_labels` (`id`)
              ON DELETE NO ACTION
              ON UPDATE NO ACTION);
          ');
	}

	public function down(){

        $this->db->query('DROP TABLE cm_course_label_courschemas');

        $this->db->query('DROP TABLE cm_course_labels');

	}
}
?>