<?php
class GetlogdateHelper extends AppHelper {
//App::import('Model','VehicleLogDetail');

    function showLastogdate($last_assessmentno=null,$vehicle_lic_no=null) {
      	App::import('Model','VehicleLogDetail');
	    $VehicleLogDetail = ClassRegistry::init('VehicleLogDetail');
	   $conditions = array('conditions' => array('VehicleLogDetail.vc_assessment_no'=>$last_assessmentno,
	   'VehicleLogDetail.vc_vehicle_lic_no'=>$vehicle_lic_no  ),	   
	   'order'=>array('VehicleLogDetail.dt_log_date'=>'desc')
	   
	   );
	   
	   $lastlogdate = $VehicleLogDetail->find('first',$conditions);
	   if($lastlogdate['VehicleLogDetail']['dt_log_date']!='')
		return date('d M Y',strtotime($lastlogdate['VehicleLogDetail']['dt_log_date']));
	   else
	   return 'N/A';
	   
	   }
		//return $explodeName[1];
    }

?>