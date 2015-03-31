<?php

class Customer extends Model {

    /**
     *
     *
     */
    var $name = 'Customer';

    /**
     *
     *
     */
    var $useDbconfig = 'default';

    /**
     *
     *
     */
    var $useTable = 'HD_CUST_VEHICLE_CARD_CBC';

    /**
     *
     *
     */
    var $primaryKey = 'nu_cust_vehicle_card_id';

    /**
     *
     *
     */
    var $validate = array(
        'vc_first_name' => array(
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Please enter first name',
            ),
            'length' => array(
                'rule' => array('maxlength', 50),
                'message' => 'Should not be more than 50 characters',
            ),
           /* 'name' => array(
                'rule' => '/^[a-zA-Z ]+$/',
                'message' => 'Alphabets only'
            )*/
        ),
        'vc_surname' => array(
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Please enter surname',
            ),
            'length' => array(
                'rule' => array('maxlength', 50),
                'message' => 'Should not be more than 50 characters',
            ),
            /*'name' => array(
                'rule' => '/^[a-zA-Z ]+$/',
                'message' => 'Alphabets only'
            )*/
        ),
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
                'message' => 'Please enter new password',
            )
        ),
        'vc_confirm__password' => array(
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
                'message' => 'Passwords must match'
            )
        ),
        'VC_CUSTOMER_NAME' => array(
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Required',
            )
        ),
        'VC_BUSINESS_REG' => array(
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Required',
            )
        ),
        'VC_CUST_TYPE' => array(
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Required',
            )
        ),
        'VC_BANK_STRUCT_CODE' => array(
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Required',
            )
        ),
        'VC_ACCOUNT_NO' => array(
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Required',
            )
        ),
        'VC_BANK_SUPPORTIVE_DOC' => array(
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Required',
            )
        ),
        'vc_company' => array(
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Please enter company name',
            ),
            'length' => array(
                'rule' => array('maxlength', 50),
                'message' => 'Should not be more than 50 characters',
            ),
            /*'name' => array(
                'rule' => '/^[a-zA-Z ]+$/',
                'message' => 'Alphabets only'
            )*/
        ),
        'vc_cont_per' => array(
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Please enter contact person name',
            ),
            'length' => array(
                'rule' => array('maxlength', 50),
                'message' => 'Should not be more than 50 characters',
            ),
            /*'name' => array(
                'rule' => '/^[a-zA-Z ]+$/',
                'message' => 'Alphabets only'
            )*/
        ),
        'vc_address1' => array(
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Please enter address 1',
            ),
            'length' => array(
                'rule' => array('maxlength', 50),
                'message' => 'Should not be more than 50 characters',
            )
        ),
        'vc_address2' => array(
            'length' => array(
                'rule' => array('maxlength', 50),
                'message' => 'Should not be more than 50 characters',
            )
        ),
        'vc_address3' => array(
            'length' => array(
                'rule' => array('maxlength', 50),
                'message' => 'Should not be more than 50 characters',
            )
        ),
        'vc_tel_no' => array(
//            'numeric' => array(
//                'rule' => '|^[0-9]*$|',
//                'message' => 'Enter a positive number',
//            ),
            'length' => array(
                'rule' => array('maxlength', 15),
                'message' => 'Should not be more than 15 characters',
            )
        ),
        'vc_fax_no' => array(
//            'numeric' => array(
//                'rule' => '|^[0-9]*$|',
//                'message' => 'Enter a positive number',
//            ),
            'length' => array(
                'rule' => array('maxlength', 15),
                'message' => 'Should not be more than 15 characters',
            )
        ),
        'vc_mobile_no' => array(
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Please enter mobile number',
            ),
            'length' => array(
                'rule' => array('maxlength', 15),
                'message' => 'Should not be more than 15 characters',
            ),
