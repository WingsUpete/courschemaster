<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Enlarge_the_input_field_in_log extends CI_Migration{

	public function up(){

        $this->db->query('ALTER TABLE `all_log` 
        CHANGE COLUMN `input` `input` VARCHAR(1024) NOT NULL ;
        ');


	}

	public function down(){
	}
}
?>
