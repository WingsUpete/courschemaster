<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Ai_in_qa_replies_table extends CI_Migration{

	public function up(){

        $this->db->query('ALTER TABLE `qa_replies` 
        CHANGE COLUMN `id` `id` INT(11) NOT NULL AUTO_INCREMENT ;
        ');


	}

	public function down(){

        $this->db->query('DROP TABLE qa_replies');

	}
}
?>
