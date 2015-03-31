<?php

/**
 * Registration model.
 *
 * 
 */
class FeedbackData extends Model {

    /**
     * Model name
     *
     * @var string
     * @access public
     */
    var $name = 'FeedbackData';

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
    var $useTable = "DT_CUST_FEEDBACK_CBC";

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
                'required' => true,
                'message' => 'Please enter only alphabets'
            ),*/
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Please enter your name'
            )
        ),
        'contact_no' => array(
//            'numeric' => array(
//                'rule' => '|^[0-9]*$|',
//                'required' => true,
//                'message' => 'Should be numeric'
//            ),
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Please enter your contact number'
            )
        ),
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