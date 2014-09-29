<?php

class ErrorController extends Zend_Controller_Action
{

    /**
     * Error Action
     */
    public function errorAction ()
    {
        $errors = $this->_getParam('error_handler');
        
        if (! $errors || ! $errors instanceof ArrayObject) {
            $this->view->message = 'You have reached the error page';
            return;
        }
        
        switch ($errors->type) {
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ROUTE:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
                // 404 error -- controller or action not found
                $this->getResponse()->setHttpResponseCode(404);
                $priority = Zend_Log::NOTICE;
                $this->view->message = '404 The requested page was not found.';
                break;
            default:
                // application error
                $this->getResponse()->setHttpResponseCode(500);
                $priority = Zend_Log::CRIT;
                $this->view->message = 'Application error';
                $this->view->exception = $errors->exception;
                break;
        }
        
        //$format = '%timestamp% %priorityName% (%priority%): %message%' . PHP_EOL;
        //$formatter = new Zend_Log_Formatter_Simple($format);
        
        /**
        $writer = new Zend_Log_Writer_Stream(
                APPLICATION_PATH . '/log/errors.txt');
        
        $writer->setFormatter($formatter);
        
        $logger = new Zend_Log();
        $logger->addWriter($writer);
        $logger->info($errors->exception);
        */
        $this->view->request = $errors->request;
    }

    

}

