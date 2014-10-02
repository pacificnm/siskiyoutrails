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
		// get account
		$account = $this->getActiveAccount();
		
		// get page
		$page = $this->getParam('page', 1);
	
		// get trails	
		$models = $this->getModel('Trail_Model_Trail')->get($this->_getFilter(), true, $page);
		
		$data = array();
		
		foreach($models as $model) {
			$item = array();
			$item['trail_id'] = $model->trail_id;
			$item['trail_name'] = $model->trail_name;
			$item['trail_slug'] = $model->trail_slug;
			$item['trail_dificulty'] = $this->getAttribute(13, 'trail', $model->trail_id, 'Unknown');
			$item['trail_distance'] = $this->getAttribute(14, 'trail', $model->trail_id, '0');
			$item['trail_duration'] = $this->getAttribute(15, 'trail', $model->trail_id, '0');
			$item['trail_type'] = $this->getAttribute(1, 'trail', $model->trail_id, 'Hiking');
			$item['trail_city'] = $this->getAttribute(6, 'trail', $model->trail_id, 'Unknown');
			$item['trail_state'] = $this->getAttribute(7, 'trail', $model->trail_id, 'Unknown');
			$item['trail_county'] = $this->getAttribute(8, 'trail', $model->trail_id, 'Unknown');
			
			// get forest
			$forest = $this->getModel('Forest_Model_Forest')->get(array(
					'filterForestSlug' => $this->getAttribute(34, 'trail', $model->trail_id, 'None'))
			);
			if(count($forest) !=0) {
				$item['trail_forest'] = $forest[0]->forest_name;
				$item['trail_forest_slug'] = $forest[0]->forest_slug;
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

		
		$this->view->totalItemCount = $models->getTotalItemCount();
		$this->view->totalPages = $models->getPages()->pageCount;
		$this->view->pageRange = $models->getPageRange();
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
		
		// get trails
		$models = $this->getModel('Trail_Model_Trail')->get($this->_getFilter(), false, null);
		
		$data = array();
		foreach($models as $model) {
			
			$item = array();
			$item['trail_id'] = $model->trail_id;
			$item['trail_name'] = $model->trail_name;
			$item['trail_slug'] = $model->trail_slug;
			$item['trail_overview'] = $model->trail_overview;
			$item['trail_type'] = $this->getAttribute(1, 'trail', $model->trail_id, 'Hiking');
			$item['trail_dificulty'] = $this->getAttribute(13, 'trail',  $model->trail_id, 'Unknown');
			$item['trail_distance'] = $this->getAttribute(14, 'trail', $model->trail_id, '0');
			$item['trail_duration'] = $this->getAttribute(15, 'trail', $model->trail_id, '0');
			$item['trail_elevation_gain'] = $this->getAttribute(2, 'trail', $model->trail_id, '0');
			$item['trail_season'] = $this->getAttribute(3, 'trail', $model->trail_id, 'Unknown');
			$item['trail_usage'] = $this->getAttribute(4, 'trail', $model->trail_id, 'Unknown');
			$item['trail_animals'] = $this->getAttribute(5, 'trail', $model->trail_id, 'Unknown');
			$item['trail_water'] = $this->getAttribute(10, 'trail', $model->trail_id, 'Unknown');
			$item['trail_city'] = $this->getAttribute(6, 'trail', $model->trail_id, 'Unknown');
			$item['trail_state'] = $this->getAttribute(7, 'trail', $model->trail_id, 'Unknown');
			$item['trail_county'] = $this->getAttribute(8, 'trail', $model->trail_id, 'Unknown');
			$item['trail_restrictions'] = $this->getAttribute(51, 'trail', $model->trail_id, 'None');
			$item['trail_features'] = $this->_getAttributeGroups(1, 'trail', $model->trail_id);
			$item['trail_activities'] = $this->_getAttributeGroups(2, 'trail', $model->trail_id);
			$item['trail_good_for'] = $this->_getAttributeGroups(3,'trail', $model->trail_id);
			
			// get forests
			$forest = $this->getModel('Forest_Model_Forest')->get(array(
					'filterForestSlug' => $this->getAttribute(34, 'trail', $model->trail_id, 'None'))
			);
			if(count($forest) !=0) {
				$item['trail_forest'] = $forest[0]->forest_name;
				$item['trail_forest_slug'] = $forest[0]->forest_slug;
			}
			
			// if we have an acount see if we can do stuff
			if(count($account['request_account_id']) > 0) {
				
				// can review
				$review = $this->getModel('Review_Model_Review')->get(array(
						'filterCollectionType' => 'trail',
						'filterCollectionId' => $model->trail_id,
						'filterAccountId' => $account['request_account_id']
						));
				if(count($review) == 0) {
					$item['can_review'] = 1;
				} else {
					$item['can_review'] = 0;
				}
				
				// can add completed
				$completed = $this->getModel('Completed_Model_Completed')->get(array(
						'filterCollectionType' => 'trail', 
						'filterCollectionId' => $model->trail_id,
						'filterAccountId' => $account['request_account_id']
						));
				if(count($completed) == 0) {
					$item['can_mark_complete'] = 1; 
				} else {
					$item['can_mark_complete'] = 0;
					$item['completed_date'] = date("m/d/Y", $completed[0]->completed_date);
				}
			}
			
			$item['request_account_admin'] = $account['request_account_admin'];
			$item['request_account_email'] = $account['request_account_email'];
			$item['request_account_id'] = $account['request_account_id'];
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
	
	
	
	private function _getAttributeGroups($groupId, $trailId)
	{
		$data = array();
		
		$groups = $this->getModel('Attributegroupitem_Model_Attributegroupitem')
			->get(array('filterAttributeGroupId' => $groupId,
					'filterTrailId' => $trailId
					));
		foreach ($groups as $group) {
			$model = array();
			if($group->attribute_value > 0) {
				$model['attribute_type_value'] = $group->attribute_type_value;
				$model['attribute_type_id'] = $group->attribute_type_id;
				$model['attribute_id'] = $group->attribute_id;
				$data[] = $model;
			}
		}
		return $data;
	}
	
	
}
