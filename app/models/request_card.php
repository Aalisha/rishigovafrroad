<?php

	class RequestCard extends Model {


/**
*
*
*
*/	
    var $name = 'RequestCard';
	
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
	
	var $validate = array(
        
        'vc_no_of_cards' => array(
		
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Please enter number of cards'
            ),
		
		'numeric' =>array(
				'rule' => 'numeric',
				'required' =>true,
				'message' => 'Enter a positive number'
				
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
 