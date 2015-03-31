<?php
class DeletelastlogHelper extends AppHelper {
    
	function getLastlogofvehicle($VC_VEHICLE_LIC_NO=null,$logdate=null, $lastlogid=null) {
       
		App::import('Model','VehicleLogDetail');
		$VehicleLogDetail = ClassRegistry::init('VehicleLogDetail');

		$conditions=array('conditions'=>array('VehicleLogDetail.vc_vehicle_lic_no'=>$VC_VEHICLE_LIC_NO),'order'=>'VehicleLogDetail.nu_end_ometer desc');
		$result = $VehicleLogDetail->find('first',$conditions);
		$allarraytrimvalues=array();
	    // foreach($result as $value){	   
		// $allarraytrimvalues[] = trim($value['VehicleLogDetail']['vc_log_detail_id'],'dtl-veh');
		// echo trim($value['VehicleLogDetail']['vc_log_detail_id'],'dtl-veh');	   
	    // }
	    // pr($allarraytrimvalues);
		return $result['VehicleLogDetail']['vc_log_detail_id'];
    }
}
?>