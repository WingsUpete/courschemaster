<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Data_model extends CI_Model{

	/**
	 * this method is used to clear all the data in the table "cm_departments"
	 *
	 * in the same time, the table "cm_prerequisites" and "cm_courses" will be cleared too
	 * thus, take care of using this method
	 *
	 */
	public function clean_tables(){
		$this->db->query('SET FOREIGN_KEY_CHECKS = 0;');
		$this->db->emPty_table('cm_users_courses');
		$this->db->emPty_table('cm_users_departments');
		$this->db->emPty_table('cm_users_majors');
		$this->db->emPty_table('cm_users_collect_courschemas');
		$this->db->empty_table('cm_courschemas');
		$this->db->empty_table('cm_majors');
		$this->db->empty_table('cm_prerequisites');
		$this->db->empty_table('cm_courses');
		$this->db->empty_table('cm_departments');
		$this->db->query('SET FOREIGN_KEY_CHECKS = 1;');
	}

	/**
	 * this method is used to add one department record to the database table "cm_departments"
	 *
	 * @param $code: the code of this department
	 * @param $name: the Chinese name of this department
	 * @param $en_name: the English name of this department
	 * @return bool: successfully or not
	 */
	public function add_one_department($code, $name, $en_name){

		$data = array(
			'code' => $code,
			'name' => $name,
			'en_name' => $en_name
		);

		$this->db->insert('cm_departments', $data);
		return $this->db->insert_id();
	}

	/**
	 * this method is used to delete one department record from the database
	 * you should delete the courses before use this method
	 *
	 * @param $code: the code for the department which will be deleted
	 */
	public function delete_one_department($code){
		$this->db
			->where('cm_departments.code', $code)
			->delete('cm_departments');
	}

	/**
	 * this method is used to query the information of all the department
	 *
	 * @return array: the query result
	 */
	public function query_all_department(){
		$result = $this->db
			->select('*')
			->from('cm_departments')
			->get()->result();

		return $result;
	}

	/**
	 * this method is used to query the information of the department by code
	 *
	 * @param $code: the code for the department, can just a part of the exact code
	 * @return array: the query result
	 */
	public function query_department_by_code($code){
		$result = $this->db
			->select('*')
			->from('cm_departments')
			->like('cm_departments.code', $code, 'both')
			->get()->result();

		return $result;
	}

	/**
	 * this method is used to query the department by Chinese or English name
	 *
	 * @param $name: the name of the department, can just a part of the exact code
	 * @return array: the query result
	 */
	public function query_department_by_name($name){
		$result = $this->db
			->select('*')
			->from('cm_departments')
			->like('cm_departments.name', $name, 'both')
			->or_like('cm_departments.en_name', $name, 'both')
			->get()->result();

		return $result;
	}

	/**
	 * this method is used to update the information of a department
	 * make sure all you value valid before using this method
	 *
	 * @param $old_code: the old code of the department
	 * @param $new_code: the new code of the department
	 * @param $new_name: the new Chinese name of the department
	 * @param $new_en_name: the new English name of the department
	 */
	public function update_department_info($old_code, $new_code, $new_name, $new_en_name){

		$data = array(
			'code' => $new_code,
			'name' => $new_name,
			'en_name' => $new_en_name
		);

		$this->db
			->where('cm_departments.code', $old_code)
			->update('cm_departments', $data);

	}

	public function add_majors_batch($data){
		return $this->db->insert_batch('cm_majors', $data);
	}
}
?>
