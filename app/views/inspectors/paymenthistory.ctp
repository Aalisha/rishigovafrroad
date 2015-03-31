<!-- Start wrapper here-->
<div class="wrapper">
    <!-- Start breadcrumb here-->
    <div class="breadcrumb">
        <ul>
            <li class="first">
                <?php echo $this->Html->link('Home', array('controller' => 'inspectors', 'action' => 'index'), array('title' => 'Home', 'class' => 'vtip')) ?>
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
            <?php echo $this->Form->create('Inspector', array('url' => array('controller' => 'inspectors', 'action' => 'paymenthistory'))); ?>
            <table width="100%" border="0" cellpadding="3">
                <tr>
                    <td valign='top' width="13%"><label class="lab-inner">From Date :</label></td>
                    <td valign='top' width="20%">
                        <?php
                        $fromDate = !empty($fromDate)?date('d M Y',  strtotime($fromDate)):'';
                        echo $this->Form->input('fromdate', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'id' => 'fromDate',
                           
                            'value' =>$fromDate,
                            'class' => ' dateseclect round2'));
                        ?>
                    </td>
                    <td valign='top' width="13%"><label class="lab-inner">To Date :</label></td>
                    <td valign='top'  width="15%">
                        <?php
                        $toDate = !empty($toDate)?date('d M Y',  strtotime($toDate)):'';
                        echo $this->Form->input('todate', array(
                            'label' => false,
                            'div' => false,
                            'type' => 'text',
                            'id' => 'toDate',
                            'value' => $toDate,
                            'class' => 'dateseclect round2'));
                        ?>
                    </td>

                    <td valign='top'  width="17%"><span class="valuetext">Customer Name</span></td>
                    <td  valign='top' width="18%">
                        <?php
                        echo $this->Form->input('vc_customer_name', array(
                            'label' => false,
                            'div' => false,
                            'type' => 'text',
                            'id' => 'vc_customer_name',
                            'maxlength' => 100,
                            'value' => $vc_customer_name,
                            'class' => 'round2'));
                        ?>
                    </td>

                    <td valign='top'  width="15%" align="center">
                        <?php echo $this->Form->submit('Submit', array('class' => 'submit')); ?>
                    </td>
                </tr>      
            </table>
            <?php echo $this->Form->end(null); ?>
        </div>
        <div id='ajaxdata' class="innerbody">

            <?php echo $this->Form->create('Inspector', array('url' => array('controller' => 'inspectors', 'action' => 'paymenthistorypdf'))); ?>
            <table width="100%" border="0" cellpadding="3">
                <tr>
                    <td width="10%"><label class="lab-inner"><?php if($vc_customer_name!=''){ ?>Customer Name :
					
					<?php }?></label></td>
                    <td width="10%"><span class="valuetext"><?php echo $vc_customer_name; ?></span></td>
                    <td width="10%"><label class="lab-inner"><?php if($fromDate!=''){ ?>From Date :
					<?php }?>
					</label></td>
                    <td width="10%"><span class="valuetext"><?php echo !empty($fromDate)?date('d M Y',  strtotime($fromDate)):''; ?></span></td>
                    <td width="10%"><label class="lab-inner"><?php if($toDate!=''){ ?>To Date :
					<?php }?>
					</label></td>
                    <td width="10%"><span class="valuetext"><?php echo  !empty($toDate)?date('d M Y',  strtotime($toDate)):''; ?> </span></td>
                    <td width="10%"  align="right">
                        <?php
                        echo $this->Form->hidden('fromDate', array('value' => $fromDate));
                        echo $this->Form->hidden('toDate', array('value' => $toDate));
                        echo $this->Form->hidden('vc_customer_name', array('value' => $vc_customer_name));
						if (count($paymentreport) > 0) :
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
                    <td width="15%" align="center">Assessment No.</td>
                    <td width="15%" align="center">Customer Name</td>
                    <td width="15%" align="center">Assessment Date</td>
                    <td width="10%" align="center">Payable Amount (N$)</td>
                    <td width="10%" align="center">Paid Amount (N$)</td>
                    <td width="15%" align="center">Payment Date</td>
                    <td width="15%" align="center">Payment Status</td>
                </tr>


                <?php if (count($paymentreport) > 0) : ?>	
                    <?php $i = 1;
                    foreach ($paymentreport as $showpaymentreport) : $sr = $i % 2 == 0 ? '' : '1'; ?>      


                        <tr class="cont<?php echo $sr;?>">
                            <td align="center"><?php echo $start; ?></td>
                            <td ><?php echo $showpaymentreport['AssessmentVehicleMaster']['vc_assessment_no']; ?></td>
                            <td ><?php echo ucfirst($showpaymentreport['AssessmentVehicleMaster']['vc_customer_name']); ?></td>
                            <td>
                                <?php echo date('d M Y', strtotime($showpaymentreport['AssessmentVehicleMaster']['dt_assessment_date'])); ?>
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
                            <?php
                                    $paymentDate = !empty($showpaymentreport['AssessmentVehicleMaster']['dt_received_date'])?
                                                        date('d M Y',strtotime($showpaymentreport['AssessmentVehicleMaster']['dt_received_date'])):
                                                          '';
                                ?>
                            <td><?php echo $paymentDate; ?></td>
                            <td><?php echo $showpaymentreport['PaymentStatus']['vc_prtype_name']; ?></td>
                        </tr>

                        <?php $i++; $start++;
                    endforeach; ?>
                <?php else : ?>
                    <tr class="cont1" style='text-align:center;'>
                        <td colspan='8'> No Record Found </td>
                    </tr>
                <?php endif; ?>
            </table>
            <?php
            $this->Paginator->options(array(
                'url' => array(
                    'fromDate' => $fromDate,
                    'toDate' => $toDate,
                    'vc_customer_name' => $vc_customer_name
                    )));
            ?>	
            <?php echo $this->element('paginationfooter'); ?>
        </div>
        <!-- end innerbody here-->
    </div>
    <!-- end mainbody here-->    
</div>
<!-- end wrapper here-->
<?php echo $this->Html->script('inspector/insp-paymentreport'); ?>