<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Collections_model extends CI_Model{

    public function get_my_collections($language, $user_id){

        if($language == 'english'){
            $this->db->select('cm_courschemas.en_name AS name');
        }else{
            $this->db->select('cm_courschemas.name AS name');
        }

        return $this->db->select('
                cm_courschemas.id AS id
            ')
            ->from('cm_users_collect_courschemas')
            ->join('cm_courschemas', 'cm_courschemas.id = cm_users_collect_courschemas.id_courschemas', 'inner')
            ->where('cm_users_collect_courschemas.id_users', $user_id)
            ->get()
            ->result_array();
    }

    public function collect_courschema($courschema_id, $user_id){
        if($this->is_collected($courschema_id, $user_id)){
            return true;
        }
        return $this->db->insert('cm_users_collect_courschemas', array(
            'id_users' => $user_id,
            'id_courschemas' => $courschema_id
        ));
    }

    public function uncollect_courschema($courschema_id, $user_id){
        if( ! $this->is_collected($courschema_id, $user_id)){
            return true;
        }
        $this->db->where('cm_users_collect_courschemas.id_users', $user_id);
        $this->db->where('cm_users_collect_courschemas.id_courschemas', $courschema_id);
        return $this->db->delete('cm_users_collect_courschemas');
    }

    protected function is_collected($courschema_id, $user_id){
        $cnt = $this->db->select('COUNT(*) AS cnt')
            ->from('cm_users_collect_courschemas')
            ->where('cm_users_collect_courschemas.id_users', $user_id)
            ->where('cm_users_collect_courschemas.id_courschemas', $courschema_id)
            ->get()
            ->row_array()['cnt'];
        return $cnt != 0;
    }
    
}