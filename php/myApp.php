<?php

namespace cmcskel;

use \cmc\app;
use \cmc\sess;
use \cmc\db\dataenv;

// CMC framework inclusion
if ($config == 'prod')
    include_once('cmc.phar');
else
    include_once('cmc/index.php');

// frames of process
require_once 'skelFrame.php';       // a sample frame

/**
 * Application's data environment
 */
class MyDataEnv extends dataenv {

    // the direct queries
    private $_myQueries = array(
    );
    // the 'table' kind data
    private $_myTables = array(
    );

    public function getQueryMap() {
        return $this->_myQueries;
    }

    public function getTables() {
        return $this->_myTables;
    }

}

/**
 *
 * Application definition
 * 
 */
class myApp extends app {

    // here is the frameset for the application
    private $_frameclasses = array(
        skelFrame::className, // sample frame
    );

    /*
     * those functions are mantarory to setup application
     */

    static function current($ClassName = __CLASS__) {
        return parent::current($ClassName);
    }

    protected function getFrameClasses() {
        return array_merge(parent::getFrameClasses(), $this->_frameclasses);
    }

    // override init to link the application to our customized session object
    protected function initialize() {
        MySess::current($this);     // to have correct session type
        parent::initialize();
    }

}

/**
 * a custom session class
 */
class MySess extends sess {
    private $_mydataEnv;        // our data environment

    static function current($app, $ClassName = __CLASS__) {
        return parent::current($app, $ClassName);
    }

    public function __construct(app $app) {
        parent::__construct($app);
        $this->_mydataEnv = new MyDataEnv();
    }

    public function getDataEnv() {
        return $this->_mydataEnv;
    }
}

/*
 *  Some shortcuts in our namespace
 */
// gets our data envirnoment
function dataenv() {
    return sess()->getDataEnv();
}

// gets the current query
function qry() {
    return sess()->getRequest();
}
