<?php $currentUser = $this->Session->read('Auth');?>
<!-- Start breadcrumb here-->
<div class="breadcrumb">
    <ul>
        <li class="first">

            <?php echo $this->Html->link('Home', array('controller' => 'profiles', 'action' => 'index'), array('title' => 'Home', 'class' => 'vtip')) ?>

        </li>
            <li class="last">Add Company</li> 
    </ul>
</div>
<!-- end breadcrumb here-->

<!-- Start mainbody here-->
<div class="mainbody">

    <h1><?php echo $mdclocal; ?></h1>

    <h3>Company Details</h3>

    <!-- Start innerbody here-->
    <?php echo $this->Form->create(array('url' => array('controller' => 'profiles', 'action' => 'add_more_company'), 'type' => 'file')); ?>
    <div class="innerbody">

        <table width="100%" border="0" cellpadding="3">
            <tr>
				<td width="13%" align="left" valign='top' ><label class="lab-inner">Customer Name :</label></td>
                <?php
                if ($this->Session->check('Auth.Member.vc_user_no')) :
                    echo $this->Form->input('vc_user_no', array(
                        'type' => 'hidden',
                        'value' => base64_encode($this->Session->read('Auth.Member.vc_user_no')),
                    ));
                endif;
                ?>
                <td width="18%" align="left" valign='top' >

                    <?php
                    echo $this->Form->input('Company.vc_customer_name', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_customer_name',
                        'readonly' => 'readonly',
                        'value' => trim($currentUser['Member']['vc_user_firstname'] . ' ' . $currentUser['Member']['vc_user_lastname']),
                        'class' => 'round disabled-field'));
                    ?>
                </td>
				<td width="13%" align="left" valign='top' >
                    <label class="lab-inner">Business Registration :</label>
                </td>
                <td width="18%" align="left" valign='top' >
                    <?php
                    echo $this->Form->input('Company.vc_business_reg', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                       // 'required' => 'required',
                        'maxlength' => 50,
                        'id' => 'vc_business_reg',
                        'class' => 'round'));
                    ?>
                </td>
				<td width="13%" align="left" valign='top'  ><label class="lab-inner">Customer Type :</label></td>
                <td width="18%" align="left" valign='top' >
                    <?php
                    echo $this->Form->input('Company.vc_cust_type', array('label' => false,
                        'div' => false,
                        'type' => 'select',
                        'id' => 'vc_cust_type',
                        'required' => 'required',
                        'options' => $CustType,
                        'class' => 'round_select')
                    );
                    ?>
                </td>
				</tr>
				<tr>
					<td width="13%" align="left" valign="top">Company Name :</td>
						<td  width="18%" align="left" valign="top">
								
									<?php echo $this->Form->input("Company.vc_company_name", array('div' => false,
										'label' => false,
										'maxlength' => 100,
										'class' => 'round',
										'type' => 'text')) ?>
								
						</td>

					
					<td width="13%" align="left" valign='top' ><label class="lab-inner">Business Registration Doc:</label></td>
					<td width="18%" align="left" valign='top' >	<span class="valuetext"> 
                         <?php
                    echo $this->Form->input('DocumentUpload.vc_business_reg_doc', array('label' => false,
                        'div' => false,
                        'type' => 'file',						
                        'id' => 'vc_business_reg_doc',
                        'class' => 'round_select')
                    );
                 
                        ?></span></td>

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
                    echo $this->Form->input('Company.vc_bank_struct_code', array('label' => false,
                        'div' => false,
                        'type' => 'select',
                        'required' => 'required',
                        'id' => 'vc_bank_struct_code',
                        'options' => $banks,
                        'class' => 'round_select')
                    );
                    ?>
                </td>
                <td width="13%" align="left" valign='top'  ><label class="lab-inner">Account Number :</label></td>
                <td width="18%" align="left" valign='top' >
                    <?php
                    echo $this->Form->input('Company.vc_account_no', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'required' => 'required',
                        'maxlength' => 19,
                        'id' => 'vc_account_no',
                        'class' => 'round'));
                    ?>
                </td>
                <td width="13%" align="left" valign='top'  ><label class="lab-inner1">Bank Supportive Doc. :</label></td>
                <td width="18%" align="left" valign='top'>

                    <?php
                    echo $this->Form->input('Company.vc_bank_supportive_doc', array('label' => false,
                        'div' => false,
                        'type' => 'select',
                        'id' => 'vc_bank_supportive_doc',
                        'options' => $DocsSupportive,
						'onchange' =>'upload_hide()',
                        'class' => 'round_select')
                    );
                    ?>
                </td>
            </tr>
