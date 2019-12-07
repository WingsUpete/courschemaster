<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Modify_cm_courschemas_table extends CI_Migration{
    
	public function up(){
        
        $this->safe_drop_column('cm_courschemas', 'matryona');
        $this->safe_drop_column('cm_courschemas', 'description');
        $this->safe_drop_column('cm_courschemas', 'en_description');
        $this->safe_drop_column('cm_courschemas', 'hash_id');
        
        if( ! $this->db->field_exists('pdf_url', 'cm_courschemas')){
            $fields = array(
                'json'    => array('type' => 'TEXT'),
                'pdf_url' => array('type' => 'VARCHAR', 'constraint' => '128')
            );
            $this->dbforge->add_column('cm_courschemas', $fields);
    
            $this->db->update('cm_courschemas', array('cm_courschemas.pdf_url' => 'default.pdf'));
        }
    }

	public function down(){
        
    }
    
    private function safe_drop_column($table, $field){
        if($this->db->field_exists($field, $table)){
            $this->dbforge->drop_column($table, $field);
        }
    }
}
?>