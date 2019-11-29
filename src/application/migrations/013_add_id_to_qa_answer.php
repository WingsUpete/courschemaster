<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_id_to_qa_answer extends CI_Migration{
    
	public function up(){
        
        $this->db->query('ALTER TABLE `qa_answers` 
        ADD COLUMN `id` INT NOT NULL AUTO_INCREMENT AFTER `vote`,
        DROP PRIMARY KEY,
        ADD PRIMARY KEY (`id`),
        ADD INDEX `fk_qa_answers_qa_questions_idx` (`id_questions` ASC);      
        ');

        $this->db->query(' ALTER TABLE `qa_answers` 
        ADD CONSTRAINT `fk_qa_answers_qa_questions`
          FOREIGN KEY (`id_questions`)
          REFERENCES `qa_questions` (`id`)
          ON DELETE NO ACTION
          ON UPDATE NO ACTION;  ');
	}

	public function down(){

        $this->db->query('ALTER TABLE `qa_answers` 
        DROP FOREIGN KEY `fk_qa_answers_qa_questions`;');

		$this->db->query('ALTER TABLE `qa_answers` 
        DROP INDEX `fk_qa_answers_qa_questions_idx` ;
        ');

        $this->db->query('ALTER TABLE `qa_answers` 
        DROP COLUMN `id`,
        DROP PRIMARY KEY,
        ADD PRIMARY KEY (`id_questions`, `id_users_provider`);');
	}
}
?>