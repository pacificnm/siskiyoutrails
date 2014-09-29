<?php
class File_IndexController extends Application_Model_Rest
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
		$adapter = new Zend_File_Transfer_Adapter_Http();
		$adapter->setDestination(REAL_PATH . '/files/tmp');
		if (!$adapter->receive()) {
			$messages = $adapter->getMessages();
			$this->view->message = implode("\n", $messages);
			$this->_response->serverError();
		} else {
			$name = $adapter->getFileName();
			$info = $adapter->getFileInfo();
			$filename = $info['files_0_']['name'];
			
			$xml = simplexml_load_file($name);
			$childs = $xml->Document->Folder->children();
		
			$trailCreateBy = $this->getParam('account_id');
			
			$fileData = array();
			foreach($childs as $child) {
				if(count($child) > 0) {
					$data = array();
					$trailType = false;
					$trailName = ucfirst(strtolower($child->name));
					
					if (preg_match("/OHV/", $child->name)) {
						$trailType = 'OHV';
						$trailName =  preg_replace( "/ohv/", '', $trailName );
						$trailName =  preg_replace( "/trail/i", '', $trailName );
					}
					
					if (preg_match("/TRAIL/", $child->name)) {
						$trailType = 'Hiking';
						$trailName =  preg_replace( "/trail/i", '', $trailName );
					}
					
					if($trailType == false && $trailType == false) {
						$trailType = 'Hiking';
					}
					
					$trailCoordinates = null;
					foreach($child->MultiGeometry->LineString as $string) {
						$trailCoordinates = $trailCoordinates . $string->coordinates;
					}
					
					// trail head
					$pieces = explode(',', $trailCoordinates);
					$trailHead = $pieces[0].','.$pieces[1];
					
					// check if we already have a trail name
					$trailName = ucwords(strtolower(trim($trailName)));
					
					$existingTrail = $this->getModel('Trail_Model_Trail')->get(array('filterTrailName' => $trailName));
					
					if(count($existingTrail) > 0) {
						$count = count($existingTrail);
						$trailName = $trailName.' '. $count++;
					}
					
					$data['trail_name'] = $trailName;
					$data['trail_slug'] = $this->slug($trailName);
					$data['trail_create_by'] = $trailCreateBy;
					$data['trail_create_date'] = time();
					$data['trail_head'] = $trailHead;
					$data['trail_coordinates'] = $trailCoordinates;
					
					$trailId = $this->getModel('Trail_Model_Trail')->create($data);
					
					$data['trail_id'] = $trailId;
					$data['trail_type'] = $trailType;
					
					// set flags 
					if($trailType == 'Hiking') {
						$data = array(
								'collection_type' => 'trail',
								'collection_id' => $trailId,
								'attribute_type_id' => 12,
								'attribute_value' => 1,
								'attribute_create_date' => time(),
								'attribute_create_by' => $trailCreateBy
								);
					
					} else {
						$data = array(
								'collection_type' => 'trail',
								'collection_id' => $trailId,
								'attribute_type_id' => 11,
								'attribute_value' => 1,
								'attribute_create_date' => time(),
								'attribute_create_by' => $trailCreateBy
						);
					}
					$attributeId = $this->getModel('Attribute_Model_Attribute')->create($data);
					
					// set trail type
					$data = array(
							'collection_type' => 'trail',
							'collection_id' => $trailId,
							'attribute_type_id' => 1,
							'attribute_value' => $trailType,
							'attribute_create_date' => time(),
							'attribute_create_by' => $trailCreateBy
					);
					$attributeId = $this->getModel('Attribute_Model_Attribute')->create($data);
					
					// set trail head
					$data = array(
							'collection_type' => 'trail',
							'collection_id' => $trailId,
							'attribute_type_id' => 9,
							'attribute_value' => $trailHead,
							'attribute_create_date' => time(),
							'attribute_create_by' => $trailCreateBy
					);
					$attributeId = $this->getModel('Attribute_Model_Attribute')->create($data);
					
					$fileData[] = $data;
				}
			}
			
			
			
			
			
			$this->view->data = $fileData;
			$this->view->params = $this->_request->getParams();
			//$this->view->message = sprintf('Resource #%s Updated', $id);
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
		
		
		
		return $search;
	}
	
	private function slug($text) 
	{
		$text = preg_replace("/[^A-Za-z0-9 ]/", " ", strtolower($text));
		$text = preg_replace('/[\s\W]+/', "-", trim($text));
		
		return $text;
		
	}
}
