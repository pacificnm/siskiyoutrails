<?php
class Application_Model_Model
{


    /**
     * Returns the Select Object
     *
     * @return Ambigous <Zend_Db_Select, Zend_Db_Table_Select>
     */
    public function getSelect ()
    {
        $select = $this->getTable()
            ->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
            ->setIntegrityCheck(false);
        
        return $select;
    }

    
    /**
     * Returns a set of database rows
     *
     * @param object $select
     *            Zend_Db_Select
     * @param string $cacheId
     *            * @param object $table
     *            Zend_Db_Table_Abstract
     * @throws Zend_Exception
     * @return Zend_Db_Table_Rowset_Abstract
     */
    public function getRowSet ($select, $cacheId, $table)
    {
    	
    	if($cacheId != null) {
    	
	        if ($rowSet = $this->getCache()->load($cacheId)) {
	            return $rowSet;
	        } else {
	            
	            try {
	                $rowSet = $table->fetchAll($select);
	                
	                // $this->getCache()->save($rowSet, $cacheId);
	                
	                return $rowSet;
	            } catch (Exception $e) {
	                throw new Zend_Exception($e->getMessage());
	            }
	        }
    	} else {
    		try {
    			$rowSet = $table->fetchAll($select);
       			 
    			return $rowSet;
    		} catch (Exception $e) {
    			throw new Zend_Exception($e->getMessage());
    		}
    	}
    }

    /**
     * Returns a single database row
     *
     * @param object $select
     *            Zend_Db_Select
     * @param string $cacheId            
     * @param object $table
     *            Zend_Db_Table_Abstract
     * @throws Zend_Exception
     * @return Zend_Db_Table_Rowset_Abstract
     */
    public function getRow ($select, $cacheId, $table)
    {
    	if($cacheId != null) {
    	
	        if ($rowSet = $this->getCache()->load($cacheId)) {
	            return $rowSet;
	        } else {
	            try {
	                $rowSet = $table->fetchRow($select);
	                
	                $this->getCache()->save($rowSet, $cacheId);
	                
	                return $rowSet;
	            } catch (Exception $e) {
	                throw new Zend_Exception($e->getMessage());
	            }
	        }
    	} else {
    		try {
    			$rowSet = $table->fetchRow($select);
    			 
    			return $rowSet;
    		} catch (Exception $e) {
    			throw new Zend_Exception($e->getMessage());
    		}
    	}
    }

    /**
     * Get Paginated Table Rows
     *
     * @param int $page            
     * @param Object $select
     *            Zend_Db_Select
     * @param string $cacheId            
     * @throws Zend_Exception
     * @return Zend_Paginator
     */
    public function getPaginator ($page, $select, $cacheId)
    {
        $config = Zend_Registry::get('Application_Config');
        
        
        if($cacheId != null ) {
        
	        if ($paginator = $this->getCache()->load($cacheId)) {
	            return $paginator;
	        } else {
	            try {
	                $paginator = Zend_Paginator::factory($select);
	                
	                $paginator->setItemCountPerPage(10)
	                    ->setPageRange(10)
	                    ->setCurrentPageNumber($page);
	                
	                // $this->getCache()->save($paginator, $cacheId);
	                
	                return $paginator;
	            } catch (Exception $e) {
	                throw new Zend_Exception($e->getMessage());
	            }
	        }
        } else {
        	try {
        		$paginator = Zend_Paginator::factory($select);
        		 
        		$paginator->setItemCountPerPage(10)
        		->setPageRange(10)
        		->setCurrentPageNumber($page);
        		
        		return $paginator;
        	} catch (Exception $e) {
        		throw new Zend_Exception($e->getMessage());
        	}
        }
    }
}