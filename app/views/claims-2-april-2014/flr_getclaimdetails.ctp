<!-- Start innerbody here-->
<div class="innerbody">
<!--
<table width="100%" border="0" cellpadding="3">
	<tr>

		<td width="13%"><label class="lab-inner">RFA Account No. :</label></td>
		<td  width="18%"><span class="valuetext"><?php echo $this->Session->read('Auth.Profile.vc_customer_no');  ?></span></td>
		<td width="13%"><label class="lab-inner">From Date :</label></td>
		<td width="14%"><span class="valuetext"><?php echo $fromDate; ?></span></td>

	</tr> 
	<tr>
		<td><label class="lab-inner">Customer Name :</label></td>
		<td><span class="valuetext"><?php echo $this->Session->read('Auth.Profile.vc_customer_name');  ?></span></td>              
		<td><label class="lab-inner">To Date :</label></td>
		<td><span class="valuetext"><?php echo $toDate; ?></span></td>
	</tr>     
</table>
-->
<br>
<table width="100%" cellspacing="1" cellpadding="5" border="0" >
	<tr class="cont1">
		<td>Claim No.</td><td><?php
        if(count($allInvoicedata)>0)
		echo $allInvoicedata[0]['ClaimHeader']['vc_party_claim_no'];?></td>
		<td  colspan="6"  width="100%" style="text-align:left;"><b>System Claim No.</b> 
		&nbsp;<?php  echo $claimno;?></td>
	
	</tr>
	<tr class="listhead">
		<td width="15%">Entry Date</td>
		<td width="15%">Invoice No.</td>    
		<td width="10%">Fuel Litres</td>
		<td width="15%">Invoice date</td>
		<td width="15%">Amount(N$) </td>
		<td width="15%">Fuel Outlet </td>
		<td width="15%">Status </td>
	
	</tr>
	<?php
	if(isset($allInvoicedata) && count($allInvoicedata)>0){
	foreach($allInvoicedata as $value)  { ?>

		<tr class="cont1">
			
			<td><?php 
			if(!empty($value['ClaimDetail']['dt_entry_date']) && $value['ClaimDetail']['dt_entry_date']!=null)
			echo date('d M Y', strtotime($value['ClaimDetail']['dt_entry_date'])); ?></td>
			
			
			<td ><?php echo $value['ClaimDetail']['vc_invoice_no']; ?></td>
			
			
			<td align="right"><?php echo number_format($value['ClaimDetail']['nu_litres'], 2, '.', ','); ?></td>
			
			<td ><?php  echo date('d M Y', strtotime($value['ClaimDetail']['dt_invoice_date'])); ?></td>
			<td align="right"><?php echo number_format($value['ClaimDetail']['nu_amount'], 2, '.', ','); ?></td>
			<td ><?php echo $value['ClaimDetail']['vc_outlet_code']; ?></td>
			<td ><?php echo $globalParameterarray[$value['ClaimDetail']['vc_status']]; ?></td>
			
		
		</tr>
	
	<?php }}else{
		?><tr>
			<td colspan='8' style="text-align:center;">No record found!!</td>
			
		
		</tr>
	<?php
	}
	
	?>

</table>


</div>
<!-- end innerbody here--> 

