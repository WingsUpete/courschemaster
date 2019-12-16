<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Students_model extends CI_Model{

    public function get_my_learned($language, $user_id){

        if($language == 'english'){
            $this->db->select('
                cm_courses.en_name AS course_name,
                cm_departments.en_name AS department_name
            ');
        }else{
            $this->db->select('
                cm_courses.name AS course_name,
                cm_departments.name AS department_name
            ');
        }

        return $this->db->select('
                cm_users_courses.id_courses AS course_id,
                cm_courses.weekly_period AS period,
                cm_courses.credit AS credit,
                cm_courses.prerequisite_logic AS prerequisite_stat,
            ')
            ->from('cm_users_courses')
            ->join('cm_courses', 'cm_courses.id = cm_users_courses.id_courses', 'inner')
            ->join('cm_departments', 'cm_departments.id = cm_courses.id_departments', 'inner')
            ->where('cm_users_courses.id_users', $user_id)
            ->get()
            ->result_array();
    }
}