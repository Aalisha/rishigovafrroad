<table width="100%" cellspacing="1" cellpadding="5" border="0" >

	<?php 
	
	if( count($data)  > 0 ) : 

		foreach ( $data as $key => $value  ) :
		
		$str = $key%2  ==  0 ? '1' : '';
	
		$url = $this->webroot.'inspectors/feedbackform/'.trim($value['AssessmentVehicleMaster']['vc_assessment_no']).'/'.trim($value['AssessmentVehicleMaster']['vc_customer_no']);
	
	?>
		
		<tr class="cont<?php echo $str;?>">
		
			<td valign="top" width="20%">
				
				<?php 

					echo $value['AssessmentVehicleMaster']['vc_assessment_no'];

				?>
			</td>
			<td valign="top" width="20%">
				<?php
					echo date('d M Y',strtotime($value['AssessmentVehicleMaster']['vc_pay_month_from'].' '.$value['AssessmentVehicleMaster']['vc_pay_year_from']));
				?>
				
			</td>
			<td valign="top" width="20%">
				<?php
					echo date('t-M-Y',strtotime($value['AssessmentVehicleMaster']['vc_pay_month_to'].' '.$value['AssessmentVehicleMaster']['vc_pay_year_to']));
				?>
				
			</td>
			<td valign="top" width="15%">
				<?php
					echo $value['AssessmentVehicleMaster']['nu_total_payable_amount']; 
				?>
				
			</td>
			<td valign="top" width="10%">
				<?php
					echo $value['AssessmentStatus']['vc_prtype_name']; 
				?>
				
			</td>
			<td valign="top" width="15%">
				
				<?php
								
				echo $this->Form->button('Show Log', array(
											'div'=>false,
											'type'=>'button',
											'label'=>false,
											'onclick'=>"window.location = '". $url ."'" 
										));
				
				?>
			
			</td>
			
		</tr>
	
		<?php endforeach; ?>
	
	<?php else :?>
	
	<tr>
		
		<td colspan='8' style='text-align:center;'>
			
			No Records Found
			
		</td>
	
	</tr>
   
    <?php  endif; ?>
	
</table>