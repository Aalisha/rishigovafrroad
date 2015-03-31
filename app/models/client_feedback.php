<?php

/**
 * Registration model.
 *
 * 
 */
class ClientFeedback extends Model {

    /**
     * Model name
     *
     * @var string
     * @access public
     */
    var $name = 'ClientFeedback';

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
    var $useTable = "DT_CLIENT_FEEDBACK_FLR";

    /**
     * Model primary key
     *
     * @var string
     * @access public
     */
    var $primaryKey = 'feedback_request_id';

    /**
     * Validating model.
     *
     * 
     */
    
    //array('complaint_type','logged_by','priority_type','contact_no','complaint_description');
    
    
    var $validate = array(
        'complaint_description' => array(
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Please enter complaint description'
            )
        ),
        
        'logged_by' => array(
            /*'name' => array(
                'rule' => '/^[a-zA-Z]+/i',
               // 'rule' => '/^[a-zA-Z]*$/',// RULE FOE ONLY ALPHABETIC
                'required' => true,
                'message' => 'Name must start with alphabet only'
            ),*/
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Please enter name'
            )
        ),
        
//        'contact_no' => array(
//            'numeric' => array(
//                'rule' => '|^[0-9]*$|',
//                'required' => true,
//                'message' => 'Please enter a valid contact number'
//            ),
//            'required' => array(
//                'rule' => 'notEmpty',
//                'required' => true,
//                'message' => 'Please enter contact number'
//            )
//        ),
        
        'priority_type' => array(
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Please select priorty type'
            )
        ),
        
        'complaint_type' => array(
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Please select complaint type'
            )
        )
        
    );
    
    
    
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