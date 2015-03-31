<!-- Start breadcrumb here-->
<div class="breadcrumb">
    <ul>
        <li class="first">
            <?php echo $this->Html->link('Home', array('controller' => 'profiles', 'action' => 'index'), array('title' => 'Home', 'class' => 'vtip')) ?>
        </li>

        <li class="last">Vehicle Registration </li>        
    </ul>
</div>
<!-- end breadcrumb here-->

<!-- Start mainbody here-->
<div class="mainbody">
    <h1><?php echo $mdclocal;?></h1>
    <h3>Customer Detail</h3>
    <!-- Start innerbody here-->
	<div class="innerbodyHeader">
	<?php echo $this->Form->create('VehicleRegistrationCompany', array('url' => array('controller' => 'vehicles', 'action' => 'companysubmit'), 'type' => 'file','enctype'=>'multipart/form-data')); ?>
           <table> <tr>
                <td align="left" width="2%">
				Company Name :</td>
				<td width="16%"><?php
                        echo $this->Form->input('VehicleDetail.nu_company_id', array('label' => false,
                            'div' => false,
                            'type' => 'select',
							'required' => 'required',
                            'options' => $CompanyId,
                            'default' => $nu_company_id,
                            'onchange' => "formsubmit('VehicleRegistrationCompanyIndexForm');",
                            'maxlength' => 30,
                            'class' => 'round_select')
                        );
                        ?></td>
            </tr></table>
			<?php echo $this->Form->end(null); ?>
	</div>
    <?php echo $this->Form->create('VehicleRegistration', array('url' => array('controller' => 'vehicles', 'action' => 'index'), 'type' => 'file','enctype'=>'multipart/form-data')); ?>

    <div class="innerbody">

        <table width="100%" border="0" cellpadding="3">
            <tr>
                <td align="right">

                    <?php echo $this->Html->link('Print MDC Notice', array('controller' => 'vehicles', 'action' => 'getMdcNotice'), array('class' => 'textbutton')); ?>

                    <?php echo $this->Html->link('Print Ref. Letter', array('controller' => 'vehicles', 'action' => 'getMdcRfrLetter'), array('class' => 'textbutton')); ?>

                </td>
            </tr>
            <tr>
                <td align="left"></td>
            </tr>
        </table>
        <table width="100%" border="0" cellpadding="3">
            <tr>
                <td><label class="lab-inner">RFA Account No. :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('VehicleHeader.vc_customer_no', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_customer_no',
                        'disabled' => true,
                        'value' => $customerdetails['Profile']['vc_customer_no'],
                        'class' => 'round'));
                    ?>

                </td>
                <td><label class="lab-inner">Account opp. date :</label></td>
                <td>
                    <?php
                    $AccOpeDate = !empty($customerdetails['Profile']['dt_account_create_date']) ?
                            date('d M Y', strtotime($customerdetails['Profile']['dt_account_create_date'])) :
                            '';

                    echo $this->Form->input('VehicleHeader.dt_account_create_date', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'dt_account_opened_date',
                        'disabled' => true,
                        'value' => $AccOpeDate,
                        'class' => 'round'));
                    ?>


                </td>
                <td><label class="lab-inner">Customer Id  :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('VehicleHeader.vc_customer_id', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_customer_id',
                        'disabled' => true,
                        'value' => $customerdetails['Profile']['vc_customer_id'],
                        'class' => 'round'));
                    ?>


                </td>
            </tr>
            <tr>
                <td><label class="lab-inner">Customer Name :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('VehicleHeader.vc_customer_name', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_customer_name',
                        'disabled' => true,
                        'value' => $customerdetails['Profile']['vc_customer_name'],
                        'class' => 'round'));
                    ?>
                    <!--<input type="text" class="round" />-->
                </td>
                <td><label class="lab-inner">Street Name : </label></td>
                <td>
                    <?php
                    echo $this->Form->input('VehicleHeader.vc_address1', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_address1',
                        'disabled' => true,
                        'value' => $customerdetails['Profile']['vc_address1'],
                        'class' => 'round'));
                    ?>
                </td>
                <td><label class="lab-inner">House No. :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('VehicleHeader.vc_address2', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_address2',
                        'disabled' => true,
                        'value' => $customerdetails['Profile']['vc_address2'],
                        'class' => 'round'));
                    ?>


                </td>
            </tr>
            <tr>
			 <td><label class="lab-inner">P.O Box :</label></td>
                <td>
                    <?php
					
                    echo $this->Form->input('VehicleHeader.vc_po_box', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_po_box',
                        'disabled' => true,
                        'value' => $customerdetails['Profile']['vc_address3'],
                        'class' => 'round'));
                    ?>


                </td>
			<td><label class="lab-inner">Town/City :</label></td>
				<td>
				<?php
                    echo $this->Form->input('VehicleHeader.vc_town', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_town',
                        'disabled' => true,
                        'readonly' => 'readonly',
                        'value' => $customerdetails['Profile']['vc_town'],
                        'class' => 'round'));
                    ?>
				</td>
               
                <td><label class="lab-inner">Telephone No. :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('VehicleHeader.vc_tel_no', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_tel_no',
                        'disabled' => true,
                        'value' => $customerdetails['Profile']['vc_tel_no'],
                        'class' => 'round'));
                    ?>

                </td>
			<tr>
                <td><label class="lab-inner">Fax No. :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('VehicleHeader.vc_fax_no', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_fax_no',
                        'disabled' => true,
                        'value' => $customerdetails['Profile']['vc_fax_no'],
                        'class' => 'round'));
                    ?>

                </td>
                <td><label class="lab-inner">Mobile No. :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('VehicleHeader.vc_mobile_no', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_mobile_no',
                        'disabled' => true,
                        'value' => $customerdetails['Profile']['vc_mobile_no'],
                        'class' => 'round'));
                    ?>
                    <!--<input type="text" class="round" />-->
                </td>
                <td><label class="lab-inner">Email :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('VehicleHeader.vc_email', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_email',
                        'disabled' => true,
                        'value' => $customerdetails['Profile']['vc_email_id'],
                        'class' => 'round'));
                    ?>
                </td>
			</tr>
			<tr>
                <td><label class="lab-inner">Customer Type :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('VehicleHeader.vc_cust_type', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_cust_type',
                        'disabled' => true,
                        'value' => $customerdetails['VC_CUST_TYPE']['vc_prtype_name'],
                        'class' => 'round'));
                    ?>
                    <!--<input type="text" class="round" />-->
                </td>
              
            </tr>
        </table>

    </div>
    <!-- end innerbody here-->


    <!-- end innerbody here-->
    <h3>Vehicle Detail</h3>
    <!-- Start innerbody here-->
    <div class="innerbody">
        <table width="100%" cellspacing="1" cellpadding="5" border="0" >
            <tr class="listhead">
                <td width="6%">Vehicle <br/>Status</td>
               <!-- <td width="8%">Company </td>-->
                <td width="8%">Vehicle <br/>License No.</td>
                <td width="8%">Vehicle <br/>Register No.</td>
                <td width="8%">Pay <br/>Frequency</td>
                <td width="8%">Vehicle <br/>Type</td>
                <td width="8%">Start <br/>Odometer</td>
                <td width="9%">Oper <br/>EST KM</td>
                <td width="9%">GVM <br/> Rating</td>
                <td width="9%">D/T <br/> Rating</td>
                <td width="10%">Predefined <br/>Route</td>
                <td width="9%">Upload <br/>Document</td>
            </tr>
        </table>
        <div class="listsr">

            <table width="100%" cellspacing="1" cellpadding="5" border="0" >
                <tr class="cont1">
                    <td width="6%" valign='middle' align='center'>
						<strong >
                        <?php
						 echo current($status);                       
                        ?>
						</strong >
                    </td>
					  
					<?php
                        /*<td width="8%" valign='middle' align='center'>
						echo $this->Form->input('VehicleDetail.0.nu_company_id', array('label' => false,
                            'div' => false,
                            'type' => 'select',
                            'tabindex'=>'3',
							'required' => 'required',
                            'options' => $CompanyId,
                            'maxlength' => 30,
                            'class' => 'round_select4')
                        );
						</td>*/
                        ?>
                    
                    <td width="8%" align="left"  valign='top'>
                        <?php
                        echo $this->Form->input('VehicleDetail.0.vc_vehicle_lic_no', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'tabindex'=>'1',
                            'maxlength' => 15,
                            'class' => 'round4'));
                        ?>

                    </td>
                    <td width="8%" align="left"  valign='top'>
                        <?php
                        echo $this->Form->input('VehicleDetail.0.vc_vehicle_reg_no', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'tabindex'=>'2',
                            'required' => 'required',
                            'maxlength' => 15,
                            'class' => 'round4'));
                        ?>

                    </td>
                    <td width="8%" align="left" valign='top'>
                        <?php
                        echo $this->Form->input('VehicleDetail.0.vc_pay_frequency', array('label' => false,
                            'div' => false,
                            'type' => 'select',
                            'tabindex'=>'3',
                            'options' => $payfrequency,
                            'maxlength' => 30,
                            'class' => 'round_select4')
                        );
                        ?>

                    </td>
                    <td width="8%" align="left" valign='top'>
                        <?php
                        echo $this->Form->input('VehicleDetail.0.vc_vehicle_type', array('label' => false,
                            'div' => false,
                            'type' => 'select',
                            'tabindex'=>'4',
                            'required' => 'required',
                            'options' => $vehiclelist,
                            'maxlength' => 15,
                            'class' => 'round_select4')
                        );
                        ?>

                    </td>
                    <td width="8%" align="left" valign='top'>
                        <?php
                        echo $this->Form->input('VehicleDetail.0.vc_start_ometer', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'tabindex'=>'5',
                            'required' => 'required',
                            'value' => '',
                            'maxlength' => 15,
                            'class' => 'round4  number-right'));
                        ?>

                    </td>
                    <td width="9%" align="left" valign='top'>
                        <?php
                        echo $this->Form->input('VehicleDetail.0.vc_oper_est_km', array('label' => false,
                            'div' => false,
                            'tabindex'=>'6',
                            'type' => 'text',
                            'required' => 'required',
                            'value' => '',
                            'maxlength' => 15,
                            'class' => 'round4 number-right'));
                        ?>

                    </td>
                    <td width="9%" align="left" valign='top'>
                        <?php
                        echo $this->Form->input('VehicleDetail.0.vc_v_rating', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'tabindex'=>'7',
                            'value' => '',
                            'maxlength' => 15,
                            'class' => 'round1 number-right'));
                        ?>

                    </td>
                    <td width="9%" align="left" valign='top'>
                        <?php
                        echo $this->Form->input('VehicleDetail.0.vc_dt_rating', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'tabindex'=>'8',
                            'value' => '',
                            'maxlength' => 15,
                            'class' => 'round1 number-right'));
                        ?>

                    </td>
                    <td width="10%" align="left" valign='top'>
                        <?php
                        echo $this->Form->input('VehicleDetail.0.vc_predefine_route', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'tabindex'=>'9',
                            'value' => '',
                            'maxlength' =>50,
                            'class' => 'round1'));
                        ?>

                    </td>
                    <td valign='top' width="7%" align="center" >

                        <?php
                        echo $this->Form->button('Upload', array('label' => false,
                            'div' => false,
                            'id' => 'updoc0',
                            'tabindex'=>'10',
                            'onclick' => 'uploaddocs(\'uploadDocsvehicle0\',0);',
                            'type' => 'button',
                            'class' => 'round3'));
                        ?>		
					
						<div id="uploadDocsvehicle0" class="ontop">

        <div id="popup0" class="popup2">

            <a href="javascript:void(0);" class="close" onClick='hidepop("uploadDocsvehicle0");' >Close</a>   

           
            <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
                
				<tr>
					
					<td valign ='top' colspan='2' align="left" class="content-area">
						<div class="listhead-popup">Upload Document</div>
					</td>

				</tr>

				<tr>

					<td colspan='2' valign ='top' align="left">
						<div class="file-format" >Pdf, Png, Jpeg, Jpg File Could be uploaded.<strong>2 MB</strong> is the maximum size for upload </div>
					</td>

				</tr>

                <tr>
                    <td  valign ='top'  width="100%" align="left">
                        <div class="content-area-outer">

                            <div class="upload-button">



                            </div>

                            <div class="button-addmore">

                                <div class='add_row' > 
                                    <a  onclick="add_fields('uploadDocsvehicle0', 0);">
                                        <?php echo $this->Html->image('add-more.png', array('width' => '24', 'height' => '24')); ?>
                                    </a>
                                    <a  onclick="add_fields('uploadDocsvehicle0', 0);"> Add </a>
                                </div>	
                                							
                            </div>

                        </div>
                    </td>
                </tr>
            </table>       

        </div>
    </div></td>
  </tr>

</table> 

        </div>
        <table width="100%" border="0">
            <tr>
                <td  valign='top' align="center">

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

    </div>
    <!-- end innerbody here-->    

    
    <?php echo $this->Form->end(null); ?>
</div>
<?php echo $this->Html->script('fileuploader'); ?>

<?php echo $this->element('commonmessagepopup'); ?>
<!-- end mainbody here-->   
<?php echo $this->Html->script('mdc/vehicles'); ?>
<script>

</script>