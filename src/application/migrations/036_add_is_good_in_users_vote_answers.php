
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_is_good_in_users_vote_answers extends CI_Migration{

	public function up(){

        if( ! $this->db->field_exists('is_good', 'qa_user_vote_answer')){
            $fields = array(
                'is_good' => array('type' => 'INT')
            );
    
            $this->dbforge->add_column('qa_user_vote_answer', $fields);
        }
	}

	public function down(){
        if($this->db->field_exists('is_good', 'qa_user_vote_answer')){
            $this->dbforge->drop_column('qa_user_vote_answer', 'is_good');
        }
    }
}
?>
