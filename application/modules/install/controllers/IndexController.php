<?php
class Install_IndexController extends Application_Model_Controller
{

	/**
	 * (non-PHPdoc)
	 *
	 * @see Application_Model_Base::init()
	 */
	public function init ()
	{
		parent::init();
	}

	/**
	 * Index Action
	 */
	public function indexAction () {
		$appConfig = Zend_Registry::get('Application_Config');
		
		$configPath = APPLICATION_PATH . '/configs/application.ini';
		
		$this->view->fileDir = $appConfig->app->file->dir;
		$this->view->configFile = $configPath;
		
		if(!is_writable( $appConfig->app->file->dir)) {
			$this->view->tmpIsWritable = false;
		} else {
			$this->view->tmpIsWritable = true;
		}
		
		if(!is_writable($configPath)) {
			$this->view->configIsWritable = false;
		} else {
			$this->view->configIsWritable = true;
		}
		
		
	}
	
	public function postAction()
	{
		if($this->getRequest()->isPost()) {
				
			$configPath = APPLICATION_PATH . '/configs/application.ini';
			$appConfig = Zend_Registry::get('Application_Config');
				
			
				
			$appConfig->resources->db->params->host = $this->getParam('database_host');
			$appConfig->resources->db->params->dbname = $this->getParam('database_name');
			$appConfig->resources->db->params->username = $this->getParam('database_user');
			$appConfig->resources->db->params->password = $this->getParam('database_password');
				
			$appConfig->app->installed = "true";
				
			$writer = new Zend_Config_Writer_Ini(array('config'   => $appConfig,
					'filename' => $configPath));
				
			$writer->write();
			
			// create tables
			new Account_Model_DbTable_Account();
			new Album_Model_DbTable_Album();
			new Artist_Model_DbTable_Artist();
			new Config_Model_DbTable_Config();
			//new Playlist_Model_DbTable_Playlist();
			new Track_Model_DbTable_Track();
			
			$data = array(
					'account_name' => $this->getParam('account_name'),
					'account_email' => $this->getParam('account_email'),
					'account_password' => $this->getParam('account_password'),
					'account_token' => '',
					'account_create' => time()
			);
			
			// save the user
			$account = $this->getModel('Account_Model_Account')->create($data);
			
			$this->redirect('/');
		}
	}
	
}