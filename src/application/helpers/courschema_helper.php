<?php defined('BASEPATH') OR exit('No direct script access allowed');

function upload_pdf($pdf_json, $courschema_name, $tmp=FALSE){
    $ci = &get_instance();

    // TODO

    $pdf_url = 'default.pdf';
    return array('status'=>TRUE, 'msg'=>'ok', 'pdf_url'=>$pdf_url);
}