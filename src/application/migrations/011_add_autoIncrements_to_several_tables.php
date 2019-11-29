<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_autoIncrements_to_several_tables extends CI_Migration{
    
	public function up(){
		$this->db->query('SET FOREIGN_KEY_CHECKS = 0;');
        $this->db->query('ALTER TABLE `qa_labels` 
        CHANGE COLUMN `id` `id` INT(11) NOT NULL AUTO_INCREMENT ;');
        $this->db->query('ALTER TABLE `qa_questions` 
		CHANGE COLUMN `id` `id` INT(11) NOT NULL AUTO_INCREMENT ;');
		$this->db->query('SET FOREIGN_KEY_CHECKS = 1;');
	}

	public function down(){
		//
	}
}
?>