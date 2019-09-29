<?php
/**
 * --------------------------------------------------------
 * Courschemaster
 * 
 * This web appilication is used to manage course schemes.
 * 
 * @author    Mike Chester Wang
 * @copyright Copyright (c) SUSTech OOAD Courschemaster group
 * @see       https://github.com/WingsUpete/courschemaster
 * @since     v0.1
 * --------------------------------------------------------
 */
class Config {

// ------------------------------------------------------------------------
// GENERAL SETTINGS
// ------------------------------------------------------------------------

const BASE_URL      = 'https://localhost/Courschemaster/src';
const LANGUAGE      = 'english';
const DEBUG_MODE    = FALSE;

// ------------------------------------------------------------------------
// DATABASE SETTINGS
// ------------------------------------------------------------------------

const DB_HOST       = '';
const DB_NAME       = '';
const DB_USERNAME   = '';
const DB_PASSWORD   = '';

// ------------------------------------------------------------------------
// phpCAS SETTINGS
// ------------------------------------------------------------------------

const CAS_DEBUG = TRUE;
const CAS_DISABLE_SERVER_VALIDATION = TRUE;
const VENDOR_CAS_SOURCE = '../vendor/jasig/phpcas/source';

///////////////////////////////////////
// Basic Config of the phpCAS client //
///////////////////////////////////////
// Full Hostname of your CAS Server
const CAS_HOST = 'cas.sustech.edu.cn';
// Context of the CAS Server
const CAS_CONTEXT = '/cas';
// Port of your CAS server. Normally for a https server it's 443
const CAS_PORT = 443;

}
?>