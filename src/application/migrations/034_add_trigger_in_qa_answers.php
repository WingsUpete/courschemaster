<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_trigger_in_qa_answers extends CI_Migration{

	public function up(){

        $this->db->query('set global log_bin_trust_function_creators=1;');

        $this->db->query('DROP TRIGGER IF EXISTS `post_answer_trigger`;');
        $this->db->query('DROP TRIGGER IF EXISTS `delete_answer_trigger`;');


        $this->db->query('
            CREATE TRIGGER post_answer_trigger 
            after insert on qa_answers 
            for each row
            begin
                update qa_questions set qa_questions.answers_cnt =  qa_questions.answers_cnt + 1
                where qa_questions.id = new.id_questions;
            end
        ');

        $this->db->query('
            CREATE TRIGGER delete_answer_trigger
            after delete on qa_answers
            for each row
            begin
                update qa_questions set qa_questions.answers_cnt =  qa_questions.answers_cnt - 1
                where qa_questions.id = old.id_questions;
            end
        ');
	}

	public function down(){
        $this->db->query('DROP TRIGGER IF EXISTS `post_answer_trigger`;');
        $this->db->query('DROP TRIGGER IF EXISTS `delete_answer_trigger`;');
    }
}
?>
