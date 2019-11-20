<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MatException extends Exception{

    public function __construct($message = "", $code = 0, $previous = null){
        parent::__construct($message, $code, $previous);
    }

}

?>