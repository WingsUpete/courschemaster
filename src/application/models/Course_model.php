<?php defined('BASEPATH') OR exit('No direct script access allowed');

require dirname(__FILE__)."\..\..\../vendor/autoload.php";
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Course_model extends CI_Model{

	public function query_course_pre($code){
		$result = $this->db
			->select('cm_courses.code AS main,
			cm_prerequisites.id_pre_course AS pre,
			type AS type')
			->from('cm_prerequisites')
			->join('cm_courses', 'cm_prerequisites.id_main_course = cm_courses.id')
			->where('cm_courses.code', $code)
			->get()->result_array();

		$counter = 0;

		foreach ($result as $row){
			$pre = $row['pre'];

			$pre_res = $this->db
				->select('cm_courses.code as pre')
				->from('cm_courses')
				->where('cm_courses.id', $pre)
				->get()->result_array();

			$result[$counter]['pre'] = $pre_res[0]['pre'];
			$counter += 1;
		}

		return $result;

	}

	/**
	 * This method is used to determine if one course exists in database or not
	 *
	 * @param $code: the code of the course
	 * @return bool: exits or not
	 */
	public function one_course_exits_or_not($code){
		$count = $this->db
			->where('cm_courses.code', $code)
			->from('cm_courses')
			->count_all_results();
		if ($count == 0){
			return False;
		}else{
			return True;
		}
	}

	/**
	 * this method is used to query all the course info
	 *
	 * @param $language: the language of query info
	 * @return mixed: the query result
	 */
	public function get_all_course_info($language){

		if($language == 'english'){
			$result = $this->db
				->select('cm_courses.code AS course_id, 
				cm_courses.en_name AS course_name, 
				cm_courses.credit AS total_credit, 
				cm_courses.weekly_period AS weekly_period,
				cm_departments.en_name AS department')
				->from('cm_courses')
				->join('cm_departments', 'cm_departments.id = cm_courses.id_departments')
				->get()->result_array();
		}else{
			$result = $this->db
				->select('cm_courses.code AS course_id, 
				cm_courses.name AS course_name, 
				cm_courses.credit AS total_credit, 
				cm_courses.weekly_period AS weekly_period,
				cm_departments.name AS department')
				->from('cm_courses')
				->join('cm_departments', 'cm_departments.id = cm_courses.id_departments')
				->get()->result_array();
		}

		return $result;

	}

	/**
	 * This method is used to query the course id by fuzzy search
	 *
	 * @param $match: the matching string, can match the cn_name, en_name or code
	 * @return mixed: the query result
	 */
	public function get_course_id_by_fuzzy_search($match){
		$result = $this->db
			->select('id AS id')
			->from('cm_courses')
			->like('cm_course_labels.name', $match)
			->or_like('cm_course_labels.en_name', $match)
			->or_like('cm_course_labels.code', $match)
			->get()->result_array();

		return $result;
	}

	/**
	 * This method is used to query the id of all the course with $label for a courschema
	 *
	 * @param $courschema_id: the id of this courschema
	 * @param $label: the label for the course you query
	 * @return mixed: the array with all the course id
	 */
	public function get_course_id_by_label($courschema_id, $label){
		$result = $this->db
			->select('id_courses AS id')
			->from('cm_course_label_courschemas')
			->like('cm_course_labels.cn_name', $label)
			->or_like('cm_course_labels.en_name', $label)
			->join('cm_course_labels', 'cm_course_labels.id = cm_course_label_courschemas.id_labels')
			->get()->result_array();

		return $result;
	}

	/**
	 * This method used to query the course by filter
	 * if the filter is null, query all
	 *
	 * @param $language: the language for the result
	 * @param $filter: the filter to filter the result
	 * @return mixed: the query result
	 */
	// filter need to be defined
	public function query_courses_by_filter($language ,$filter){
		$result = null;

		// need to be implemented

		return $result;
	}


	/**
	 * this method is used to query all the course by department
	 *
	 * @param $department_id : the department id of the department
	 * @return array: the result of query
	 */
	public function query_course_by_department($department_id){
		$result = $this->db
			->select('*')
			->from('cm_courses')
			->where('cm_courses.id_departments', $department_id)
			->get()->result();

		return $result;
	}

	/**
	 * this method is used to query the course by name, chinese or english
	 *
	 * @param $name : the chinese or english name of the course, can just a part of the name
	 * @return array: the result of query
	 */
	public function query_course_by_name($name){
		$result = $this->db
			->select('*')
			->from('cm_courses')
			->like('cm_courses.name', $name, 'both')
			->or_like('cm_courses.en_name', $name, 'both')
			->get()->result();

		return $result;
	}

	/**
	 * this method is used to query the course by code
	 *
	 * @param $code : the code of the course, can just a part of the exact code
	 * @return array: the result of query
	 */
	public function query_course_by_code($code){
		$result = $this->db
			->select('*')
			->from('cm_courses')
			->like('cm_courses.code', $code, 'both')
			->get()->result();

		return $result;
	}

	/**
	 * this method is used to query the information of all course
	 *
	 * @return array: the query result
	 */
	public function query_all_course(){
		$result = $this->db
			->select('*')
			->from('cm_courses')
			->get()->result();

		return $result;
	}

	/**
	 * this method is used to update a recode of a course
	 * all the new should should valid
	 * that means make sure your value valid before use this method
	 *
	 * @param $old_code: the old code of this course
	 * @param $new_name: the new Chinese name of this course
	 * @param $new_en_name: the new English name of this course
	 * @param $new_code: the new course code
	 * @param $new_department_id: the new id of the department which set this course
	 * @param $new_credit: the new total credit of this course
	 * @param $new_exp_credit: the new experiment credit of this course
	 * @param $new_weekly_period: the new weekly period of this course
	 * @param $new_semester: new kind of semester for this course
	 * @param $new_language: new main language of this course
	 * @param $new_description: the new Chinese description of this course
	 * @param $new_en_description: the new English description of this course
	 * @param $new_pre_logic: the new advanced placement logic for this course
	 */
	// need to be finished
	public function update_one_course($old_code, $new_code, $new_name, $new_en_name,
									  $new_department_id, $new_credit, $new_exp_credit,
									  $new_weekly_period, $new_semester, $new_language,
									  $new_description, $new_en_description, $new_pre_logic){

		$data = array(
			'name' => $new_name,
			'en_name' => $new_en_name,
			'code' => $new_code,
			'id_departments' => $new_department_id,
			'credit' => $new_credit,
			'experiment_credit' => $new_exp_credit,
			'weekly_period' => $new_weekly_period,
			'semester' => $new_semester,
			'language' => $new_language,
			'description_cn' => $new_description,
			'description_en' => $new_en_description,
			'prerequisite_logic' => $new_pre_logic
		);

		$this->db
			->where('cm_courses.code', $old_code)
			->update('cm_courses', $data);

		$code = $new_code;
		$pre_logic = strtoupper($new_pre_logic);

		$main_id = 0;
		$query = $this->db
			->select('*')
			->from('cm_courses')
			->where('cm_courses.code', strtoupper($code))
			->get();

		foreach ($query->result() as $row)
		{
			$main_id = $row->id;
		}

		$type_count = 0;
		if (strlen($pre_logic) > 0){
			$or_list = explode('&', $pre_logic);
			print_r($or_list);
			for ($i = 0; $i < count($or_list); $i++) {
				$this_list = $or_list[$i];
				$this_list = str_replace('(', '', $this_list);
				$this_list = str_replace(')', '', $this_list);

				if(strlen($this_list) > 0){
					$type_count++;
					$this_list = explode('|', $this_list);
					print_r($this_list);

					for ($j = 0; $j < count($this_list); $j++) {

						$pre_id = 0;
						$query = $this->db
							->select('*')
							->from('cm_courses')
							->where('cm_courses.code', strtoupper($this_list[$j]))
							->get();
						foreach ($query->result() as $row)
						{
							$pre_id = $row->id;
						}
						if ($pre_id == 0){
							continue;
						}

						$data = array(
							'id_main_course' => $main_id,
							'id_pre_course' => $pre_id,
							'type' => $type_count
						);

						print_r($data);
						$this->db->insert('cm_prerequisites', $data);

					}
				}
			}
		}

	}

	/**
	 * this method is used to delete a course record from database
	 * all the dependence about this course will be deleted
	 *
	 * @param $code: the code of this course
	 * @return bool: delete successfully or not
	 */
	public function delete_one_course($code){
		$id = $this->db
			->select('cm_courses.id AS id')
			->from('cm_courses')
			->where('cm_courses.code', $code)
			->get();

		if ($id->num_rows() > 0){
			$id = $id->row_array()['id'];

			$as_pre = $this->db
				->select('*')
				->from('cm_prerequisites')
				->where('cm_prerequisites.id_pre_course', $id)
				->get();

			if($as_pre->num_rows() > 0){
				return False;
			}

			$this->db
				->where('cm_prerequisites.id_main_course', $id)
				->delete('cm_prerequisites');

			$this->db
				->where('cm_prerequisites.id_pre_course', $id)
				->delete('cm_prerequisites');

			$this->db
				->where('cm_courses.code', $code)
				->delete('cm_courses');

			return True;
		}

		return False;

	}

	/**
	 * this method is used to add one course record to the databse table "cm_courses"
	 *
	 * @param $name: the Chinese name of this course
	 * @param $en_name: the English name of this course
	 * @param $code: the course code
	 * @param $department_id: the id of the department which set this course
	 * @param $credit: the total credit of this course
	 * @param $exp_credit: the experiment credit of this course
	 * @param $weekly_period: the weekly period of this course
	 * @param $semester: kind of semester for this course
	 * @param $language: main language of this course
	 * @param $description: the Chinese description of this course
	 * @param $en_description: the English description of this course
	 * @param $pre_logic: the advanced placement logic for this course
	 */
	public function add_one_course($name, $en_name, $code, $department_id,
								   $credit, $exp_credit, $weekly_period,
								   $semester, $language, $description, $en_description, $pre_logic){

		$data = array(
			'name' => $name,
			'en_name' => $en_name,
			'code' => $code,
			'id_departments' => $department_id,
			'credit' => $credit,
			'experiment_credit' => $exp_credit,
			'weekly_period' => $weekly_period,
			'semester' => $semester,
			'language' => $language,
			'description_cn' => $description,
			'description_en' => $en_description,
			'prerequisite_logic' => $pre_logic
		);

		$this->db->insert('cm_courses', $data);

		$main_id = 0;
		$query = $this->db
			->select('*')
			->from('cm_courses')
			->where('cm_courses.code', strtoupper($code))
			->get();

//		$query = $this->db->query('select * from cm_courses where code=\''
//			.strtoupper($code).'\'');
		foreach ($query->result() as $row)
		{
			$main_id = $row->id;
		}
//		echo $main_id;
//		echo '<br>';

		$type_count = 0;
		if (strlen($pre_logic) > 0){
//			echo '<br>';
//			echo $pre_logic;
			$or_list = explode('&', $pre_logic);
//			echo '<br>';
//			print_r($or_list);
//			echo '<br>';
			for ($i = 0; $i < count($or_list); $i++) {
				$this_list = $or_list[$i];
				$this_list = str_replace('(', '', $this_list);
				$this_list = str_replace(')', '', $this_list);

				if(strlen($this_list) > 0){
					$type_count++;
					$this_list = explode('|', $this_list);
//					print_r($this_list);
//					echo '<br>';

					for ($j = 0; $j < count($this_list); $j++) {

						$pre_id = 0;
						$query = $this->db
							->select('*')
							->from('cm_courses')
							->where('cm_courses.code', strtoupper($this_list[$j]))
							->get();
//						$query = $this->db->query('select * from cm_courses where code=\''
//							.strtoupper($this_list[$j]).'\'');
						foreach ($query->result() as $row)
						{
							$pre_id = $row->id;
						}
						if ($pre_id == 0){
							continue;
						}

						$data = array(
							'id_main_course' => $main_id,
							'id_pre_course' => $pre_id,
							'type' => $type_count
						);

//						print_r($data);
//						echo '<br>';
						$this->db->insert('cm_prerequisites', $data);

					}
				}
			}
		}

	}

	/**
	 * this method is used to add a batch of records to the database by excel file
	 *
	 * @param $path: the path of the specific excel files
	 * @throws \PhpOffice\PhpSpreadsheet\Exception
	 * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
	 */
	public function add_course_record_by_excel($path){


		$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($path);

		$sheet = $spreadsheet->getSheet(0);//sheet

		$sheet = $spreadsheet->getActiveSheet();

		$res = array();
		foreach ($sheet->getRowIterator() as $row) {
			$tmp = array();
			foreach ($row->getCellIterator() as $cell) {
				$tmp[] = $cell->getFormattedValue();
			}
			$res[$row->getRowIndex()] = $tmp;
		}

		$start = FALSE;
		$end = FALSE;

		for($i = 1; $i <= sizeof($res); $i++) {
			if($res[$i][0] == '#csm' and $start){
				$end = TRUE;
			}

			if($start and !$end){
				if(strlen($res[$i][1]) > 0){
					// check course id, next row if exits
					$query = $this->db
						->select('*')
						->from('cm_courses')
						->where('cm_courses.code', strtoupper($res[$i][1]))
						->get();

//					$query = $this->db->query('select * from cm_courses where code=\''.strtoupper($res[$i][1]).'\'');
					if($query->num_rows() > 0){
						continue;
					}
					$course_id = strtoupper($res[$i][1]);

					// name
					$course_name = $res[$i][2];
					$course_en_name = $res[$i][3];

					// credit
					$course_credit = (float)$res[$i][4];
					$course_exp_credit = (float)$res[$i][5];

					// period
					$course_weekly_period = (float)$res[$i][6];

					// semester
					$course_semester_temp = $res[$i][7];
					$course_semester = '';
					if ( (strpos($course_semester_temp, '2') !== false) or
						(strpos($course_semester_temp, '春') !== false) or
						(strpos($course_semester_temp, 'spring') !== false)){
						$course_semester = $course_semester.'2; ';
					}
					if ( (strpos($course_semester_temp, '3') !== false) or
						(strpos($course_semester_temp, '夏') !== false) or
						(strpos($course_semester_temp, 'summer') !== false)){
						$course_semester = $course_semester.'3; ';
					}
					if ( (strpos($course_semester_temp, '1') !== false) or
						(strpos($course_semester_temp, '秋') !== false) or
						(strpos($course_semester_temp, 'fall') !== false)){
						$course_semester = $course_semester.'1; ';
					}

					// language
					$course_language_temp = $res[$i][8];
					$course_language = '';
					if ( (strpos($course_language_temp, '中文') !== false) or
						(strpos($course_language_temp, 'cn') !== false) or
						(strpos($course_language_temp, 'C') !== false) or
						(strpos($course_language_temp, 'chinese') !== false)){
						$course_language = $course_language.'C; ';
					}
					if ( (strpos($course_language_temp, '英文') !== false) or
						(strpos($course_language_temp, 'en') !== false) or
						(strpos($course_language_temp, 'E') !== false) or
						(strpos($course_language_temp, 'english') !== false)){
						$course_language = $course_language.'E; ';
					}
					if ( (strpos($course_language_temp, '中英文') !== false) or
						(strpos($course_language_temp, 'both') !== false) or
						(strpos($course_language_temp, 'B') !== false)){
						$course_language = $course_language.'B; ';
					}

					// advanced placement
					// need to check
					$advanced_placement = strtoupper($res[$i][9]);
					$advanced_placement = str_replace(' ', '', $advanced_placement);
					$advanced_placement = str_replace('\r', '', $advanced_placement);
					$advanced_placement = str_replace('\n', '', $advanced_placement);
					$advanced_placement = str_replace('\t', '', $advanced_placement);

					// description
					$course_cn_description = $res[$i][10];
					$course_en_description = $res[$i][11];

					// check the department, next row if not exits
					$course_department_id = 0;
					$query = $this->db
						->select('*')
						->from('cm_departments')
						->where('cm_departments.code', strtoupper($res[$i][12]))
						->get();

					foreach ($query->result() as $row)
					{
						$course_department_id = $row->id;
					}
					if($course_department_id == 0){
						continue;
					}

					$this->add_one_course($course_name, $course_en_name, $course_id, $course_department_id,
						$course_credit, $course_exp_credit, $course_weekly_period,
						$course_semester, $course_language, $course_cn_description, $course_en_description,
						$advanced_placement
						);
				}
			}

			if($res[$i][0] == '#csm' and !$start){
				$start = TRUE;
			}
		}

	}

}

?>
