<?php
class Forest_IndexController extends Application_Model_Rest
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

		$forests  = $this->getModel('Forest_Model_Forest')->get($this->_getFilter());

		$data = array();
		foreach($forests as $forest) {
			$dataItem = array();
			$dataItem['forest_id'] = $forest->forest_id;
			$dataItem['forest_name'] = $forest->forest_name;
			$dataItem['forest_slug'] = $forest->forest_slug;
			$dataItem['forest_overview'] = $forest->forest_overview;
			$dataItem['forest_create_date'] = date("m/d/Y", $forest->forest_create_date);
			$dataItem['forest_create_by'] = $forest->forest_create_by;
			$dataItem['forest_street'] = $this->getAttribute(53, $forest->forest_id, 'Unknown');
			$dataItem['forest_city'] = $this->getAttribute(6, $forest->forest_id, 'Unknown');
			$dataItem['forest_state'] = $this->getAttribute(7, $forest->forest_id, 'Unknown');
			$dataItem['forest_postal'] = $this->getAttribute(54, $forest->forest_id, 'Unknown');
			$data[] = $dataItem;
		}
		
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


		$forests  = $this->getModel('Forest_Model_Forest')->get($this->_getFilter());
		
		$data = array();
		foreach($forests as $forest) {
			$dataItem = array();
			$dataItem['forest_id'] = $forest->forest_id;
			$dataItem['forest_name'] = $forest->forest_name;
			$dataItem['forest_slug'] = $forest->forest_slug;
			$dataItem['forest_overview'] = $forest->forest_overview;
			$dataItem['forest_create_date'] = date("m/d/Y", $forest->forest_create_date);
			$dataItem['forest_create_by'] = $forest->forest_create_by;
			$dataItem['forest_street'] = $this->getAttribute(53, $forest->forest_id, 'Unknown');
			$dataItem['forest_city'] = $this->getAttribute(6, $forest->forest_id, 'Unknown');
			$dataItem['forest_state'] = $this->getAttribute(7, $forest->forest_id, 'Unknown');
			$dataItem['forest_postal'] = $this->getAttribute(54, $forest->forest_id, 'Unknown');
			$data[] = $dataItem;
		}
		
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
		$accountId = 1;
		
		$id = $this->getParam('forest_id');
		
		$data = array(
				'forest_name' => $this->getParam('forest_name'),
				'forest_slug' => $this->slug($this->getParam('forest_name')),
				'forest_overview' => $this->getParam('forest_overview'),
				'forest_create_date' => time(),
				'forest_create_by' => $accountId
				);
		
		$forestId = $this->getParam('forest_id');
		
		$this->getModel('Forest_Model_Forest')->update($id, $data);
		
		// street
		$this->setAttribute(53, $this->getParam('forest_street'), $forestId, $accountId);
		
		// city
		$this->setAttribute(6, $this->getParam('forest_city'), $forestId, $accountId);
		
		// state
		$this->setAttribute(7, $this->getParam('forest_state'), $forestId, $accountId);
		
		// zip
		$this->setAttribute(54, $this->getParam('forest_postal'), $forestId, $accountId);
		
		
			
		$this->view->id = $forestId;
		$this->view->params = $this->_request->getParams();
		$this->view->message = sprintf('Resource #%s Updated', $forestId);
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
				'forest_name' => $this->getParam('forest_name'),
				'forest_slug' => $this->slug($this->getParam('forest_name')),
				'forest_overview' => $this->getParam('forest_overview'),
				'forest_create_date' => time(),
				'forest_create_by' => $accountId
				);
		
		$forestId = $this->getModel('Forest_Model_Forest')->create($data);

		// street
		$this->setAttribute(53, $this->getParam('forest_street'), $forestId, $accountId);
		
		// city
		$this->setAttribute(6, $this->getParam('forest_city'), $forestId, $accountId);
		
		// state
		$this->setAttribute(7, $this->getParam('forest_state'), $forestId, $accountId);
		
		// zip
		$this->setAttribute(54, $this->getParam('forest_postal'), $forestId, $accountId);
		
		$this->view->id = $forestId;
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
			$search['filterForestId'] = $this->getParam('forest_id');
		}

		if($this->getParam('forest_slug')) {
			$search['filterForestSlug'] = $this->getParam('forest_slug');
		}

		return $search;
	}
	
	private function slug($text)
	{
		$text = preg_replace("/[^A-Za-z0-9 ]/", " ", strtolower($text));
		$text = preg_replace('/[\s\W]+/', "-", trim($text));
	
		return $text;
	}
	
	/**
	 *
	 * @param int $attributeTypeId The attribute type id
	 * @param string $attributeValue The attribute value
	 * @param unknown_type $trailId The trail id
	 * @param unknown_type $accountId The account id of the user setting the attribute
	 * @return int the attribute id
	 */
	private function setAttribute($attributeTypeId, $attributeValue, $forestId, $accountId)
	{
		$attribute = $this->getModel('Attribute_Model_Attribute')->get(
				array('filterCollectionType' => 'forest',
						'filterCollectionId' => $forestId,
						'filterAttributeTypeId' => $attributeTypeId
				));
		if(count($attribute) == 0) {
			$data = array(
					'attribute_value' => $attributeValue,
					'collection_type' => 'forest',
					'collection_id' => $forestId,
					'attribute_type_id' => $attributeTypeId,
					'attribute_create_date' => time(),
					'attribute_create_by' => $accountId);
			$attributeId = $this->getModel('Attribute_Model_Attribute')->create($data);
			return $attributeId;
		} else {
			$data = array('attribute_value' => $attributeValue);
			$this->getModel('Attribute_Model_Attribute')->update($attribute[0]->attribute_id, $data);
			return $attribute[0]->attribute_id;
		}
	}
	
	/**
	 *
	 * @param unknown_type $attributeId
	 * @param unknown_type $trailId
	 * @param unknown_type $default
	 */
	private function getAttribute($attributeId, $forestId, $default)
	{
		$attributeValue = $this->getModel('Attribute_Model_Attribute')->get(array(
				'filterCollectionType' => 'forest',
				'filterCollectionId' => $forestId,
				'filterAttributeTypeId' => $attributeId
		));
		if(count($attributeValue) < 1) {
			$attributeValue = $default;
		} else {
			$attributeValue = $attributeValue[0]->attribute_value;
		}
		return $attributeValue;
	}
}
