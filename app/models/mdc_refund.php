<?php
	/**
	 *
	 *
	 *
	 */
	class MdcRefund extends Model {
	
	
	/**
	 *
	 *
	 *
	 */
    var $name = 'MdcRefund';
	
	
	/**
	 *
	 *
	 *
	 */
	var $useDbConfig = 'default';
	
	
	/**
	 *
	 *
	 *
	 */
	var $useTable = "CBC_MDC_REFUND_CBC";
	
	
	/**
	 *
	 *
	 *
	 */
	 	
   
	 var $primaryKey= 'nu_refund_id';
	  /**
	 *
	 *
	 *
	 */
    var $validate = array(
        
        'vc_permit_no' => array(
			
			'required' => array(
				'rule' => 'notEmpty',
				'message' => 'Please enter permit no.'
			)
			
		),
			
		'vc_reason'=> array(
			'name' => array(
			    'rule' => 'notEmpty',
                'required' => true,
				'message' => 'Please enter reason'
                
            
			),
			'required'=> array(
				'rule' => 'notEmpty',
				'required' => true,
				'message' => 'Please enter reason'
			)
			
		),
		
		'vc_destination'=> array(
			'required' => array(
				'rule' => 'notEmpty',
				'required' => true,
				'message' => 'Please enter destination'
			)
			
		),
			
		
		'nu_permit_amt'=>array(
			'numeric'=>array(
			'rule'=>'numeric',
			'message'=>'Please enter amount'
			),
			
			'required'=> array(
				'rule' => 'notEmpty',
				'message'=> 'Please enter amount'
			)
		)
	
	
    );
	
	/**
	 *
	 *
	 *
	 */
	 
	function alphaNumericDash($check)
    {
         $value = array_shift($check);
         return preg_match('/^[0-9a-zA-Z-]*$/', $value);
		 
    }
	
	
	function getPrimaryKey() {

        $count = $this->find('count');
        $primaryKey = $count + 1;

        if ($this->find('count', array('conditions' => array($this->name . '.' . $this->primaryKey => $primaryKey))) > 0) {

            $i = (int) $count;

            while ($i >= 1) {

                $i += 1;

                $primaryKey = $i;

                $returnValue = $this->find('count', array('conditions' => array($this->name . '.' . $this->primaryKey => $primaryKey)));

                if ($returnValue == 0) {

                    break;
                }

                $i++;
            }

            return $primaryKey;
        } else {

            return $primaryKey;
        }
    }
	
	
}	         