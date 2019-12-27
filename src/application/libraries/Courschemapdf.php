<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once Config::VENDOR_TCPDF_SOURCE . '/tcpdf.php';

class Courschemapdf{

    //library variables
    private $pdf;
    private $html;

    //pdf variables
    private $header_logo_ext = 'png';
    private $language = 'english';

    //courschema variables
    private $courschema_name = 'unset';
    private $department_name = 'unset';
    private $version = 'unset';
    private $content_intro = 'unset';
    private $content_objectives = 'unset';
    private $content_program_length = 'unset';
    private $content_degree = 'unset';
    

    public function __construct(){

        $this->pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    }

    public function new_pdf(){
        
        $this->pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    }

    public function init($language){
        $this->new_pdf();
        $this->language = $language;
        // set font
        if($this->language == 'english'){
            $this->pdf->SetFont('times', '', 10);
        }else{
            $this->pdf->SetFont('stsongstdlight', '', 10);
        }
        // set document information
        $this->pdf->SetCreator('Courschemaster');
        $this->pdf->SetAuthor('Courschemaster');
        $this->pdf->SetTitle('SUSTech Courschema');
        $this->pdf->SetSubject('SUSTech Courschema');
        $this->pdf->SetKeywords('Courschema, SUSTech, OOAD');
        // set pdf header
        $this->pdf->SetHeaderData(
            'pdf_logo' . ($this->language == 'english' ? '_en' : '_cn') . '.png' , 
            30, 
            "Courschema", 
            "Powered by Courschemaster"
        );
        // set header and footer fonts
        $this->pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $this->pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        // set default monospaced font
        $this->pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        
        // set margins
        $this->pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $this->pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $this->pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        
        // set auto page breaks
        $this->pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        // set image scale factor
        $this->pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $this->pdf->setLanguageArray($l);
        }
        
        $this->html = file_get_contents(APPPATH.'../assets/courschema_html/courschema_header.html');
    }

    public function set_courschema_header($name, $department, $version){
        $this->courschema_name = $name;
        $this->department_name = $department;
        $this->version = $version;
    }

    public function set_courschema_intro($intro){
        $this->content_intro = $intro;
    }

    public function set_courschema_objectives($objectives){
        $this->content_objectives = $objectives;
    }

    public function set_courschema_program_length($len){
        $this->content_program_length = $len;
    }

    public function set_courschema_degree($degree){
        $this->content_degree = $degree;
    }

    public function add_page(){
        $this->pdf->AddPage();
    }

    public function append_raw_html($html_segment){
        $this->html .= $html_segment;
    }

    public function append_table($table_header, $arr){
        $html = '<table cellpadding="1" cellspacing="1" border="0.5" style="text-align:center;">';
        
        $html .= '<tr bgcolor="#AAAAAA">';
        foreach($table_header AS $e){
            $html .= '<th><strong>'. $e . '</strong></th>';
        }
        $html .= '</tr>';

        $html .= '<tbody>';
        foreach($arr AS $row){
            $html .= '<tr>';
            foreach($row AS $e){
                $html .= '<td>' . $e . '</td>';
            }
            $html .= '</tr>';
        }
        $html .= '</tbody>';

        $this->html .= $html . '</table>';
    }

    public function _html_variables_replace(){
        
        if($this->language == 'english'){
            $this->html = str_replace('INTRO', 'Introducation', $this->html);
            $this->html = str_replace('OBJECTIVES', 'Objectives', $this->html);
            $this->html = str_replace('PROGRAM_LENGTH', 'Program Length', $this->html);
            $this->html = str_replace('DEGREE', 'Degree', $this->html);
            $this->html = str_replace('PL_AND_DEG', 'Program Length and Degree', $this->html);
            $this->html = str_replace('VERSION', 'Version', $this->html);
        }else{
            $this->html = str_replace('INTRO', '专业简介', $this->html);
            $this->html = str_replace('OBJECTIVES', '培养目标', $this->html);
            $this->html = str_replace('PROGRAM_LENGTH', '学制', $this->html);
            $this->html = str_replace('DEGREE', '学位', $this->html);
            $this->html = str_replace('PL_AND_DEG', '学制和学位', $this->html);
            $this->html = str_replace('VERSION', '版本号', $this->html);
        }
        $this->html = str_replace('CONTENT_IT', $this->content_intro, $this->html);
        $this->html = str_replace('CONTENT_OBJ', $this->content_objectives, $this->html);
        $this->html = str_replace('CONTENT_PL', $this->content_program_length, $this->html);
        $this->html = str_replace('CONTENT_DEG', $this->content_degree, $this->html);
        $this->html = str_replace('COURSCHEMA_NAME', $this->courschema_name, $this->html);
        $this->html = str_replace('DEPARTMENT_NAME', $this->department_name, $this->html);
        $this->html = str_replace('CONTENT_VER', $this->version, $this->html);
    }

    public function test_html(){
        $this->_html_variables_replace();
        $this->pdf->writeHTML($this->html, true, false, true, false, '');
        $this->pdf->lastPage();
        $this->pdf->Output('C:\\Users\\ASUS\\desktop\\example.pdf', 'I');
    }

    public function output($save_path){
        $this->_html_variables_replace();
        $this->pdf->writeHTML($this->html, true, false, true, false, '');
        $this->pdf->lastPage();
        $this->pdf->Output($save_path, 'F');
    }
}
