<?php
class Completed_Model_Completed extends Application_Model_Model
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

		if(array_key_exists('filterCollectionType', $search)) {
			$select->where('completed.collection_type = ?', $search['filterCollectionType']);
		}

		if(array_key_exists('filterCollectionId', $search)) {
			$select->where('completed.collection_id = ?', $search['filterCollectionId']);
		}
		
		if(array_key_exists('filterAccountId', $search)) {
			$select->where('completed.completed_by = ?', $search['filterAccountId']);
		}
	
		$select->joinLeft('account', 'account.account_id = completed.completed_by');
		
		if($pagination) {
			$models = $this->getPaginator($page, $select, null);
		} else {
			$models = $this->getRowSet($select, $cacheId, $this->getTable());
		}
		return $models;
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
			->quoteInto('completed_id = ?', $id);

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
			->quoteInto('completed_id = ?', $id);

			$this->getTable()->delete($where);
		} catch (Exception $e) {
			throw new Zend_Exception($e->getMessage());
		}
	}

	/**
	 * Returns the database table object
	 *
	 * @return Completed_Model_DbTable_Completed
	 */
	protected function getTable ()
	{
		if (null !== $this->_table) {
			return $this->_table;
		} else {
			$this->_table = new Completed_Model_DbTable_Completed();
			return $this->_table;
		}
	}
}
