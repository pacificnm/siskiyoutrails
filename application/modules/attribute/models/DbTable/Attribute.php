<?php
class Attribute_Model_DbTable_Attribute extends Zend_Db_Table_Abstract
{

	/**
	 *
	 * @var string
	 */
	protected $_name = 'attribute';

	/**
	 * Contructor
	 */
	public function __construct ()
	{
		parent::__construct();

		$this->verify();
	}

	/**
	 * Verifies the Database Table Exists
	 *
	 * @throws Zend_Exception
	 */
	private function verify ()
	{
		// test if Database exists
		try {
			$db = $this->getDefaultAdapter();
		} catch (Exception $e) {
			throw new Zend_Exception($e->getMessage());
		}

		// test if table exists
		try {
			$result = $db->describeTable($this->_name);

			if (empty($result)) {
				$this->createTable();
			}
		} catch (Exception $e) {
			$this->createTable();

		}
	}

	/**
	 * Creates the Database Table
	 *
	 * @throws Zend_Exception
	 */
	private function createTable ()
	{
		$db = $this->getDefaultAdapter();

		try {
			$db->query("");
		} catch (Exception $e) {
			throw new Zend_Exception($e->getMessage());
		}
	}

	/**
	 * Inserts default rows in the table
	 */
	private function insertRows ()
	{
		$db = $this->getDefaultAdapter();
			
		try {
			$db->query("");
		} catch (Exception $e) {
			throw new Zend_Exception($e->getMessage());
		}

	}
}
