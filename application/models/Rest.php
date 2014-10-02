<?php 
abstract class Application_Model_Rest extends REST_Controller 
{
	
	
	public function optionsAction()
	{
		$this->getResponse()->setBody(null);
		$this->getResponse()->setHeader('Allow', 'OPTIONS, HEAD, INDEX, GET, POST, PUT, DELETE');
	}
	
	/**
	 * 
	 * @param string $model
	 */
	public function getModel($model)
	{
		$model = new $model();
	
		return $model;
	}
		
	/**
	 * Retruns the users ip address
	 * @todo
	 * @return string 
	 */
	public function getIpAddress()
	{
		return '127.0.0.1';
	}
		
	/**
	 * Returns the active user account. If none returns guest values
	 * 
	 * @return array 
	 */
	public function getActiveAccount()
	{
		$item = array();
		
		// get account
		$account = $this->getModel('Account_Model_Account')->get(array(
				'filterAccountEmail' => $this->getParam('account_email', 'guest@siskiyoutrails.com'),
				'filterAccountToken' => $this->getParam('account_token', '')
		));
		
		if(count($account) > 0 ) {
			$item['request_account_id'] = $account[0]->account_id;
			$item['request_account_name'] = $account[0]->account_name;
			$item['request_account_admin'] = $account[0]->account_admin;
			
		} else {
			$item['request_account_id'] = 0;
			$item['request_account_name'] = 'Guest';
			$item['request_account_name'] = 0;
			$item['request_account_admin'] = 0;
		}
		
		$item['request_account_email'] = $this->getParam('account_email', 'guest@siskiyoutrails.com');
		$item['request_account_token'] = $this->getParam('account_token');
		$item['request_account_time'] = date("m/d/y h:i:s");
		$item['request_account_ip'] = $this->getIpAddress();
		
		return $item;
	}
	
	/**
	 * 
	 * @param unknown_type $attributeTypeId
	 * @param unknown_type $attributeValue
	 * @param unknown_type $collectionType
	 * @param unknown_type $collectionId
	 * @param unknown_type $accountId
	 * @return unknown
	 */
	public function setAttribute($attributeTypeId, $attributeValue, $collectionType, 
			$collectionId, $accountId)
	{
		$attribute = $this->getModel('Attribute_Model_Attribute')->get(
				array('filterCollectionType' => $collectionType,
						'filterCollectionId' => $collectionId,
						'filterAttributeTypeId' => $attributeTypeId
				));
		if(count($attribute) == 0) {
			$data = array(
					'attribute_value' => $attributeValue,
					'collection_type' => $collectionType,
					'collection_id' => $collectionId,
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
	 * @param unknown_type $collectionType
	 * @param unknown_type $collectionId
	 * @param unknown_type $default
	 * @return unknown
	 */
	public function getAttribute($attributeId, $collectionType, $collectionId, $default)
	{
		$attributeValue = $this->getModel('Attribute_Model_Attribute')->get(array(
				'filterCollectionType' => $collectionType,
				'filterCollectionId' => $collectionId,
				'filterAttributeTypeId' => $attributeId
		));
		if(count($attributeValue) < 1) {
			$attributeValue = $default;
		} else {
			$attributeValue = $attributeValue[0]->attribute_value;
		}
		return $attributeValue;
	}
	
	
	
	/**
	 * Create url friendly slug
	 * 
	 * @param string $text
	 */
	public function slug($text)
	{
		$text = preg_replace("/[^A-Za-z0-9 ]/", " ", strtolower($text));
		$text = preg_replace('/[\s\W]+/', "-", trim($text));
	
		return $text;
	}
}