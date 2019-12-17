<?php defined('BASEPATH') OR exit('No direct script access allowed');

require dirname(__FILE__)."\..\..\../vendor/autoload.php";
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Course_label_model extends CI_Model{

	/**
	 * this method is used to add course label relationship record by excel
	 *
	 * @param $path: the path of the excel file
	 * @param $id_courschemas: the id of the courschemas
	 * @throws \PhpOffice\PhpSpreadsheet\Exception
	 * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
	 */
	public function add_label_relationship_by_excel($path, $id_courschemas){
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
			echo '<br>';
			echo $row->getRowIndex();
			echo '<br>';
			print_r($tmp);
		}

		$d_start = FALSE;
		$d_end = FALSE;
		$c_start = FALSE;
		$c_end = FALSE;

		for($i = 1; $i <= sizeof($res); $i++) {
			if($res[$i][0] == '#define' and $d_start){
				$d_end = TRUE;
			}
			if($res[$i][0] == '#define' and $c_start){
				$c_end = TRUE;
			}

			if($d_start and !$d_end){
				$label = $res[$i][1];
				$cn_name = $res[$i][2];
				$en_name = $res[$i][3];

				if(strlen($label) > 0){
					$this->add_one_label($label, $cn_name, $en_name);
				}
			}

			if($c_start and !$c_end){
				$code = $res[$i][1];
				$label = $res[$i][2];

				if(strlen($code)){
					$this->add_one_course_label_relation_by_code($code, $id_courschemas, $label);
				}
			}

			if($res[$i][0] == '#define' and !$c_start){
				$c_start = TRUE;
			}
			if($res[$i][0] == '#define' and !$d_start){
				$d_start = TRUE;
			}
		}
	}

	/**
	 * this method is used to add one course label relationship record to database
	 * by course code, courschemas id, label
	 *
	 * check course code, label
	 * no check id_courschemas
	 *
	 * return True if successfully
	 * return False if failed
	 *
	 * @param $course_code: the code of the course
	 * @param $id_courschemas: the id of the courschemas
	 * @param $label: the label
	 * @return bool: add successfully or not
	 */
	public function add_one_course_label_relation_by_code($course_code, $id_courschemas, $label){
		$result = $this->db
			->select('cm_courses.id AS id')
			->from('cm_courses')
			->where('cm_courses.code', strtoupper($course_code))
			->get()->result_array();

		if(empty($result)){
			return False;
		}else{
			$id_courses = $result[0]['id'];
		}

		$result = $this->db
			->select('cm_course_labels.id AS id')
			->from('cm_course_labels')
			->where('cm_course_labels.label', strtoupper($label))
			->get()->result_array();

		if(empty($result)){
			return False;
		}else{
			$id_labels = $result[0]['id'];
		}

		$this->add_one_course_label_relation($id_courses, $id_courschemas, $id_labels);
		return True;
	}

	/**
	 * this method is used to add course label relation record to the database
	 * no check, no return
	 *
	 * @param $id_courses: the id of the course
	 * @param $id_courschemas: the id of the courschema
	 * @param $id_labels: the id of the label
	 */
	public function add_one_course_label_relation($id_courses, $id_courschemas, $id_labels){
		$data = array(
			'id_courses' => $id_courses,
			'id_courschemas' => $id_courschemas,
			'id_labels' => $id_labels
		);

		$this->db->insert('cm_course_label_courschemas', $data);
	}

	/**
	 * this method is used add one label record to the database
	 * not check, no return
	 *
	 * @param $label: the label define in the matryona
	 * @param $cn_name: the Chinese label name
	 * @param $en_name: the English label name
	 */
	public function add_one_label($label, $cn_name, $en_name){
		$data = array(
			'label' => $label,
			'cn_name' => $cn_name,
			'en_name' => $en_name
		);

		$this->db->insert('cm_course_labels', $data);
	}

}

?>
