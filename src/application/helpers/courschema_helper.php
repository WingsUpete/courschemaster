<?php defined('BASEPATH') OR exit('No direct script access allowed');

function upload_pdf($pdf_json, $courschema_name, $tmp=FALSE){
    $ci = &get_instance();

    // TODO

    $pdf_url = 'default.pdf';
    return array('status'=>TRUE, 'msg'=>'ok', 'pdf_url'=>$pdf_url);
}

function get_redirect_info($id, $user_id, &$view){
    $ci = &get_instance();
    if( ! $id){
        $view['cur_id'] = 'no_id_flag';
        $view['redirect'] = FALSE;
        $view['cur_name'] = 'no_id_flag';
        $view['collected'] = 'no_id_flag';
    }else{
        $view['redirect'] = FALSE;

        $ci->load->model('courschemas_model');
        $result = $ci->courschemas_model->get_cm_by_id($id, $user_id);

        $view['cur_id'] = $result['id'];
        $view['collected'] = $result['collected'];
        $view['cur_name'] = $result['name'];
    }
}