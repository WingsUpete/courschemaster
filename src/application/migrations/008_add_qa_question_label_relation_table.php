
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_qa_question_label_relation_table extends CI_Migration{
    
	public function up(){
        //
        $this->db->query(
            'CREATE TABLE `qa_labels_questions` (
                `id_questions` INT NOT NULL,
                `id_labels` INT NOT NULL,
                PRIMARY KEY (`id_questions`, `id_labels`),
                INDEX `fk_ql_qa_labels_idx` (`id_labels` ASC),
                CONSTRAINT `fk_ql_qa_labels`
                  FOREIGN KEY (`id_labels`)
                  REFERENCES `qa_labels` (`id`)
                  ON DELETE NO ACTION
                  ON UPDATE NO ACTION,
                CONSTRAINT `fk_ql_qa_questions`
                  FOREIGN KEY (`id_questions`)
                  REFERENCES `qa_questions` (`id`)
                  ON DELETE NO ACTION
                  ON UPDATE NO ACTION);');
	}

	public function down(){
		$this->db->query('DROP TABLE qa_labels_questions');
	}
}
?>
