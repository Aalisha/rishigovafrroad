<?php

/**
*
*	Class name
*
*/

class CardLogCbc extends Model {

/**
*
*	Model name
*
*/
	
    var $name = 'CardLogCbc';
	
/**
*
*	Table used
*
*/
	
	var $useTable = 'DT_CUST_CARD_LOG_CBC';

/**
*
*	Primary key
*
*/

	var $primaryKey= 'nu_cust_card_log_id';
	
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