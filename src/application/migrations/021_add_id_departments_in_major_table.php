<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_id_departments_in_major_table extends CI_Migration{
    
	public function up(){
        
        $this->db->query('ALTER TABLE `cm_majors` 
            ADD COLUMN `id_departments` INT NULL AFTER `en_name`,
            ADD INDEX `fk_departments_majors_idx` (`id_departments` ASC);
        ');

        $this->db->query('ALTER TABLE `cm_majors` 
            ADD CONSTRAINT `fk_departments_majors`
            FOREIGN KEY (`id_departments`)
            REFERENCES `cm_departments` (`id`)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION;
        ');

	}

	public function down(){

        if( $this->db->field_exists('id_departments', 'cm_majors')){
            $this->db->query('ALTER TABLE `cm_majors` 
            DROP FOREIGN KEY `fk_departments_majors`;
            ');
			$this->db->query('ALTER TABLE `cm_majors` 
                DROP COLUMN `id_departments`,
                DROP INDEX `fk_departments_majors_idx` ;
            ');
		}
        
	}
}
?>