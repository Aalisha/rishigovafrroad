<?php $currentUser = $this->Session->read('Auth');?>

<!-- Start wrapper here-->

<div class="wrapper">
    <!-- Start breadcrumb here-->

    <div class="breadcrumb">
        <ul>
        <li class="first">
         <?php echo $this->Html->link('Home', array('controller' => 'customers', 'action' => 'view','cbc' =>true), array('title' => 'Home', 'class' => 'vtip')) ?>
        </li>        
        <li class="last">Customer Recharge Report</li>        
        </ul>
    </div>
    <!-- end breadcrumb here-->


    <!-- Start mainbody here-->

    <div class="mainbody">

        <h1>Welcome to RFA CBC</h1>
        <h3>Customer Recharge Report</h3>

    <!-- Start innerbody here-->
	        <div class="innerbody" >

			<?php 
				echo $this->Form->create('Cbcreport',array('url' => array('controller' => 'cbcreports', 'action' => 'customerrecharge','cbc'=>true))); 
			?>

		<table width="100%" border="0" cellpadding="3">
        
			<tr>
				<td><label class="lab-inner">Customer Name :</label></td>
				<td>								
				<?php 
					echo $this->Form->input( 'Cbcreport.vc_customer_name', array('label'=>false,
						'div' => false,
						'type' => 'text', 
						'id'=>'vc_customer_name' ,
						'disabled' => 'disabled',
						'value' => $currentUser['Customer']['vc_first_name'] . ' ' . $currentUser['Customer']['vc_surname'],
						'class'=>'round'));
				?>
			
			</td>
        
			<td><label class="lab-inner">Address 1 :</label></td>
			<td>
				<?php 
					echo $this->Form->input( 'Cbcreport.vc_address1', array( 'label'=>false,
																			'div' => false,
																			'type' => 'text', 
																			'value'=>$currentUser['Customer']['vc_address1'],
																			'disabled' => 'disabled',
																			'class'=>'round'));
				?>
								
								
			</td>
			
			<td><label class="lab-inner">Address 2 :</label></td>
			<td>
				<?php 
					echo $this->Form->input( 'Cbcreport.vc_address2', array( 'label'=>false,
																			'div' => false,
																			'type' => 'text', 
																			'value'=>$currentUser['Customer']['vc_address2'],
																			'disabled' => 'disabled',
																			'class'=>'round'));
				?>
			
			
			</td>
		</tr>
        
		<tr>
			<td><label class="lab-inner">Address 3 :</label></td>
			<td>
				<?php 
					echo $this->Form->input( 'Cbcreport.vc_address3', array( 'label'=>false,
																			'div' => false,
																			'type' => 'text',
																			'value'=>$currentUser['Customer']['vc_address3'],
																			'disabled' => 'disabled',
																			'class'=>'round')); 
				?>
			
			
			</td>
			
			<td><label class="lab-inner">Telephone No. :</label></td>
			<td>
				<?php 
					echo $this->Form->input( 'Cbcreport.vc_tel_no', array( 'label'=>false,
																		  'div' => false,
																		  'type' => 'text',
																		  'value'=>$currentUser['Customer']['vc_tel_no'],
																		  'disabled' => 'disabled',
																		  'class'=>'round')); 
				?>
			
			</td>
			
			<td><label class="lab-inner">Fax No. :</label></td>
			<td>
				<?php 
					echo $this->Form->input( 'Cbcreport.vc_fax_no', array('label'=>false,
																		 'div' => false,
																		 'type' => 'text',
																		 'value'=>$currentUser['Customer']['vc_fax_no'],
																		 'disabled' => 'disabled',
																		 'class'=>'round'));
				?>
			</td>
      
		</tr>
            
		<tr>
			<td><label class="lab-inner">Mobile No. :</label></td>
			<td>
				<?php 
					echo $this->Form->input( 'Cbcreport.vc_mobile_no', array('label'=>false,
																			'div' => false,
																			'type' => 'text',
																			'value'=>$currentUser['Customer']['vc_mobile_no'],
																			'disabled' => 'disabled',
																			'class'=>'round'));
				?>
			
			</td>
			
			<td><label class="lab-inner">Email :</label></td>
			<td>
				<?php 
					echo $this->Form->input( 'Cbcreport.vc_email', array( 'label'=>false,
																			'div' => false,
																			'type' => 'text',
																			'value'=>$currentUser['Customer']['vc_email'],
																			'disabled' => 'disabled',
																			'class'=>'round')); 
				?>
			
			</td>
			
			<td>&nbsp;</td>
			<td>&nbsp;</td>
        
		</tr>
		<tr>
			<td><label class="lab-inner">From Date :</label></td>
			<td><span class="valuetext">
			
				<?php 	
				$SearchfromDate = !empty ($SearchfromDate) ? date('d M Y',  strtotime($SearchfromDate)):'';
				echo $this->Form->input( 'fromdate', array( 'label'=>false,
																			'div' => false,
																			'type' => 'text',
																			'id' => 'fromDate',
																			'readonly' => 'readonly',
																			'value' => $SearchfromDate,
																			'class'=>'round')); 
				?></span></td>
			<td><label class="lab-inner">To Date :</label></td>
			<td><span class="valuetext">
				<?php 	
				 $SearchtoDate = !empty ($SearchtoDate) ? date('d M Y',  strtotime($SearchtoDate)):'';
				echo $this->Form->input( 'todate', array( 'label'=>false,
																			'div' => false,
																			'type' => 'text',
																			'id' => 'toDate',
																			'readonly' => 'readonly',
																			'value' => $SearchtoDate,
																			'class'=>'round')); 
				?>
				</span></td>
				<td>&nbsp;</td>
			<td label class="lab-inner" align="right">
							<?php echo $this->Form->submit('Submit', array('class' => 'submit')); ?>
							
			</td>
		
		</tr>
	</table>
		<?php echo $this->Form->end(null); ?>
        </div>
        <div id='ajaxdata' class="innerbody">

            <?php echo $this->Form->create('Cbcreport', array('url' => array('controller' => 'cbcreports', 'action' => 'customer_recharge_pdf' ,'cbc' => true))); ?>

            <table width="100%" border="0" cellpadding="3" class ="customersInfo">
                <tr>
                    <td width="10%"><label class="lab-inner">Customer Name :</label></td>
                    <td width="10%"><span class="valuetext"><?php echo ucfirst($customername); ?></span></td>
                    <td width="10%"><label class="lab-inner">

                            <?php
                            if ($SearchfromDate !== '' && !empty($SearchfromDate)) {

                                $SearchfromDate = date('d-M-Y', strtotime($SearchfromDate));
                                ?>
                                From Date :
                            <?php } ?>
                        </label>
                    </td>
                    <td width="10%"><span class="valuetext"><?php echo $SearchfromDate; ?></span></td>
                    <td width="10%"><label class="lab-inner">
                            <?php
                            if ($SearchtoDate !== '' && !empty($SearchtoDate)) {

                                $SearchtoDate = date('d-M-Y', strtotime($SearchtoDate));
                                ?>
                                To Date :
                            <?php } ?>
                        </label>
                    </td>
                    <td width="10%"><span class="valuetext"><?php echo $SearchtoDate; ?></span></td>
                    <td width="10%"  align="right">

                        <?php
                        echo $this->Form->hidden('fromdate', array('value' => $SearchfromDate));

                        echo $this->Form->hidden('todate', array('value' => $SearchtoDate));
                        if (count($report) > 0):
                            echo $this->Form->submit('Print Report', array(
                                'label' => false,
                                'type' => 'submit',
                                'div' => false,
                                'class' => 'submit'));
                        endif;
                        ?>
                    </td>
                </tr>
            </table>

            <?php echo $this->Form->end(null); ?>

            <br />
            <table width="100%" cellspacing="1" cellpadding="5" border="0">
                <tr class="listhead1">
                    <td width="4%" align="center">SI. <br/>No.</td>
                    <td width="9%" align="center">Recharge <br/>Date</td>
                    <td width="12%" align="center">Cheque/Bank Ref.<br/> No.</td>
                    <td width="11%" align="center">Cheque/Bank <br/>Ref. Date</td>
                    <td width="14%" align="center">Recharge <br/>Amount (N$)</td>
                    <td width="14%" align="center">Approved <br/>Amount (N$)</td>
                    <td width="7%" align="center">Admin <br/>Fee (N$)</td>
                    <td width="16%" align="center">Net Amount (N$)</td>
                    <td width="8%" align="center">Recharge <br/>Status</td>
                    <td width="4%" align="center">Reason</td>
                </tr>
                <?php
                if (count($report) > 0) {

                    $i = 1;

                    foreach ($report as $val) {
                        ?>

                        <tr class="cont1">
                            <td align="right">

                                <?php
                                echo $start;
                                ?>
                            </td>
                            <!-- <td><?php echo $currentUser['vc_user_firstname'] . ' ' . $currentUser['vc_user_lastname'] ?></td>-->
                            <td align="left">
							
								<?php 
									 $entryDate = !empty($val['AccountRecharge']['dt_entry_date']) ?
                                                  date('d-M-Y', strtotime($val['AccountRecharge']['dt_entry_date'])):
                                                  '';
								?>

                                <?php
                                echo $entryDate;
                                ?>
                            </td>
                            <td align="left">

                                <?php
                                echo wordwrap($val['AccountRecharge']['vc_ref_no'], 13, "<br>\n", true);
                                ?>
                            </td>
                            <td align="left">
							
								<?php $paymentDate = !empty($val['AccountRecharge']['dt_payment_date']) ?
                                                  date('d-M-Y', strtotime($val['AccountRecharge']['dt_payment_date'])):
                                                  '';
                               
								?>

                                <?php
                                echo $paymentDate;
                                ?>
                            </td>
                            <td align="right">

                                <?php
                                echo wordwrap(number_format($val['AccountRecharge']['nu_amount_un'], 2, '.', ','), 25, "<br>\n", true);
                                ?>
                            </td>
							<td align="right">

                                <?php
                                echo wordwrap(number_format($val['AccountRecharge']['nu_amount'], 2, '.', ','), 25, "<br>\n", true);
                                ?>
                            </td>
                            <td align="right">

                                <?php
                                echo wordwrap(number_format($val['AccountRecharge']['nu_hand_charge'], 2, '.', ','), 12, "<br>\n", true);
                                ?>
                            </td>
                            <td align="right">

                                <?php
                                if ($val['AccountRecharge']['vc_recharge_status'] == 'STSTY04' && !empty($val['AccountRecharge']['nu_amount']) && $val['AccountRecharge']['nu_amount'] > 100) {
                                    echo wordwrap(number_format((($val['AccountRecharge']['nu_amount']) - 100), 2, '.', ','), 25, "<br>\n", true);
                                }else {
								echo 'N/A';
								}
                                ?>
                            </td>
                            <td align="left">

                                <?php
                                echo $globalParameterarray[$val['AccountRecharge']['vc_recharge_status']];
                                ?>
                            </td>
							
						        <?php if( trim( $val['AccountRecharge']['vc_recharge_status'] == 'STSTY05' )) {?>
								
							<td style='text-align:center;'> 
								
								<?php 
								
								echo $this->Html->image('remarks.jpg', array('alt' => '', 'id'=>'imgedt'.$val, 'title'=>'View Remarks','style'=>' cursor: pointer;')); 
								
								?>
							
							</td>
							
								<?php } else { ?>
							
									<td style='text-align:center;'> 
										<?php $novalue='N/A';	echo $novalue;?>
									</td>
								
								<?php }
								
									echo $this->Form->input(null, 
														array('label' => false,
															'div' => false,
															'type' => 'hidden',
															'id'=>false,
															'name'=>false,
															'value'=>base64_encode($val['AccountRecharge']['nu_acct_rec_id'])));	
								?>
					    </tr>
                        <?php
                        $i++;
                        $start++;
                    }//end foreach
                } else {
                    ?>

                    <tr class="cont1" style='text-align: center'>

                        <td colspan='10'> No Record Found !! </td>

                    </tr>
                <?php } ?>


            </table>
			
				<?php
				
					$this->Paginator->options(array(
						'url' => array(
							'fromDate' => $SearchfromDate,
							'toDate' => $SearchtoDate
							)));

					if (count($report) > 0) {
						
						echo $this->element('cbc/paginationfooter');
						
					}	
				?>

        </div>
        <!-- end innerbody here-->
    </div>
				
    <!-- end mainbody here-->    

</div>
<!-- end wrapper here-->
<?php echo $this->element('commonmessagepopup'); ?>
<?php echo $this->Html->script('cbc/recharge-report'); ?>
<?php echo $this->Html->script('cbc/cbc_reports'); ?>