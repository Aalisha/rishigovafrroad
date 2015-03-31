
<?php

/**
 * Registration model.
 *
 * 
 */
class Feedback extends Model {

    /**
     * Model name
     *
     * @var string
     * @access public
     */
    var $name = 'Feedback';

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
    var $useTable = "PR_MST_PARAMETER_TYPE";

    /**
     * Model primary key
     *
     * @var string
     * @access public
     */
    var $primaryKey = 'pk_vc_prtype_code';

    /**
     * validate name
     *
     * @var array
     * @access public
     * @ contain complete description about validation of model
     */
    var $validate = array(
        'complain_description' => array(
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Please enter complaint description'
            )
        ),
        'complaint_lodged_by' => array(
            /*'name' => array(
                'rule' => '/^[a-z0-9]+$/i',
                'required' => true,
                'message' => 'Please enter only alphabets'
            ),*/
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Please enter your name'
            )
        ),
    );

    function alphaNumericDash($check) {

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

