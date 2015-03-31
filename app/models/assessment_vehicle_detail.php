
<?php

/**
 * Vehicle Log Detail model.
 *
 * 
 */
class AssessmentVehicleDetail extends Model {

    /**
     * Model name
     *
     * @var string
     * @access public
     */
    var $name = 'AssessmentVehicleDetail';

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
    var $useTable = "DT_ASSESSMENT_MDC";

    /**
     * Model primary key
     *
     * @var string
     * @access public
     */
    var $primaryKey = 'vc_assessment_detail_id';

    /**
     * validate name
     *
     * @var array
     * @access public
     * @ contain complete description about validation of model
     */

    /**
     *
     * @var type 
     * 
     */
    public $belongsTo = array(
        'AssessmentVehicleMaster' => array(
            'className' => 'AssessmentVehicleMaster',
            'foreignKey' => 'vc_assessment_no',
        )
    );
	
    public $hasOne = array(
        'VehicleDetail' => array(
            'className' => 'VehicleDetail',
            'foreignKey' => false,
            'conditions' => array('AssessmentVehicleDetail.vc_vehicle_lic_no = VehicleDetail.vc_vehicle_lic_no')
            ));
   
	var $validate = array();

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

}