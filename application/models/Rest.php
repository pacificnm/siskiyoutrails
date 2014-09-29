<?php 
abstract class Application_Model_Rest extends REST_Controller 
{
	
	
	public function optionsAction()
	{
		$this->getResponse()->setBody(null);
		$this->getResponse()->setHeader('Allow', 'OPTIONS, HEAD, INDEX, GET, POST, PUT, DELETE');
	}
	
	/**
	 * 
	 * @param string $model
	 */
	public function getModel($model)
	{
		$model = new $model();
	
		return $model;
	}
}