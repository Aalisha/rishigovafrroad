<?php
/**
 * Client Header model.
 *
 * 
 */
class ClaimHeader extends Model {

    /**
     * Model name
     *
     * @var string
     * @access public
     */
    var $name = 'ClaimHeader';

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
    var $useTable = 'HD_CLAIM_FLR';
    
    
    var $hasMany = array(
        'ClaimDetail' => array(
            'className' => 'ClaimDetail',
            'foreignKey' => 'vc_claim_no'
        )
    );

    /**
     * Model primary key
     *
     * @var string
     * @access public
     */

    /**
     * Model primary key
     *
     * @var string
     * @access public
     */
     var $primaryKey = 'vc_claim_no';

    /**
     * validate name
     *
     * @var array
     * @access public
     * @ contain complete description about validation of model
     */

   
  var $validate = array(
  
  'dt_claim_from' => array(
    'notEmpty' => array(
        'rule' => 'notEmpty',
        'required' => true,
        'allowEmpty' => false,
        'message' => 'Please enter from date'
		)
	)/*,
	'vc_party_claim_no' => array(
		'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Please enter password',
            ),'length' => array(
                'rule' => array('between', 1, 20),
                'required' => true,
                'message' => 'should be less than 20',
            ),
  )*/
);
//maxlength=20
function getPrimaryKey() {

        $count = $this->find('count');
        $primaryKey = (string) ( "CLAIM-".($count+1) );

        if ($this->find('count', array('conditions' => array($this->name . '.' . $this->primaryKey => $primaryKey))) > 0) {

            $i = (int) $count;

            while ($i >= 1) {

                $i += 1;

                $primaryKey = (string)("CLAIM-".($i));

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