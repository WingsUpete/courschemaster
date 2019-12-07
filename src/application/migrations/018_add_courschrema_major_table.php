<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_courschrema_major_table extends CI_Migration{
    
	public function up(){
        
        $this->db->query('CREATE TABLE `cm_courschemas_majors` (
            `id_courschemas` INT NOT NULL,
            `id_majors` INT NOT NULL,
            PRIMARY KEY (`id_courschemas`, `id_majors`),
            INDEX `fk_courschemas_majors_majors_idx` (`id_majors` ASC),
            CONSTRAINT `fk_courschemas_majors_courschemas`
              FOREIGN KEY (`id_courschemas`)
              REFERENCES `cm_courschemas` (`id`)
              ON DELETE NO ACTION
              ON UPDATE NO ACTION,
            CONSTRAINT `fk_courschemas_majors_majors`
              FOREIGN KEY (`id_majors`)
              REFERENCES `cm_majors` (`id`)
              ON DELETE NO ACTION
              ON UPDATE NO ACTION);
        ');

	}

	public function down(){

                $this->db->query('DROP TABLE cm_courschemas_majors');
        
	}
}
?>