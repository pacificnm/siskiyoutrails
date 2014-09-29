<?php
class Account_Model_Account extends Application_Model_Model
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
		
		if(array_key_exists('filterAccountEmail', $search)) {
			$select->where('account.account_email =?', $search['filterAccountEmail']);
		}
		if(array_key_exists('filterAccountPassword', $search)) {
			$select->where('account.account_password =?', $search['filterAccountPassword']);
		}
		if(array_key_exists('filterAccountId', $search)) {
			$select->where('account.account_id =?', $search['filterAccountId']);
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
            ->quoteInto('account_id = ?', $id);

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
            ->quoteInto('account_id = ?', $id);

            $this->getTable()->delete($where);
        } catch (Exception $e) {
            throw new Zend_Exception($e->getMessage());
        }
    }

    /**
     * Returns the database table object
     *
     * @return Track_Model_DbTable_Track
     */
    protected function getTable ()
    {
        if (null !== $this->_table) {
            return $this->_table;
        } else {
            $this->_table = new Account_Model_DbTable_Account();
            return $this->_table;
        }
    }
}
