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

    public function get_visible_students_info($language, $user_id){
        //TODO Return students only visible
        
        if($language == 'english'){
            $this->db->select('
                cm_majors.en_name      AS major,
                cm_departments.en_name AS department,
            ');
        }else{
            $this->db->select('
                cm_majors.name      AS major,
                cm_departments.name AS department,
            ');
        }

        $rtn = $this->db->select('
                cm_users.id             AS id,
                cm_users.cas_sid        AS sid,
                cm_users.name           AS name,
                cm_users.id_courschemas AS cid
            ')
            ->from('cm_users')
            ->join('cm_majors', 'cm_majors.id = cm_users.id_majors', 'inner')
            ->join('cm_departments', 'cm_departments.id = cm_majors.id_departments', 'inner')
            ->get()
            ->result_array();

        for($i = 0; $i < sizeof($rtn); $i++){
            $id = $rtn[$i]['cid'];
            if($id){
                $tmp = $this->db->select('
                    cm_courschemas.name As name,
                    cm_courschemas.id   AS id
                ')
                ->from('cm_courschemas')
                ->where('cm_courschemas.id', $id)
                ->get()
                ->row_array();
                $rtn[$i]['courschema_name'] = $tmp['name'];
                $rtn[$i]['courschema_id']   = $tmp['id'];
            }else{
                $rtn[$i]['courschema_name'] = 'no_courschema_yet';
                $rtn[$i]['courschema_id']   = 'no_courschema_yet';
            }
            unset($rtn[$i]['cid']);
        }
        return $rtn;
    }
}