<?php

/**
 * Client Change History model.
 *
 * 
 */
class ClientChangeHistory extends Model {

    /**
     * Model name
     *
     * @var string
     * @access public
     */
    var $name = 'ClientChangeHistory';

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
    var $useTable = 'MST_CLIENT_CHANGE_FLR';

    /**
     * Model primary key
     *
     * @var string
     * @access public
     */
    var $primaryKey = 'vc_change_id';

    /**
     * validate name
     *
     * @var array
     * @access public
     * @ contain complete description about validation of model
     */
    var $validate = array(
        'vc_id_no' => array(
            'length' => array(
                'rule' => array('between', 1, 50),
                'required' => true,
                'message' => 'Please keep this field below 50 characters.'
            ),
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Required',
            )
        ),
        'vc_client_name' => array(
            'length' => array(
                'rule' => array('between', 1, 200),
                'required' => true,
                'message' => 'Please keep this field below 200 characters.'
            ),
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Required',
            )
        ),
        'vc_contact_person' => array(
            'length' => array(
                'rule' => array('between', 1, 200),
                'required' => true,
                'message' => 'Please keep this field below 200 characters.'
            ),
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Required',
            )
        ),
        'vc_address1' => array(
            'length' => array(
                'rule' => array('between', 1, 100),
                'required' => true,
                'message' => 'Please keep this field below 100 characters.',
            ),
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Required',
            )
        ),
        'vc_address2' => array(
            'length' => array(
                'rule' => array('between', 0, 100),
                'required' => false,
                'message' => 'Please keep this field below 100 characters.',
            )
        ),
        'vc_address3' => array(
            'length' => array(
                'rule' => array('between', 0, 50),
                'required' => false,
                'message' => 'Please keep this field below 50 characters.',
            )
        ),
        'vc_address4' => array(
            'length' => array(
                'rule' => array('between', 1, 100),
                'required' => true,
                'message' => 'Please keep this field below 100 characters.',
            ),
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Required',
            )
        ),
        'vc_address5' => array(
            'length' => array(
                'rule' => array('between', 0, 100),
                'required' => false,
                'message' => 'Please keep this field below 100 characters.',
            )
        ),
        'vc_address6' => array(
            'length' => array(
                'rule' => array('between', 0, 50),
                'required' => false,
                'message' => 'Please keep this field below 50 characters.',
            )
        ),
        'vc_postal_code1' => array(
            'length' => array(
                'rule' => array('between', 1, 25),
                'required' => true,
                'message' => 'Please keep this field below 25 characters.',
            ),
            'numeric' => array(
                'rule' => 'numeric',
                'message' => 'Postal Code should be numeric'
            ),
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Required',
            )
        ),
        'vc_postal_code2' => array(
            'length' => array(
                'rule' => array('between', 1, 25),
                'required' => true,
                'message' => 'Please keep this field below 25 characters.',
            ),
            'numeric' => array(
                'rule' => 'numeric',
                'message' => 'Postal Code should be numeric'
            ),
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Required',
            )
        ),
        'vc_tel_no' => array(
            'length' => array(
                'rule' => array('between', 0, 40),
                'required' => false,
                'message' => 'Please keep this field below 40 characters.',
            ),
//            'numeric' => array(
//                'rule' => 'numeric',
//                'allowEmpty' => true,
//                'required' => false,
//                'message' => 'Tel. No. should be numeric'
//            ),
        ),
        'vc_tel_no2' => array(
            'length' => array(
                'rule' => array('between', 0, 40),
                'required' => false,
                'message' => 'Please keep this field below 40 characters.',
            ),
//            'numeric' => array(
//                'rule' => 'numeric',
//                'allowEmpty' => true,
//                'required' => false,
//                'message' => 'Tel. No. should be numeric'
//            ),
        ),
        
        'vc_cell_no' => array(
            'length' => array(
                'rule' => array('between', 1, 30),
                'required' => true,
                'message' => 'Please keep this field below 30 characters.',
            ),
            
//            'numeric' => array(
//                'rule' => 'numeric',
//                'message' => 'Mobile No. should be numeric'
//            ),
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Required',
            )
        ),
        'vc_cell_no2' => array(
            'length' => array(
                'rule' => array('between', 1, 30),
                'required' => true,
                'message' => 'Please keep this field below 30 characters.',
            ),
//            'numeric' => array(
//                'rule' => 'numeric',
//                'message' => 'Mobile No. should be numeric'
//            ),
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Required',
            )
        ),
        'vc_fax_no' => array(
            'length' => array(
                'rule' => array('between', 0, 30),
                'required' => false,
                'message' => 'Please keep this field below 30 characters.',
            ),
//            'numeric' => array(
//                'rule' => 'numeric',
//                'allowEmpty' => true,
//                'required' => false,
//                'message' => 'Fax No. should be numeric'
//            )
        ),
        
        'vc_fax_no2' => array(
            'length' => array(
                'rule' => array('between', 0, 30),
                'required' => false,
                'message' => 'Please keep this field below 30 characters.',
            ),
//            'numeric' => array(
//                'rule' => 'numeric',
//                'allowEmpty' => true,
//                'required' => false,
//                'message' => 'Fax No. should be numeric'
//            )
        ),
        'type' => array(
            'required' => true,
            'message' => 'Required',
        )
    );

    /**
     *
     * Function to generate primary key
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