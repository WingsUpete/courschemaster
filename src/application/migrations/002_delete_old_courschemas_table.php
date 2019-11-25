<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Delete_old_courschemas_table extends CI_Migration
{

	public function up()
	{
		$close = 'SET FOREIGN_KEY_CHECKS=0';
		$open = 'SET FOREIGN_KEY_CHECKS=1';
		$this->db->query($close);
		$this->dbforge->drop_table('cm_groups_courses',TRUE);
		$this->dbforge->drop_table('cm_groups',TRUE);
		$this->dbforge->drop_table('cm_courschemas_groups',TRUE);
		$this->dbforge->drop_table('cm_types',TRUE);
		$this->db->query($open);
	}

	public function down()
	{
		//nothing
	}
}

?>
