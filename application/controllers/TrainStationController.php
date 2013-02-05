<?php

class TrainStationController
    extends Zend_Controller_Action
{
    protected $trainStationMapper = null;

    public function init()
    {
        $this->trainStationMapper = new Application_Model_TrainStationMapper();

        $ajaxContext = $this->_helper->getHelper('AjaxContext');
        $ajaxContext
            ->addActionContext('index', array('json', 'html'))
            ->addActionContext('view', array('json', 'html'))
            ->initContext();
    }

    public function indexAction()
    {
        $this->view->trainStations = $this->trainStationMapper->fetchAll();
    }

    public function viewAction()
    {
        $id = $this->_getParam('id');
        $this->view->trainStation = $this->trainStationMapper->getById($id);
    }
}
