<?php 
class Application_Model_Controller extends Zend_Controller_Action
{
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