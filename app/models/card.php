<?php

	class Card extends Model {


/**
*
*
*
*/
	

    var $name = 'Card';
	
/**
*
*
*
*/
	
	
	var $useTable = 'DT_CUST_CARD_REQUESTS_CBC';
		
/**
*
*
*
*/
	var $primaryKey='card_request_id';
	
/**
*
*
*
*/
/* 	
	public $validate = array(
        
        'vc_pending1' => array(
		
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Must not be blank',
            )
        ),
		
		'vc_pending2' => array(
		
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Must not be blank',
            )
        ),
		
		'vc_pending3' => array(
		
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Must not be blank',
            )
        ),
		
		'vc_pending4' => array(
		
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Must not be blank',
            )
        ),
		
		'vc_pending5' => array(
		
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Must not be blank',
            )
        ),
		
		'vc_card_required'=>array(
		
			'required'=>array(
				
				'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Must not be blank',
				
			)
		),
		
		
		'vc_cbc_permit_no'=>array(
		
			'required'=>array(
				
				'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Must not be blank',
				
			)
		),
		
		'vc_mdc_permit_no'=>array(
		
			'required'=>array(
				
				'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Must not be blank',
				
			)
		),
		
		'vc_cbc_amount'=>array(
		
			'required'=>array(
				
				'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Must not be blank',
				
			)
		),
		
		'vc_mdc_amount'=>array(
		
			'required'=>array(
				
				'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Must not be blank',
				
			)
		),
		
		'vc_cbc_reason'=>array(
		
			'required'=>array(
				
				'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Must not be blank',
				
			)
		),
		
		'vc_mdc_reason'=>array(
		
			'required'=>array(
				
				'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Must not be blank',
				
			)
		)
	);
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
 