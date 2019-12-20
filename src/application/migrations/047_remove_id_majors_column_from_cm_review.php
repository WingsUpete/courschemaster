<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Remove_id_majors_column_from_cm_review extends CI_Migration{

	public function up(){

		$this->db->query('ALTER TABLE `cm_review` 
        DROP FOREIGN KEY `fk_review_majors`;');

        $this->db->query('ALTER TABLE `cm_review` 
        DROP COLUMN `id_majors`,
        DROP INDEX `fk_review_majors_idx` ;');
	}

	public function down(){
        $this->db->query('ALTER TABLE `cm_review` 
        ADD COLUMN `id_majors` INT NULL AFTER `status`,
        ADD INDEX `fk_review_majors_idx` (`id_majors` ASC);');

        $this->db->query('ALTER TABLE `cm_review` 
        ADD CONSTRAINT `fk_review_majors`
          FOREIGN KEY (`id_majors`)
          REFERENCES `cm_majors` (`id`)
          ON DELETE NO ACTION
          ON UPDATE NO ACTION;');
    }
    
    protected function safe_drop_column($table, $column){
        if($this->db->field_exists($column, $table)){
            $this->dbforge->drop_column($table, $column);
        }
    }

}
?>
