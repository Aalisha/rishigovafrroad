<?php
	/**
	 *
	 *
	 *
	 */
	class CardRefund extends Model {
	
	
	/**
	 *
	 *
	 *
	 */
    var $name = 'CardRefund';
	
	
	/**
	 *
	 *
	 *
	 */
	var $useDbConfig = 'default';
	
	
	/**
	 *
	 *
	 *
	 */
	var $useTable = "CBC_MDC_REFUND_CBC";
	
	
	/**
	 *
	 *
	 *
	 */
	var $primaryKey= 'nu_refund_id';
	
	/**
	 *
	 *
	 *
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