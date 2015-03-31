<?php
$currentUser = $this->Session->read('Auth.Member');
?>


<!-- Start wrapper here-->
<div class="wrapper">
    <!-- Start breadcrumb here-->
    <div class="breadcrumb">
        <ul>
            <li class="first">
                <?php echo $this->Html->link('Home', array('controller' => 'customers', 'action' => 'view','cbc' =>true), array('title' => 'Home', 'class' => 'vtip')) ?>
            </li>

            <li class="last">Customer Statement Report</li>        
        </ul>
    </div>

    <!-- end breadcrumb here-->
    <!-- Start mainbody here-->

    <div class="mainbody">


        <h1>Welcome to RFA CBC</h1>
        <h3>Customer Statement Report</h3>
        <!-- Start innerbody here-->

        <?php
        echo $this->Form->create(array('url' => array('controller' => 'cbcreports',
                'action' => 'cbc_customerstatements')));
        ?>


        <div class="innerbody">

            <table width="100%" border="0" cellpadding="3">

                <tr>
                    <td><label class="lab-inner">Customer Name :</label></td>
                    <td>

                        <?php
                        echo $this->Form->input('VC_CUSTOMER_NAME', array('label' => false,
                            'type' => 'text',
                            'id' => '',
                            'value' => $currentUser['vc_user_firstname'] . ' ' . $currentUser['vc_user_lastname'],
							'disabled' => 'disabled',
                            'class' => 'round'));
                        ?>
                    </td>

                    <td><label class="lab-inner">Address 1 :</label></td>
                    <td>

                        <?php
                        echo $this->Form->input('VC_USER_LASTNAME', array('label' => false,
                            'type' => 'text',
                            'id' => '',
							'disabled' => 'disabled',
                            'value' => $customer['Customer']['vc_address1'],
                            'class' => 'round'));
                        ?>
                    </td>

                    <td><label class="lab-inner">Address 2 :</label></td>
                    <td>

                        <?php
                        echo $this->Form->input('VC_USER_LASTNAME', array('label' => false,
                            'type' => 'text',
                            'id' => '',
							'disabled' => 'disabled',
                            'value' => $customer['Customer']['vc_address2'],
                            'class' => 'round'));
                        ?>

                    </td>
                </tr>


                <tr>
                    <td><label class="lab-inner">Address 3 :</label></td>
                    <td>

                        <?php
                        echo $this->Form->input('VC_USER_LASTNAME', array('label' => false,
                            'type' => 'text',
                            'id' => '',
							'disabled' => 'disabled',
                            'value' => $customer['Customer']['vc_address3'],
                            'class' => 'round'));
                        ?>
                    </td>

                    <td><label class="lab-inner">Telephone No. :</label></td>
                    <td>

                        <?php
                        echo $this->Form->input('VC_USER_LASTNAME', array('label' => false,
                            'type' => 'text',
                            'id' => '',
							'disabled' => 'disabled',
                            'value' => $customer['Customer']['vc_tel_no'],
                            'class' => 'round'));
                        ?>
                    </td>

                    <td><label class="lab-inner">Fax No. :</label></td>
                    <td>

                        <?php
                        echo $this->Form->input('VC_USER_LASTNAME', array('label' => false,
                            'type' => 'text',
                            'id' => '',
							'disabled' => 'disabled',
                            'value' => $customer['Customer']['vc_fax_no'],
                            'class' => 'round'));
                        ?>
                    </td>
                </tr>

                <tr>
                    <td><label class="lab-inner">Mobile No. :</label></td>
                    <td>

                        <?php
                        echo $this->Form->input('VC_USER_LASTNAME', array('label' => false,
                            'type' => 'text',
                            'id' => '',
							'disabled' => 'disabled',
                            'value' => $customer['Customer']['vc_mobile_no'],
                            'class' => 'round'));
                        ?>
                    </td>


                    <td><label class="lab-inner">Email :</label></td>
                    <td>

                        <?php
                        echo $this->Form->input('VC_USER_LASTNAME', array('label' => false,
                            'type' => 'text',
                            'id' => '',
							'disabled' => 'disabled',
                            'value' => $customer['Customer']['vc_email'],
                            'class' => 'round'));
                        ?>
                    </td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>

                <tr>

                    <td width="13%" valign="top"><label class="lab-inner" >From Date :</label></td>
                    <td width="20%" valign="top" class="align-left">

                        <?php
						
						 if (isset($SearchfromDate) && $SearchfromDate!= '' ) {

                                    $SearchfromDate1 = date('d M Y',  strtotime($SearchfromDate));
									}
									else{
									$SearchfromDate1 = '';
									}
									if (isset($SearchtoDate) && $SearchtoDate != '' ) {

                                    $SearchtoDate1 = date('d M Y',  strtotime($SearchtoDate));
									}
									else{
									$SearchtoDate1 = '';
									}

						echo $this->Form->input('Customer.vc_from_date', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'id' => 'fromDate',
                            'readonly'=>'readonly',
                            'required'=>'required',
                            'value' => $SearchfromDate1,
                             'maxlength'=>12,
                            'class' => 'round'));
                        ?>

                    </td>

                    <td width="13%" valign="top"><label class="lab-inner">To Date :</label></td>
                    <td width="15%" valign="top" class="align-left">
                        <?php
                        // $SearchtoDate = !empty ($SearchtoDate) ? date('d M Y',  strtotime($SearchtoDate)):'';
                        echo $this->Form->input('Customer.vc_to_date', array('label' => false, 'type' => 'text', 'id' => 'toDate',
                            'required'=>'required',
                            'value' =>$SearchtoDate1,
                            'readonly'=>'readonly',
                            'maxlength'=>12,
                            'class' => 'round'));
                        ?>


                    </td>

                    </td>
                    <td width="17%"><span class="valuetext">
                            <!--Particular Vehicle--></span></td>

                    <td align="left">&nbsp;<?php echo $this->Form->submit('Submit', array('class' => 'submit')); ?></td>
                    <td>&nbsp;</td>

                </tr>

            </table>
            <?php echo $this->Form->end(); ?>

            <br>

                <?php echo $this->Form->create('Cbcreport', array('url' => array('controller' => 'cbcreports', 'action' => 'cbc_customerstatements_pdf', 'cbc' => true))); ?>

                <table width="90%" border="0" cellpadding="3" class ="customersInfo">
                    <tr>

                        <td width="10%"><label class="lab-inner">

                                <?php
                                if (isset($SearchfromDate) && $SearchfromDate !== '' && !empty($SearchfromDate)) {

                                    $SearchfromDate = date('d-m-Y', strtotime($SearchfromDate));
                                    ?>
                                    From Date :
                                <?php } ?>
                            </label>
                        </td>
                        <td width="10%"><span class="valuetext">
                            <?php  if (isset($SearchfromDate) && $SearchfromDate !== '')
                            echo   $SearchfromDate = date('d-M-Y', strtotime($SearchfromDate)); ?></span></td>
                        <td width="10%"><label class="lab-inner">
                                <?php
                                if (isset($SearchtoDate) && $SearchtoDate!== '' && !empty($SearchtoDate)) {

                                    $SearchtoDate = date('d-M-Y', strtotime($SearchtoDate));
                                    ?>
                                    To Date :
                                <?php }
                                ?>
                            </label>
                        </td>
                        <td width="10%"><span class="valuetext">
                            <?php if (isset($SearchtoDate) && $SearchtoDate !== '')
                            echo $SearchtoDate; ?></span></td>
                        <td width="10%" align="right">

                            <?php
				            echo $this->Form->hidden('fromdate', array('value' =>$SearchfromDate));

                            echo $this->Form->hidden('todate', array('value' => $SearchtoDate));
							if (isset($SearchfromDate) && $SearchfromDate!='' &&  isset($SearchtoDate) && $SearchtoDate!='' && $totalrows>0 ) {
                
                            echo $this->Form->submit('Print Report', array(
                                'label' => false,
                                'type' => 'submit',
                                'div' => false,
                                'class' => 'submit'));
                            }
							?>
                        </td>
                    </tr>
                </table>
            <br />
              <?php
                if (isset($SearchfromDate) && $SearchfromDate !== '' && isset($SearchtoDate) && $SearchtoDate!='' ) {

				?>
            <table width="100%" cellspacing="1" cellpadding="5" border="0" >
                <tr class="listhead1">
                    <td width="11%" align="center">Opening Balance (N$)<br /></td>
                    <td width="11%" align="center">Recharge (N$)</td>
                    <td width="13%" align="center">Admin Fees (N$)</td>
                    <td width="11%" align="center">Card Issue (N$)</td>
                    <td width="13%" align="center">CBC Total (N$)</td>
                    <td width="13%" align="center">MDC Total (N$)</td>
                    <td width="13%" align="center">Refund (N$)</td>
                    <td width="15%" align="center">Account Balance (N$)</td>
                </tr>
		        <tr class="cont1">
                    <td align="right"><?php
					$openingbalance='';
					$totalRefundAll='';
					$totalpaid='';
					//$nu_account_balance =  $customer['Customer']['nu_account_balance'];
					$totalpaid      = ($Noofrecharge*$globalParameterarray['CBCADMINFEE'])+$totalcbcamt+$totalmdcamt+(($sumofcardsIssued)*($globalParameterarray['CBCADMINFEE']));
					//echo $openingbalance = number_format($totalRefundAll-$totalpaid, 2, '.', ',');
					//echo $openingbalance = number_format(($nu_account_balance-($totalpaid+$TotalsumRecharge +$TotalsumRefund)), 2, '.', ',');
					// $openingbalanceRunning = $nu_account_balance-($totalpaid+$TotalsumRecharge +$TotalsumRefund);
					$nu_account_balance=($funcopeningbalance+$TotalsumRecharge +$TotalsumRefund)-$totalpaid;
					echo number_format($funcopeningbalance, 2, '.', ',');
					?></td>
                    <td align="right" ><?php  if(isset($TotalsumRecharge) && $TotalsumRecharge!='' ) 
					echo wordwrap(number_format($TotalsumRecharge, 2, '.', ','),12, "<br>\n", true);
					else 
					0;?></td>
                                  
                    <td align="right"><?php  if(isset($Noofrecharge) && $Noofrecharge!='' )
					echo wordwrap(number_format(($Noofrecharge)*($globalParameterarray['CBCADMINFEE']), 2, '.', ','),12, "<br>\n", true); else 0;?></td>
					<td align="right"><?php  if(isset($sumofcardsIssued) && $sumofcardsIssued!='' ) 
					echo wordwrap(number_format(($sumofcardsIssued)*($globalParameterarray['CBCADMINFEE']), 2, '.', ','),12, "<br>\n", true);
					else 0;?></td>
                   
				    <td align="right"><?php  if(isset($totalcbcamt) && $totalcbcamt!='' ) echo wordwrap(number_format($totalcbcamt, 2, '.', ','),12, "<br>\n", true); else 0;?></td>
                    <td align="right"><?php  if(isset($totalmdcamt) && $totalmdcamt!='' ) echo wordwrap(number_format($totalmdcamt, 2, '.', ','),12, "<br>\n", true); else 0;?></td>
                    <td align="right"><?php  if(isset($TotalsumRefund) && $TotalsumRefund!='' ) 
							echo wordwrap(number_format($TotalsumRefund, 2, '.', ','),12, "<br>\n", true);
							else 0;?></td>
                    <td align="right">
                        <?php 
						
						$pos = strpos($nu_account_balance,'-');
					if($pos!== false){
					echo "<b>(".trim(wordwrap(number_format($nu_account_balance, 2, '.', ','),30, "<br>\n", true),'-').")</b>";
					
					}else{				
			    	echo "<b>" . wordwrap(number_format($nu_account_balance, 2, '.', ','),30, "<br>\n", true). "</b>";
				 }
						

                        ?>
                    </td>
                </tr>

            </table>

            <br />
	<?php
			
			}
			if (isset($SearchfromDate) && $SearchfromDate !== '' && isset($SearchtoDate) && $SearchtoDate!='' && $totalrows>0){
			?>
        
            <table width="100%" cellspacing="1" cellpadding="3" border="0" >
                <tr class="listhead1">
                    <td width="3%" align="center">SI. No.</td>
                    <td width="8%" align="center">Transaction <br/>Type</td>
                    <td width="10%" align="center">Transaction <br/>Date</td>
                    <td width="12%" align="center">Remarks</td>
                    <td width="10%" align="center">Issue/Ref.<br/> Date</td>
                    <td width="12%" align="center">Card No.</td>
                    <td width="12%" align="center">Permit/Ref.<br/> No.</td>
                    <td width="11%" align="center">Vehicle <br/>Reg. No.</td>
                    <td width="10%" align="center">Net Amount <br/>(N$)</td>
                    <!--<td width="12%" align="center">Running Balance <br/>(N$)</td>-->
                </tr>

                <?php
                $i = 1;
			
                //pr($storeallValues);
				//die;
				$runningValue ='';
				
				if($pagecounter=='' || $pagecounter==1){
						 $runningValue = $funcopeningbalance;

				}else {
				 	$runningValue = $pageopeningbalance;
				}
				//echo  'pageopne--'.($pageopeningbalance-$funcopeningbalance);
									//pr($storeallValues);

						
                if (isset($storeallValues) && count($storeallValues) > 0) {
		        
				foreach ($storeallValues as $index => $value) {
            	$bracket=0;            
				
						//$remarks = $value['Temp']['Running'];
						$transaction_type = $value['Temp']['transaction_type'];
						
						$permit_refno = (isset($value['Temp']['permit_refno']) && $value['Temp']['permit_refno']!='' && $value['Temp']['permit_refno']!='NA')?$value['Temp']['permit_refno']:'N/A';
						$remarks      = (isset($value['Temp']['remarks']) && $value['Temp']['remarks']!='' && $value['Temp']['remarks']!='NA')?$value['Temp']['remarks']:'N/A';
						$cardno      = (isset($value['Temp']['cardno']) && $value['Temp']['cardno']!='' && $value['Temp']['cardno']!='NA')?$value['Temp']['cardno']:'N/A';
						$vehicleregno      = (isset($value['Temp']['vehicleregno']) && $value['Temp']['vehicleregno']!='' && $value['Temp']['vehicleregno']!='NA')?$value['Temp']['vehicleregno']:'N/A';

						$netamount    = $value['Temp']['netamount'];
						
						if ($value['Temp']['transaction_type'] == 'Recharge'){
							$transaction_type = 'Recharge';
							if($vehicleregno=='STSTY04')
							{
							$cardno='N/A';
							$vehicleregno='N/A';
							$permit_refno = $value['Temp']['permit_refno'];

 
							if($value['Temp']['netamount'] == 0)
							{
							 $netamount        = 0;				
							 $runningValue     = $runningValue+0;							 
							 $netamount        = $value['Temp']['netamount']-$globalParameterarray['CBCADMINFEE'];				
							 $runningValue = ($runningValue)+($netamount);

							 //$remarks = ;
							 //$remarks = $value['Temp']['netamount'];

							}else{
							//echo 'run--'.$runningValue;
							 $netamount        = $value['Temp']['netamount']-$globalParameterarray['CBCADMINFEE'];				
							 $runningValue = ($runningValue)+($netamount);
							 $remarks = $value['Temp']['netamount'].' - '.$globalParameterarray['CBCADMINFEE'].' ( Admin Fee )';
 
							}
							
							}else{
 
							if($value['Temp']['netamount'] == 0)
							{
							 $netamount        = 0;				
							 $runningValue     = $runningValue+0;							 
							 $remarks = 'Recharge  '.$globalParameterarray[$vehicleregno];
 
							 //$remarks = ;
							 //$remarks = $value['Temp']['netamount'];

							}else{
							//echo 'run--'.$runningValue;
							 $runningValue = ($runningValue)+0;
							 $remarks = 'Recharge  '.$globalParameterarray[$vehicleregno];
 
							}

							$cardno='N/A';
							$vehicleregno='N/A';
							$permit_refno = $value['Temp']['permit_refno'];

							}
						}
						
						if ($value['Temp']['transaction_type'] == 'Refund'){
							$transaction_type = 'Refund';
							if($vehicleregno=='STSTY04')
							{
							$vehicleregno='N/A';
							$cardno='N/A';
							$remarks = ' Refund from HO ';
							//VehicleRegNo							
							if($value['Temp']['netamount'] == 0)
							{
							// $netamount        = 'Pending';				
							 $runningValue     = $runningValue+0;
							}else{
							 //$netamount        = $value['Temp']['netamount']-$globalParameterarray['CBCADMINFEE'];				
							 $netamount        = $value['Temp']['netamount'];				
							 $runningValue = $runningValue+$netamount;
							}
							
						  }else {
						  
							$remarks = ' Refund '.$globalParameterarray[$vehicleregno].' from HO ';
							
							//VehicleRegNo							
							if($value['Temp']['netamount'] == 0)
							{
							// $netamount        = 'Pending';				
							 $runningValue     = $runningValue+0;
							}else{
							 //$netamount        = $value['Temp']['netamount']-$globalParameterarray['CBCADMINFEE'];				
							 $netamount        = $value['Temp']['netamount'];				
							 $runningValue = $runningValue+0;
							}
							$vehicleregno='N/A';
							$cardno='N/A';
							
						  }
						}
						
						
						
						if ($value['Temp']['transaction_type'] == 'CardsIssued'){
							$transaction_type = 'Card Issue';
								$bracket=1;
							if(isset($value['Temp']['running']) && $value['Temp']['running']>0){
							 $netamount= ($value['Temp']['running'])*($globalParameterarray['CBCADMINFEE']);
							 $bracket=1;
							
							 $runningValue = $runningValue-$netamount;
							}
						}
						
						if ($value['Temp']['transaction_type']!= 'Recharge' && $value['Temp']['transaction_type']!= 'CardsIssued' && $value['Temp']['transaction_type']!= 'Refund'){
							$bracket=1;
							$runningValue = $runningValue-$netamount;
							if($value['Temp']['transaction_type']== 'MDC' || $value['Temp']['transaction_type']== 'CBC')
							$remarks = $value['Temp']['remarks'];
											
						}
					    	//$_SESSION['incOpneingbal'][$limit]=$runningValue;
			
						   // $sr = $i % 2 == 0 ? '' : '1';
                            ?>		
                        <tr class="cont1">
                            <td align="right"><?php //$i++; 
							echo ((($pagecounter-1)*($limit))+($i++));  ?></td>
                            <td align="left"><?php 
							echo wordwrap ($transaction_type,12, "<br>\n", true);
							?></td>
                            <td align="left"><?php echo date('d-M-Y', strtotime($value['Temp']['transaction_date'])); ?></td>
                            <td align="left"><?php 
							echo wordwrap($remarks,15, "<br>\n", true);
							
							 ?></td>
                            <td align="left"><?php 
							
							
							echo (isset($value['Temp']['issue_ref_date']) && $value['Temp']['issue_ref_date']!='' && $value['Temp']['issue_ref_date']!='NA')?date('d-M-Y', strtotime($value['Temp']['issue_ref_date'])):'N/A'; ?></td>
                            <td align="right"><?php 	echo wordwrap($cardno,12, "<br>\n", true);
						 ?></td>
                            <td align="left"><?php echo wordwrap($permit_refno,12, "<br>\n", true);  ?></td>
                            <td align="left"><?php  echo wordwrap($vehicleregno,12, "<br>\n", true); ?></td>
							<?php if($bracket==1) {?>
                       <td align="right"><?php  echo '('.wordwrap(number_format($netamount, 2, '.', ''),20, "<br>\n", true).')'; ?></td>
					    <?php } else {?>

					   <td align="right"><?php  echo wordwrap(number_format($netamount, 2, '.', ','),20, "<br>\n", true); ?></td>
                            <?php }?>
							<!--<td colspan="2" align="right"><span class="valuetext"><?php 
							$pos = strpos($runningValue,'-');
							if($pos!== false){
							// echo '('.trim(wordwrap(number_format($runningValue, 2, '.', ','),30, "<br>\n", true),'-').')';

							}else{
						//	echo wordwrap(number_format($runningValue, 2, '.', ','),30, "<br>\n", true);
							}

							
							
						 ?></span></td>-->
                        </tr>
						


                    <?php
                    }?>
                <tr><td colspan="9" style="text-align:right;">
				<!--Closing Balance &nbsp;:&nbsp;	-->
								
				<?php
					$pos = strpos($runningValue,'-');
					if($pos!== false){
				//	echo "<b>(".trim(wordwrap(number_format($runningValue, 2, '.', ','),30, "<br>\n", true),'-').")</b>";
					
					}else{				
			    	//echo "<b>" . wordwrap(number_format($runningValue, 2, '.', ','),30, "<br>\n", true). "</b>";
				 }
				}else {?>
				  <tr><td colspan="9" style="text-align:center;">No Record found !!</td></tr>		
		  
		
				<?php }?>
					  <tr><td colspan="9">		
					  
					  
					  <?php
					  if(isset($SearchfromDate) && $SearchfromDate !== '' && !empty($SearchfromDate)){
						$SearchfromDate ; 
					}
          
					if(isset($SearchtoDate) && $SearchtoDate !== '' && !empty($SearchtoDate)){
						$SearchtoDate ; 
					}
      ?>
	  </td>
                    </tr>
					<?php }else {?>
					                <tr><td colspan='11' style="text-align:center;"><span style="width:100%; float:left; text-align:center;">No Record found !!</span></td></tr>

				<?php 	}?>

                <tr><td>	&nbsp;	</td></tr>
            </table>

        </div>
        <!-- end innerbody here-->       
        <?php
          
        ?>

 
        <table width="100%" border="0">

            <tr>
                <td align="center">
<?php
 if(isset($SearchfromDate) && $SearchfromDate !== '' && isset($SearchtoDate) && $SearchtoDate!='' ){
					
					$this->Paginator->options(array(
						'url' => array(
							'vc_from_date' => $SearchfromDate,
						  
							'vc_to_date' => $SearchtoDate
					)));
					echo $this->element('cbc/paginationfooter');
					}?>
					<?php //echo $this->Form->submit(NULL, array('label' => false, 'id' => '', 'value' => 'submit', 'class' => 'submit')); ?>


                </td>
            </tr>

        </table>

    </div>

<?php echo $this->Form->end(); ?>

    <!-- end mainbody here-->    

</div>

<!-- end wrapper here-->
<?php echo $this->Html->script('cbc/cbc_custstate_reports'); ?>

	