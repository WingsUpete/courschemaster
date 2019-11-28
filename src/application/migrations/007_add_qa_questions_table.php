<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_qa_questions_table extends CI_Migration{
    
	public function up(){
        //
        $this->db->query(
            'CREATE TABLE `cm`.`qa_questions` (
                `id` INT NOT NULL,
                `title` VARCHAR(128) NOT NULL,
                `description` VARCHAR(512) NOT NULL,
                `id_users_questioner` INT NOT NULL,
                `timestamp` DATETIME NOT NULL,
                `authentication` INT NOT NULL,
                `num_of_views` INT NOT NULL,
                PRIMARY KEY (`id`),
                INDEX `fk_qa_question_cm_users_idx` (`id_users_questioner` ASC),
                CONSTRAINT `fk_qa_question_cm_users`
                  FOREIGN KEY (`id_users_questioner`)
                  REFERENCES `cm`.`cm_users` (`id`)
                  ON DELETE NO ACTION
                  ON UPDATE NO ACTION);');
	}

	public function down(){
		$this->db->query('DROP TABLE qa_questions');
	}
}
?>
