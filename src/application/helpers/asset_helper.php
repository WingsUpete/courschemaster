<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Assets URL helper function.
 *
 * This function will create an asset file URL that includes a cache busting parameter in order
 * to invalidate the browser cache in case of an update.
 *
 * @param string $uri Relative URI (just like the one used in the base_url helper).
 * @param string|null $protocol Valid URI protocol.
 *
 * @return string Returns the final asset URL.
 */
function asset_url($uri = '', $protocol = NULL ,$ctype = '')
{
   $ci =& get_instance();
   $cache_busting_token = (! Config::DEBUG_MODE )? '?' . $ci->config->item('cache_busting_token') : '';
   if($ctype != ''){
       if($ctype == 'css'){
           $cache_busting_token .= ! Config::DEBUG_MODE ? $ci->config->item('css_suffix') : '';
       }else if($ctype == 'js'){
           $cache_busting_token .= ! Config::DEBUG_MODE ? $ci->config->item('js_suffix') : '';
       }else{
           show_error('parameter ctype is wrong.');
       }
   }else{
    $cache_busting_token .= getSuffix($uri);
   }
   return base_url($uri . $cache_busting_token, $protocol);
}


/**
 * 
 * To boost the loading speed to avoid connection error (time out), 
 * add a suitable suffix to uri which point to .css or .js file
 * 
 * @param string $uri Relative URI.
 * 
 * @return string Returns the suitable suffix
 */

function getSuffix($uri){
    
    $ci =& get_instance();

    $suffix = substr($uri, strlen($uri) - 3, 3);

    if($suffix == 'css'){
        return $ci->config->item('css_suffix');
    }else if(substr($suffix, 1, 2) == 'js'){
        return $ci->config->item('js_suffix');
    }else{
        return '';
    }
}