//            'numeric' => array(
//                'rule' => '|^[0-9]*$|',
//                'message' => 'Enter a positive number'
//            )
        ),
        'vc_alter_email' => array(
            'length' => array(
                'rule' => array('maxlength', 50),
                'message' => 'Should not be more than 15 characters',
            ),
            'customUnique' => array(
                'rule' => 'checkEmailUnique',
                'message' => 'Email Id Already used'
            )
        ),
        'vc_alter_phone_no' => array(
            'length' => array(
                'rule' => array('maxlength', 15),
                'message' => 'Should not be more than 15 characters',
            ),
//            'numeric' => array(
//                'rule' => '|^[0-9]*$|',
//                'message' => 'Enter a positive number'
//            )
        ),
        'vc_alter_cont_person' => array(
            'length' => array(
                'rule' => array('maxlength', 50),
                'message' => 'Should not be more than 50 characters',
            ),
            /*'name' => array(
                'rule' => '/^[a-zA-Z ]*$/',
                'message' => 'Alphabets only'
            )*/
        ),
       /* 'upload_doc' => array(
            'rule' => array('extension', array('doc', 'docx', 'pdf', 'png', 'jpeg', 'jpg')),
            'message' => 'Please upload a valid file'
        )*/
    );

    /**
     *
     *
     * Custom function for maximum file size validation
     *
     */
    function checkSize($file) {

        if ($file['size'] <= 2048000 && $file['size'] > 0) {

            return true;
        }

        return false;
    }

    /**
     *
     * Get Primary Key Value  
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

    /**
     *
     *  
     *
     */
    function matchPassword($data) {

        if ($data['vc_confirm__password'] == $this->data['Profile']['vc_password']) {

            return true;
        }

        $this->validates('vc_password', 'Not match confirm password ');
        return false;
    }

    /**
     *
     *  
     *
     */
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

    /**
     *
     *  Function for Unique alternate email
     *
     */
    function checkEmailUnique($data) {
        App::import('Model', 'Member');
        //pr()
        $obj = new Member();
        //if( $Session->read('Auth.Profile.ch_active') == 'STSTY05'  ) :
        //	$Session = new CakeSession();
        // pr($Session->read('Auth'));

        if (isset($this->data['Customer']['editvalue']) && $this->data['Customer']['editvalue'] == 'edit') {

            $countResult = $this->find('count', array(
                'conditions' => array(
                    'OR' => array(
                        array('Customer.vc_alter_email' => $data['vc_alter_email'],
                            'Customer.vc_cust_no!' => $this->data['Customer']['vc_cust_no'],
                        ),
                        array('Customer.vc_email' => $data['vc_alter_email'],
                        )),
                    'Customer.vc_comp_code' => $this->data['Customer']['vc_comp_code']
            )));

            $countmemberResult = $obj->find('count', array(
                'conditions' => array(
                    'Member.vc_email_id' => $data['vc_alter_email'],
                    'Member.vc_comp_code' => $this->data['Customer']['vc_comp_code'],
                    'Member.vc_cbc_customer_no!' => $this->data['Customer']['vc_cust_no'],)));
        } else {

            $countResult = $this->find('count', array(
                'conditions' => array(
                    'OR' => array(
                        array('Customer.vc_alter_email' => $data['vc_alter_email'],
                        ),
                        array('Customer.vc_email' => $data['vc_alter_email'],
                        )),
                    'Customer.vc_comp_code' => $this->data['Customer']['vc_comp_code']
                ))
            );
            $countmemberResult = $obj->find('count', array(
                'conditions' => array(
                    'Member.vc_email_id' => $data['vc_alter_email'],
                    'Member.vc_comp_code' => $this->data['Customer']['vc_comp_code']
            )));
        }
        if (isset($data['vc_alter_email']) && !empty($data['vc_alter_email']) && trim($data['vc_alter_email']) == trim(isset($this->data['Customer']['vc_email']))) {
            return false;
        }

        if ($countResult == 0 && $countmemberResult == 0) {

            return true;
        } else {
            return false;
        }
    }

    /**
     *
     *  
     *
     */
}