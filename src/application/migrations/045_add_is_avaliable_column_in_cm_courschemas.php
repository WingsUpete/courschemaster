<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_is_avaliable_column_in_cm_courschemas extends CI_Migration{

	public function up(){

		$fields = array(
            'is_available' => array('type'=>'INT')
        );
        if( ! $this->db->field_exists('is_available', 'cm_courschemas')){
            $this->dbforge->add_column('cm_courschemas', $fields);
            $this->db->update('cm_courschemas', array('is_available' => 1));
        }
	}

	public function down(){
        $this->safe_drop_column('cm_courschemas', 'is_available');
    }
    
    protected function safe_drop_column($table, $column){
        if($this->db->field_exists($column, $table)){
            $this->dbforge->drop_column($table, $column);
        }
    }

}
?>
