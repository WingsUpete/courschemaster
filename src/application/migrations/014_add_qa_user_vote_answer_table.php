<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_qa_user_vote_answer_table extends CI_Migration{
    
	public function up(){
        
        $this->db->query('CREATE TABLE `qa_user_vote_answer` (
            `id_users` INT NOT NULL,
            `id_answers` INT NOT NULL,
            PRIMARY KEY (`id_users`, `id_answers`),
            INDEX `fk_uva_answer_id_idx` (`id_answers` ASC),
            CONSTRAINT `fk_uva_answer_id`
              FOREIGN KEY (`id_answers`)
              REFERENCES `qa_answers` (`id`)
              ON DELETE NO ACTION
              ON UPDATE NO ACTION,
            CONSTRAINT `fk_uva_user_id`
              FOREIGN KEY (`id_users`)
              REFERENCES `cm_users` (`id`)
              ON DELETE NO ACTION
              ON UPDATE NO ACTION);');
	}

	public function down(){

        $this->db->query('DROP TABLE qa_user_vote_answer');

	}
}
?>