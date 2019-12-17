
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Fixed_table_name_typo extends CI_Migration{

	public function up(){

		$this->dbforge->rename_table('cm_plans_couses', 'cm_plans_courses');

	}

	public function down(){
		$this->dbforge->rename_table('cm_plans_courses', 'cm_plans_couses');
	}

}
?>
