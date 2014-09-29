<?php
class IndexController extends Zend_Controller_Action    
{

    /**
     * (non-PHPdoc)
     *
     * @see Application_Model_Base::init()
     */
    public function init ()
    {
        parent::init();
        $appConfig = Zend_Registry::get('Application_Config');
      
        if($appConfig->app->installed == "false") {
        	$this->redirect('/install');
        }
    }

    /**
     * Index Action
     */
    public function indexAction () {
    	
    	
    	
    } 
    
    public function postAction() {
    	
    }
    
}