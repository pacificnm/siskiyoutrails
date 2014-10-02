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
		// get account
		$account = $this->getActiveAccount();
		
		// get reviews
		$models = $this->getModel('Review_Model_Review')->get($this->_getFilter());
		
		$data = array();
		
		// set up return
		foreach ($models as $model) {
			$item['review_id'] = $model->review_id;
			$item['collection_type'] = $model->collection_type;
			$item['collection_id'] = $model->collection_id;
			$item['review_text'] = $model->review_text;
			$item['review_date'] = date("m/d/Y", $model->review_date);
			$item['review_rate'] = $model->review_rate;$model['account_id'] = $model->account_id;
			$item['account_name'] = $model->account_name;
			$item['account_completed'] = $model->account_completed;
			$item['account_review'] = $model->account_review;
			$item['account_score'] = $model->account_score;
			$item['account_create'] = date("m/d/Y", $model->account_create);
			$item['account_admin'] = $model->account_admin;
			
			if(count($account) > 0) {
				if($account['request_account_id'] == $model->account_id) {
					$item['can_edit_review'] = 1;
				} else {
					$item['can_edit_review'] = 0;
				}
			} else {
				$item['can_edit_review'] = 3;
			}
			$item['request_account_admin'] = $account['request_account_admin'];
			$item['request_account_email'] = $account['request_account_email'];
			$item['request_account_id'] = $account['request_account_id'];
			$item['request_account_name'] = $account['request_account_name'];
			$item['request_account_time'] = $account['request_account_time'];
			$item['request_account_token'] = $account['request_account_token'];
			$data[] = $item;
		}
		
		// log request
		
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
		// get account
		$account = $this->getActiveAccount();
		
		// get reviews
		$models = $this->getModel('Review_Model_Review')->get($this->_getFilter());
		
		$data = array();
		
		foreach ($models as $model) {
			$item['review_id'] = $model->review_id;
			$item['collection_type'] = $model->collection_type;
			$item['collection_id'] = $model->collection_id;
			$item['review_text'] = $model->review_text;
			$item['review_date'] = date("m/d/Y", $model->review_date);
			$item['review_rate'] = $model->review_rate;
			$item['account_id'] = $model->account_id;
			$item['account_name'] = $model->account_name;
			$item['account_email'] = $model->account_email;
			$item['account_create'] = date("m/d/Y", $model->account_create);
			if(count($account) > 0) {
				if($account['account_id'] == $model->account_id) {
					$item['can_edit_review'] = 1;
				} else {
					$item['can_edit_review'] = 0;
				}
			} else {
				$item['can_edit_review'] = 3;
			}
			$item['request_account_admin'] = $account['request_account_admin'];
			$item['request_account_email'] = $account['request_account_email'];
			$item['request_account_id'] = $account['request_account_id'];
			$item['request_account_ip'] = $account['request_account_ip'];
			$item['request_account_name'] = $account['request_account_name'];
			$item['request_account_time'] = $account['request_account_time'];
			$item['request_account_token'] = $account['request_account_token'];
			$data[] = $item;
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

		if($this->getParam('collection_id')) {
			$search['filterCollectionId'] = $this->getParam('collection_id');
		}

		if($this->getParam('collection_type')) {
			$search['filterCollectionType'] = $this->getParam('collection_type');
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
	
}
