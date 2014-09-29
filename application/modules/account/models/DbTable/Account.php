<?php 
class Account_Model_DbTable_Account extends Zend_Db_Table_Abstract
{

	/**
	 *
	 * @var string
	 */
	protected $_name = 'account';

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
			$db->query("
			CREATE TABLE IF NOT EXISTS `account` (
			  `account_id` int(20) NOT NULL AUTO_INCREMENT,
			  `account_name` varchar(45) COLLATE utf8_bin NOT NULL,
			  `account_email` varchar(45) COLLATE utf8_bin NOT NULL,
			  `account_password` varchar(45) COLLATE utf8_bin NOT NULL,
			  `account_token` varchar(100) COLLATE utf8_bin NOT NULL,
			  `account_create` int(20) NOT NULL,
			  PRIMARY KEY (`account_id`),
			  UNIQUE KEY `account_email` (`account_email`)
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
