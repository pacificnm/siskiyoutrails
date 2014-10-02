<?php 
class Nearby_IndexController extends Application_Model_Rest
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
		
		$data = array();
		
		$collectionType = $this->getParam('collection_type');
		$collectionId = $this->getParam('collection_id');
		
		switch($collectionType) {
			case 'trail':
					$models = $this->getModel('Trail_Model_Trail')->nearby(array(
						'filterTrailId' => $collectionId
					), 7);
					
					
					foreach($models as $model) {
						
						$item['trail_id'] = $model['trail_id'];
						$item['trail_name'] = $model['trail_name'];
						$item['trail_slug'] = $model['trail_slug'];
						$item['trail_dificulty'] = $this->getAttribute(13,'trail', $model['trail_id'], 'Unknown');
						$item['trail_distance'] = $this->getAttribute(14, 'trail', $model['trail_id'], '');
						$item['trail_duration'] = $this->getAttribute(15, 'trail', $model['trail_id'], '');
						
						$item['request_account_admin'] = $account['request_account_admin'];
						$item['request_account_email'] = $account['request_account_email'];
						$item['request_account_id'] = $account['request_account_id'];
						$item['request_account_ip'] = $account['request_account_ip'];
						$item['request_account_name'] = $account['request_account_name'];
						$item['request_account_time'] = $account['request_account_time'];
						$item['request_account_token'] = $account['request_account_token'];
							
						$data[] = $item;
					}
					
				break;
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
		// get account
		$account = $this->getActiveAccount();

		$data = array();
		
		$collectionType = $this->getParam('collection_type');
		$collectionId = $this->getParam('collection_id');
		
		switch($collectionType) {
			case 'trail':
				
				break;
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
		// get account
		$account = $this->getActiveAccount();
			
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
		// get account
		$account = $this->getActiveAccount();
		
		$this->view->id = $id;
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
		// get account
		$account = $this->getActiveAccount();

		$this->view->id = $id;
		$this->view->message = sprintf('Resource #%s Deleted', $id);
		$this->_response->ok();
	}


	private function _getFilter()
	{
		$search = array();

		

		return $search;
	}
	
}
