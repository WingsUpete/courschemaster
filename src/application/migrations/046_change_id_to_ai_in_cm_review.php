<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Change_id_to_ai_in_cm_review extends CI_Migration{

	public function up(){

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
