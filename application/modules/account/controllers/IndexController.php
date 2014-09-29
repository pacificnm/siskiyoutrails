<?php
class Account_IndexController extends Application_Model_Rest
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
		
		if(empty($this->getParam('account_email')) || empty($this->getParam('account_token'))) {
			$this->_response->unauthorized();
		} else {
		
			$data = $this->getModel('Account_Model_Account')->get($this->_getFilter())->toArray();
			
			
			
			$this->view->data = $data;
			$this->_response->ok();
		}
		
	}
	
	/**
	 * The get action handles GET requests and receives an 'id' parameter; it
	 * should respond with the server resource state of the resource identified
	 * by the 'id' value.
	 */
	public function getAction()
	{
		if(empty($this->getParam('account_email'))) {
			
			$this->view->message = 'login failed';
			$this->_response->unauthorized();
			
		} else {
			
			
			
			$data = $this->getModel('Account_Model_Account')->get($this->_getFilter());
			if(count($data) == 0) {
				$this->view->message = 'login failed';
				$this->_response->unauthorized();
			} else {
				$data = $data[0];
				
				// update token
				$token = md5($this->getParam('account_email') . time());
				$new = array(
						'account_token' => $token
						);
				
				
				$this->getModel('Account_Model_Account')->update($data->account_id, $new);
				
				$returnData = array(
						'account_id' => $data->account_id,
						'account_name' => $data->account_name,
						'account_email' => $data->account_email,
						'account_token' => $token,
						'account_admin' => $data->account_admin,
				);
				
				$this->view->data = $returnData;
				$this->_response->ok();
			}
			
		}
	}
	
	/**
	 * The put action handles PUT requests and receives an 'id' parameter; it
	 * should update the server resource state of the resource identified by
	 * the 'id' value.
	 */
	public function putAction()
	{
		$id = $this->getParam('account_id');
		$token = $this->getParam('account_token');
		
		$account = $this->getModel('Account_Model_Account')->get(array('filterAccountToken' => $token, 'filterAccountId' => $id));
		
		if(count($account) < 1) {
			$this->view->message = 'account not authorized';
			$this->_response->unauthorized();
		} else {
		
			$data = array(
				'account_name' => $this->getParam('account_name'),
				'account_email' => $this->getParam('account_email')
					);
			
			$this->getModel('Account_Model_Account')->update($id, $data);
			
			$this->view->id = $id;
			$this->view->params = $this->_request->getParams();
			$this->view->message = sprintf('Resource #%s Updated', $id);
			$this->_response->ok();
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
		
		$token = md5($this->getParam('account_email') . time());
		
		$data = array(
				'account_name' => $this->getParam('account_name'),
				'account_email' => $this->getParam('account_email'),
				'account_password' => $this->getParam('account_password'),
				'account_token' => $token,
				'account_create' => time()
		);
		
		$id = $this->getModel('Account_Model_Account')->create($data);
		
		$data = $this->getModel('Account_Model_Account')->get(array('filterAccountId' => $id))->toArray();
		
		$data = $data[0];
		
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
		$this->getModel('Account_Model_Account')->delete($id);
		
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
		
		if($this->getParam('account_email')) {
			$search['filterAccountEmail'] = $this->getParam('account_email');
		}
		
		if($this->getParam('account_password')) {
			$search['filterAccountPassword'] = $this->getParam('account_password');
		}
		
		if($this->getParam('account_token')) {
			$search['filterAccountToken'] = $this->getParam('account_token');
		}
		
		return $search;
	}
}
