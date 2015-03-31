<?php

/**
 * Invoice Claim Doc  model.
 *
 * 
 */
class InvoiceClaimDoc extends Model {

    /**
     * Model name
     *
     * @var string
     * @access public
     */
    var $name = 'InvoiceClaimDoc';

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
    var $useTable = 'PR_INVOICE_UPLOAD__DOCS_FLR';

 
    /**
     * Model primary key
     *
     * @var string
     * @access public
     */
    var $primaryKey = 'vc_upload_id';

    /**
     * validate name
     *
     * @var array
     * @access public
     * @ contain complete description about validation of model
     */
    var $validate = array(
        'vc_id_no' => array(
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Required',
            ),
            'length' => array(
                'rule' => array('maxLength' => 50),
                'required' => true,
                'message' => 'Please keep this field below 50 characters.',
            )
        ),
        'vc_cateogry' => array(
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Must not be blank',
            )
        ),
        'nu_refund' => array(
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Must not be blank',
            ),
            'length' => array(
                'rule' => array('maxLength' => 22),
                'required' => true,
                'message' => 'Please keep this field below 22 characters.'
            )
        ),
        'nu_fuel_usage' => array(
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Must not be blank',
            ),
            'length' => array(
                'rule' => array('maxLength' => 22),
                'required' => true,
                'message' => 'Please keep this field below 22 characters.'
            )
        ),
        'nu_expected_usage' => array(
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Must not be blank',
            ),
            'length' => array(
                'rule' => array('maxLength' => 22),
                'required' => true,
                'message' => 'Please keep this field below 22 characters.'
            )
        ),
        'nu_off_road_usage' => array(
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Must not be blank',
            ),
            'length' => array(
                'rule' => array('maxLength' => 22),
                'required' => true,
                'message' => 'Please keep this field below 22 characters.'
            )
        ),
        'nu_off_expected_usage' => array(
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Must not be blank',
            ),
            'length' => array(
                'rule' => array('maxLength' => 22),
                'required' => true,
                'message' => 'Please keep this field below 22 characters.'
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