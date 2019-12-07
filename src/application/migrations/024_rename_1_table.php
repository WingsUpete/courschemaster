<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Rename_1_table extends CI_Migration{
    
	public function up(){
        
        $this->db->query('ALTER TABLE `cm_users_collect_courschems` 
        RENAME TO  `cm_users_collect_courschemas` ;
        ');
    }

	public function down(){
        $this->db->query('ALTER TABLE `cm_users_collect_courschemas` 
        RENAME TO  `cm_users_collect_courschems` ;');
	}
}
?>