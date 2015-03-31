<?php $profile['Profile'] = $this->Session->read('Auth.Profile'); ?>
<!-- Start breadcrumb here-->
<div class="breadcrumb">
    <ul>
        <li class="first">
            <?php echo $this->Html->link('Home', array('controller' => 'profiles', 'action' => 'index'), array('title' => 'Home', 'class' => 'vtip')); ?>
        </li>

        <li class="last">Customer Assessment Details</li>     
    </ul>
</div>
<!-- end breadcrumb here-->
<!-- Start mainbody here-->


<div class="mainbody">
    <h1><?php echo $mdclocal;?></h1>
    <h3>Customer Assessment Details</h3>
	<div class="innerbody">
	<?php echo $this->Form->create('VehicleRegistrationCompany', array('url' => array('controller' => 'vehicles', 'action' => 'companysubmit'), 'type' => 'file','enctype'=>'multipart/form-data')); ?>
           <table  width="100%"> <tr>
                <td align="left" width="15%">
				Company Name :</td>
				<td width="18%"><?php
				//echo 'nu-company-id'.$nu_company_id;
                        echo $this->Form->input('VehicleDetail.nu_company_id', array('label' => false,
                            'div' => false,
                            'type' => 'select',
                            'tabindex'=>'3',
							'required' => 'required',
                            'options' => $CompanyId,
                            'default' => $nu_company_id,
                            'onchange' => "formsubmit('VehicleRegistrationCompanyViewassessmentForm');",
                            'maxlength' => 30,
                            'class' => 'round_select')
                        );
                        ?></td>
						<td align="right"><?php 
						$assessmentno=0;
						echo $this->Html->link('Statement', array('action'=>'downloadPrintReceipt', $assessmentno), array('class' => 'textbutton1')); ?></td>
            </tr></table>
			<?php echo $this->Form->end(null); ?>
	</div>
    <!-- Start innerbody here-->
    <div class="innerbody">
        <table width="100%" border="0" cellpadding="3">
            <tr>
                <td width="13%"><label class="lab-inner">A/C. Open Date :</label></td>
                <td width="22%">
                    <?php
                    $AccOpeDate = !empty($profile['Profile']['dt_account_create_date']) ?
                            date('d M Y', strtotime($profile['Profile']['dt_account_create_date'])) : '';
                    echo $this->Form->input('AssessmentVehicleMaster.dt_account_create_date', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'disabled' => 'disabled',
                        'value' => $AccOpeDate,
                        'class' => 'round'));
                    ?>

                </td>
                <td width="11%"><label class="lab-inner">RFA A/C. No. :</label></td>
                <td width="19%">
                    <?php
                    echo $this->Form->input('AssessmentVehicleMaster.vc_customer_no', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'disabled' => 'disabled',
                        'value' => $profile['Profile']['vc_customer_no'],
                        'class' => 'round'));
                    ?>

                </td>
            </tr>
            <tr>
                <td><label class="lab-inner">Customer Name :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('AssessmentVehicleMaster.vc_customer_name', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_customer_name',
                        'disabled' => 'disabled',
                        'value' => $profile['Profile']['vc_customer_name'],
                        'class' => 'round'));
                    ?>
                    <!--<input type="text" class="round" />-->
                </td>
                <td><label class="lab-inner">Customer ID. :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('AssessmentVehicleMaster.vc_customer_id', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_customer_id',
                        'disabled' => 'disabled',
                        'value' => $profile['Profile']['vc_customer_id'],
                        'class' => 'round'));
                    ?>
                    <!--<input type="text" class="round" />-->
                </td>
            </tr>
            <tr>
                <td><label class="lab-inner">Street Name  :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('AssessmentVehicleMaster.vc_address1', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_address1',
                        'disabled' => 'disabled',
                        'value' => $profile['Profile']['vc_address1'],
                        'class' => 'round'));
                    ?>

                </td>
                <td><label class="lab-inner">House No. :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('AssessmentVehicleMaster.vc_address2', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_address2',
                        'disabled' => 'disabled',
                        'value' => $profile['Profile']['vc_address2'],
                        'class' => 'round'));
                    ?>

                </td>
            </tr>
            <tr>
                <td><label class="lab-inner">P.O Box :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('AssessmentVehicleMaster.vc_po_box', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_po_box',
                        'disabled' => 'disabled',
                        'value' => $profile['Profile']['vc_address3'],
                        'class' => 'round'));
                    ?>
                </td>
				<td valign='top' ><label class="lab-inner">Town/City :</label></td>
                    <td valign='top' >
                        <?php
                        echo $this->Form->input('AssessmentVehicleMaster.vc_town', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'id' => 'vc_town',
                            'disabled' => 'disabled',
                            'value' => $profile['Profile']['vc_town'],
                            'class' => 'round'));
                        ?>

                    </td>

            </tr>
            <tr>
                <td><label class="lab-inner">Fax No. :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('AssessmentVehicleMaster.vc_fax_no', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_fax_no',
                        'disabled' => 'disabled',
                        'value' => $profile['Profile']['vc_fax_no'],
                        'class' => 'round'));
                    ?>

                </td>
                <td><label class="lab-inner">Mobile No. :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('AssessmentVehicleMaster.vc_mobile_no', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_mobile_no',
                        'disabled' => 'disabled',
                        'value' => $profile['Profile']['vc_mobile_no'],
                        'class' => 'round'));
                    ?>

                </td>
            </tr>
			<tr>
                <td><label class="lab-inner">Telephone No. :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('AssessmentVehicleMaster.vc_tel_no', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_tel_no',
                        'disabled' => 'disabled',
                        'value' => $profile['Profile']['vc_tel_no'],
                        'class' => 'round'));
                    ?>

                </td>
				
                <td><label class="lab-inner">Email :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('AssessmentVehicleMaster.vc_email_id', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_email_id',
                        'disabled' => 'disabled',
                        'value' => $profile['Profile']['vc_email_id'],
                        'class' => 'round'));
                    ?>

                </td></tr>
            <tr>
			
                <td><label class="lab-inner">Variance Amt. :</label></td>
                <td>
                    <?php
					//number_format($profile['Profile']['nu_variance_amount'],'2','.',',')
					//$profile['Profile']['nu_variance_amount']
                    echo $this->Form->input('AssessmentVehicleMaster.nu_variance_amount', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'nu_variance_amount',
                        'disabled' => 'disabled',
                        'value' => '',
                        'class' => 'round'));
                    ?>

                </td>
                <td><!--<label class="lab-inner">Email :</label>--></td>
                <td>
                    <?php
                    /*echo $this->Form->input('AssessmentVehicleMaster.vc_email_id', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_email_id',
                        'disabled' => 'disabled',
                        'value' => $profile['Profile']['vc_email_id'],
                        'class' => 'round'));
                    */?>

                </td>
            </tr>

        </table>
        <br>
        <div class='listsr1'>
            <table width="100%"  cellspacing="1" cellpadding="5" border="0" >
                <thead>
                    <tr class="listhead">
                        <td>Assessment Date</td>
                        <td>Assessment No.</td>
                        <td>Assessment Status</td>
                        <td>Assessment Payment</td>
                        <td>Payable Amount</td>
                        <td>Paid Amount</td>
                        <td>From Date </td>
                        <td>To Date</td>
						<td>Action</td>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($data) > 0) : ?>

                        <?php $i = 1;
                        foreach ($data as $key => $value) : $sr = $i % 2 == 0 ? '' : '1'; 
						// echo ((($pagecounter-1)*($limit))+$i); 
						?>

                            <?php
                            $fromDate = date('01-M-Y', strtotime($value['AssessmentVehicleMaster']['vc_pay_month_from'] . '' . $value['AssessmentVehicleMaster']['vc_pay_year_from']));

                            $toDate = date('t-M-Y', strtotime($value['AssessmentVehicleMaster']['vc_pay_month_to'] . '' . $value['AssessmentVehicleMaster']['vc_pay_year_to']));
                            ?>

                            <tr class="cont<?php echo $sr ?>" >
                                <td>

                                    <?php
                                    echo date('d M Y', strtotime($value['AssessmentVehicleMaster']['dt_assessment_date']));
                                    ?>

                                </td>
                                <td>
                                    <?php
                                    echo $this->Html->link($value['AssessmentVehicleMaster']['vc_assessment_no'], array('controller' => 'vehicles', 'action' => 'showassessmentdetail',base64_encode($value['AssessmentVehicleMaster']['vc_assessment_no'])));
                                    ?>

                                </td>
                                <td>
                                    <?php
                                    echo $value['AssessmentStatus']['vc_prtype_name'];
                                    ?>

                                </td>
                                <td>
                                    <?php
										
										echo $value['PaymentStatus']['vc_prtype_name'];

                                    
                                    ?>

                                </td>
                                <td align="right">
                                    <?php
                                    echo number_format($value['AssessmentVehicleMaster']['nu_total_payable_amount'], 2, '.', ',');
                                    ?>

                                </td>
                                <td align="right">
                                    <?php
                                    echo number_format($value['AssessmentVehicleMaster']['vc_mdc_paid'], 2, '.', ',');
                                    ?>

                                </td>
                                <td>
                                    <?php
                                    echo $fromDate;
                                    ?>

                                </td>

                                <td>
                                    <?php
                                    echo $toDate;
                                    ?>

                                </td>
								
								 <td style="text-align:center;">
                                     <?php
										if ($value['PaymentStatus']['vc_prtype_code'] == 'STSTY01' || $value['PaymentStatus']['vc_prtype_code'] == 'STSTY05' ) :

											$url = $this->webroot . 'payments/index/' . base64_encode($value['AssessmentVehicleMaster']['vc_assessment_no']);
											echo $this->Form->button('Pay Now', array(
												'label' => false,
												'type' => 'button',
												'onclick' => "javascript:window.location='$url'",
												'div' => false,
												'rel' => 'addlog0',
												'class' => 'round5'));
										else :
										
											echo 'N/A';

										endif;
                                    ?>

                                </td>


                            </tr>

                        <?php endforeach; ?>

                    <?php else : ?>

                        <tr class="cont1">

                            <td colspan='9' style="text-align:center;" > No Record Found !!</td>

                        <tr>
                        <?php endif; ?>
                </tbody>
            </table>
        </div>	
    </div>
    <!-- end innerbody here-->
</div>