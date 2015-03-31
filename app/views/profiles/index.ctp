<?php $currentUser = $this->Session->read('Auth');?>
<!-- Start breadcrumb here-->
<div class="breadcrumb">
    <ul>
        <li class="first">

            <?php echo $this->Html->link('Home', array('controller' => 'profiles', 'action' => 'index'), array('title' => 'Home', 'class' => 'vtip')) ?>

        </li>

        <?php
		//pr($this->data);

		if (trim($this->Session->read('Auth.Member.vc_mdc_customer_no')) == '') : ?>

            <li class="last">Add Profile</li> 

        <?php elseif (trim($this->Session->read('Auth.Profile.ch_active')) == 'STSTY05') : ?>

            <li class="last">Edit Profile</li> 

        <?php else : ?>

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
    <?php echo $this->Form->create(array('url' => array('controller' => 'profiles', 'action' => 'index'), 'type' => 'file')); ?>
    <div class="innerbody">

        <table width="100%" border="0" cellpadding="3" id = "table1">
            <tr>
                  <td colspan='5' align="right" width="80%" valign='top'>
                    <label class="lab-inner"><b>Account Status :</b></label>
                </td>
                <td width="24%" align="left" valign='top' > 
				 <?php 
				 if (isset($currentUser['Profile']['ch_active']) && $currentUser['Profile']['ch_active'] == 'STSTY05') : ?>
				<span style="color:#ff0000;">
				<?php  
					endif;				
				if (isset($currentUser['Status']['vc_prtype_name'])) :
                            echo $currentUser['Status']['vc_prtype_name'];
                        else:
                            echo 'Inactive';							
					endif;
				if (isset($currentUser['Profile']['ch_active'])&& $currentUser['Profile']['ch_active'] == 'STSTY05') : 
							?></span>
							<?php endif;?>
                    
                 </td>
            </tr>
			 <?php 
			 if (isset($currentUser['Profile']['ch_active']) && $currentUser['Profile']['ch_active'] == 'STSTY05') : ?>
			<tr>
                  <td colspan='5' align="right" width="80%" valign='top'>
                    <label class="lab-inner"><b>Remarks :</b></label>
                </td>
                <td width="24%" align="left" valign='top' >
				<span style="font-size:12px;color:#ff0000;" >
				<?php   
				echo $currentUser['Profile']['vc_remarks'];                        	
				?></span>
                    
                 </td>
            </tr>
			<?php endif; ?>
			<tr>
                <td width="13%" align="left" valign='top' ><label class="lab-inner">Customer Name :</label></td>
                <?php
                if ($this->Session->check('Auth.Member.vc_user_no')) :
                    echo $this->Form->input('vc_user_no', array(
                        'type' => 'hidden',
                        'value' => base64_encode($this->Session->read('Auth.Member.vc_user_no')),
                    ));
                endif;
				if ($this->Session->check('Auth.Member.vc_username')) :
                    echo $this->Form->input('vc_username', array(
                        'type' => 'hidden',
                        'value' => base64_encode($this->Session->read('Auth.Member.vc_username')),
                    ));
                endif;
                ?>
                <td width="18%" align="left" valign='top' >

                    <?php
                    echo $this->Form->input('Profile.vc_customer_name', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_customer_name',
                        'readonly' => 'readonly',
                        'value' => trim($currentUser['Member']['vc_user_firstname'] . ' ' . $currentUser['Member']['vc_user_lastname']),
                        'class' => 'round disabled-field'));
                    ?>
                </td>
                <td width="13%" align="left" valign='top'>
                    <label class="lab-inner">Customer ID :</label>
                </td>
                <td width="16%" align="left" valign='top' >
                    <?php
                    echo $this->Form->input('Profile.vc_customer_id', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_customer_id',
                        'maxlength' => 30,
						//Profile
                        'value' => (isset($currentUser['Profile']['vc_customer_id']) && $currentUser['Profile']['vc_customer_id']!='')?$currentUser['Profile']['vc_customer_id']:$this->data['Profile']['vc_customer_id'],
                        'required' => 'required',
                        'class' => 'round'));
                    ?>
                </td>
                <td width="16%" align="left" valign='top' >
                    <label class="lab-inner1">Business Registration :</label>
                </td>
                <td width="24%" align="left" valign='top' >
                    <?php
					
                    echo $this->Form->input('Profile.vc_business_reg', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                       // 'required' => 'required',
                        'maxlength' => 50,
                        'value' =>(isset($currentUser['Profile']['vc_business_reg']) && $currentUser['Profile']['vc_business_reg']!='')?$currentUser['Profile']['vc_business_reg']:$this->data['Profile']['vc_business_reg'] ,
                        'id' => 'vc_business_reg',
                        'class' => 'round'));
                    ?>
                </td>
            </tr>
            <tr>
                <td width="13%" align="left" valign='top'  ><label class="lab-inner">Customer Type :</label></td>
                <td width="18%" align="left" valign='top' >
                    <?php
                    echo $this->Form->input('Profile.vc_cust_type', array('label' => false,
                        'div' => false,
                        'type' => 'select',
                        'id' => 'vc_cust_type',
                        'required' => 'required',
                        'options' => $CustType,
                        'default' => @$currentUser['VC_CUST_TYPE']['vc_prtype_code'],
                        'class' => 'round_select')
                    );
                    ?>
                </td>
				<td width="13%" align="left" valign="top">Company Name :</td>
						
						<td width="18%" align="left" valign="top">
							
								<?php echo $this->Form->input("Company.vc_company_name", array(
																'div' => false,
																'label' => false,
																'class' => 'round',
																'value' => @$company['Company']['vc_company_name'],
																'type' => 'text'));

																?>
							
						</td>
				
				
                <td width="13%" align="left" valign='top'  ><label class="lab-inner">Business Certificate Doc:</label><br>
				<?php 
				if($currentUser['Profile']['vc_cust_type']=='CUSTYPE01' && $currentUser['Profile']['ch_active']=="STSTY05" && $currentUser['Profile']['ch_business_type']=='Y' ) {
				 $url = $this->webroot . 'profiles/download/B';
				?>
				<a href="<?php echo $url; ?>"> Download Doc</a>
                                    
				<?php	}
					?>
					
				</td>
                <td width="16%" align="left" valign='top' >
                   <span class="valuetext"> 
                         <?php
                    echo $this->Form->input('DocumentUpload.vc_business_reg_doc', array('label' => false,
                        'div' => false,
                        'type' => 'file',						
                        'id' => 'vc_business_reg_doc',
                        'class' => 'round_select')
                    );
                 
                        ?></span>
