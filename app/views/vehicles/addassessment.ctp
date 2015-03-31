    <?php $profile = $this->Session->read('Auth'); ?>
    <!-- Start breadcrumb here-->
    <div class="breadcrumb">
        <ul>
            <li class="first">
                <?php echo $this->Html->link('Home', array('controller' => 'profiles', 'action' => 'index'), array('title' => 'Home', 'class' => 'vtip')) ?>
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
           <table> <tr>
                <td align="left" width="3%">
				Company Name :</td>
				<td width="15%"><?php
				//echo 'nu-company-id'.$nu_company_id;
                        echo $this->Form->input('VehicleDetail.nu_company_id', array('label' => false,
                            'div' => false,
                            'type' => 'select',
                            'tabindex'=>'3',
							'required' => 'required',
                            'options' => $CompanyId,
                            'default' => $nu_company_id,
                            'onchange' => "formsubmit('VehicleRegistrationCompanyAddassessmentForm');",
                            'maxlength' => 30,
                            'class' => 'round_select')
                        );
                        ?></td>
            </tr></table>
			<?php echo $this->Form->end(null); ?>
	</div>
		
        <!-- Start innerbody here-->
        <div class="innerbody">


            <?php echo $this->Form->create(array('url' => array('controller' => 'vehicles', 'action' => 'addassessment'))); ?>

            <table width="100%" border="0" cellpadding="3">
                <tr>
                    <td valign='top' width="13%"><label class="lab-inner">A/C. Open Date :</label></td>
                    <td  valign='top' width="22%">
                        <?php
                        $AccOpeDate = !empty ($profile['Profile']['dt_account_create_date']) ?
                                         date('d M Y', strtotime($profile['Profile']['dt_account_create_date'])):'';
                        echo $this->Form->input('AssessmentVehicleMaster.dt_account_create_date', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'disabled' => 'disabled',
                            'value' => $AccOpeDate,
                            'class' => 'round'));
                        ?>

                    </td>
                    <td  valign='top' width="11%"><label class="lab-inner">RFA A/C. No. :</label></td>
                    <td valign='top' width="19%">
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
                    <td valign='top' ><label class="lab-inner">Assess. Date :</label></td>
                    <td valign='top' >
                        <?php
                        echo $this->Form->input('AssessmentVehicleMaster.dt_assessment_date', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'disabled' => 'disabled',
                            'value' => date('d M Y'),
                            'required' => 'required',
                            'class' => 'round'));
                        ?>

                    </td>
                    <td valign='top' ><label class="lab-inner">Rec. Date :</label></td>
                    <td valign='top' >
                        <?php
                        echo $this->Form->input('AssessmentVehicleMaster.dt_received_date', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'disabled' => 'disabled',
                            'value' => date('d M Y'),
                            'required' => 'required',
                            'class' => 'round'));
                        ?>

                    </td>
                </tr>
                <tr>

                    <td valign='top' ><label class="lab-inner">Process Date :</label></td>
                    <td valign='top' >
                        <?php
                        echo $this->Form->input('AssessmentVehicleMaster.dt_process_date', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'disabled' => 'disabled',
                            'value' => date('d M Y'),
                            'required' => 'required',
                            'class' => 'round'));
                        ?>

                    </td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td valign='top' ><label class="lab-inner">Customer Name :</label></td>
                    <td valign='top' >
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
                    <td valign='top' ><label class="lab-inner">Customer ID :</label></td>
                    <td valign='top' >
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
                    <td valign='top'><label class="lab-inner">Street Name  :</label></td>
                    <td valign='top' >
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
                    <td valign='top' ><label class="lab-inner">House No. :</label></td>
                    <td valign='top' >
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
                    <td valign='top' ><label class="lab-inner">P.O Box :</label></td>
                    <td valign='top' >
                        <?php
						//pr($profile['Profile']);
                        echo $this->Form->input('AssessmentVehicleMaster.vc_po_box', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'id' => 'vc_address3',
                            'value' => $profile['Profile']['vc_address3'],
                            'disabled' => 'disabled',
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
                    <td valign='top' ><label class="lab-inner">Fax No. :</label></td>
                    <td valign='top' >
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
                    <td valign='top' ><label class="lab-inner">Mobile No. :</label></td>
                    <td valign='top' >
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
                    <td valign='top' ><label class="lab-inner">Telephone No. :</label></td>
                    <td valign='top' >
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
					<td valign='top' ><label class="lab-inner">Email :</label></td>
                    <td valign='top' >
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
					
                </tr>
                <tr>
                    <td valign='top' ><label class="lab-inner">Pay From :</label></td>
                    <td valign='top' >
                        <?php
                        echo $this->Form->input('AssessmentVehicleMaster.vc_pay_month_from', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'id' => 'vc_pay_from',
                            'readonly' => 'readonly',
                            'required' => 'required',
                            'class' => 'round'));
                        ?>

                    </td>
                    <td valign='top' ><label class="lab-inner">Pay To :</label></td>
                    <td valign='top' >
                        <?php
                        echo $this->Form->input('AssessmentVehicleMaster.vc_pay_month_to', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'id' => 'vc_pay_to',
                            'readonly' => 'readonly',
                            'required' => 'required',
                            'class' => 'round'));
                        ?>

                    </td>
                </tr>
                <tr>
                    <!--
                    <td valign='top' ><label class="lab-inner">MDC Paid :</label></td>
                    <td valign='top' >
                        <?php
                        echo $this->Form->input('AssessmentVehicleMaster.vc_mdc_paid', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'id' => 'vc_mdc_paid',
                            'maxlength'=>10,
                            'class' => 'round'));
                        ?>

                    </td>
                   -->
                    <td valign='top' ><label class="lab-inner">Variance Amt.(N$) :</label></td>
                    <td valign='top' >
                        <?php
						// number_format($profile['Profile']['nu_variance_amount'],'2','.',',')
						// $profile['Profile']['nu_variance_amount']
                        
						echo $this->Form->input('AssessmentVehicleMaster.nu_variance_amount', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'id' => 'nu_variance_amount',
                            'disabled' => 'disabled',
                            'value' =>'',
                            'class' => 'round number-right'));
                        ?>

                    </td>
                    <td valign='top' width="13%">&nbsp;</td>
                    <td valign='top' width="22%">&nbsp;</td>
                </tr>
            </table>
            <br>
            <div class='listsr1'>
                <table width="100%"  cellspacing="1" cellpadding="5" border="0" >
                    <thead>
                        <tr class="listhead">
                            <td valign='top' >Vehicle License No.</td>
                            <td valign='top' >Vehicle Register No.</td>
                            <td valign='top' >Pay Frequency</td>
                            <td valign='top' >Prev. End OM</td>
                            <td valign='top' >End OM</td>
                            <td valign='top' >KM Travel on <br/>Namibian Road <br/>Network</td>
                            <td valign='top' > Rate(N$) <br/>Per 100 Km</td>
                            <td valign='top' width="10%" >Payable(N$)<br />(Km Traveled * Rate)/100</td>
                            <td valign='top' >Remarks</td>
                            <td valign='top' >Vehicle Log</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="cont1">
                            <td valign='top' >

                                <?php
                                echo $this->Form->input('AssessmentVehicleDetail.0.vc_vehicle_lic_no', array('label' => false,
                                    'div' => false,
                                    'type' => 'select',
                                    'options' => $vehiclelist,
                                    'required' => 'required',
                                    'maxlength' => 15,
                                    'rel' => 'license',
                                    'class' => 'round_select2')
                                );
                                ?>

                            </td>
                            <td valign='top' >
                                <?php
                                echo $this->Form->input('AssessmentVehicleDetail.0.vc_vehicle_reg_no', array('label' => false,
                                    'div' => false,
                                    'type' => 'select',
                                    'options' => $vehicleReg,
                                    'rel' => 'registration',
                                    'required' => 'required',
                                    'maxlength' => 15,
                                    'class' => 'round_select2')
                                );
                                ?>

                            </td>
                            <td valign='top' >
                                <?php
                                echo $this->Form->input('AssessmentVehicleDetail.0.vc_pay_frequency', array('label' => false,
                                    'div' => false,
                                    'type' => 'text',
                                    'id' => 'vc_pay_frequency',
                                    'maxlength' => 30,
                                    'readonly' => 'readonly',
                                    'class' => 'round2'));
                                ?>

                            </td>
                            <td valign='top' >
                                <?php
                                echo $this->Form->input('AssessmentVehicleDetail.0.vc_prev_end_om', array('label' => false,
                                    'div' => false,
                                    'type' => 'text',
                                    'id' => 'vc_prev_end_om',
                                    'required' => 'required',
                                    'maxlength' => 15,
                                    'readonly' => 'readonly',
                                    'class' => 'round2'));
                                ?>

                            </td>
                            <td valign='top' >
                                <?php
                                echo $this->Form->input('AssessmentVehicleDetail.0.vc_end_om', array('label' => false,
                                    'div' => false,
                                    'type' => 'text',
                                    'id' => 'vc_end_om_0',
                                    'readonly' => 'readonly',
                                    'maxlength' => 15,
                                    'required' => 'required',
                                    'class' => 'round2'));
                                ?>

                            </td>
                            <td valign='top' >
                                <?php
                                echo $this->Form->input('AssessmentVehicleDetail.0.vc_km_travelled', array('label' => false,
                                    'div' => false,
                                    'type' => 'text',
                                    'id' => 'vc_km_travelled_0',
                                    'required' => 'required',
                                    'readonly' => 'readonly',
                                    'maxlength' => 15,
                                    'class' => 'round2'));
                                ?>

                            </td>
                            <td valign='top' > 
                                <?php
                                echo $this->Form->input('AssessmentVehicleDetail.0.vc_rate', array('label' => false,
                                    'div' => false,
                                    'type' => 'text',
                                    'id' => 'vc_rate',
                                    'readonly' => 'readonly',
                                    'required' => 'required',
                                    'maxlength' => 10,
                                    'class' => 'round2'));
                                ?>

                            </td>

                            <td valign='top' >
                                <?php
                                echo $this->Form->input('AssessmentVehicleDetail.0.vc_payable', array('label' => false,
                                    'div' => false,
                                    'type' => 'text',
                                    'id' => 'vc_payable',
                                    'readonly' => 'readonly',
                                    'maxlength' => 15,
                                    'class' => 'round2'));
                                ?>

                            </td>

                            <td valign='top'  >
                                <?php
                                echo $this->Form->input('AssessmentVehicleDetail.0.vc_remarks', array('label' => false,
                                    'div' => false,
                                    'type' => 'text',
									'id' => 'vc_remarks',
									'maxlength'=>100,
                                    'class' => 'round2'));
                                ?>

                            </td>
                            <td valign='top' align="center">
                                <?php
                                echo $this->Form->button('Log', array(
                                    'label' => false,
                                    'type' => 'button',
                                    'div' => false,
                                    'rel' => 'addlog0',
                                    'class' => 'round5'));
                                ?>
