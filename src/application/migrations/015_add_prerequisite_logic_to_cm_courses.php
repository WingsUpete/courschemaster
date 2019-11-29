<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_prerequisite_logic_to_cm_courses extends CI_Migration{
    
	public function up(){
        
        $this->db->query('ALTER TABLE `cm_courses` 
        ADD COLUMN `prerequisite_logic` VARCHAR(128) NULL AFTER `description_en`;');
	}

	public function down(){

        $this->db->query('ALTER TABLE `cm_courses` 
        DROP COLUMN `prerequisite_logic`;
        ');

	}
}
?>