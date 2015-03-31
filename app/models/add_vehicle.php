<?php

/**
 * Registration model.
 *
 * 
 */
class AddVehicle extends Model {

    /**
     * Model name
     *
     * @var string
     * @access public
     */
    var $name = 'AddVehicle';

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
    var $useTable = "DT_VEHICLES_CBC";
  
    /**
     * Model primary key
     *
     * @var string
     * @access public
     */
    var $primaryKey= 'nu_vehicle_id';
	
	/**
     * Model Belongs to relation Many to One relation
     *
     * @var string
     * @access public
     */
	 


    /**
     * validate name
     *
     * @var array
     * @access public
     * @ contain complete description about validation of model
     */
	var $validate = array( 
		 'vc_vehicle_type' => array(
		 'required' => array(
				'rule' => 'notEmpty',
				'required' => true,
				'message' => 'Please choose from list.'
			)
		),
		'vc_make' =>array(
			'required' =>array(
				'rule' =>'notEmpty',
				'required' =>true,
				'message' => 'please select an option !'
				)
			),	
		
		'vc_vehicle_sr_no' => array(
			'required' => array(
				'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Must not be blank!'
			)
		),
		
		'vc_reg_no' => array(
			'required' => array(
				'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Must not be blank!'
			)
		),
		'vc_type_no' =>array(
		    'required' => array(
				'rule' =>'notEmpty',
				'required' =>true,
				'message' => 'Please choose from list !'
				
			)
		)
		
		
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
	
  

