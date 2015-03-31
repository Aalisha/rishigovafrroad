<?php


/**
*
*	Class name
*
*/

class ActivationDeactivationCard extends Model {

/**
*
*	Model name
*
*/
	
    var $name = 'ActivationDeactivationCard';
	
/**
*
*	Table used
*
*/
	
	var $useTable = 'DT_CUST_CARD_CBC';

/**
*
*	Primary key
*
*/

	var $primaryKey= 'vc_card_no';
	
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