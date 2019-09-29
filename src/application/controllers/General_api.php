<?

class General_api extends CI_Controller{

    public function ajax_change_language(){
        try{

            // Get Input
            $post_language = $this->input->post('language');

            // Check if language exists in the available languages.
            $found = FALSE;
            foreach ($this->config->item('available_languages') as $lang){
                if ($lang == $post_language){
                    $found = TRUE;
                    break;
                }
            }

            if ( ! $found){
                throw new Exception('Translations for the given language does not exist (' . $post_language . ').');
            }

            $this->session->set_userdata('language', $post_language);
            $this->config->set_item('language', $post_language);

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode('success'));

        }catch (Exception $exc){
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['exceptions' => [exceptionToJavaScript($exc)]]));
        }
    }
}

?>