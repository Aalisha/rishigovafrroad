<?php 
$customerdetails = $this->Session->read('Auth'); ?>
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
    <h3>Vehicle Registration </h3>
    <!-- Start innerbody here-->
    <?php echo $this->Form->create('VehicleRegistration', array('url' => array('controller' => 'vehicles', 'action' => 'changedetail', base64_encode(trim($data['VehicleDetail']['vc_registration_detail_id']))), 'type' => 'file')); ?>
    <div class="innerbody">

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
					
						echo $this->Form->input('id', array('label' => false,
								'div' => false,
								'type' => 'hidden',
								'id' => 'id',
								'value' => trim($data['VehicleDetail']['vc_registration_detail_id']),
								));					
                    ?>

                </td>
                <td><label class="lab-inner">Account opp. date :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('VehicleHeader.dt_account_create_date', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'dt_account_opened_date',
                        'disabled' => true,
                        'value' => date('d M Y', strtotime($customerdetails['Profile']['dt_account_create_date'])),
                        'class' => 'round'));
                    ?>


                </td>
                <td><label class="lab-inner">Customer Id</label></td>
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
                <td><label class="lab-inner">Street Name :</label></td>
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
              
            </tr>
            <tr>  <td><label class="lab-inner">Fax No. :</label></td>
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
                
                <!--
                <td><label class="lab-inner">Pay Frequency :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('VehicleHeader.vc_pay_frequency', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_pay_frequency',
                        'disabled' => true,
                        'value' => $payfrequency,
                        'class' => 'round'));
                    ?>

                </td>
                -->
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
                <td><label class="lab-inner">
				<!-- Company Name : -->
				</label></td>
                <td><?php /*
				echo $this->Form->input('VehicleDetail.nu_company_id', 
							array('label' =>false,
                            'div' => false,
                            'type' => 'text',
                            'tabindex'=>'1',
                            'value' => $CompanyId[$nu_company_id],
							'disabled' =>true,
                            'class' => 'round')
                        );*/?></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
        </table>

    </div>
    <!-- end innerbody here-->


    <!-- end innerbody here-->
    <h3>Vehicle Details</h3>
    <!-- Start innerbody here-->
    <div class="innerbody">
       <div class='list'>
	   <table width="100%" id='changedetailvehicleID' cellspacing="1" cellpadding="5" 
	   border="0" >
           <thead >

				<tr class="listhead">
					<td width="6%">Vehicle <br/>Status</td>
					<td width="9%">Company<br> Name</td>					
					<td width="8%">Vehicle <br/>License No.</td>
					<td width="8%">Vehicle <br/>Reg. No.</td>
					<td width="8%">Pay <br/>Frequency</td>
					<td width="8%">Vehicle <br/>Type</td>
					<td width="8%">Start <br/>Odometer</td>
					<td width="8%">Oper. <br/>EST Km</td>
					<td width="8%">GVM <br/>Rating</td>
					<td width="8%">D/T <br/>Rating</td>
					<td width="9%">Predefine <br/>Route</td>
					<td width="9%">Upload <br/>Document</td>
				</tr>

			</thead>
			<tbody>
			<tr class="cont1">
                    <td valign='top' width="6%" valign='middle' align='center'>
								
                        <?php
                        echo $this->Form->input('VehicleDetail.0.vc_registration_detail_id', array('label' => false,
                            'type' => 'hidden',
                            'value' => $data['VehicleDetail']['vc_registration_detail_id']
                        ));
                        ?>
						<strong > 
							
							<?php echo current($status); ?>
							
						</strong >
                    
                    </td>
					<td valign='top' width="8%" >
					<?php
					
                        echo $this->Form->input('VehicleDetail.0.nu_company_id', array('label' => false,'div' => false,
                            'type' => 'select',
                            'tabindex'=>'3',
							'required' => 'required',
                            'options' => $CompanyId,
                            'default' => $data['VehicleDetail']['nu_company_id'],
                            'class' => 'round_select4')
                        );
                        ?>
					 </td>
                    <td  valign='top' width="8%">
                        <?php
                        echo $this->Form->input('VehicleDetail.0.vc_vehicle_lic_no', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'id' => 'vc_vehicle_lic_no',
                            'tabindex'=>'2',
                            'required' => 'required',
                            'value' => $data['VehicleDetail']['vc_vehicle_lic_no'],
                            'maxlength' => '15',
                            'class' => 'round1'));
                        ?>
                    </td>
                    <td valign='top'  width="8%">
                        <?php
                        echo $this->Form->input('VehicleDetail.0.vc_vehicle_reg_no', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'tabindex'=>'3',
                            'id' => 'vc_vehicle_reg_no',
                            'required' => 'required',
                            'maxlength' => '15',
                            'value' => $data['VehicleDetail']['vc_vehicle_reg_no'],
                            'class' => 'round1'));
                        ?>

                    </td>
                    <td valign='top' width="8%">
                        <?php
                        echo $this->Form->input('VehicleDetail.0.vc_pay_frequency', array('label' => false,
                            'div' => false,
                            'type' => 'select',
                            'id' => 'vc_pay_frequency',
                            'tabindex'=>'4',
                            'options' => $payfrequency,
                            'default' => $data['VehicleDetail']['vc_pay_frequency'],
                            'class' => 'round_select1')
                        );
                        ?>

                    </td>
                    <td valign='top' width="8%">
                        <?php
                        echo $this->Form->input('VehicleDetail.0.vc_vehicle_type', array('label' => false,
                            'div' => false,
                            'type' => 'select',
                            'required' => 'required',
                            'tabindex'=>'4',
                            'id' => 'vc_vehicle_type',
                            'options' => $vehiclelist,
                            'default' => $data['VehicleDetail']['vc_vehicle_type'],
                            'class' => 'round_select1')
                        );
                        ?>

                    </td>
                    <td valign='top' width="8%">
                        <?php
                        echo $this->Form->input('VehicleDetail.0.vc_start_ometer', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'id' => 'vc_start_ometer',
                             'tabindex'=>'5',
                            'required' => 'required',
                            'value' => $data['VehicleDetail']['vc_start_ometer'],
                            'maxlength' => '15',
                            'class' => 'round1 number-right'));
                        ?>

                    </td>
                    <td valign='top' width="8%">
                        <?php
                        echo $this->Form->input('VehicleDetail.0.vc_oper_est_km', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'id' => 'vc_oper_est_km',
                             'tabindex'=>'6',
                            'required' => 'required',
                            'value' => $data['VehicleDetail']['vc_oper_est_km'],
                            'maxlength' => '15',
                            'class' => 'round1 number-right'));
                        ?>

                    </td>
                    <td valign='top' width="8%">
                        <?php
                        echo $this->Form->input('VehicleDetail.0.vc_v_rating', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                             'tabindex'=>'7',
                            'id' => 'vc_v_rating',
                            'value' => $data['VehicleDetail']['vc_v_rating'],
                            'maxlength' => '15',
                            'class' => 'round1 number-right'));
                        ?>

                    </td>
                    <td  valign='top' width="8%">
                        <?php
                        echo $this->Form->input('VehicleDetail.0.vc_dt_rating', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                             'tabindex'=>'8',
                            'id' => 'vc_dt_rating',
                            'value' => $data['VehicleDetail']['vc_dt_rating'],
                            'maxlength' => '15',
                            'class' => 'round1 number-right'));
                        ?>

                    </td>
                    <td valign='top' width="9%">
                        <?php
                        echo $this->Form->input('VehicleDetail.0.vc_predefine_route', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                             'tabindex'=>'9',
                            'id' => 'vc_predefine_route',
                            'value' => $data['VehicleDetail']['vc_predefine_route'],
                            'maxlength' => 50,
                            'class' => 'round1'));
                        ?>

                    </td>

                    <td valign='top'  width="9%" align="center" >

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
							<div >
							<table border='0' width="100%" cellspacing="0" cellpadding="0">
							<tr><td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							</tr>
							<?php
							if(count($vehicledocs)){
							
							$docsnum=1;
							
							foreach($vehicledocs as $index=>$value){
							
							$url =$this->webroot.'vehicles/download/'.base64_encode($value['DocumentUploadVehicle']['vc_upload_vehicle_id']);
							?>
							<tr id="removerowid<?php echo base64_encode($value['DocumentUploadVehicle']['vc_upload_vehicle_id']);?>">							<td width="25%">&nbsp;<?php echo $value['DocumentUploadVehicle']['vc_uploaded_doc_name'];?></td>
<td width="10%">&nbsp;&nbsp;&nbsp; <a href="<?php echo $url;?>">View</a></td><td width="60%" align="left">&nbsp;<a 
 rel="<?php echo base64_encode($value['DocumentUploadVehicle']['vc_upload_vehicle_id']);?>" id="deletefileID<?php echo base64_encode($value['DocumentUploadVehicle']['vc_upload_vehicle_id']); ?>"
href="#">Delete</a></td></tr>
							<?php 
							$docsnum++;
							}
							}
							?>
							<tr><td>&nbsp;</td><td>&nbsp;</td>
														<td>&nbsp;</td>

							</tr>
							</table>
							</div>

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
    </div>
					
                    </td>

                </tr>
			</tbody>
		</table>
        </div>

        <table width="100%" border="0" cellspacing='0'>
            <tr>
                <td align="center">


                    <?php
                    echo $this->Form->button('Submit', array('label' => false,
                        'div' => false,
                        'id' => 'submitvehiclechangedetailid',
                        'type' => 'submit',
                        'class' => 'round3 submit'));
                    ?>			
                </td>

            </tr>
        </table>

    </div>

    <?php echo $this->Form->end(null); ?>

	<?php echo $this->element('commonmessagepopup'); ?>

	<?php echo $this->element('commonbackproceesing'); ?>

</div>
<!-- end mainbody here--> 

<!-- end mainbody here-->   
<?php echo $this->Html->script('mdc/vehicles-changedetail'); ?> 
<style>
.innerbody {
    background-color: #F8FFF8;
    border: 1px solid #DAEFDA;
    margin-bottom: 15px;
    padding: 10px;
    width: 102%;
}
</style>