<?php
	//pr($this->data);
?>        
		<tr id='vc_uploaded_doc_name' 
			<?php
			
			if((isset($this->data['Company']['vc_bank_supportive_doc']) && $this->data['Company']['vc_bank_supportive_doc']!='' ) ){
			
			}
			else{
			?>
			style="display:none"
			<?php }?>
			>


                <td width="13%" align="left" valign='top'  ><label class="lab-inner">Upload Bank Doc. :</label></td>
                <td colspan='5' align="left" valign='top'>
                    <?php
                    echo $this->Form->input('DocumentUpload.vc_uploaded_doc_name', array('label' => false,
                        'div' => false,
                        'type' => 'file',
                        'id' => 'vc_uploaded_doc_name',
						
                        'class' => 'round_select')
                    );
                    ?></td>
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
                    echo $this->Form->input('Company.vc_address1', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'required' => 'required',
                        'maxlength' => 50,
                        'id' => 'vc_address1',
                        'class' => 'round'));
                    ?>
                </td>
                <td width="13%" align="left" valign='top' ><label class="lab-inner">House No.:</label></td>
                <td width="18%" align="left" valign='top'>

                    <?php
                    echo $this->Form->input('Company.vc_address2', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_address2',
                        'maxlength' => 50,
                        'class' => 'round'));
                    ?>
                </td>
                <td width="13%" align="left" valign='top' ><label class="lab-inner1">P.O Box :</label></td>
                <td width="18%" align="left" valign='top' >
                    <?php
                    echo $this->Form->input('Company.vc_address3', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'maxlength' => 20,
                        'class' => 'round'));
                    ?>
                </td>
            </tr>
			<tr>
                
				  <td width="13%" align="left" valign='top' ><label class="lab-inner">Town / City :</label></td>
                <td width="18%" align="left" valign='top' ><?php
                    echo $this->Form->input('Company.vc_town', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'maxlength' => 20,
                        'value' => '',
                        'class' => 'round'));
                    ?></td>
                <td width="13%" align="left" valign='top' ><label class="lab-inner">Town Municipal Bill  :</label></td>
                <td width="18%" align="left" valign='top' ><?php
                 
					echo $this->Form->input('DocumentUpload.vc_municipal_doc_name', array('label' => false,
                        'div' => false,
                        'type' => 'file',						
                        //'id' => 'vc_uploaded_doc_name',
                        'class' => 'round_select'));
                    ?></td>
                <td width="13%" align="left" valign='top' ><label class="lab-inner">Email :</label></td>
                <td width="18%" align="left" valign='top' >
                    <?php
                    echo $this->Form->input('Company.vc_email_id', array('label' => false,
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
                    echo $this->Form->input('Company.vc_tel_no', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_tel_no',
                        'maxlength' => 15,
                        'class' => 'round'));
                    ?>
                </td>
                <td width="13%" align="left" valign='top' ><label class="lab-inner">Fax No. :</label></td>
                <td width="18%" align="left" valign='top' >
                    <?php
                    echo $this->Form->input('Company.vc_fax_no', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'fax_no',
                        'maxlength' => 15,
                        'class' => 'round'));
                    ?>
                </td>
                <td width="13%" align="left" valign='top'  ><label class="lab-inner1">Mobile No. :</label></td>
                <td width="18%" align="left" valign='top' >
                    <?php
                    echo $this->Form->input('Company.vc_mobile_no', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'required' => 'required',
                        'id' => 'vc_mobile_no',
                        'maxlength' => 15,
                        'class' => 'round'));
                    ?>
                </td>
            </tr>
			
        </table>
    </div>
	<table width="100%" border="0">
        <tr>
            <td align="center"><?php echo $this->Form->submit('Submit', array('type' => 'submit', 'class' => 'submit', 'value' => 'submit')); ?></td>
        </tr>
    </table>
    <!-- end innerbody here-->   
</br>
</div>
<!-- end mainbody here--> 

<?php echo $this->Form->end(); ?>
<?php echo $this->Html->script('mdc/add_more_company'); ?>
<?php  //echo $this->element('commonmessagepopup'); ?>
<?php //echo $this->element('commonbackproceesing'); ?>