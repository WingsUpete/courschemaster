<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_answers_cnt_in_qa_questions extends CI_Migration{

	public function up(){

        if( ! $this->db->field_exists('answers_cnt', 'qa_questions')){
            $fields = array(
                'answers_cnt' => array('type' => 'INT')
            );
            $this->dbforge->add_column('qa_questions', $fields);
            $this->update_answers_cnt();
        }

	}

	public function down(){
        if($this->db->field_exists('answers_cnt', 'qa_questions')){
        
            $this->dbforge->drop_column('qa_questions', 'answers_cnt');

        }
        
    }
    
    protected function update_answers_cnt(){

        $this->db->update('qa_questions', array('answers_cnt' => 0));

        $data = $this->db->select('
                qa_questions.id      AS id,
                COUNT(qa_answers.id) AS answers_cnt
            ')
            ->from('qa_questions')
            ->join('qa_answers', 'qa_answers.id_questions = qa_questions.id', 'inner')
            ->group_by('qa_answers.id_questions')
            ->get()
            ->result_array();
        
        $this->db->update_batch('qa_questions', $data, 'id');
    }
}
?>
