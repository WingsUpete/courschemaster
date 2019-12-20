<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_comment_in_cm_review extends CI_Migration{

	public function up(){

        if( ! $this->db->field_exists('comment', 'cm_review')){
            $fields = array(
                'comment' => array('type' => 'VARCHAR', 'constraint' => 1024)
            );
            $this->dbforge->add_column('cm_review', $fields);
        }
	}

	public function down(){
        $this->safe_drop_column('cm_review', 'comment');
    }
    
    protected function safe_drop_column($table, $column){
        if($this->db->field_exists($column, $table)){
            $this->dbforge->drop_column($table, $column);
        }
    }

}
?>
