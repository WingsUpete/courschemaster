<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_one_single_row_in_privileges extends CI_Migration{

	public function up(){

		$this->db->query('INSERT INTO `cm_privileges` 
        (`id`, `name`, `secretary`, `teaching_affairs_department`, `mentor`, `student`, `visitor`, `system_configs`) 
        VALUES (\'4\', \'tao_x\', \'0\', \'20\', \'0\', \'0\', \'20\', \'0\');');

	}

	public function down(){

	}

}
?>
