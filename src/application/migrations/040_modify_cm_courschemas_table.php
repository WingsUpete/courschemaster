
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Modify_cm_courschemas_table extends CI_Migration{

	public function up(){

		$this->safe_drop_column('cm_courschemas', 'version');
		$this->safe_drop_column('cm_courschemas', 'group');
        $this->safe_drop_column('cm_courschemas', 'json');
        $this->safe_drop_column('cm_courschemas', 'pdf_url');

        $fields = array(
            'list_json_en'  => array('type' => 'TEXT'),
            'list_json_cn'  => array('type' => 'TEXT'),
            'pdf_url_en'    => array('type' => 'VARCHAR', 'CONSTRAINT' => 256),
            'pdf_url_cn'    => array('type' => 'VARCHAR', 'CONSTRAINT' => 256),
            'graph_json_en' => array('type' => 'TEXT'),
            'graph_json_cn' => array('type' => 'TEXT')
        );

        if( ! $this->db->field_exists('graph_json_en', 'cm_courschemas')){
            $this->dbforge->add_column('cm_courschemas', $fields);
        }
	}

	public function down(){
        $this->safe_drop_column('cm_courschemas', 'list_json_en' );
        $this->safe_drop_column('cm_courschemas', 'list_json_cn' );
        $this->safe_drop_column('cm_courschemas', 'pdf_url_en'   );
        $this->safe_drop_column('cm_courschemas', 'pdf_url_cn'   );
        $this->safe_drop_column('cm_courschemas', 'graph_json_en');
        $this->safe_drop_column('cm_courschemas', 'graph_json_cn');

        $fields = array(
            'version' => array('type' => 'VARCHAR', 'CONSTRAINT' => 45),
            'group'   => array('type' => 'VARCHAR', 'CONSTRAINT' => 512),
            'json'    => array('type' => 'TEXT'),
            'pdf_url' => array('type' => 'VARCHAR', 'CONSTRAINT' => 128)
        );

        if( ! $this->db->field_exists('version', 'cm_courschemas')){
            $this->dbforge->add_column('cm_courschemas', $fields);
        }
		
    }
    
    protected function safe_drop_column($table, $column){
        if($this->db->field_exists($column, $table)){
            $this->dbforge->drop_column($table, $column);
        }
    }
}
?>
