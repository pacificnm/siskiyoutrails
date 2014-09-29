<?php
class Trail_IndexController extends Application_Model_Rest
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

		$page = $this->getParam('page', 1);
		
		$items = $this->getModel('Trail_Model_Trail')->get($this->_getFilter(), true, $page);
		$data = array();
		foreach($items as $item) {
			$dataItem = array();
			$dataItem['trail_id'] = $item->trail_id;
			$dataItem['trail_name'] = $item->trail_name;
			$dataItem['trail_slug'] = $item->trail_slug;
			$dataItem['trail_dificulty'] = $this->getAttribute(13, $item->trail_id, 'Unknown');
			$dataItem['trail_distance'] = $this->getAttribute(14, $item->trail_id, '0');
			$dataItem['trail_duration'] = $this->getAttribute(15, $item->trail_id, '0');
			$dataItem['trail_type'] = $this->getAttribute(1, $item->trail_id, 'Hiking');
			$dataItem['trail_city'] = $this->getAttribute(6, $item->trail_id, 'Unknown');
			$dataItem['trail_state'] = $this->getAttribute(7, $item->trail_id, 'Unknown');
			$dataItem['trail_county'] = $this->getAttribute(8, $item->trail_id, 'Unknown');
			
			$forest = $this->getModel('Forest_Model_Forest')->get(array('filterForestSlug' => $this->getAttribute(34, $item->trail_id, 'None')));
			if(count($forest) !=0) {
				$dataItem['trail_forest'] = $forest[0]->forest_name;
				$dataItem['trail_forest_slug'] = $forest[0]->forest_slug;
			}
			
			$data[] = $dataItem;
		}

		$this->view->totalItemCount = $items->getTotalItemCount();
		$this->view->totalPages = $items->getPages()->pageCount;
		$this->view->pageRange = $items->getPageRange();
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

		
		
		$pagination = $this->getModel('Trail_Model_Trail')->get($this->_getFilter(), false, null);
		
		$data = array();
		foreach($pagination as $item) {
			
			$dataItem = array();
			$dataItem['trail_id'] = $item->trail_id;
			$dataItem['trail_name'] = $item->trail_name;
			$dataItem['trail_slug'] = $item->trail_slug;
			$dataItem['trail_overview'] = $item->trail_overview;
			$dataItem['trail_type'] = $this->getAttribute(1, $item->trail_id, 'Hiking');
			$dataItem['trail_dificulty'] = $this->getAttribute(13, $item->trail_id, 'Unknown');
			$dataItem['trail_distance'] = $this->getAttribute(14, $item->trail_id, '0');
			$dataItem['trail_duration'] = $this->getAttribute(15, $item->trail_id, '0');
			$dataItem['trail_elevation_gain'] = $this->getAttribute(2, $item->trail_id, '0');
			$dataItem['trail_season'] = $this->getAttribute(3, $item->trail_id, 'Unknown');
			$dataItem['trail_usage'] = $this->getAttribute(4, $item->trail_id, 'Unknown');
			$dataItem['trail_animals'] = $this->getAttribute(5, $item->trail_id, 'Unknown');
			$dataItem['trail_water'] = $this->getAttribute(10, $item->trail_id, 'Unknown');
			$dataItem['trail_city'] = $this->getAttribute(6, $item->trail_id, 'Unknown');
			$dataItem['trail_state'] = $this->getAttribute(7, $item->trail_id, 'Unknown');
			$dataItem['trail_county'] = $this->getAttribute(8, $item->trail_id, 'Unknown');
			$dataItem['trail_restrictions'] = $this->getAttribute(51, $item->trail_id, 'None');
			$dataItem['trail_features'] = $this->_getAttributeGroups(1, $item->trail_id);
			$dataItem['trail_activities'] = $this->_getAttributeGroups(2, $item->trail_id);
			$dataItem['trail_good_for'] = $this->_getAttributeGroups(3,$item->trail_id);
			
			$forest = $this->getModel('Forest_Model_Forest')->get(array('filterForestSlug' => $this->getAttribute(34, $item->trail_id, 'None')));
			if(count($forest) !=0) {
				$dataItem['trail_forest'] = $forest[0]->forest_name;
				$dataItem['trail_forest_slug'] = $forest[0]->forest_slug;
			}
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
		$id = $this->getParam('trail_id');
		if($id < 1 ) {
			
			$this->view->message = 'missing trail_id';
			$this->_response->serverError();
		} else {
			$accountId = 1;
			
			// trail
			$data = array(
					'trail_name' => $this->getParam('trail_name'),
					'trail_slug' => $this->slug($this->getParam('trail_name')),
					'trail_overview' => $this->getParam('trail_overview'),
			);
			$this->getModel('Trail_Model_Trail')->update($id, $data);
			
			// trail type
			$this->setAttribute(1, $this->getParam('trail_type'), $id, $accountId);
			
			// trail dificulty
			$this->setAttribute(13, $this->getParam('trail_dificulty'), $id, $accountId);
			
			// trail distance
			$this->setAttribute(14, $this->getParam('trail_distance'), $id, $accountId);
			
			// trail duration
			$this->setAttribute(15, $this->getParam('trail_duration'), $id, $accountId);
			
			// Elev. Gain
			$this->setAttribute(2, $this->getParam('trail_elevation_gain'), $id, $accountId);
			
			// Season
			$this->setAttribute(3, $this->getParam('trail_season'), $id, $accountId);
			
			// Usage
			$this->setAttribute(4, $this->getParam('trail_usage'), $id, $accountId);
						
			// Animals
			$this->setAttribute(5, $this->getParam('trail_animals'), $id, $accountId);
			
			// water
			$this->setAttribute(10, $this->getParam('trail_water'), $id, $accountId);
			
			// city
			$this->setAttribute(6, $this->getParam('trail_city'), $id, $accountId);
			
			// state
			$this->setAttribute(7, $this->getParam('trail_state'), $id, $accountId);
			
			// county
			$this->setAttribute(8, $this->getParam('trail_county'), $id, $accountId);
			
			// restrictions
			$this->setAttribute(51, $this->getParam('trail_restrictions'), $id, $accountId);
			
			// forest
			$this->setAttribute(34, $this->getParam('trail_forest'), $id, $accountId);
			
			$this->view->trail_id = $id;
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

		if($this->getParam('trail_id')) {
			$search['filterTrailId'] = $this->getParam('trail_id');
		}

		if($this->getParam('trail_slug')) {
			$search['filterTrailSlug'] = $this->getParam('trail_slug');
		}
		
		if($this->getParam('trail_forest')) {
			$search['filterTrailForest'] = $this->getParam('trail_forest');
		}
		
		if($this->getParam('trail_name')) {
			$search['filterTrailName'] = $this->getParam('trail_name');
		}
		
		if($this->getParam('trail_difficulty')) {
			$search['filterTrailDifficulty'] = $this->getParam('trail_difficulty');
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
	private function setAttribute($attributeTypeId, $attributeValue, $trailId, $accountId)
	{
		$attribute = $this->getModel('Attribute_Model_Attribute')->get(
				array('filterCollectionType' => 'trail',
						'filterCollectionId' => $trailId,
						'filterAttributeTypeId' => $attributeTypeId
				));
		if(count($attribute) == 0) {
			$data = array(
					'attribute_value' => $attributeValue,
					'collection_type' => 'trail',
					'collection_id' => $trailId,
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
	private function getAttribute($attributeId, $trailId, $default)
	{
		$attributeValue = $this->getModel('Attribute_Model_Attribute')->get(array(
				'filterCollectionType' => 'trail',
				'filterCollectionId' => $trailId,
				'filterAttributeTypeId' => $attributeId
		));
		if(count($attributeValue) < 1) {
			$attributeValue = $default;
		} else {
			$attributeValue = $attributeValue[0]->attribute_value;
		}
		return $attributeValue;
	}
	
	private function _getAttributeGroups($groupId, $trailId)
	{
		$data = array();
		
		$groups = $this->getModel('Attributegroupitem_Model_Attributegroupitem')
			->get(array('filterAttributeGroupId' => $groupId,
					'filterTrailId' => $trailId
					));
		foreach ($groups as $group) {
			$item = array();
			if($group->attribute_value > 0) {
				$item['attribute_type_value'] = $group->attribute_type_value;
				$item['attribute_type_id'] = $group->attribute_type_id;
				$item['attribute_id'] = $group->attribute_id;
				$data[] = $item;
			}
		}
		return $data;
	}
	
	
}
