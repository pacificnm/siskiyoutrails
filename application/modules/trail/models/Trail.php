<?php
class Trail_Model_Trail extends Application_Model_Model
{

	/**
	 *
	 * @var unknown
	 */
	private $_table = null;

	/**
	 *
	 * @param unknown_type $search
	 * @param unknown_type $pagination
	 * @param unknown_type $page
	 * @return unknown
	 */
	public function get($search, $pagination = false, $page = 1)
	{
		$select = $this->getSelect();

		$cacheId = null;

		if(array_key_exists('filterTrailName', $search)) {
			$select->where('trail.trail_name  LIKE ?', $search['filterTrailName'] . '%');
		}
		
		if(array_key_exists('filterTrailId', $search)) {
			$select->where('trail.trail_id = ?', $search['filterTrailId']);
		}
		
		if(array_key_exists('filterTrailSlug', $search)) {
			$select->where('trail.trail_slug = ?', $search['filterTrailSlug']);
		}
		
		if(array_key_exists('filterTrailForest', $search)) {
			$select->join('attribute', "attribute.collection_id = trail.trail_id AND attribute.attribute_value = '{$search['filterTrailForest']}'" , array('attribute_value as trail_forest'));
		}
		
		if(array_key_exists('filterTrailDifficulty', $search)) {
			$select->join('attribute AS attribute_2', "attribute_2.collection_id = trail.trail_id AND attribute_2.attribute_value = '{$search['filterTrailDifficulty']}'" , array('attribute_value as trail_difficulty'));
		}
		
		
		$select->order('trail_name');
		
		//echo $select->__toString();
		
		if($pagination) {
			$paginator = Zend_Paginator::factory($select);

			$paginator->setItemCountPerPage(10)
			->setPageRange(10)
			->setCurrentPageNumber($page);


			$rowSet = $this->getPaginator($page, $select, null);
			return $rowSet;
		} else {
			$models = $this->getRowSet($select, $cacheId, $this->getTable());
				
			return $models;
		}
	}

	/**
	 *
	 * @param unknown_type $data
	 * @throws Zend_Exception
	 */
	public function create ($data)
	{
		try {
			$id = $this->getTable()->insert($data);
			return $id;
		} catch (Exception $e) {
			throw new Zend_Exception($e->getMessage());
		}
	}

	/**
	 *
	 * @param unknown_type $id
	 * @param unknown_type $data
	 * @throws Zend_Exception
	 */
	public function update ($id, $data)
	{
		try {
			$where = $this->getTable()
			->getDefaultAdapter()
			->quoteInto('trail_id = ?', $id);

			$this->getTable()->update($data, $where);
		} catch (Exception $e) {
			throw new Zend_Exception($e->getMessage());
		}
	}

	/**
	 *
	 * @param unknown_type $id
	 * @throws Zend_Exception
	 */
	public function delete ($id)
	{
		try {
			$where = $this->getTable()
			->getDefaultAdapter()
			->quoteInto('trail_id = ?', $id);

			$this->getTable()->delete($where);
		} catch (Exception $e) {
			throw new Zend_Exception($e->getMessage());
		}
	}

	/**
	 * Returns the database table object
	 *
	 * @return Trail_Model_DbTable_Trail
	 */
	protected function getTable ()
	{
		if (null !== $this->_table) {
			return $this->_table;
		} else {
			$this->_table = new Trail_Model_DbTable_Trail();
			return $this->_table;
		}
	}
}
