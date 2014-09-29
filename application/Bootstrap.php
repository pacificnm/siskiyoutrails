<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

	/**
	 * Initializes Application Config
	 */
	protected function _initApplicationConfig()
	{
		$configPath = APPLICATION_PATH . '/configs/application.ini';
		
		// test if is file
		if (! is_File($configPath)) {
			throw new Zend_Exception('Missing config file');
		} else {
			$appConfig = new Zend_Config_Ini($configPath, 'production',  array('skipExtends' => true, 'allowModifications' => true));
		
			Zend_Registry::set('Application_Config', $appConfig);
		}
	}
	
	
	
	public function _initREST()
	{
		
			$frontController = Zend_Controller_Front::getInstance();

		    // set custom request object
		    $frontController->setRequest(new REST_Request);
		    $frontController->setResponse(new REST_Response);
		
		    // add the REST route for the API module only
		    $restRoute = new Zend_Rest_Route($frontController, array(), array('api'));
		    $frontController->getRouter()->addRoute('rest', $restRoute);
			
		
	}
}

