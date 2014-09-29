<?php
class Attributegroupitem_Model_Attributegroupitem extends Application_Model_Model
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

		$select->joinLeft('attribute_type', 'attribute_type.attribute_type_id = attribute_group_item.attribute_type_id');
		$select->joinLeft('attribute_group', 'attribute_group_item.attribute_group_id = attribute_group.attribute_group_id');
		
		if(array_key_exists('filterAttributeGroupId', $search)) {
			$select->where('attribute_group_item.attribute_group_id =?', $search['filterAttributeGroupId']);
		}
		
		// if we have a trail id
		if(array_key_exists('filterTrailId', $search)) {
			$select->joinLeft('attribute', "attribute_group_item.attribute_type_id = attribute.attribute_type_id 
					AND attribute.collection_id ='{$search['filterTrailId']}'", array('collection_id', 'attribute_value', 'attribute_id'));
		}
		
		
		$select->order('attribute_type.attribute_type_value');
		
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

	public function getCollectionItems()
	{
		$select = $this->getSelect();
		
		$cacheId = null;
		
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
			->quoteInto('attribute_group_item_id = ?', $id);

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
			->quoteInto('attribute_group_item_id = ?', $id);

			$this->getTable()->delete($where);
		} catch (Exception $e) {
			throw new Zend_Exception($e->getMessage());
		}
	}

	/**
	 * Returns the database table object
	 *
	 * @return Attributegroupitem_Model_DbTable_Attributegroupitem
	 */
	protected function getTable ()
	{
		if (null !== $this->_table) {
			return $this->_table;
		} else {
			$this->_table = new Attributegroupitem_Model_DbTable_Attributegroupitem();
			return $this->_table;
		}
	}
}

