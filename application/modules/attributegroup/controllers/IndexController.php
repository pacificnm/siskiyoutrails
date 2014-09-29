<?php
class Attributegroup_IndexController extends Application_Model_Rest
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
		$data = $this->getModel('Attributegroup_Model_Attributegroup')->get($this->_getFilter())->toArray();

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

		$data = $this->getModel('Attributegroup_Model_Attributegroup')->get($this->_getFilter())->toArray();
		
			
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
		
		$id = $this->getParam('attribute_group_id');
		
		$data = array(
				'attribute_group_name' => $this->getParam('attribute_group_name'),
				'collection_type' => $this->getParam('collection_type'),
				);
		
		$this->getModel('Attributegroup_Model_Attributegroup')->update($id, $data);	
		
		$this->view->attribute_type_id = $id;
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
		$accountId = 1;
		
		$data = array(
				'attribute_group_name' => $this->getParam('attribute_group_name'),
				'collection_type' => $this->getParam('collection_type'),
				'attribute_group_create' => time(),
				'attribute_group_create_by' => $accountId
				);

		$id = $this->getModel('Attributegroup_Model_Attributegroup')->create($data);
		
		$this->view->attribute_type_id = $id;
		$this->view->data = $data;
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
		

		$this->view->id = $id;
		$this->view->message = sprintf('Resource #%s Deleted', $id);
		$this->_response->ok();
	}


	private function _getFilter()
	{
		$search = array();

		if($this->getParam('account_id')) {
			$search['filterAccountId'] = $this->getParam('account_id');
		}

		

		return $search;
	}
}
