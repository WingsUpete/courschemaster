<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_qa_labels_table extends CI_Migration{
    
	public function up(){
        //
        $this->db->query(
            'CREATE TABLE `qa_labels` (
            `id` INT NOT NULL,
            `cn_name` VARCHAR(45) NOT NULL,
            `en_name` VARCHAR(45) NOT NULL,
            PRIMARY KEY (`id`));');
	}

	public function down(){
		$this->db->query('DROP TABLE qa_labels');
	}
}
?>
