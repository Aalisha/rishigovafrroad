<?php
class InvoicedocdetailsHelper extends AppHelper {
	
    function giveDocdetails($vc_invoice_no,$outletcode,$dt_invoice_date,$vc_claim_no,$vc_client_no) {
      		
			App::import('Model','InvoiceClaimDoc');
	       $InvoiceClaimDoc = ClassRegistry::init('InvoiceClaimDoc');
		   $InvoiceClaimDocdetails = $InvoiceClaimDoc->find('first',array(
											'fields'=> array('InvoiceClaimDoc.vc_uploaded_doc_name',
											'InvoiceClaimDoc.vc_claim_dt_id',
											'InvoiceClaimDoc.vc_uploaded_doc_type',
											'InvoiceClaimDoc.vc_uploaded_doc_for',
												'InvoiceClaimDoc.vc_upload_id',
											'InvoiceClaimDoc.vc_claim_no'),
											 'conditions' => array('InvoiceClaimDoc.vc_invoice_no'=>$vc_invoice_no,
											 'InvoiceClaimDoc.vc_outlet_code'=>$outletcode,
											 'InvoiceClaimDoc.vc_invoice_datetimestamp'=>$dt_invoice_date,
											 'InvoiceClaimDoc.vc_claim_no'=>$vc_claim_no,
											 'InvoiceClaimDoc.vc_client_no'=>$vc_client_no,
											 )  
											));
			

		return $InvoiceClaimDocdetails;
	   
	   }
	   
	   function singlegiveDocdetails($claimNo) {
      		   App::import('Model','InvoiceClaimDoc');

	       $InvoiceClaimDoc = ClassRegistry::init('InvoiceClaimDoc');
		   $InvoiceClaimDocdetails = $InvoiceClaimDoc->find('all',array(
											'fields'=> array('InvoiceClaimDoc.vc_uploaded_doc_name',
											'InvoiceClaimDoc.vc_claim_dt_id',
											'InvoiceClaimDoc.vc_uploaded_doc_type',
											'InvoiceClaimDoc.vc_uploaded_doc_for',
											'InvoiceClaimDoc.vc_upload_id',
											'InvoiceClaimDoc.vc_claim_no'),
											 'conditions' => array('InvoiceClaimDoc.vc_claim_no'=>$claimNo,
											'InvoiceClaimDoc.vc_uploaded_doc_for'=>'Claim'
											 )  
											));
			

		return $InvoiceClaimDocdetails;
	   
	   }
		
    
}
?>