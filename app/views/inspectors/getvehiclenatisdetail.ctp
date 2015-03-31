  <?php 
 	//pr($natis );
  if (count($natis) > 0) : ?>
                    <?php
                    $i = 1;
					$val=$natis ;
           // foreach ($natis as $val) {
					//pr($val);
					//pr($index);
					//die;
                ?>
    <tr class="cont1">
		<td align="center">	<?php
		echo $i;
		?>
		</td>
        </td>
        <td valign="top" >
        <?php
		//echo $val['AssessmentVehicleDetail']['vc_assessment_no'];
		
		//pr($val);
	//	die;
             echo wordwrap($val['AssessmentVehicleDetail']['vc_assessment_no'], 12, "<br>\n", true);	
			 
		
			 ?>
		
        </td>
        <td valign="top" >
          <?php
		  $last_date = !empty($val['AssessmentVehicleDetail']['dt_created_date']) ?
                                        date('d M Y', strtotime($val['AssessmentVehicleDetail']['dt_created_date'])) :
                                        '';
		  echo $last_date;
		  ?>

        </td>
        <td valign="top" class='number-right'>
         <?php
		 echo number_format($val['AssessmentVehicleMaster']['nu_total_payable_amount'], 2,'.', ',');
		 ?>

        </td>
        <td valign="top" class='number-right' >
		<?php
		 echo   number_format($val['AssessmentVehicleMaster']['vc_mdc_paid'],2,'.',',');
		
		?>	

        </td>
        <td valign="top" class='number-right' >
        <?php
		 $outstanding=$val['AssessmentVehicleMaster']['nu_total_payable_amount']-$val['AssessmentVehicleMaster']['vc_mdc_paid'];
		echo number_format($outstanding,2,'.',',');
		
		?>		

        </td>
        <td valign="top" >
            <?php
	//$log_date = !empty($val['VehicleLogDetail']['dt_log_date']) ? date('d M //Y',strtotime($val['VehicleLogDetail']['dt_log_date'])) :             '';
	
	//echo 'lic--',$lic_no_search;
	echo $log_date= $this->Getlogdate->showLastogdate($val['AssessmentVehicleDetail']['vc_assessment_no'],$lic_no_search);
            
            ?>

        </td>
		<td valign="top" >
            <?php
            
			$assesment_date = !empty($val['AssessmentVehicleMaster']['dt_assessment_date']) ?
                                        date('d M Y', strtotime($val['AssessmentVehicleMaster']['dt_assessment_date'])) :
                                        '';
            echo $assesment_date;
            ?>

        </td>
		<td valign="top" class='number-right' >
            <?php
			 echo number_format($Totalnu_total_payable_amount, 2,'.',',');
            ?>

        </td>
       
		
		<td valign="top" class='number-right' >
            <?php
         echo number_format($Totalvc_mdc_paid, 2,'.',',');
            ?>

        </td>
		
		<td valign="top" class='number-right' >
            <?php
			//echo $Totalnu_total_payable_amount,' -==-- ',$Totalvc_mdc_paid;
            echo number_format($Totalnu_total_payable_amount - $Totalvc_mdc_paid,2,'.',',');
			
            ?>
		
        </td>     
    </tr>
	 <?php
		$i++;
		
//	}
	?>
<?php else : ?>
	<tr class="cont1" style='text-align:center;'>
		<td colspan='14'> No Record Found </td>
	</tr>
   <?php endif; ?> 