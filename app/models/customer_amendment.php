<?php

/**
 *  Amendent Model.
 *
 * 
 */
class CustomerAmendment extends Model {

    /**
     * Model name
     *
     * @var string
     * @access public
     */
    var $name = 'CustomerAmendment';

    /**
     * Model Database Configuration
     *
     * @var string
     * @access public
     */
    var $useDbConfig = 'default';

    /**
     * Model use Table
     *
     * @var string
     * @access public
     */
    var $useTable = "MST_CUSTOMER_AMENDMENTS_MDC";
    
    /**
     * Model primary key
     *
     * @var string
     * @access public
     */
    var $primaryKey= 'vc_cust_amend_no';
  

	/**
     * validate name
     *
     * @var array
     * @access public
     * @ contain complete description about validation of model
     */	 
	 
	 var $validate = array(
		
			'vc_amend_type'=>array(
			
				'required'=>array(
			
					'rule' => 'notEmpty',
					
					'message' => 'Required'
			
				)
			
		
			),
			'vc_new_customer_name'=>array(
			
				'required'=>array(

				'rule' => 'notEmpty',
							
				'message' => 'Required'

				)
			
		
			),
			
			'vc_new_cust_no'=>array(
			
				
					'rule' => array('checkbusinessidRequired'),
					'message' => 'Required',


				
			)
		
	 
	 );
	 
	 
	 /**
	 * Get primary key
	 *
	 */
	
	function checkbusinessidRequired(){
		
		//CUSTYPE01 means business type in which business reg id is mandatory
		
		//
		//pr($this->data);
		//die;
		if(isset($this->data['CustomerAmendment']['vc_cust_type']) && $this->data['CustomerAmendment']['vc_cust_type']=='CUSTYPE01'){
	
		  if($this->data['CustomerAmendment']['vc_new_cust_no']=='')
			return false;
			else
			return true;
		}
		return true;
	
	}
	
	function getPrimaryKey () {
		
		$count = $this->find('count');
		
		$primaryKey = (string) ( "cust-amd-".($count+1) );
		
		if( $this->find('count',array('conditions'=>array($this->name . '.' . $this->primaryKey=>$primaryKey))) > 0) {
								
				$i = (int) $count;

                while ( $i >= 1 ) {

                    $i += 1;
					
					$primaryKey = (string) ( "cust-amd-".($i) );
                    
					$returnValue = $this->find('count',array('conditions'=>array($this->name . '.' . $this->primaryKey=>$primaryKey)));

                    if ($returnValue == 0) {
                        									
                        break;
                    }
					
					$i++;
                }

                return  $primaryKey;
			
		} else {
		
			return  $primaryKey;

		}	
	
	}
}