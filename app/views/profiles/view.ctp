<?php $profile = $this->Session->read('Auth');

 ?>
<!-- Start breadcrumb here-->
<div class="breadcrumb">
    <ul>
        <li class="first">

            <?php echo $this->Html->link('Home', array('controller' => 'profiles', 'action' => 'index'), array('title' => 'Home', 'class' => 'vtip')) ?>

        </li>
        <?php if (trim($this->Session->read('Auth.Member.vc_mdc_customer_no')) != ''): ?>

            <li class="last">View Profile</li> 

        <?php else: ?>

            <li class="last">Add Profile</li> 

        <?php endif; ?>	
    </ul>
</div>
<!-- end breadcrumb here-->

<!-- Start mainbody here-->
<div class="mainbody">

    <h1><?php echo $mdclocal; ?></h1>

    <h3>Customer Identification</h3>

    <!-- Start innerbody here-->
	<?php
	//pr($CompanyId);
	//echo count($CompanyId);
	if(count($CompanyId)>1){
	?>
	<div class="innerbodyHeader">
	<?php echo $this->Form->create('VehicleRegistrationCompany', array('url' => array('controller' => 'vehicles', 'action' => 'companysubmit'), 'type' => 'file','enctype'=>'multipart/form-data')); ?>
           <table border="0"> <tr>
                <td align="left" width="12%">
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
                        ?></td><td width="16%">&nbsp;</td>
						<td width="35%" align="right">Customer Status&nbsp;:</td>
						
						<td>

                    <span class="valuetext"> <?php
                    echo $profile['Status']['vc_prtype_name'];
                    ?></span>
                </td>
            </tr></table>
			<?php echo $this->Form->end(null); ?>
	</div>
	<?php }?>
    <div class="innerbody">

        <table width="100%" border="0" cellpadding="3">
            <tr>
                <td><label class="lab-inner">Customer Name :</label></td>
                <td>

                    <?php
																					

                    echo $this->Form->input('Profile.vc_customer_name', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_customer_name',
                        'disabled' => true,
                        'value' => trim($profile['Profile']['vc_customer_name']),
                        'class' => 'round'));
                    ?>
                </td>
                <td>
                    <label class="lab-inner">Customer ID :</label>
                </td>
                <td>
                    <?php
                    echo $this->Form->input('Profile.vc_customer_id', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_customer_id',
                        'disabled' => true,
                        'value' => trim($profile['Profile']['vc_customer_id']),
                        'class' => 'round'));
                    ?>
                </td>
                <td>
                    <label class="lab-inner1" style="width:130px;">Business Registration :</label>
                </td>
                <td>
                    <?php
                    echo $this->Form->input('Profile.vc_business_reg', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'disabled' => true,
                        'value' => trim($profile['Profile']['vc_business_reg']),
                        'class' => 'round'));
                    ?>
                </td>
            </tr>
            <tr>
                <td><label class="lab-inner">Customer Type :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('Profile.vc_cust_type', array('label' => false,
                        'div' => false,
                        'type' => 'select',
                        'id' => 'vc_cust_type',
                        'options' => $CustType,
                        'disabled' => true,
                        'default' => $profile['Profile']['vc_cust_type'],
                        'class' => 'round_select')
                    );
                    ?>
                </td>
				<td><label class="lab-inner">Company Name :</label></td>
                <td>
                    <?php
					
                    echo $this->Form->input('Company.vc_company_name', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'disabled' => true,
                        'default' => @$allCompanyId[$profile['Profile']['nu_company_id']],
                        'class' => 'round')
                    );
                    ?>
                </td>
                <td><label class="lab-inner" style="width:130px;">
				<?php if($profile['Profile']['vc_cust_type']=='CUSTYPE01' && $profile['Profile']['ch_business_type']=='Y' ) {?>
						Download Business Certificate :
				<?php }?>
				
				</label></td>
                <td>