<input type="hidden" value="<?php  if(isset($currentUser['Profile']['ch_active']) && $currentUser['Profile']['ch_active']!='')echo $currentUser['Profile']['ch_active'];?>" name ="profilestatus" id="profilestatusid">
                </td>
            
                    <!-- <td width="16%" align="left" valign='top' >&nbsp; </td>
                    <td width="24%" align="left"  valign='top'>&nbsp;</td> -->
                
            </tr>
        </table>

    </div>

    <!-- end innerbody here-->
    <h3>Bank Details</h3>

    <!-- Start innerbody here-->
    <div class="innerbody">
        <table width="100%" border="0" cellpadding="3">
            <tr>
                <td width="13%" align="left" valign='top'  ><label class="lab-inner">Bank Name :</label></td>
                <td width="18%" align="left" valign='top'>
                    <?php
                    echo $this->Form->input('Profile.vc_bank_struct_code', array('label' => false,
                        'div' => false,
                        'type' => 'select',
                        'required' => 'required',
                        'id' => 'vc_bank_struct_code',
                        'options' => $banks,
                        'default' => @$currentUser['Profile']['vc_bank_struct_code'],
                        'class' => 'round_select')
                    );
                    ?>
                </td>
                <td width="13%" align="left" valign='top'  ><label class="lab-inner">Account Number :</label></td>
                <td width="16%" align="left" valign='top' >
                    <?php
                    echo $this->Form->input('Profile.vc_account_no', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'required' => 'required',
                        'maxlength' => 19,
                        'id' => 'vc_account_no',
                        'value' => (isset($currentUser['Profile']['vc_account_no']) && $currentUser['Profile']['vc_account_no']!='')?$currentUser['Profile']['vc_account_no']:$this->data['Profile']['vc_account_no'] ,
                        'class' => 'round'));
                    ?>
                </td>
                <td width="16%" align="left" valign='top'  ><label class="lab-inner1">Bank Supportive Doc. :</label></td>
                <td width="24%" align="left" valign='top'>

                    <?php
					echo $this->Form->input('Profile.vc_bank_supportive_doc', array('label' => false,
                        'div' => false,
                        'type' => 'select',
                        'id' => 'vc_bank_supportive_doc',
                        'options' => $DocsSupportive,
                        'default' => @$currentUser['Profile']['vc_bank_supportive_doc'],
						'onchange' =>'upload_hide()',
                        'class' => 'round_select')
                    );
                    ?>
                </td>
            </tr>
            <tr id='vc_uploaded_doc_name' 
			
			<?php
			if((isset($this->data['Profile']['vc_bank_supportive_doc']) && $this->data['Profile']['vc_bank_supportive_doc']!='' )){
			
			}else{
			
			if(isset($currentUser['Profile']['ch_active']) && $currentUser['Profile']['ch_active']=="STSTY05" && $currentUser['Profile']['vc_bank_supportive_doc']!=''){
			?>
			style="display:''"			
			<?php
			}
			else{ ?>
			style="display:none"
			<?php }
			}?>>


                <td width="13%" align="left" valign='top'  ><label class="lab-inner">Upload Bank Doc. :</label>
				<br>
				<?php 
				if($currentUser['Profile']['vc_bank_supportive_doc']!='' && $currentUser['Profile']['ch_active']=="STSTY05") {
				 $url = $this->webroot . 'profiles/download';
				?>
				<a href="<?php echo $url; ?>"> Download Doc</a>
                                    
				<?php	}
					?>
				</td>
                <td colspan='5' align="left" valign='top'>
                    <?php
                    echo $this->Form->input('DocumentUpload.vc_uploaded_doc_name', array('label' => false,
                        'div' => false,
                        'type' => 'file',
						
                        //'id' => 'vc_uploaded_doc_name',
                        'class' => 'round_select')
                    );
                    ?></td>
                </td>







            </tr>
        </table>

    </div>


    <!-- end innerbody here-->    

    <h3>Customer Communication</h3>

    <!-- Start innerbody here-->
    <div class="innerbody">
        <table width="100%" border="0" cellpadding="3">
            <tr>
                <td width="13%" align="left" valign='top' ><label class="lab-inner">Street Name :</label></td>
                <td width="18%" align="left" valign='top'>
                    <?php
                    echo $this->Form->input('Profile.vc_address1', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'required' => 'required',
                        'maxlength' => 50,
                        'value' => (isset($currentUser['Profile']['vc_address1']) && $currentUser['Profile']['vc_address1']!='')?$currentUser['Profile']['vc_address1']:$this->data['Profile']['vc_address1'],
                        'id' => 'vc_address1',
                        'class' => 'round'));
                    ?>
                </td>
                <td width="13%" align="left" valign='top' ><label class="lab-inner">House No. :</label></td>
                <td width="16%" align="left" valign='top'>

                    <?php
                    echo $this->Form->input('Profile.vc_address2', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_address2',
                        'maxlength' => 50,
                        'value' => (isset($currentUser['Profile']['vc_address2']) && $currentUser['Profile']['vc_address2']!='')?$currentUser['Profile']['vc_address2']:$this->data['Profile']['vc_address2'],
                        'class' => 'round'));
                    ?>
                </td>
                <td width="16%" align="left" valign='top' ><label class="lab-inner1">P.O Box :</label></td>
                <td width="24%" align="left" valign='top' >
                    <?php
					//pr($currentUser['Profile']);
                    echo $this->Form->input('Profile.vc_address3', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'maxlength' => 20,
                        'value' => (isset($currentUser['Profile']['vc_address3']) && $currentUser['Profile']['vc_address3']!='')?$currentUser['Profile']['vc_address3']:$this->data['Profile']['vc_address3'],
                        'class' => 'round'));
                    ?>
                </td>
            </tr>
			  <tr>
                
                <td width="13%" align="left" valign='top' ><label class="lab-inner">Town / City :</label></td>
                <td width="16%" align="left" valign='top' ><?php
                    echo $this->Form->input('Profile.vc_town', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'maxlength' => 20,
                        'value' => (isset($currentUser['Profile']['vc_town']) && $currentUser['Profile']['vc_town']!='')?$currentUser['Profile']['vc_town']:$this->data['Profile']['vc_town'],
                        'class' => 'round'));
                    ?></td>
                <td width="16%" align="left" valign='top' ><label class="lab-inner">Town Municipal Bill  :</label>
				<br>
					<?php 
				if($currentUser['Profile']['ch_active']=="STSTY05" && $currentUser['Profile']['ch_municipal_type']=='Y' ) {
				 $url = $this->webroot . 'profiles/download/M';
				?>
				<a href="<?php echo $url; ?>"> Download Doc</a>
                                    
				<?php	}
					?>
				</td>
                <td width="24%" align="left" valign='top' ><?php
                   	echo $this->Form->input('DocumentUpload.vc_municipal_doc_name', array('label' => false,
                        'div' => false,
                        'type' => 'file',						
                        //'id' => 'vc_uploaded_doc_name',
                        'class' => 'round_select')
                    );
                    ?></td>
				<td width="13%" align="left" valign='top' ><label class="lab-inner">Email :</label></td>
                <td width="18%" align="left" valign='top' >
                    <?php
                    echo $this->Form->input('Profile.vc_email_id', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_email_id',
                        'readonly' => 'readonly',
                        'value' => trim($currentUser['Member']['vc_email_id']),
                        'class' => 'round disabled-field'));
                    ?>

                </td>
            </tr>
            <tr>
                <td width="13%" align="left" valign='top' ><label class="lab-inner">Telephone No. :</label></td>
                <td width="18%" align="left" valign='top' >

                    <?php
                    echo $this->Form->input('Profile.vc_tel_no', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_tel_no',
                        'maxlength' => 15,
                        'value' => (isset($currentUser['Profile']['vc_tel_no']) && $currentUser['Profile']['vc_tel_no']!='')?$currentUser['Profile']['vc_tel_no']:$this->data['Profile']['vc_tel_no'],
                        'class' => 'round'));
                    ?>
                </td>
                <td width="13%" align="left" valign='top' ><label class="lab-inner">Fax No. :</label></td>
                <td width="16%" align="left" valign='top' >
                    <?php
                    echo $this->Form->input('Profile.vc_fax_no', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'fax_no',
                        'maxlength' => 15,
                        'value' => (isset($currentUser['Profile']['vc_fax_no']) && $currentUser['Profile']['vc_fax_no']!='')?$currentUser['Profile']['vc_fax_no']:$this->data['Profile']['vc_fax_no'],
                        'class' => 'round'));
                    ?>
                </td>
                <td width="16%" align="left" valign='top'  ><label class="lab-inner1">Mobile No. :</label></td>
                <td width="24%" align="left" valign='top' >
                    <?php
                    echo $this->Form->input('Profile.vc_mobile_no', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'required' => 'required',
                        'id' => 'vc_mobile_no',
                        'value' => (isset($currentUser['Profile']['vc_mobile_no']) && $currentUser['Profile']['vc_mobile_no']!='')?$currentUser['Profile']['vc_mobile_no']:$this->data['Profile']['vc_mobile_no'],
                        'maxlength' => 15,
                        'class' => 'round'));
                    ?>
					<input type="hidden" value="<?php  if(isset($currentUser['Profile']['ch_status']) && $currentUser['Profile']['ch_status']!='')echo $currentUser['Profile']['ch_status'];?>" name ="profilestatus" id="profilestatusid">
					<input type="hidden" value="<?php  if(isset($currentUser['Profile']['ch_municipal_type']) && $currentUser['Profile']['ch_municipal_type']!='')echo $currentUser['Profile']['ch_municipal_type'];?>" name ="chmunicipaltype" id="chmunicipaltype">
					<input type="hidden" value="<?php  if(isset($currentUser['Profile']['ch_business_type']) && $currentUser['Profile']['ch_business_type']!='')echo $currentUser['Profile']['ch_business_type'];?>" name ="chbusinesstype" id="chbusinesstype">
                </td>
            </tr>
          
        </table>

    </div>
    <!-- end innerbody here-->        

    <table width="100%" border="0">
        <tr>
            <td align="center"><?php echo $this->Form->submit('Submit', array('type' => 'submit', 'class' => 'submit', 'value' => 'submit')); ?></td>
        </tr>
    </table>

</div>
<!-- end mainbody here--> 

<?php echo $this->Form->end(); ?>

<?php 
echo $this->Html->script('mdc/profile'); ?>
<?php echo $this->element('commonmessagepopup'); ?>
<?php echo $this->element('commonbackproceesing'); 
?>