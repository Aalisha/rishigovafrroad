<?php

App::import('Sanitize');

/**
 * 
 *
 *
 *
 */
class HomesController extends AppController {

    /**
     *
     *
     */
    var $name = 'Homes';

    /**
     *
     *
     */
    var $uses = array('Inspector');

    /**
     *
     *
     */
    public function beforeFilter() {
		
		$this->Auth->allow('*');
		
        parent::beforeFilter();
		
		$currentUser = $this->checkUser();
   
    }

    /**
     *
     *
     */
    public function index() {
       
       
         try {
		 
		     if( !empty($this->data) && $this->RequestHandler->isPost() ){
			 
					
					$this->Inspector->set($this->data);
					
					if($this->Inspector->validates(array('fieldList'=>array('vc_username','vc_password')))) {

							$loginDetail = array('vc_username' => $this->data['Inspector']['vc_username'], 'vc_password' => $this->Auth->password(trim($this->data['Inspector']['vc_password'])));
							
							$this->Auth->fields = array(
									   'username' => 'vc_username',
									   'password' => 'vc_password');
						
						if( $this->Auth->login($loginDetail) ){
							
							$this->data = null;
							
							$this->Session->setFlash('Successfully Login','success');
							
							$this->redirect(array('controller'=>'inspectors','action'=>'index'));
							
						}else {
							
							$this->data = null;
							
							$this->Session->setFlash($this->Auth->loginError,'error');

						}
					
					}
			 
			}

             $this->layout = 'home';
             
             $this->set('title_for_layout', ' RFA (Road Fund Administration) ');
         
          } catch (Exception $e) {

            echo 'Caught exception: ', $e->getMessage(), "\n";

            exit;
        }
    
        
    }

	
}