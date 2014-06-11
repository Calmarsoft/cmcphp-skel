<?php
namespace cmcskel;      // par convetion, nom du site/projet comme namespace

/**
 * 
 * Application entry file
 * 
 * contants: application class instantiate and run
 * 
 * 
 */
/** check environment  **/
$config='';
$doc = filter_input(INPUT_SERVER, 'DOCUMENT_ROOT');
$srv = filter_input(INPUT_SERVER, 'HTTP_HOST');

if ($doc) {
    if (preg_match('|^/homez\.|', $doc))
        $config = 'prod';   // ovh
    else if ($srv=='devtest2.home.lan')
        $config = 'test';    // serveur local test
    else $config = 'dev';     
}

if ($config == 'prod')
    ini_set('include_path', 'php:/usr/lib/pear');
else
    ini_set('include_path', '/var/www/devpt/cmc:php:/usr/lib/pear');


require_once 'php/myApp.php';


// application create instance
$myApp = myApp::current();
// run application
$myApp->run();

