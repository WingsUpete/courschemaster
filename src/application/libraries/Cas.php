<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once Config::VENDOR_CAS_SOURCE . '/CAS.php';
class Cas {
    /**
     * CodeIgniter Instance
     *
     * @var CodeIgniter
     */
    protected $CI;
    public function __construct(){
        $CI =& get_instance();
        $this->CI = $CI;
        if (Config::CAS_DEBUG) {
            // Enable debugging
            phpCAS::setDebug();
            // Enable verbose error messages. Disable in production!
            phpCAS::setVerbose(true);
        }
        // Initialize phpCAS
        phpCAS::client(CAS_VERSION_2_0,
            Config::CAS_HOST,
            Config::CAS_PORT,
            Config::CAS_CONTEXT,
            False);
        // configures SSL behavior
        phpCAS::setNoCasServerValidation();
    }
    /**
      * Trigger CAS authentication if user is not yet authenticated.
      */
    public function forceAuthentication()
    {
        phpCAS::forceAuthentication();
    }
    /**
     * This method returns the CAS user's login name.
     *
     * @return string the login name of the authenticated user
     * */
    public function getUser()
    {
        return phpCAS::getUser();
    }
    /**
     * Answer an attribute for the authenticated user.
     *
     * @param string $key attribute name
     *
     * @return mixed string for a single value or an array if multiple values exist.
     */
    public function getAttribute($key) {
        return phpCAS::getAttribute($key);
    }
    /**
     * Answer attributes about the authenticated user.
     *
     * @warning should only be called after phpCAS::forceAuthentication()
     * or phpCAS::checkAuthentication().
     *
     * @return array
     */
    public function getAttributes() {
        return phpCAS::getAttributes();
    }
    /**
     *  Logout and redirect to the main site URL,
     *  or to the URL passed as argument
     * @param string $url
     */
    public function logout($url = '')
    {
        if (empty($url)) {
            $this->CI->load->helper('url');
            $url = base_url();
        }
        phpCAS::logoutWithRedirectService($url);
    }
}