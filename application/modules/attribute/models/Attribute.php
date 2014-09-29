<?php
class Attribute_Model_Attribute extends Application_Model_Model
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

		if(array_key_exists('filterAttributeId', $search)) {
			$select->where('attribute.attribute_id = ?', $search['filterAttributeId']);
		}

		
		
		if(array_key_exists('filterCollectionType', $search)) {
			$select->where('attribute.collection_type = ?', $search['filterCollectionType']);
		}
		
		if(array_key_exists('filterCollectionId', $search)) {
			$select->where('attribute.collection_id = ?', $search['filterCollectionId']);
		}
		
		if(array_key_exists('filterAttributeTypeId', $search)) {
			$select->where('attribute.attribute_type_id = ?', $search['filterAttributeTypeId']);
		}
		
		if($pagination) {
			$paginator = Zend_Paginator::factory($select);

			$paginator->setItemCountPerPage(25)
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
			->quoteInto('attribute_id = ?', $id);

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
			->quoteInto('attribute_id = ?', $id);

			$this->getTable()->delete($where);
		} catch (Exception $e) {
			throw new Zend_Exception($e->getMessage());
		}
	}

	/**
	 * Returns the database table object
	 *
	 * @return Attribute_Model_DbTable_Attribute
	 */
	protected function getTable ()
	{
		if (null !== $this->_table) {
			return $this->_table;
		} else {
			$this->_table = new Attribute_Model_DbTable_Attribute();
			return $this->_table;
		}
	}
}
