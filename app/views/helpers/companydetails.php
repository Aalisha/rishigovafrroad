<?php
class CompanydetailsHelper extends AppHelper {
	
   
   function giveCompanyId($vc_vehicle_reg_no) {
      		   App::import('Model','VehicleDetail');

	       $VehicleDetail = ClassRegistry::init('VehicleDetail');
		   $VehicleCompanydetails = $VehicleDetail->find('first',array(
											'fields'=> array('VehicleDetail.nu_company_id','VehicleDetail.vc_vehicle_reg_no'),
											 'conditions' => array('VehicleDetail.vc_vehicle_reg_no'=>$vc_vehicle_reg_no)  
											));
			

		return $VehicleCompanydetails['VehicleDetail']['nu_company_id'];
	   
	   }
	   
	
		
    
}
?>