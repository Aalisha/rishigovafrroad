<?php $profile = $this->Session->read('Auth'); ?>
<!-- Start wrapper here-->
<div class="wrapper">
    <!-- Start breadcrumb here-->
    <div class="breadcrumb">
        <ul>
            <li class="first">
                <?php echo $this->Html->link('Home', array('controller' => 'profiles', 'action' => 'index'), array('title' => 'Home', 'class' => 'vtip')) ?>
            </li>
            <li class="last">Customer Payment History Report</li>
        </ul>
    </div>
    <!-- end breadcrumb here-->
    <!-- Start mainbody here-->
    <div class="mainbody">
        <h1><?php echo $mdclocal;?></h1>
        <h3>Customer Payment History Report</h3>
        <!-- Start innerbody here-->
        <div class="innerbody">
            <?php echo $this->Form->create('Report', array('url' => array('controller' => 'reports', 'action' => 'paymenthistory'))); ?>
            <table width="100%" border="0" cellpadding="3">
                <tr>
                    <td width="13%" valign="top"><label class="lab-inner">From Date :</label></td>
                    <td width="18%" valign="top" class="align-left">
                        <?php
                        $fromDate = !empty($fromDate) ? date('d M Y', strtotime($fromDate)) : '';
                        echo $this->Form->input('fromdate', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'readonly'=>'readonly',
                            'id' => 'fromDate',
                            'maxlength' => 12,
                            'value' => $fromDate,
                            'class' => 'round2'));
                        ?>
                    </td>
                    <td width="13%" valign="top" ><label class="lab-inner">To Date :</label></td>
                    <td width="17%" valign="top" class="align-left"><?php
                        $toDate = !empty($toDate) ? date('d M Y', strtotime($toDate)) : '';
                        echo $this->Form->input('todate', array(
                            'label' => false,
                            'div' => false,
                            'type' => 'text',
                            'id' => 'toDate',
                            'readonly'=>'readonly',
                            'maxlength' => 12,
                            'value' => $toDate,
                            'class' => 'round2'));
                        ?>
                    </td>
					<td align="left" valign="top">
				Company Name :</td>
				<td valign="top"><?php
				//echo 'nu-company-id'.$nu_company_id;
                        echo $this->Form->input('nu_company_id', array('label' => false,
                            'div' => false,
                            'type' => 'select',
                            'options' => array('All') + $CompanyId,
                            'default' => $nu_company_id,
							'class' => 'round_select round2')
                        );
                        ?></td>
                    <td width="9%" valign="top" align="center">
                        <?php echo $this->Form->submit('Submit', array('class' => 'submit')); ?>
                    </td>
                </tr>      
            </table>
            <?php echo $this->Form->end(null); ?>
        </div>
        <div id='ajaxdata' class="innerbody">

            <?php echo $this->Form->create('Report', array('url' => array('controller' => 'reports', 'action' => 'paymenthistorypdf'))); ?>
            <table width="100%" border="0" cellpadding="3">
                <tr>
                    <td width="10%"><label class="lab-inner">RFA Account No. :</label></td>
                    <td width="10%"><span class="valuetext"><?php echo $profile['Profile']['vc_customer_no']; ?></span></td>
                    <td width="10%">
                        <label class="lab-inner">
                            <?php
                            if (!empty($fromDate)) {
                                $fromDate = date('d M Y', strtotime($fromDate));
                                ?>
                                From Date :
                            <?php } ?>
                        </label>
                    </td>
                    <td width="10%"><span class="valuetext"><?php echo $fromDate; ?></span></td>
                    <td width="5%">
                        <label class="lab-inner">
                            <?php
                            if (!empty($toDate)) {
                                $toDate = date('d M Y', strtotime($toDate));
                                ?>
                                To Date :
                            <?php } ?>

                        </label>
                    </td>
                    <td width="10%"><span class="valuetext"><?php echo $toDate; ?> </span></td>
                    <td width="8%">&nbsp;</td>

                </tr>
                
                <tr>
                    <td width="10%"><label class="lab-inner">Customer Name :</label></td>
                    <td width="10%"><span class="valuetext"><?php echo $profile['Profile']['vc_customer_name']; ?></span></td>
                     <td width="10%">
                        <label class="lab-inner">
                           <?php
						   if(!empty($nu_company_id)) {
                            ?>
                            Company Name :
                           <?php } ?>
                        </label>
                    </td>
                    <td  width="20%"><span class="valuetext"><?php echo wordwrap(ucfirst($company_name['Company']['vc_company_name']), 25, "<br>\n", true); ?></span></td>
                    <td width="5%">&nbsp;</td>
                    <td width="5%">&nbsp;</td>
                    <td width="10%" align="right">
                        <?php
                        echo $this->Form->hidden('fromDate', array('value' => $fromDate));
                        echo $this->Form->hidden('toDate', array('value' => $toDate));
						echo $this->Form->hidden('nu_company_id', array('value' => $nu_company_id));

                        if (count($paymentreport) > 0):

                            echo $this->Form->button('Print Report', array(
                                'label' => false,
                                'type' => 'submit',
                                'div' => false,
                                'class' => 'textbutton1 submit'));
                        endif;
                        ?>
                    </td>

                </tr>
                
            </table>

            <?php echo $this->Form->end(null); ?>
            <table width="100%" cellspacing="1" cellpadding="5" border="0" >
                <tr class="listhead1">
                    <td width="5%" align="center">SI. No.</td>
					<?php if(empty($nu_company_id)) {?>
                                    <td  width="10%" align="center">Company name</td>
					<?php } ?>
                    <td width="15%" align="center">Assessment No.</td>
                    <td width="15%" align="center">Assessment Date</td>
                    <td width="10%" align="center">Payable Amount (N$)</td>
                    <td width="10%" align="center">Paid Amount (N$)</td>
                    <td width="10%" align="center">Variance Amount (N$)</td>
                    <td width="15%" align="center">Payment Date</td>
                    <td width="15%" align="center">Payment Status</td>
                </tr>


                <?php if (count($paymentreport) > 0) : ?>	
                    <?php $i = 1;
                    foreach ($paymentreport as $showpaymentreport) : $sr = $i % 2 == 0 ? '' : '1'; ?>      

                        <tr class="cont1">
                            <td align="center"><?php echo ((($pagecounter - 1) * ($limit)) + $i); ?></td>
								
							<?php if(empty($nu_company_id)) {?>
							
                                <td align="left"><?php echo $CompanyId[$showpaymentreport['AssessmentVehicleMaster']['nu_company_id']]; ?></td>
                           
							<?php } ?>	
							
                            <td ><?php echo $showpaymentreport['AssessmentVehicleMaster']['vc_assessment_no']; ?></td>
                            <?php
                            $AssMntDate = !empty($showpaymentreport['AssessmentVehicleMaster']['dt_assessment_date']) ?
                                    date('d M Y', strtotime($showpaymentreport['AssessmentVehicleMaster']['dt_assessment_date'])) :
                                    '';
                            ?>
                            <td>
                                <?php echo $AssMntDate; ?>
                            </td>
                            <td align="right">
                                
                                <?php
                                $TotAmtPayable = isset($showpaymentreport['AssessmentVehicleMaster']['nu_total_payable_amount']) ? 
                                $this->Number->format($showpaymentreport['AssessmentVehicleMaster']['nu_total_payable_amount'], array(
                                'places' => 2,
                                'before' => false,
                                'escape' => false,
                                'decimals' => '.',
                                'thousands' => ','
                                )):'';

                                echo $TotAmtPayable; 
                               ?>
                                
                                
                           </td>
                            <td align="right">
                            <?php
                                $MdcPaid = isset($showpaymentreport['AssessmentVehicleMaster']['vc_mdc_paid']) ? 
                                $this->Number->format($showpaymentreport['AssessmentVehicleMaster']['vc_mdc_paid'], array(
                                'places' => 2,
                                'before' => false,
                                'escape' => false,
                                'decimals' => '.',
                                'thousands' => ','
                                )):'';

                                echo $MdcPaid; 
                               ?>
                           </td>
                            <td align="right">
                            <?php
						$VarianceAmount=(float)($showpaymentreport['AssessmentVehicleMaster']['nu_total_payable_amount'])-(float)($showpaymentreport['AssessmentVehicleMaster']['vc_mdc_paid']);
                                $VarianceAmount = isset($VarianceAmount) ? 
                                $this->Number->format($VarianceAmount, array(
                                'places' => 2,
                                'before' => false,
                                'escape' => false,
                                'decimals' => '.',
                                'thousands' => ','
                                )):'';

                                echo $VarianceAmount; 
                               ?>
                           </td>
                            <?php
                            $PayMntDate = isset($showpaymentreport['AssessmentVehicleMaster']['dt_received_date']) ?
                                    date('d M Y', strtotime($showpaymentreport['AssessmentVehicleMaster']['dt_received_date'])) :
                                    '';
                            ?>

                            <td><?php echo $PayMntDate; ?></td>
                            <td><?php echo $showpaymentreport['PaymentStatus']['vc_prtype_name']; ?></td>
                        </tr>

                        <?php $i++;
                    endforeach; ?>
                <?php else : ?>
				<?php if(empty($nu_company_id)) {?>
					<tr class="cont1" style='text-align:center;'>
                        <td colspan='9'> No Record Found </td>
                    </tr>				
				<?php }else{ ?>
					<tr class="cont1" style='text-align:center;'>
                        <td colspan='8'> No Record Found </td>
                    </tr>				
				<?php } ?>
				<?php endif; ?>
            </table>
            <?php
            $this->Paginator->options(array(
                'url' => array(
                    'fromDate' => $fromDate,
                    'todate' => $toDate,
					'nu_company_id' => $nu_company_id
                    )));
            ?>	
            <?php echo $this->element('paginationfooter'); ?>
        </div>
        <!-- end innerbody here-->
    </div>
    <!-- end mainbody here-->    
</div>
<!-- end wrapper here-->
<?php echo $this->Html->script('mdc/payments-report'); ?>