<?php

/**
 * Client model.
 *
 * 
 */
class Client extends Model {

    /**
     * Model name
     *
     * @var string
     * @access public
     */
    var $name = 'Client';

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
    var $useTable = 'MST_CLIENT_FLR';

    /**
     * Model primary key
     *
     * @var string
     * @access public
     */
    var $primaryKey = 'vc_client_no';

    /**
     *
     *
     *  hasOne
     *
     */
    var $hasOne = array(
        'ClientHeader' => array(
            'className' => 'ClientHeader',
            'foreignKey' => 'vc_client_no',
            'dependent' => false
        ),
        'ClientBank' => array(
            'className' => 'ClientBank',
            'foreignKey' => 'vc_client_no',
            'dependent' => false
        )
    );
    var $hasMany = array(
        'ClientFuelOutlet' => array(
            'className' => 'ClientFuelOutlet',
            'foreignKey' => 'vc_client_no',
            'dependent' => false
        )
    );
    var $belongsTo = array(
        'Status' => array(
            'className' => 'ParameterType',
            'foreignKey' => false,
            'conditions' => array('Client.ch_active_flag = Status.vc_prtype_code'),
            'dependent' => false
        )
    );

    /**
     * validate name
     *
     * @var array
     * @access public
     * @ contain complete description about validation of model
     */
    var $validate = array(
        'vc_old_password' => array(
            'match' => array(
                'rule' => 'checkOldPassword',
                'message' => 'Incorrect old password.',
            ),
            'length' => array(
                'rule' => array('between', 6, 50),
                'required' => true,
                'message' => 'Use between 6 and 50 characters',
            ),
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Please enter old password',
            )
        ),
        'vc_password' => array(
            'length' => array(
                'rule' => array('between', 6, 50),
                'required' => true,
                'message' => 'Use between 6 and 50 characters',
            ),
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Please enter password',
            )
        ),
        'vc_confirm_password' => array(
            'length' => array(
                'rule' => array('between', 6, 50),
                'required' => true,
                'message' => 'Use between 6 and 50 characters',
            ),
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Please enter confirm password',
            ),
            'match' => array(
                'rule' => 'matchPassword',
                'message' => 'Password not matched'
            )
        ),
        'vc_id_no' => array(
            'length' => array(
                'rule' => array('between', 1, 50),
                'required' => true,
                'message' => 'Please keep this field below 50 characters.'
            ),
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Please enter business reg. id',
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
                'message' => 'Please enter client name',
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
                'message' => 'Please enter contact person name',
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
                'message' => 'Please postal enter address',
            )
        ),
        'vc_address2' => array(
            'length' => array(
                'rule' => array('between', 0, 50),
                'required' => false,
                'message' => 'Please keep this field below 50 characters.',
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
                'message' => 'Please  enter business address',
            )
        ),
        'vc_address5' => array(
            'length' => array(
                'rule' => array('between', 0, 50),
                'required' => false,
                'message' => 'Please keep this field below 50 characters.',
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
                'message' => 'Postal code should be numeric'
            ),
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Please enter postal code',
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
                'message' => 'Postal code should be numeric'
            ),
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Please enter postal code',
            )
        ),
         'vc_tel_no' => array(
            'length' => array(
                'rule' => array('between', 7, 15),
                'allowEmpty' => true,
                'message' => 'Please use between 7 to 15 characters',
            ),

        ),
        'vc_tel_no2' => array(
            'length' => array(
                'rule' => array('between', 7, 15),
                'allowEmpty' => true,
                'message' => 'Please use between 7 to 15 characters',
            ),

        ),
        'vc_cell_no' => array(
            'length' => array(
                'rule' => array('between', 7, 15),
                'required' => true,
                'message' => 'Please use between 7 to 15 characters',
            ),
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Please enter mobile number',
            )
        ),
        'vc_cell_no2' => array(
            'length' => array(
                'rule' => array('between', 7, 15),
                'required' => true,
                'message' => 'Please use between 7 to 15 characters',
            ),
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Please enter mobile number',
            )
        ),
        'vc_email' => array(
            'length' => array(
                'rule' => array('between', 1, 50),
                'required' => true,
                'message' => 'Please keep this field below 50 characters.',
            ),
            'email' => array(
                'rule' => 'email',
                'message' => 'Must be a valid email address',
            ),
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Please enter email address',
            )
        ),
        'vc_email2' => array(
            'length' => array(
                'rule' => array('between', 1, 50),
                'required' => true,
                'message' => 'Please keep this field below 50 characters.',
            ),
            'email' => array(
                'rule' => 'email',
                'message' => 'Must be a valid email address',
            ),
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Please enter email address',
            )
        ),
        'vc_fax_no' => array(
            'length' => array(
                'rule' => array('between', 7, 15),
                'allowEmpty' => true,
                'message' => 'Please use between 7 to 15 characters',
            )
        ),
        'vc_fax_no2' => array(
            'length' => array(
                'rule' => array('between', 7, 15),
                 'allowEmpty' => true,
                'message' => 'Please use between 7 to 15 characters',
            )
        )
    );

    function matchPassword($data) {

        if ($data['vc_confirm_password'] == $this->data['Client']['vc_password']) {

            return true;
        }

        $this->validates('vc_password', 'Not match confirm password ');
        return false;
    }

    function checkOldPassword($data) {

        $Member = ClassRegistry::init('Member');
        App::import('Model', 'CakeSession');
        $Session = new CakeSession();
        
		$queryResult = $Member->find('first', array(
            'conditions' => array(
                'Member.vc_username' => $Session->read('Auth.Member.vc_username'),
                'Member.vc_password' => AuthComponent::password($data['vc_old_password'])
        )));

        if ($queryResult) {

            return true;
        }

        return false;
    }

    /* isValidPhoneFormat() - Custom method to validate Phone Number Format
     * @params Int $phone
     */

    function isValidPhoneFormat($data) {

        $phone_no = isset($data['vc_cell_no2']) ? $data['vc_cell_no2'] : isset($data['vc_cell_no']) ? $data['vc_cell_no'] : '';

        $errors = array();

        if (empty($phone_no)) {

            $errors [] = "Please enter Phone Number";
        } else if (!preg_match('/^[(]{0,1}[0-9]{3}[)]{0,1}[-\s.]{0,1}[0-9]{3}[-\s.]{0,1}[0-9]{4}$/', $phone_no)) {
            $errors [] = "Please enter valid Phone Number";
        }

        if (!empty($errors))
            return implode("\n", $errors);

        return true;
    }

    /**
     *
     * Function to generate primary key
     *
     */
    function getPrimaryKey() {

        $count = $this->find('count');
		
        $primaryKey = (string) ( "FLR-".($count+1) );



        if ($this->find('count', array('conditions' => array($this->name . '.' . $this->primaryKey => $primaryKey))) > 0) {

            $i = (int) $count;

            while ($i >= 1) {

                $i += 1;

        //        $primaryKey = $i;
                $primaryKey = (string)("FLR-".($i));

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