<?php if($profile['Profile']['vc_cust_type']=='CUSTYPE01' && $profile['Profile']['ch_business_type']=='Y' ) {?>
                    <span class="valuetext"> <?php
                   $url = $this->webroot . 'profiles/download/B';

                    echo $this->Form->button('Click Here ', array('label' => false,
                        'div' => false,
                        'type' => 'button',
                        'onclick' => "javascript:window.location='$url'",
                        'class' => 'round_select')
                    );
                    
					}?></span>
                </td>
                
            </tr>
        </table>

    </div>

    <!-- end innerbody here-->
    <h3>Bank Details</h3>

    <!-- Start innerbody here-->
    <div class="innerbody">
        <table width="100%" border="0" cellpadding="3">
            <tr>
                <td><label class="lab-inner">Bank Name :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('Profile.vc_bank_struct_code', array('label' => false,
                        'div' => false,
                        'type' => 'select',
                        'id' => 'vc_bank_struct_code',
                        'disabled' => true,
                        'options' => $banks,
                        'default' => $profile['Profile']['vc_bank_struct_code'],
                        'class' => 'round_select')
                    );
                    ?>
                </td>
                <td><label class="lab-inner">Account Number :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('Profile.vc_account_no', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_account_no',
                        'disabled' => true,
                        'value' => trim($profile['Profile']['vc_account_no']),
                        'class' => 'round'));
                    ?>
                </td>
				<?php
				if($profile['Profile']['vc_bank_supportive_doc']!=''){
				?>
				
                <td><label class="lab-inner1">Bank Supportive Doc. :</label></td>
                <td>

                    <?php
                    echo $this->Form->input('Profile.vc_bank_supportive_doc', array('label' => false,
                        'div' => false,
                        'type' => 'select',
                        'id' => 'vc_bank_supportive_doc',
                        'disabled' => true,
                        'options' => $DocsSupportive,
                        'default' => $profile['Profile']['vc_bank_supportive_doc'],
                        'class' => 'round_select')
                    );
					//pr($profile['Profile']);
                    ?>
                </td>
				<?php } else{ ?>
				 <td><label class="lab-inner1">&nbsp;</label></td>
                <td style="width:153px;">

                   &nbsp;
                </td>
				<?php }?>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
				<?php
				if($profile['Profile']['vc_bank_supportive_doc']!=''){
				?>
                <td><label class="lab-inner">Download Doc. :</label></td>
                <td>	


                    <?php

                    $url = $this->webroot . 'profiles/download';

                    echo $this->Form->button('Click Here ', array('label' => false,
                        'div' => false,
                        'type' => 'button',
                        'onclick' => "javascript:window.location='$url'",
                        'class' => 'round_select')
                    );
                    ?>
					</td>
					<?php } else{ ?>
					 <td><label class="lab-inner1">&nbsp;</label></td>
                <td style="width:153px;">

                   &nbsp;
                </td>
					<?php }?>




            </tr>
        </table>

    </div>

    <!-- end innerbody here-->    

    <h3>Customer Communication</h3>

    <!-- Start innerbody here-->
    <div class="innerbody">
        <table width="100%" border="0" cellpadding="3">
            <tr>
                <td><label class="lab-inner">Street Name :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('Profile.vc_address1', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_address1',
                        'disabled' => true,
                        'value' => trim($profile['Profile']['vc_address1']),
                        'class' => 'round'));
                    ?>
                </td>
                <td><label class="lab-inner">House No. :</label></td>
                <td>

                    <?php
                    echo $this->Form->input('Profile.vc_address2', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_address2',
                        'disabled' => true,
                        'value' => trim($profile['Profile']['vc_address2']),
                        'class' => 'round'));
                    ?>
                </td>
                <td><label class="lab-inner1">P.O Box :</label></td>
                <td>
                    <?php
					//pr($profile['Profile']);
                    echo $this->Form->input('Profile.vc_po_box', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_po_box',
                        'disabled' => true,
                        'value' => trim($profile['Profile']['vc_address3']),
                        'class' => 'round'));
                    ?>
                </td>
            </tr>
			  <tr>
               
                 <td align="left" valign='top' ><label class="lab-inner">Town / City :</label></td>
                <td  align="left" valign='top' ><?php
                    echo $this->Form->input('Profile.vc_town', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'disabled' => true,
                        'value' => trim($profile['Profile']['vc_town']),
                        'class' => 'round'));
                    ?></td>
                <td  align="left" valign='top' ><label class="lab-inner">Download Town Municipal Bill  :</label></td>
                <td  align="left" valign='top' >
				<table>
				<tr>
				<?php
			//	pr($profile['Profile']);
				if($profile['Profile']['ch_municipal_type']=='Y'){
				?>
                <td><!--<label class="lab-inner">Download Doc. :</label>--></td>
                <td>	


                    <?php

                    $url = $this->webroot . 'profiles/download/M';

                    echo $this->Form->button('Click Here ', array('label' => false,
                        'div' => false,
                        'type' => 'button',
                        'onclick' => "javascript:window.location='$url'",
                        'class' => 'round_select')
                    );
                    ?>
					</td>
					<?php } else{ ?>
					 <td><label class="lab-inner1">&nbsp;</label></td>
                <td style="width:153px;">

                   &nbsp;
                </td>
					<?php }?>	</tr>
				</table>
				
				</td>
				 <td><label class="lab-inner">Email :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('Profile.vc_email_id', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_email_id',
                        'disabled' => true,
                        'value' => trim($profile['Profile']['vc_email_id']),
                        'class' => 'round'));
                    ?>

                </td>
            </tr>
            <tr>
                <td><label class="lab-inner">Telephone No. :</label></td>
                <td>

                    <?php
                    echo $this->Form->input('Profile.vc_tel_no', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_tel_no',
                        'disabled' => true,
                        'value' => trim($profile['Profile']['vc_tel_no']),
                        'class' => 'round'));
                    ?>
                </td>
                <td><label class="lab-inner">Fax No. :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('Profile.vc_fax_no', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'fax_no',
                        'disabled' => true,
                        'value' => trim($profile['Profile']['vc_fax_no']),
                        'class' => 'round'));
                    ?>
                </td>
                <td><label class="lab-inner1">Mobile No. :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('Profile.vc_mobile_no', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_mobile_no',
                        'disabled' => true,
                        'value' => trim($profile['Profile']['vc_mobile_no']),
                        'class' => 'round'));
                    ?>
                </td>
            </tr>
          
        </table>

    </div>
    <!-- end innerbody here-->        


</div>
<!-- end mainbody here--> 
