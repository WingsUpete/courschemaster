<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_id_answers_in_qa_replies extends CI_Migration{

	public function up(){

        $this->db->query('ALTER TABLE `qa_replies` 
            ADD COLUMN `id_answers` INT NULL AFTER `timestamp`,
            ADD INDEX `fk_replies_answers_answers_idx` (`id_answers` ASC);
        ');

        $this->db->query('ALTER TABLE `qa_replies` 
            ADD CONSTRAINT `fk_replies_answers_answers`
            FOREIGN KEY (`id_answers`)
            REFERENCES `qa_answers` (`id`)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION;
        ');


	}

	public function down(){

        $this->db->query('ALTER TABLE `qa_replies` 
            DROP FOREIGN KEY `fk_replies_answers_answers`;
        ');

        $this->db->query('ALTER TABLE `qa_replies` 
            DROP COLUMN `id_answers`,
            DROP INDEX `fk_replies_answers_answers_idx` ;
        ');
	}
}
?>
