<?php 
class Config_Model_DbTable_Config extends Zend_Db_Table_Abstract
{

	/**
	 *
	 * @var string
	 */
	protected $_name = 'config';

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
			//$this->insertRows();
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
			$db->query("
			CREATE TABLE IF NOT EXISTS `config` (
			  `config_id` int(20) NOT NULL AUTO_INCREMENT,
			  `config_key` varchar(45) COLLATE utf8_bin NOT NULL,
			  `config_val` varchar(45) COLLATE utf8_bin NOT NULL,
			  PRIMARY KEY (`config_id`),
			  UNIQUE KEY `config_key` (`config_key`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin");
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
