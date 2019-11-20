<?php defined('BASEPATH') OR exit('No direct script access allowed');

function exceptionToJavaScript($exception){
    return json_encode([
        'code' => $exception->getCode(),
        'file' => $exception->getFile(),
        'line' => $exception->getLine(),
        'message' => $exception->getMessage(),
        'previous' => $exception->getPrevious(),
        'trace' => $exception->getTraceAsString()
    ]);
}

?>