<?php

/**
 * Payment model.
 *
 * 
 */
class Payment extends Model {

    /**
     * Model name
     *
     * @var string
     * @access public
     */
    var $name = 'Payment';

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
    var $useTable = "HD_ASSESSMENT_MDC";

    /**
     * Model primary key
     *
     * @var string
     * @access public
     */
    var $primaryKey = 'vc_assessment_no';

    /**
     * validate name
     *
     * @var array
     * @access public
     * @ contain complete description about validation of model
     */
    var $validate = array(
         'vc_uploaded_doc_name' => array(
			/*'extension'=>array(
				
				'rule' => array('extension',array('pdf','png','jpeg','jpg')),
				
				'message' => 'Excepted file type pdf, png, jpeg,jpg',
				
			),*/
			'size'=> array( 
				
				'rule'=>'checkSize',
				
				'message'=>'Could not be more than 2MB.'				
			)			
        ), 
        'vc_payment_reference_no' => array(
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Required',
            ),
            'length' => array(
                'rule' => array('between', 4, 30),
                'required' => true,
                'message' => 'Use between 4 and 30 characters',
            ),
        ),
        'vc_bank_struct_code' => array(
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Required',
            )
        )
    );

    /**
     *
     *
     */
     function checkSize($data) {
	 //echo '<br>',$data['vc_uploaded_doc_name']['size'];
        if(isset($data['vc_uploaded_doc_name']['name']) && !empty($data['vc_uploaded_doc_name']['name'])){
		 if ((int)$data['vc_uploaded_doc_name']['size'] <= 2048000) {


            return true;
          }else{
		
		  return false;
		  }
		
		}else{
		
		  return true;
		
		}
    } /**/

    /**
     * Get primary key
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

}