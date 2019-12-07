<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Courschemas_model extends CI_Controller{

    public function get_dep($language){
        if($language == 'english'){
            $this->db->select('
                cm_departments.id      AS dep_id,
                cm_departments.en_name AS name,
                cm_departments.code    AS code,
                COUNT(cm_majors.id)    AS number_of_majors
            ');
        }else{
            $this->db->select('
                cm_departments.id      AS dep_id,
                cm_departments.name    AS name,
                cm_departments.code    AS code,
                COUNT(cm_majors.id)    AS number_of_majors
            ');
        }
        
        return $this->db->from('cm_departments')
            ->join('cm_majors', 'cm_majors.id_departments = cm_departments.id', 'inner')
            ->group_by('cm_departments.id')
            ->get()
            ->result_array();
    }

    public function get_maj($language, $dep_id){
        if($language == 'english'){
            $this->db->select('
                cm_majors.id             AS maj_id,
                cm_majors.en_name        AS name,
                COUNT(cm_courschemas.id) AS number_of_courschemas
            ');
        }else{
            $this->db->select('
                cm_majors.id             AS maj_id,
                cm_majors.name           AS name,
                COUNT(cm_courschemas.id) AS number_of_courschemas
            ');
        }
        
        return $this->db->from('cm_majors')
            ->join('cm_courschemas', 'cm_courschemas.id_majors = cm_majors.id', 'inner')
            ->where('cm_majors.id_departments', $dep_id)
            ->group_by('cm_majors.id')
            ->get()
            ->result_array();
    }

    public function get_cm($language, $user_id, $maj_id){
        if($language == 'english'){
            $this->db->select('
                cm_courschemas.id      AS ver_id,
                cm_courschemas.en_name AS name,
            ');
        }else{
            $this->db->select('
                cm_courschemas.id      AS ver_id,
                cm_courschemas.name    AS name,
            ');
        }

        $result = $this->db
            ->from('cm_courschemas')
            ->order_by('cm_courschemas.id')
            ->get()
            ->result_array();

        $collected_ids = $this->db->select('
                cm_users_collect_courschemas.id_courschemas AS id
            ')
            ->from('cm_users_collect_courschemas')
            ->where('cm_users_collect_courschemas.id_users', $user_id)
            ->order_by('cm_users_collect_courschemas.id_courschemas')
            ->get()
            ->result_array();

        $r_ptr          = 0;
        $c_ptr          = 0;
        $result_size    = sizeof($result);
        $collected_size = sizeof($collected_ids);

        for($i = 0; $i <$result_size; $i++){
            $result[$i]['collected'] = 0;
        }

        while($r_ptr < $result_size && $c_ptr < $collected_size){
            if($result[$r_ptr]['ver_id'] == $collected_ids[$c_ptr]['id']){
                $result[$r_ptr]['collected'] = 1;
                $r_ptr++;
                $c_ptr++;
            }else{
                if($result[$r_ptr]['ver_id'] < $collected_ids[$c_ptr]['id']){
                    $r_ptr++;
                }else{
                    $c_ptr++;
                }
            }
        }

        return $result;
    }
}