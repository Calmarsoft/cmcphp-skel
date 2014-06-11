<?php
namespace cmcskel;

use cmc\ui\dynframe;
// used components
use cmc\ui\widgets\label,cmc\ui\widgets\button;

class skelFrame extends dynframe {

    const className = __CLASS__;
    var $count = 0;

    protected $_widgetdef = array(
        'div_hello' => array(label::factory, 'helloworld'),
        'div_hellostat' => array(label::factory, 'hellostat'),        
        'div_hellodyn' => array(label::factory, 'hellodyn'),
        'div_helloclick' => array(label::factory, 'helloclick'),
        'bt_test' => array(button::factory, 'testbutton'),
    );

    static public function getId() {
        return 'skel';
    }

    public function getName() {
        return 'dynframe';
    }

    // view is upon update, static part
    public function viewStaticUpdate($view) {
        $this->w('div_hellostat')->setHtml('Hello world from <b>static update; </b>date is: ' . date(DATE_RFC2822));
    }
    // when material is calculated in the session
    public function viewInitialUpdate($view) {
        $this->w('div_hello')->setHtml('Hello world from <b>initial update; </b>date is: ' . date(DATE_RFC2822));
        $this->AddClickEvent('bt_test', array($this, 'click'));
    }
    // each time a refresh is made
    public function viewUpdate($view, $sess) {
        $this->w('div_hellodyn')->setHtml('Hello world from <b>update; </b>date is: ' . date(DATE_RFC2822));
        $this->count++;
    }
    /******* EVENTS ******/
    public function click() {
        $this->w('div_helloclick')->setHtml('Click on server '. $this->count.'; </b>date is: ' . date(DATE_RFC2822));
        $this->count++;
    }

}

?>
