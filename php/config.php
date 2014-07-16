<?php

namespace cmc;

use cmc\core\request;

/** some main constants, used by some config values **/
const site = 'cmcskel'; // our application name
const index = 'index';  // the main view name


/** global application parameters */
global $config;
switch ($config) {
    case 'prod':
        /// our production database connection
        $config_db = array(
            'type' => 'mysqli',
            'server' => 'mysql51-xx.perso',
            'database' => 'prod_db',
            'login' => 'prod_login',
            'password' => 'zzzz',);
        // our production error display settings: none
        ini_set('display_errors', '0');
        error_reporting(-1);
        break;
    default:
        // in test: use a local development MySQL server
        $config_db = array(
            'type' => 'mysqli',
            'server' => 'localhost',
            'database' => site,       // in local, base is project name
            'login' => site,
            'password' => '');
        // direct error dislpay
        ini_set('display_errors', '1');
        error_reporting(-1);
}

// Some PHP global settings
// a 10 minutes session lifetime
ini_set("session.cookie_lifetime", "600");

/**
 * 
 * Global session parameters
 *
 * @author Benoit@calmarsoft.com
 */
class config extends dftconfig {
    // Application constants
    // Default view path
    const my_dft_Path = index;
    // 'material' location i.e. the HTML part
    const MAT_path = '';

    // important when MAT_path is '': defines which are valid material sources
    static function MAT_valid($path) {
        if ($path === self::my_dft_Path)
            return true;
        
        return false;
    }
    // redefines some default constants
    const APP_cache = true;     // application cache (optional)
    const SESS_save = true;     // session capability
    const SESS_save_mat = true; // session material save (avoid recaclating on each refresh)
    const DFT_REDIRECT = false; // auto redirect to default
    const ERR_REDIRECT = false;  // auto redirect on error
    const Multilingual = false; // Multilingual capable
    const CACHE_path = 'cache/';    // application cache location
    const APP_guid = 'c614b303e2a468dce9122e2a864700d6';    // application guid (important if different application share the same cache directory)
    
    static function PoweredBy_Banner($path) {
        $servinfo = '<br>PHP '.phpversion() . '<br>' .php_uname();
        return <<<EOT
        <style>.cmc-poweredby{float:right;margin-right:20px;margin-top:20px;font-size:small;text-align:right}</style>        
            <div class="cmc-poweredby">Powered by CMC (c) <a href="http://cmc.calmarsoft.com/">CMC Components</a> $servinfo</div>
EOT
        ;
    }
        
    
    static function TIME_Banner($path) { global $config; if ($config=='prod') return false; else return true;}
}

// session files in our cache directory
ini_set('session.save_path', request::rootphyspath() . '/'. config::CACHE_path);

config::setConfig('db', $config_db);
unset($config_db);
unset($config);

