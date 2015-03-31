<?php

/**
*
*	Class name
*
*/

class ActivationDeactivationVehicle extends Model {

/**
*
*	Model name
*
*/
	
    var $name = 'ActivationDeactivationVehicle';
	
/**
*
*	Table used
*
*/
	
	var $useTable = 'DT_VEHICLES_CBC';

/**
*
*	Primary key
*
*/

	var $primaryKey= 'nu_vehicle_id';
	
/**
*
*
*
*/

public $belongsTo = array(
       
       
        'ParameterType' => array(
            'className' => 'ParameterType',
            'foreignKey' => 'vc_veh_type',
        ),
       
    );
	
/**
*
*	Validation array
*
*/
	

	var $validate = array(
	
		'vc_request_type' => array(
			'required' => array(
				'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Please select a vehicle to deactivate!'
			)
		)
	);
	
/**
*
*Function to generate primary key
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
?>