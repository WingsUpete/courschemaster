<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

/*
| Courschemaster 
|--------------------------------------------------------------------------
| Privileges
|--------------------------------------------------------------------------
*/
define('PRVI_SYSTEM_CONFIGS', 20);
define('PRIV_STUDENTS', 20);
define('PRIV_SECRETARY', 20);
define('PRIV_TAO', 20);
define('PRIV_MENTOR', 20);
define('PRIV_VISITOR', 0);

/*
| Courschemaster - Students
|--------------------------------------------------------------------------
| Sidebar
|--------------------------------------------------------------------------
*/
define('PRIV_STUDENTS_MY_COURSCHEMA', 'students_my_courschema');
define('PRIV_STUDENTS_ALL_COURSCHEMAS', 'students_all_courschemas');
define('PRIV_STUDENTS_COLLECTION', 'students_collection');
define('PRIV_STUDENTS_MY_PLAN', 'students_my_plan');
define('PRIV_STUDENTS_LEARNED', 'students_learned');
/*
| Courschemaster - Secretary
|--------------------------------------------------------------------------
| Sidebar
|--------------------------------------------------------------------------
*/
define('PRIV_SECRETARY_ALL_COURSCHEMAS', 'secretary_all_courschemas');
define('PRIV_SECRETARY_COLLECTION', 'secretary_collection');
define('PRIV_SECRETARY_STUDENT_INFO', 'secretary_student_info');
define('PRIV_SECRETARY_COURSE_MANAGEMENT', 'secretary_course_management');
define('PRIV_SECRETARY_COURSCHEMA_MANAGEMENT', 'secretary_courschema_management');
define('PRIV_SECRETARY_REVIEW', 'ssecretary_review');
/*
| Courschemaster - Mentor
|--------------------------------------------------------------------------
| Sidebar
|--------------------------------------------------------------------------
*/
define('PRIV_MENTOR_STUDENT_INFO', 'mentor_my_courschema');
define('PRIV_MENTOR_ALL_COURSCHEMAS', 'mentor_all_courschemas');
define('PRIV_MENTOR_COLLECTION', 'mentor_collection');
/*
| Courschemaster - TAO
|--------------------------------------------------------------------------
| Sidebar
|--------------------------------------------------------------------------
*/
define('PRIV_TAO_ALL_COURSCHEMAS', 'tao_all_courschemas');
define('PRIV_TAO_COLLECTION', 'tao_collection');
define('PRIV_TAO_STUDENT_INFO', 'tao_student_info');
define('PRIV_TAO_COURSE_MANAGEMENT', 'tao_course_management');
define('PRIV_TAO_COURSCHEMA_MANAGEMENT', 'tao_courschema_management');
define('PRIV_TAO_REVIEW', 'tao_review');

/*
| Courschemaster - AJAX variables
|--------------------------------------------------------------------------
*/
define('AJAX_SUCCESS', 'success');
define('AJAX_FAIL', 'fail');
define('AJAX_TRUE', 'true');
define('AJAX_FALSE', 'false');