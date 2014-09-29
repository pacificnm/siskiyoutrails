<?php
class Config_IndexController extends Application_Model_Rest
{
	/**
	 * The head action handles HEAD requests; it should respond with an
	 * identical response to the one that would correspond to a GET request,
	 * but without the response body.
	 */
	public function headAction()
	{
		$this->view->message = 'headAction has been called';
		$this->_response->ok();
	}
	
	
	/**
	 * The index action handles index/list requests; it should respond with a
	 * list of the requested resources.
	 */
	public function indexAction()
	{
		$data = $this->getModel('Config_Model_Config')->get($this->_getFilter())->toArray();
		
		$this->view->data = $data;
		$this->_response->ok();
		
	}
	
	/**
	 * The get action handles GET requests and receives an 'id' parameter; it
	 * should respond with the server resource state of the resource identified
	 * by the 'id' value.
	 */
	public function getAction()
	{
		$data = $this->getModel('Config_Model_Config')->get($this->_getFilter())->toArray();
		
		$this->view->data = $data;
		$this->_response->ok();
	}
	
	/**
	 * The put action handles PUT requests and receives an 'id' parameter; it
	 * should update the server resource state of the resource identified by
	 * the 'id' value.
	 */
	public function putAction()
	{
		$data = array();
		
		$this->getModel('Config_Model_Config')->update($id, $data);
		
		$this->view->id = $id;
		$this->view->params = $this->_request->getParams();
		$this->view->message = sprintf('Resource #%s Updated', $id);
		$this->_response->ok();
	}
	
	/**
	 * The post action handles POST requests; it should accept and digest a
	 * POSTed resource representation and persist the resource state.
	 * 
	 * @todo create email functions
	 * @todo create resource createWorkorder
	 */
	public function postAction()
	{
		$data = array();
		
		$id = $this->getModel('Config_Model_Config')->create($data);
		
		$this->view->params = $this->_request->getParams();
		$this->view->id = $id;
		$this->view->message = 'Resource Created';
		$this->_response->created();	
	}
	
	/**
	 * The delete action handles DELETE requests and receives an 'id'
	 * parameter; it should update the server resource state of the resource
	 * identified by the 'id' value.
	 */
	public function deleteAction()
	{
		$this->getModel('Config_Model_Config')->delete($id);
		
		$this->view->id = $id;
		$this->view->message = sprintf('Resource #%s Deleted', $id);
		$this->_response->ok();
	}
	
	
	private function _getFilter()
	{
		$search = array();
		
		if($this->getParam('config_id')) {
			$search['filterConfigId'] = $this->getParam('config_id');
		}
		
		return $search;
	}
}
