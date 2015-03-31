<?php

/**
*
*Class name
*
*/

class AccountRecharge extends Model {

/**
*
*Model name
*
*/
	
    var $name = 'AccountRecharge';
	
/**
*
*Table used for the model
*
*/
	
	var $useTable = 'ACCOUNT_RECHARGE_CBC';

/**
*
*Primary key
*
*/

	var $primaryKey='nu_acct_rec_id';
	
/**
*
*Validation array
*
*/

	
	var $validate = array(

       'dt_payment_date' => array(
			'required' => array(
				'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Please select date'
			)
	
		),
       'vc_ref_no' => array(
			'length' => array(
                'rule'    => array('maxlength', 20),
                'message' => 'Should not be more than 20 characters'
			),
			'required' => array(
				'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Please enter reference number'
			),
			'name' => array(
				'rule' => 'alphaNumericDash',
				'message' => 'Alphanumeric only'
			)
	
		),	  
		
       'ch_tran_type' => array(
			'required' => array(
				'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Please select an option'
			)
	
		),		
		'nu_amount_un' => array(
		
			'numeric' => array(
				'rule' => array('customNumeric'),
				'message' => 'Enter a positive number'
			),
			
			'length' => array(
                'rule'    => array('between', 3, 15),
                'message' => 'Amount must be greater than 100'
			),
			
			'required' => array(
				'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Please enter amount'
			)
		),
		
		/*'upload_doc' => array(
		
			'size'=> array(
						'rule'=>'checkSize',
						'message'=>'File must be less than 2MB'				
			),
			
			'rule' => array('extension', array('jpg','jpeg','pdf','png')),
			'message' => 'Please upload a file'
		)*/
	);
	
/**
*
*
*Custom function for maximum file size validation
*
*/
	
	function checkSize($file){
	pr($file);die;
		if( (int)$file['size'] <= 2048000 && (int)$file['size'] > 0 ) {
			
			return true;
		
		}
		
		return false;
	
	}
	
/**
*
*Custom function for alphanumeric validation
*
*/

	function alphaNumericDash($check)
    {
         $value = array_shift($check);
         return preg_match('|^[0-9a-zA-Z-]*$|', $value);
    }
	
/**
*
*Function to generate primary key
*
*/
	
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
	
	/*
	*
	*
	*
	*/
	
	function customNumeric($data) {
		
		return Validation::numeric(current($data)) && current($data) >= 100;
		
	 }
			
}

?>