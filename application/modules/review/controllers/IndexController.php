<?php
class Review_IndexController extends Application_Model_Rest
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

		$data = $this->getModel('Review_Model_Review')->get($this->_getFilter())->toArray();
		
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


		$data = $this->getModel('Review_Model_Review')->get($this->_getFilter())->toArray();
		
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
		
		
		
		
		$accountEmail = $this->getParam('account_email');
		$accountToken = $this->getParam('account_token');
		$collectionId = $this->getParam('collection_id');
		$collectionType = $this->getParam('collection_type');
		$reviewId = $this->getParam('review_id');
		$reviewDate = $this->getParam('review_date');
		$reviewRate = $this->getParam('review_rate');
		$reviewText = $this->getParam('review_text');
		
		if($reviewId < 1) {
			$this->view->message = 'Missing review id';
			$this->_response->serverError();
		} else {
		
			$filterStripTags = new Zend_Filter_StripTags();
			
			$data = array(
					'collection_type' => $collectionType,
					'collection_id' => $collectionId,
					'account_id' => 1,
					'review_text' => $filterStripTags->filter($reviewText),
					'review_date' => strtotime($reviewDate),
					'review_rate' => $reviewRate
			);
			
			if($this->_validate($data)) {
				$this->getModel('Review_Model_Review')->update($reviewId, $data);
				$this->view->review_id = $reviewId;
				$this->view->data = $data;
				$this->view->message = sprintf('Resource #%s Updated', $reviewId);
				$this->_response->ok();
			} else {
				$this->_response->serverError();
			}
		}
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
		
		
		$accountEmail = $this->getParam('account_email');
		$accountToken = $this->getParam('account_token');
		$collectionId = $this->getParam('collection_id');
		$collectionType = $this->getParam('collection_type');
		$reviewDate = $this->getParam('review_date');
		$reviewRate = $this->getParam('review_rate');
		$reviewText = $this->getParam('review_text');
		
		$filterStripTags = new Zend_Filter_StripTags();
		
		$data = array(
				'collection_type' => $collectionType,
				'collection_id' => $collectionId,
				'account_id' => 1,
				'review_text' => $filterStripTags->filter($reviewText),
				'review_date' => strtotime($reviewDate),
				'review_rate' => $reviewRate
		);
		
		if($this->_validate($data)) {
			$reviewId = $this->getModel('Review_Model_Review')->create($data);
			$this->view->id = $reviewId;
			$this->view->data = $data;
			$this->view->message = 'Resource Created';
			$this->_response->created();
		} else {
			$this->_response->serverError();
		}
		
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
	
	private function _validate($data)
	{
		$validator = new Zend_Validate_Int();
		if(!$validator->isValid($data['review_date'])){
			$this->view->message =  $validator->getMessages();
			$this->_response->serverError();
			return false;
		}
		
		$validator = new Zend_Validate_Int();
		if(!$validator->isValid($data['collection_id'])){
			$this->view->message = $validator->getMessages();
			$this->_response->serverError();
			return false;
		}
		
		$validator = new Zend_Validate_NotEmpty();
		if(!$validator->isValid($data['collection_type'])) {
			$this->view->message = $validator->getMessages();
			$this->_response->serverError();
			return false;
		}
		
		$validator = new Zend_Validate_NotEmpty();
		if(!$validator->isValid($data['review_text'])) {
			$this->view->message = $validator->getMessages();
			$this->_response->serverError();
			return false;
		}
		return true;
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