<!--<input type="text" value="0" name="logbuttonid0" id="logbuttonid0">-->

                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>	
            <table width="100%" border="0">
                <tr>
                    <td align="center" valign='top' >
                       
				<?php
                        echo $this->Form->button('Add', array('label' => false,
                            'div' => false,
                            'id' => 'addrow',
                            'type' => 'button',
                            'class' => 'submit'));
                        ?>

				&nbsp;&nbsp;&nbsp;&nbsp;




 				<?php
                        echo $this->Form->button('Remove', array('label' => false,
                            'div' => false,
                            'id' => 'rmrow',
                            'type' => 'button',
                            'class' => 'submit'));
                        ?>
                        &nbsp;&nbsp;&nbsp;&nbsp;			
                        <?php
                        echo $this->Form->button('Submit', array('label' => false,
                            'div' => false,
                            'id' => 'submit',
                            'type' => 'submit',
                            'class' => 'submit'));
                        ?>
						
                    </td>

                </tr>

            </table>	

            <?php echo $this->Form->end(null); ?>
        </div>

        <!-- end innerbody here-->
    </div>
    
	<?php echo $this->element('commonmessagepopup'); ?>
    <?php echo $this->element('commonbackproceesing'); ?>
    <?php echo $this->element('logshowpopup'); ?>
    <?php echo $this->Html->script('mdc/assessment'); ?>
	<style type='text/css' >
		.ui-datepicker-calendar {
			display: none;
		}
	</style>