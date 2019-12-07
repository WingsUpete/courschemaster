<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_majors_departments_table extends CI_Migration{
    
	public function up(){
        
        $this->db->query('CREATE TABLE `cm_majors_departments` (
            `id_majors` INT NOT NULL,
            `id_departments` INT NOT NULL,
            PRIMARY KEY (`id_majors`, `id_departments`),
            INDEX `fk_majors_departments_departments_idx` (`id_departments` ASC),
            CONSTRAINT `fk_majors_departments_majors`
              FOREIGN KEY (`id_majors`)
              REFERENCES `cm_majors` (`id`)
              ON DELETE NO ACTION
              ON UPDATE NO ACTION,
            CONSTRAINT `fk_majors_departments_departments`
              FOREIGN KEY (`id_departments`)
              REFERENCES `cm_departments` (`id`)
              ON DELETE NO ACTION
              ON UPDATE NO ACTION);
        ');

	}

	public function down(){

        $this->db->query('DROP TABLE cm_majors_departments');
        
	}
}
?>