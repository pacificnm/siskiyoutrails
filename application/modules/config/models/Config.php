<?php
class Config_Model_Config extends Application_Model_Model
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
            ->quoteInto('config_id = ?', $id);

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
            ->quoteInto('config_id = ?', $id);

            $this->getTable()->delete($where);
        } catch (Exception $e) {
            throw new Zend_Exception($e->getMessage());
        }
    }

    /**
     * Returns the database table object
     *
     * @return Config_Model_DbTable_Config
     */
    protected function getTable ()
    {
        if (null !== $this->_table) {
            return $this->_table;
        } else {
            $this->_table = new Config_Model_DbTable_Config();
            return $this->_table;
        }
    }
}