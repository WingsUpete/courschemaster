<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_qa_answers_table extends CI_Migration{
    
	public function up(){
        //
        $this->db->query(
            'CREATE TABLE `qa_answers` (
                `id_questions` INT NOT NULL,
                `content` BLOB NOT NULL,
                `id_users_provider` INT NOT NULL,
                `timestamp` DATETIME NOT NULL,
                `authentication` INT NOT NULL,
                `vote` INT NOT NULL,
                PRIMARY KEY (`id_questions`, `id_users_provider`));');
	}

	public function down(){
		$this->db->query('DROP TABLE qa_answers');
	}
}
?>
