
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Modify_time_zone_for_database extends CI_Migration{

	public function up(){

		$query_1 = 'set global time_zone = \'+8:00\';';
		$query_2 = 'flush privileges;';

		$this->db->query($query_1);
		$this->db->query($query_2);

	}

	public function down(){
		$query_1 = 'set global time_zone = \'+0:00\';';
		$query_2 = 'flush privileges;';

		$this->db->query($query_1);
		$this->db->query($query_2);
	}
}
?>
