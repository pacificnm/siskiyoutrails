<?php
class Completed_IndexController extends Application_Model_Rest
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

		$account = $this->getActiveAccount();
			
		$models = $this->getModel('Completed_Model_Completed')->get($this->_getFilter());
			
		$data = array();
		foreach($models as $model) {
			$item = array();
			$item['completed_id'] = $model->completed_id;
			$item['collection_type'] = $model->collection_type;
			$item['collection_id'] = $model->collection_id;
			$item['completed_by'] = $model->completed_by;
			$item['completed_date'] = date("m/d/Y", $model->completed_date);
			$item['completed_comment'] = $model->completed_comment;
			$item['account_id'] = $model->account_id;
			$item['account_name'] = $model->account_name;
			$item['account_completed'] = $model->account_completed;
			$item['account_review'] = $model->account_review;
			$item['account_score'] = $model->account_score;
			$item['account_slug'] = $this->slug($model->account_name);
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
	 * The get action handles GET requests and receives an 'id' parameter; it
	 * should respond with the server resource state of the resource identified
	 * by the 'id' value.
	 */
	public function getAction()
	{
	$account = $this->getActiveAccount();
			
		$models = $this->getModel('Completed_Model_Completed')->get($this->_getFilter());
			
		$data = array();
		
		foreach($models as $model) {
			$item = array();
			$item['completed_id'] = $model->completed_id;
			$item['collection_type'] = $model->collection_type;
			$item['collection_id'] = $model->collection_id;
			$item['completed_by'] = $model->completed_by;
			$item['completed_date'] = date("m/d/Y", $model->completed_date);
			$item['completed_comment'] = $model->completed_comment;
			$item['account_id'] = $model->account_id;
			$item['account_name'] = $model->account_name;
			$item['account_completed'] = $model->account_completed;
			$item['account_review'] = $model->account_review;
			$item['account_score'] = $model->account_score;
			$item['account_slug'] = $this->slug($model->account_name);
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
		$account = $this->getActiveAccount();
		
		if($account['request_account_id'] > 0) {
			
			$data = array(
					'collection_type' => $this->getParam('collection_type'),
					'collection_id' => $this->getParam('collection_id'),
					'completed_by' => $account['request_account_id'],
					'completed_date' => strtotime($this->getParam('completed_date')),
					'completed_comment' => $this->getParam('completed_comment'),
					);
			
			if($this->_validate($data)) {
				
				$id = $this->getModel('Completed_Model_Completed')->create($data);
				
				$this->view->id = $id;
				$this->view->data = $data;
				$this->view->message = 'Resource Created';
				$this->_response->created();
			} else {
				
				$this->_response->serverError();
			}
		} else {
			$this->view->message = 'Missing account id';
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

	/**
	 * Validates the data
	 * @param array $data
	 * @return boolean
	 */
	private function _validate($data) 
	{
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
		
		return true;
	}
	
	private function _getFilter()
	{
		$search = array();

		if($this->getParam('collection_type')) {
			$search['filterCollectionType'] = $this->getParam('collection_type');
		}
		
		if($this->getParam('collection_id')) {
			$search['filterCollectionId'] = $this->getParam('collection_id');
		}

		

		return $search;
	}
}
