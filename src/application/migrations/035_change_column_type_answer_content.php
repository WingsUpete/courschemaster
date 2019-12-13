
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Change_column_type_answer_content extends CI_Migration{

	public function up(){

        if($this->db->field_exists('content', 'qa_answers')){
            $this->dbforge->drop_column('qa_answers', 'content');
        }

        $fields = array(
            'content' => array('type' => 'VARCHAR', 'constraint' => '2048')
        );

        $this->dbforge->add_column('qa_answers', $fields);

	}

	public function down(){
        
    }
}
?>
