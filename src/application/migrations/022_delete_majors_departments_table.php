<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Delete_majors_departments_table extends CI_Migration{
    
	public function up(){
        
        $this->db->query('DROP TABLE cm_majors_departments');

    }

	public function down(){

	}
}
?>