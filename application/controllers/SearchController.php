<?php

class SearchController
    extends Zend_Controller_Action
{
    public function init()
    {
        $ajaxContext = $this->_helper->getHelper('AjaxContext');
        $ajaxContext
            ->addActionContext('index', array('json', 'html'))
            ->initContext();
    }

    public function indexAction()
    {
        if (is_null($this->getRequest()->getParam('postalCode'))) {
            return;
        }

        $postalCode = $this->getRequest()->getParam('postalCode');

        $dom = new DOMDocument();
        $dom->load('http://maps.googleapis.com/maps/api/geocode/xml?address=Netherlands,' . $postalCode . '&sensor=false');
        $xpath = new DOMXpath($dom);

        $latitude = $xpath->query('//result/geometry/location/lat')->item(0)->nodeValue;
        $longitude = $xpath->query('//result/geometry/location/lng')->item(0)->nodeValue;

        $dbTable = new Application_Model_DbTable_TrainStation();

        $select = $dbTable->select();
        $select
            ->setIntegrityCheck(false)
            ->from(
                $dbTable, 
                array(
                    'name',
                    '( 6371 * acos( cos( radians(' .$latitude . ') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(' . $longitude . ') ) + sin( radians(' . $latitude . ') ) * sin( radians( latitude ) ) ) ) AS distance'
                )
            )
            ->order('distance');

        $this->view->data = $dbTable->fetchAll($select);

    }
}
