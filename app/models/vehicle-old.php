<?php

/**
 * Registration model.
 *
 * 
 */
class Vehicle extends Model {

    /**
     * Model name
     *
     * @var string
     * @access public
     */
    var $name = 'Vehicle';

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
    var $useTable = "MST_CUSTOMER_DETAILS_MDC";
    
    /**
     * Model primary key
     *
     * @var string
     * @access public
     */
    //var $primaryKey= 'vc_customer_no';

    /**
     * validate name
     *
     * @var array
     * @access public
     * @ contain complete description about validation of model
     */
//    var $validate = array(  
//        'vc_customer_name' => array(
//                'required' => array(
//                'rule' => 'notEmpty',
//                'required' => true,
//                'message' => 'Must not be blank',
//            )
//            
//        ),
//        'vc_customer_id' => array(
//            'required' => array(
//                'rule' => 'notEmpty',
//                'required' => true,
//                'message' => 'Must not be blank',
//            )
//            
//        ),
//        'vc_business_reg' => array(
//            'required' => array(
//                'rule' => 'notEmpty',
//                'required' => true,
//                'message' => 'Must not be blank',
//            )
//        ),
//        'vc_bank_account_no' => array(
//            'required' => array(
//                'rule' => 'notEmpty',
//                'required' => true,
//                'message' => 'Must not be blank',
//            ),
//        ),
//        'vc_address1' => array(
//            'required' => array(
//                'rule' => 'notEmpty',
//                'required' => true,
//                'message' => 'Must not be blank',
//            ),
//        ),
//        'vc_address2' => array(
//            'required' => array(
//                'rule' => 'notEmpty',
//                'required' => true,
//                'message' => 'Must not be blank',
//            ),
//        ),
//        'vc_address3' => array(
//            'required' => array(
//                'rule' => 'notEmpty',
//                'required' => true,
//                'message' => 'Must not be blank',
//            ),
//        ),
//        'vc_address3' => array(
//            'required' => array(
//                'rule' => 'notEmpty',
//                'required' => true,
//                'message' => 'Must not be blank',
//            ),
//        ),
//        'vc_tel_no' => array(
//            'required' => array(
//                'rule' => 'notEmpty',
//                'required' => true,
//                'message' => 'Must not be blank',
//            ),
//        ),
//        'vc_mobile_no' => array(
//            'required' => array(
//                'rule' => 'notEmpty',
//                'required' => true,
//                'message' => 'Must not be blank',
//            ),
//        ),
//        
//        
//    );
  
}