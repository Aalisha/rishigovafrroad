<?php

/**
 * Vehicle Log Detail model.
 *
 * 
 */
class VehicleDetail extends Model {

    /**
     * Model name
     *
     * @var string
     * @access public
     */
    var $name = 'VehicleDetail';

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
    var $useTable = "dt_registration_mdc";

    /**
     * Model primary key
     *
     * @var string
     * @access public
     */
    var $primaryKey = 'vc_registration_detail_id';

    /**
     * Model Belongs to relation Many to One relation
     *
     * @var string
     * @access public
     */
    public $belongsTo = array(
        'STATUS' => array(
            'className' => 'ParameterType',
            'foreignKey' => 'vc_vehicle_status',
        ),
        'PAYFREQUENCY' => array(
            'className' => 'ParameterType',
            'foreignKey' => 'vc_pay_frequency',
        ),
        'VEHICLETYPE' => array(
            'className' => 'ParameterType',
            'foreignKey' => 'vc_vehicle_type',
        ),
        'CustomerProfile' => array(
            'className' => 'Profile',
            'foreignKey' => 'vc_customer_no'
        )
    );

    /**
     * validate name
     *
     * @var array
     * @access public
     * @ contain complete description about validation of model
     */
    var $validate = array();

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