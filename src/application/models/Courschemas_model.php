<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Courschemas_model extends CI_Model{

    public function _get_timestamp(){
        $timestamp_datetime = new DateTime('NOW');
        return $timestamp_datetime->format('Y-m-d H:i:s');
    }

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

    public function get_cm_by_id($courschema_id, $user_id=NULL){
        $this->db->select('
            cm_courschemas.id   AS id,
            cm_courschemas.name AS name
        ');
        
        $rtn = $this->db->from('cm_courschemas')
            ->where('cm_courschemas.id', $courschema_id)
            ->get()
            ->row_array();
        
        if($user_id){
            $cnt = $this->db->select('
                COUNT(*) AS cnt
            ')
            ->from('cm_users_collect_courschemas')
            ->where('cm_users_collect_courschemas.id_users', $user_id)
            ->where('cm_users_collect_courschemas.id_courschemas', $rtn['id']);

            $rtn['collected'] = $cnt == '0' ? 0 : 1;
        }else{
            $rtn['collected'] = $cnt == 'visitor_flag';
        }

        return $rtn;
    }

    public function get_cm($language, $user_id, $maj_id){

        $this->db->select('
            cm_courschemas.id      AS ver_id,
            cm_courschemas.name    AS name,
        ');

        $result = $this->db
            ->from('cm_courschemas')
            ->order_by('cm_courschemas.id')
            ->where('cm_courschemas.type', 'cmc')
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

    public function get_ccBasic($language, $user_id){
        
        $this->db->select('
            cm_courschemas.id   AS id,
            cm_courschemas.name AS name
        ');
        
        $rtn = $this->db->from('cm_users')
            ->where('cm_users.id', $user_id)
            ->join('cm_courschemas', 'cm_courschemas.id = cm_users.id_courschemas', 'inner')
            ->get()
            ->row_array();
        
        $cnt = $this->db->select('
                COUNT(*) AS cnt
            ')
            ->from('cm_users_collect_courschemas')
            ->where('cm_users_collect_courschemas.id_users', $user_id)
            ->where('cm_users_collect_courschemas.id_courschemas', $rtn['id']);
    
        $rtn['collected'] = $cnt == '0' ? 0 : 1;
        return $rtn;
    }

    public function get_pdf_by_user_id($language, $user_id){

        if($language == 'english'){
            $this->db->select('cm_courschemas.pdf_url_en AS pdf_url');
        }else{
            $this->db->select('cm_courschemas.pdf_url_cn AS pdf_url');
        }

        $url = $this->db
            ->from('cm_users')
            ->join('cm_courschemas', 'cm_courschemas.id = cm_users.id_courschemas', 'inner')
            ->where('cm_users.id', $user_id)
            ->get()
            ->row_array()['pdf_url'];

        return array(
            'file_url' => asset_url('assets/pdf/' . $url),
            'download_link' => base_url('index.php/download/pdf/'.$url)
        );
    }

    public function get_pdf_by_id($language, $courschema_id){
        
        $this->db->select('
            cm_courschemas.pdf_url AS pdf_url,
            cm_courschemas.id      AS id
        ');
        
        $result =  $this->db
            ->from('cm_courschemas')
            ->where('cm_courschemas.id', $courschema_id)
            ->get()
            ->row_array();
        
        return array(
            'id' => $result['id'],
            'file_url' => asset_url('assets/pdf/' . $result['pdf_url']),
            'download_link' => base_url('index.php/download/pdf/'.$result['pdf_url'])
        );
    }

    public function submit_courschema($user_id, $pdf_json, $graph_json, $list_json, $courschema_name, $type, $major_id, $source_code){
        $this->load->helper('courschema');
        $rtn = upload_pdf($pdf_json, $courschema_name);

        if($rtn['status'] == FALSE){
            return array('status' => 'wrong_pdf_json', 'pdf_url' => $rtn['msg']);
        }

        $this->db->trans_begin();

        $pdf_url = $rtn['pdf_url'];

        $data_inserted = array(
            'name' => $courschema_name,
            'type' => $type,
            'id_majors' => $major_id,
            'pdf_url' => $pdf_url,
            'graph_json' => $graph_json,
            'source_code' => $source_code,
            'list_json' => $list_json,
            'is_available' => 0
        );

        if( ! $this->db->insert('cm_courschemas', $data_inserted)){
            $this->db->trans_rollback();
            $rtn = FALSE;
        }else{
            // This thing will go to review table
            $courschema_id = $this->db->insert_id();
            $data_inserted = array(
                'id_users_poster' => $user_id,
                'id_courschemas' => $courschema_id,
                'status' => 'pending',
                'post_timestamp' => $this->_get_timestamp()
            );
            $rtn = $this->db->insert('cm_review', $data_inserted);
            if($rtn){
                $this->db->trans_commit();       
            }else{
                $this->db->trans_rollback();
            }
        }
        
        log_operation('submit_courschema', $user_id, array('pdf_url'=>$pdf_url, 'id_major'=>$major_id), $rtn);
        $this->db->trans_complete();
        return $rtn;
    }

    public function get_courschema_matryona($courschema_id){
        return $this->db->select('
                cm_courschemas.source_code AS matryona_source_code,
                cm_courschemas.pdf_url     AS pdf_url,
                cm_courschemas.graph_json  AS graph_json,
                cm_courschemas.list_json   AS list_json,
                cm_courschemas.name        AS courschema_name,
                cm_courschemas.type        AS type
            ')
            ->from('cm_courschemas')
            ->where('cm_courschemas.id', $courschema_id)
            ->get()
            ->row_array();
    }

    public function get_visible_courschema($language, $user_id){
        

        if($language == 'english'){
            $this->db->select('
                cm_majors.en_name      AS major_name,
                cm_departments.en_name AS department_name
            ');
        }else{
            $this->db->select('
                cm_majors.name         AS major_name,
                cm_departments.name    AS department_name
            ');
        }

        $this->db->select('
                cm_courschemas.id   AS id,
                cm_courschemas.name AS name
            ')
            ->from('cm_courschemas')
            ->join('cm_majors', 'cm_majors.id = cm_courschemas.id_majors', 'inner')
            ->join('cm_departments', 'cm_departments.id = cm_majors.id_departments', 'inner');

        $role = $this->session->userdata('role');

        if($role != 'tao_x' && $role != 'admin_8c6fc01'){
            $this->load->model('users_model');
            $id_user_dep = $this->users_model->get_dep_id($user_id);
            $this->db->where('cm_majors.id_departments', $id_user_dep);
        }
            
        return $this->db
            ->where('cm_courschemas.type', 'cmc')
            ->get()
            ->result_array();
    }

    public function find_cmh($cmh_name_list){
        $num_cmh = sizeof($cmh_name_list);
        $this->db->select('
            cm_courschemas.name        AS cmh_name,
            cm_courschemas.source_code AS cmh_content
        ')
        ->from('cm_courschemas');
        
        foreach($cmh_name_list AS $name){
            $this->db->or_where('cm_courschemas.name', $name);
        }
        
        $rtn = $this->db
            ->get()
            ->result_array();

        if(sizeof($rtn) != $num_cmh){
            return array('status'=>'false', 'query_result'=> 'need:' . $num_cmh .' got:' . sizeof($rtn));
        }else{
            return array('status' => 'true', 'query_result' => $rtn);
        }
    }  


    public function upload_courschemas($language, $user_id, $target_files, $major_id){
        
        

        $ok = True;

        $this->db->trans_begin();

        for($i = 0; $i < sizeof($target_files['name']); $i++){
            $cmi_obj = 'it'.$i;
            $this->load->library('cminterpreter', NULL, $cmi_obj);
            
            $arr = explode('.', $target_files['name'][$i]);

            $file_name = $arr[0];
            $ext = $arr[1];
            move_uploaded_file($target_files['tmp_name'][$i], TMP_PATH .$file_name);

            $content = file_get_contents(TMP_PATH .$file_name);

            if($ext == 'cmc'){
                $result = $this->$cmi_obj->compile_to_pdf($language, $content);
                if($result['status']){
                    $pdf_url = $result['pdf_url'];
                }else{
                    $this->db->trans_rollback();
                    return array('status' => FALSE, 'msg' => $result['msg']);
                }
                $graph_json = $this->$cmi_obj->compile_to_graph($content);
                $data_inserted[$i] = array(
                    'name' => $file_name,
                    'type' => 'cmc',
                    'id_majors' => $major_id,
                    'pdf_url' => $pdf_url,
                    'graph_json' => $graph_json,
                    'list_json' => $graph_json,
                    'source_code' => $content,
                    'is_available' => 0
                );
            }else{
                $data_inserted[$i] = array(
                    'name' => $file_name,
                    'type' => 'cmh',
                    'id_majors' => $major_id,
                    'source_code' => $content,
                    'is_available' => 0
                );
            }
        }

        for($i = 0; $i < sizeof($data_inserted); $i++){
            $data = $data_inserted[$i];

            if( ! $this->db->insert('cm_courschemas', $data)){
                $this->db->trans_rollback();
                return array('status' => FALSE, 'msg' => 'db errro');
            }else{
                // This thing will go to review table
                $courschema_id = $this->db->insert_id();
                $data_review = array(
                    'id_users_poster' => $user_id,
                    'id_courschemas' => $courschema_id,
                    'status' => 'pending',
                    'post_timestamp' => $this->_get_timestamp()
                );
                $rtn = $this->db->insert('cm_review', $data_review );
                if( ! $rtn){
                    $this->db->trans_rollback();
                    log_operation('upload courschemas', $user_id, array('target_files'=>$target_files), $rtn);
                    return array('status' => FALSE, 'msg' => 'db error');
                }
            }
        }

        if($rtn){
            $this->db->trans_commit();  
        }else{
            $this->db->trans_rollback();
        }
        $this->db->trans_complete();
        log_operation('upload courschemas', $user_id, array('target_files'=>$target_files), $rtn);
        return array('status' => TRUE, 'msg'=> 'success');
        
    }

    public function assign_courschema($user_id, $courschem_id){
        $this->db->where('cm_users.id', $user_id);
        return $this->db->update('cm_users', array('id_courschemas' => $courschem_id));
    }

    public function delete_cmh($cmh_name_list){
        $ok = True;
        foreach($cmh_name_list AS $name){
            $this->db->where('cm_courschemas.name', $name);
            $ok &= $this->db->delete('cm_courschemas');
            if( ! $ok){
                return array('status' => TRUE);
            }
        }
        return array('status' => $ok);
    }
}