
<?php

/**
 * Assessment Vehicle Master model.
 *
 * 
 */
class AssessmentVehicleMaster extends Model {

    /**
     * Model name
     *
     * @var string
     * @access public
     */
    var $name = 'AssessmentVehicleMaster';

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
    var $useTable = "HD_ASSESSMENT_MDC";

    /**
     * Model primary key
     *
     * @var string
     * @access public
     */
    var $primaryKey = 'vc_assessment_no';

    /**
     * validate name
     *
     * @var array
     * @access public
     * @ contain complete description about validation of model
     */
    var $validate = array();

    /**
     * 
     * hasMany Relation is like one to many relation like One Master  and its multiple details
     * 
     */
    var $hasMany = array(
        'AssessmentVehicleDetail' => array(
            'className' => 'AssessmentVehicleDetail',
            'foreignKey' => 'vc_assessment_no'
        )
    );

    /**
     * Model Belongs to relation Many to One relation
     *
     * @var string
     * @access public
     */
    public $belongsTo = array(
        'PaymentStatus' => array(
            'className' => 'ParameterType',
            'foreignKey' => 'vc_payment_status',
        ),
        'AssessmentStatus' => array(
            'className' => 'ParameterType',
            'foreignKey' => 'vc_status',
            ));

    /**
     *
     * Get Primary Key Value  
     *
     */
    function getPrimaryKey($vc_comp_code) {

        $count = $this->find('count');

        $primaryKey = (string) ( strtoupper($vc_comp_code) . '-ASS-' . ($count + 1) );

        if ($this->find('count', array('conditions' => array($this->name . '.' . $this->primaryKey => $primaryKey))) > 0) {

            $i = (int) $count;

            while ($i >= 1) {

                $i += 1;

                $primaryKey = (string) ( strtoupper($vc_comp_code) . '-ASS-' . ($i) );

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