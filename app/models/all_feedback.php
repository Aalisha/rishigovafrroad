<?php

/**
 * Registration model.
 *
 * 
 */
class AllFeedback extends Model {

    /**
     * Model name
     *
     * @var string
     * @access public
     */
    var $name = 'AllFeedback';

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
    var $useTable = "pr_cust_feedback";

    /**
     * Model primary key
     *
     * @var string
     * @access public
     */
    var $primaryKey = 'feedback_id';

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
                'message' => 'Sholud not be empty'
            )
        ),
        'logged_by' => array(
            'name' => array(
                'rule' => '/^[a-zA-Z]+/i',
                'required' => true,
                'message' => 'Only Alphabetic characters are allowed'
            ),
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Please fill your name'
            )
        ),
        'dt_created' => array(
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Please choose date'
            )
        ),
        'contact_no' => array(
//            'numeric' => array(
//                'rule' => '|^[0-9]*$|',
//                'required' => true,
//                'message' => 'Please fill appropriate numbers only'
//            ),
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Please fill your number'
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