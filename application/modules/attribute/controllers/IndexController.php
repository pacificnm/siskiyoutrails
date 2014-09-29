<?php
class Attribute_IndexController extends Application_Model_Rest
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
		$data = $this->getModel('Attributegroupitem_Model_Attributegroupitem')->get($this->_getFilter())->toArray();

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
				'attribute_type_id' => $this->getParam('attribute_type_id'),
				'attribute_value' => $this->getParam('attribute_value'),
				'collection_id' => $this->getParam('collection_id'),
				'collection_type' => $this->getParam('collection_type'),
				'attribute_create_date' => time(),
				'attribute_create_by' => $accountId
				);

		// first check if we have it already
		$attribute = $this->getModel('Attribute_Model_Attribute')->get($this->_getFilter());
		if(count($attribute) == 0) {
			$id = $this->getModel('Attribute_Model_Attribute')->create($data);
		} else {
			$id = $attribute[0]->attribute_id;
			$this->getModel('Attribute_Model_Attribute')->update($id, $data);
		}
		
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

		if($this->getParam('attribute_type_id')) {
			$search['filterAttributeTypeId'] = $this->getParam('attribute_type_id');
		}

		if($this->getParam('collection_type')) {
			$search['filterCollectionType'] = $this->getParam('collection_type');
		}

		if($this->getParam('collection_id')) {
			$search['filterCollectionId'] = $this->getParam('collection_id');
		}
		return $search;
	}
}

