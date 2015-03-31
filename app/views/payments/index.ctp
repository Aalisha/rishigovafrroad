<?php $profile['Profile'] = $this->Session->read('Auth.Profile'); ?>
<!-- Start breadcrumb here-->
<div class="breadcrumb">
    <ul>
        <li class="first">
            <?php echo $this->Html->link('Home', array('controller' => 'profiles', 'action' => 'index'), array('title' => 'Home', 'class' => 'vtip')) ?>
        </li>

        <li class="last">Customer Payment Details</li>        
    </ul>
</div>
<!-- end breadcrumb here-->
<!-- Start mainbody here-->


<div class="mainbody">
    <h1><?php echo $mdclocal;?></h1>
    <h3>Customer Assessment Details</h3>
	    <!--	<div class="innerbody">

		<table> <tr>
                <td align="left" width="2%">
				Company Name :</td>
				<td width="18%"><?php
				//echo 'nu-company-id'.$nu_company_id;
                       /* echo $this->Form->input('VehicleDetail.nu_company_id', array('label' => false,
                            'div' => false,
                            'type' => 'select',
                            'options' => $CompanyId,
                            'default' => $nu_company_id,
							'disabled' => true,
                            'class' => 'round_select')
                        );*/
                        ?></td>
            </tr></table>
			<?php //echo $this->Form->end(null); ?>
	</div>-->
    <!-- Start innerbody here-->
    <div class="innerbody">

        <table width="100%" border="0" cellpadding="3">
            <tr>
                <td width="13%"><label class="lab-inner">A/C. Open Date :</label></td>
                <td width="22%">
                    <?php
                    $AccOpeDate = !empty($profile['Profile']['dt_account_create_date']) ?
                            date('d-M-Y', strtotime($profile['Profile']['dt_account_create_date'])) : '';
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
                    echo $this->Form->input('vc_customer_no', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'disabled' => 'disabled',
                        'value' => $profile['Profile']['vc_customer_no'],
                        'class' => 'round'));
                    ?>

                </td>
                <td colspan="2" rowspan="10" align="right" valign="top">

                    <table width="100%" border="0" cellpadding="3">
                        <tr>

                            <td width="93%" align="right">Payment Received </td>

                            <td width="7%" align="left">

                                <?php if ($AssessmentVehicleMaster['AssessmentVehicleMaster']['vc_payment_status'] == 'STSTY04') : ?>

                                    <div class="paymentreceived-yes">&nbsp;</div>

                                <?php else : ?>

                                    <div class="paymentreceived-no">&nbsp;</div>

                                <?php endif; ?>


                            </td>
                        </tr>
                        <tr>
                            <td height="44" colspan="2" align="right">

                                <?php
								//pr($AssessmentVehicleMaster);

								if ($AssessmentVehicleMaster['AssessmentVehicleMaster']['vc_payment_status'] == 'STSTY04') : ?>

                                    <?php //echo $this->Html->link('Print Receipt', '', array('class' => 'textbutton1')); ?>

                                <?php endif; ?>

                            </td>
                        </tr>
                    </table>

                    <table width="80%" border="0" cellpadding="3"  bgcolor="#dceddc" style="border:solid 1px #a1c8a0;" >
                        <tr>
                            <td align="center" >
                                <?php if ($AssessmentVehicleMaster['AssessmentVehicleMaster']['vc_payment_status'] == 'STSTY04') : ?>
                                    <?php // echo $this->Html->link('Pay Proof', '', array('class' => 'textbutton')); ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td align="left"><b>Authorized User</b></td>
                        </tr>

                        <tr>
                            <td align="left">
                                <?php
                                echo $this->Form->input('AuthorizedUser', array('label' => false,
                                    'div' => false,
                                    'type' => 'text',
                                    'disabled' => 'disabled',
                                    'value' => $AssessmentVehicleMaster['AssessmentVehicleMaster']['vc_authorized_user'],
                                    'class' => 'round'));
                                ?>

                            </td>
                        </tr>
                        <tr>

                            <td align="left">

                                <?php
                                $defaultValue = isset($AssessmentVehicleMaster['AssessmentVehicleMaster']['vc_authorized_user']) ? 'ASSUSRVRF01' : 'ASSUSRVRF02';

                                $attributes = array('legend' => false, 'value' => $defaultValue, 'disabled' => 'disabled');


                                echo $this->Form->radio('AuthorizeCheckUser', $ASSUSRVRF, $attributes);

                                $CheckedValue = isset($AssessmentVehicleMaster['AssessmentVehicleMaster']['vc_invalid']) && $AssessmentVehicleMaster['AssessmentVehicleMaster']['vc_invalid'] == 'ASSUSRVRF01' ? true : false;
                                ?>

                                <?php
                                if ($CheckedValue) :

                                    echo $this->Form->checkbox('invalid', array('hiddenField' => false, 'disabled' => 'disabled', 'style' => "margin-left:60px", 'checked' => 'checked'));


                                else :

                                    echo $this->Form->checkbox('invalid', array('hiddenField' => false, 'disabled' => 'disabled', 'style' => "margin-left:60px"));

                                endif;
                                ?>

                                <?php echo $this->Form->label('Invalid'); ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td><label class="lab-inner">Assess. Date :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('dt_assessment_date', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'disabled' => 'disabled',
                        'value' => isset($AssessmentVehicleMaster['AssessmentVehicleMaster']['dt_assessment_date']) ? date('d-M-Y', strtotime($AssessmentVehicleMaster['AssessmentVehicleMaster']['dt_assessment_date'])) : '',
                        'class' => 'round'));
                    ?>

                </td>
                <td><label class="lab-inner">Rec. Date :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('dt_received_date', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'disabled' => 'disabled',
                        'value' => isset($AssessmentVehicleMaster['AssessmentVehicleMaster']['dt_received_date']) ? date('d-M-Y', strtotime($AssessmentVehicleMaster['AssessmentVehicleMaster']['dt_received_date'])) : '',
                        'class' => 'round'));
                    ?>

                </td>
            </tr>
            <tr>

                <td><label class="lab-inner">Process Date :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('dt_process_date', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'disabled' => 'disabled',
                        'value' => isset($AssessmentVehicleMaster['AssessmentVehicleMaster']['dt_process_date']) ? date('d-M-Y', strtotime($AssessmentVehicleMaster['AssessmentVehicleMaster']['dt_process_date'])) : '',
                        'class' => 'round'));
                    ?>

                </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
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

                </td>
                <td><label class="lab-inner">Customer ID :</label></td>
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

                </td>
            </tr>
            <tr>
                <td><label class="lab-inner">Address 1 :</label></td>
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
                <td><label class="lab-inner">Address 2 :</label></td>
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
                <td><label class="lab-inner">P.O .Box :</label></td>
                <td>
                    <?php
				//	pr( $profile['Profile']);
                    echo $this->Form->input('AssessmentVehicleMaster.vc_po_box', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_po_box',
                        'value' => $profile['Profile']['vc_address3'],
                        'disabled' => 'disabled',
                        'class' => 'round'));
                    ?>

                </td>
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

                </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td><label class="lab-inner">Pay Month From :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('vc_pay_month_from', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'disabled' => 'disabled',
                        'value' => $AssessmentVehicleMaster['AssessmentVehicleMaster']['vc_pay_month_from'],
                        'class' => 'round'));
                    ?>

                </td>
                <td><label class="lab-inner">Pay Month To :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('vc_pay_month_to', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'disabled' => 'disabled',
                        'value' => $AssessmentVehicleMaster['AssessmentVehicleMaster']['vc_pay_month_to'],
                        'class' => 'round'));
                    ?>

                </td>
            </tr>
            <tr>
                <td><label class="lab-inner">Pay Year From :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('vc_pay_year_from', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'disabled' => 'disabled',
                        'value' => $AssessmentVehicleMaster['AssessmentVehicleMaster']['vc_pay_year_from'],
                        'class' => 'round'));
                    ?>

                </td>
                <td><label class="lab-inner">Pay Year To :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('vc_pay_year_to', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'disabled' => 'disabled',
                        'value' => $AssessmentVehicleMaster['AssessmentVehicleMaster']['vc_pay_year_to'],
                        'class' => 'round'));
                    ?>

                </td>
            </tr>
            <tr>

                <td><label class="lab-inner" style="width:117px;">Payable Amount(N$):</label></td>
                <td>
                    <?php
                    echo $this->Form->input('vc_mdc_paid', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'disabled' => 'disabled',
                        'value' => number_format($AssessmentVehicleMaster['AssessmentVehicleMaster']['nu_total_payable_amount'],'2','.',','),
                        'class' => 'round number-right'));
					
                    ?>

                </td>

                <td><label class="lab-inner">Variance Amt.(N$) :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('nu_variance_amount', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'nu_variance_amount',
                        'disabled' => 'disabled',
                        'value' => number_format($AssessmentVehicleMaster['AssessmentVehicleMaster']['nu_variance_amount'],'2','.',','),
                        'class' => 'round number-right'));
                    ?>

                </td>
                <td width="13%">&nbsp;</td>
                <td width="22%">&nbsp;</td>
            </tr>
        </table>
        <br />
        <?php echo $this->Form->create(array('url' => array('controller' => 'payments', 'action' => 'index', $assessmentNo), 'type' => 'file')); ?>		
        <table width="100%" border="0" cellpadding="3">

            <tr>

                <td valign='top' width="13%"><label class="lab-inner"> Paid Amount (N$):</label></td>
                <td valign='top' width="22%">
                    <?php
                    echo $this->Form->input('Payment.vc_mdc_paid', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'maxlength' => 10,
                        'required' => 'required',
                        'class' => 'round'));
							echo $this->Form->input('Payment.vc_mdc_payable_hidden', array('label' => false,
                        'div' => false,
                        'type' => 'hidden',
                        'value' => $AssessmentVehicleMaster['AssessmentVehicleMaster']['nu_total_payable_amount'],
                        'class' => 'round number-right'));
                    ?>
                </td>

                <td valign='top' width="13%"><label class="lab-inner" style="width: 127px;"> Reference Number :</label></td>
                <td valign='top' width="22%"><?php
                    echo $this->Form->input('Payment.vc_payment_reference_no', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'maxlength' => 30,
                        'required' => 'required',
                        'class' => 'round'));
                    ?>
                </td>


            </tr>

            <tr>

                <td valign='top' width="13%"><label class="lab-inner"> Upload Document :</label></td>
                <td valign='top' width="22%"><?php
                    echo $this->Form->input('Payment.vc_uploaded_doc_name', array('label' => false,
                        'div' => false,
                        'type' => 'file',
                        'class' => 'round_select'));
                    ?>
                </td>
                <td valign='top' width="11%"><label class="lab-inner">Bank Name :</label></td>
                <td valign='top' width="19%"><?php
                    echo $this->Form->input('Payment.vc_bank_struct_code', array('label' => false,
                        'div' => false,
                        'type' => 'select',
                        'options' => $banks,
                        'required' => 'required',
                        'default' => $profile['Profile']['vc_bank_struct_code'],
                        'class' => 'round'));
                    ?></td>

            </tr>
				<?php 
			if(isset($AssessmentVehicleMaster['AssessmentVehicleMaster']['ch_upload_doc']) && $AssessmentVehicleMaster['AssessmentVehicleMaster']['ch_upload_doc']=='Y'){
			$url =$this->webroot.'vehicles/downloadammned/A/'.base64_encode($AssessmentVehicleMaster['AssessmentVehicleMaster']['vc_assessment_no']);
			$urldeletedoc =$this->webroot.'vehicles/deletedoc/A/'.base64_encode($AssessmentVehicleMaster['AssessmentVehicleMaster']['vc_assessment_no']);
			
			?>
            <tr>
                <td><a href="<?php echo $url;?>">Download Doc.</a></td>
                <td>
                    <a id="deletedocid"  rel ="<?php echo $urldeletedoc;?>"
					href="#"> Delete Doc.</a>
                </td>
                <td></td>
                <td>
                    
                </td></tr>
				<?php } ?>

            <tr>

                <td colspan='4' style='text-align:center' >

                    <?php
                    echo $this->Form->button('Submit', array('label' => false,
                        'div' => false,
                        'id' => 'submit',
                        'type' => 'submit',
                        'class' => 'round3 submit'));
                    ?>	

                </td>


            </tr>


        </table>

        <?php echo $this->Form->end(Null); ?>

    </div>

    <!-- end innerbody here-->
</div>
<?php echo $this->element('commonmessagepopup'); ?>
<?php echo $this->Html->script('mdc/payment'); ?>
