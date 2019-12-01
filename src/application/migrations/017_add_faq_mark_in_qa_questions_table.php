<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_faq_mark_in_qa_questions_table extends CI_Migration{
    
	public function up(){
        
        $field = array(
            'faq_mark' => [
				'type' => 'INT'
			]
        );
        $this->dbforge->add_column('qa_questions',  $field);
        $this->db->update('qa_questions', ['faq_mark' => 0]);
	}

	public function down(){

        if( $this->db->field_exists('faq_mark', 'qa_questions')){
			$this->dbforge->drop_column('qa_questions', 'faq_mark');
		}

	}
}
?>