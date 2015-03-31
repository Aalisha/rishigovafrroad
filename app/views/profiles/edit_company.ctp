<?php 
$currentUser = $this->Session->read('Auth');
?>
<!-- Start breadcrumb here-->
<div class="breadcrumb">
    <ul>
        <li class="first">

            <?php echo $this->Html->link('Home', array('controller' => 'profiles', 'action' => 'index'), array('title' => 'Home', 'class' => 'vtip')) ?>

        </li>
            <li class="last">Edit Company</li> 
    </ul>
</div>
<!-- end breadcrumb here-->

<!-- Start mainbody here-->
<div class="mainbody">

    <h1><?php echo $mdclocal; ?></h1>

	<table width='100%' border='0'>
		
				<tr>				
				<td width="80%" colspan='3' align="right" valign='top'> 
				<label class="lab-inner"><b>Company Status :</b></label>
				</td>				
				<td width="20%" align="left" valign='top'><span class="valuetext" style="color:#ff0000;">
							<?php
							  echo $globalParameterarray[$company['Company']['ch_status']];
							?>
						</span>
					</td>
				</tr>
				
				<tr>
			
				
				
				<td width="80%" colspan='3' align="right" valign='top'> 
				<label class="lab-inner"><b> Remarks : </b></label> 
				</td>
				<td width="20%" align="left" valign='top'>
				<span style="color:#ff0000;">
					<?php echo $company['Company']['vc_remarks'];?>
					</span>
					</td>
				</tr>
			
	</table>
	    <h3>Company Details</h3>

    <!-- Start innerbody here-->
    <?php echo $this->Form->create(array('url' => array('controller' => 'profiles', 'action' => 'edit_company'), 'type' => 'file')); ?>
    <div class="innerbody">

        <table width="100%" border="0" cellpadding="3">
            <?php
				//pr($data);
			//pr($company['Company']);
                        echo $this->Form->input('Company.nu_company_id', array('label' => false,
                            'div' => false,
                            'class' => 'round',
							'type' =>'hidden',
							'value'=>$company['Company']['nu_company_id']					
							));
				
			?>
			
				<td width="13%" align="left" valign='top' ><label class="lab-inner">Customer Name :</label></td>
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
                <td width="18%" align="left" valign='top'>		
                    <?php
                    echo $this->Form->input('Company.vc_business_reg', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        //'required' => 'required',
                        'maxlength' => 50,
						'value' => @$company['Company']['vc_business_reg'],
						'id' => 'vc_business_reg',
                        'class' => 'round'));
                    ?>
                </td>
				<td width="13%" align="left" valign='top'  ><label class="lab-inner">Customer Type :</label></td>
                <td width="18%" align="left" valign='top' >
                    <?php
					//pr($CustType);
			//pr($company['Company']['vc_cust_type']);
					//pr($CustType);
                    echo $this->Form->input('Company.vc_cust_type', array('label' => false,
                        'div' => false,
                        'type' => 'select',
                        'id' => 'vc_cust_type',
                        'required' => 'required',
                        'options' => $CustType,
						'default' => $company['Company']['vc_cust_type'],
                        'class' => 'round_select')
                    );
                    ?>
                </td>
				</tr>
				<tr>
					<td width="13%" align="left" valign="top">Company Name :</td>
					<td  width="18%" align="left" valign="top">
							
								<?php echo $this->Form->input("Company.vc_company_name", array(
												'div' => false,
												'label' => false,
												'maxlength' => 100,
												'class' => 'round',
												'value' => @$company['Company']['vc_company_name'],
												'type' => 'text')) ?>
							
					</td>
					<!--
					<td width="13%" align="left" valign='top' >&nbsp;</td>
					<td width="18%" align="left" valign='top' >&nbsp;</td>
					-->
					<td width="13%" align="left" valign='top' ><label class="lab-inner">Business Certificate Doc:</label>
					<br>
					<?php
					//pr($company);
					//echo $company['Company']['ch_business_type'];
					if($company['Company']['ch_business_type']=='Y'){


									echo '<br>';
									
									$url =$this->webroot."profiles/download/B";
									?>
									<a href="<?php  echo $url;?>">Download Doc.</a>
									<?php 								 
									echo '<br>';

									}
									?>
					</td>
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
						'default' => @$company['Company']['vc_bank_struct_code'],
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
						'value' => @$company['Company']['vc_account_no'],
                        'class' => 'round'));
                    ?>
                </td>
                <td width="13%" align="left" valign='top'  ><label class="lab-inner1">Bank Supportive Doc. :</label>
				
				</td>
                <td width="18%" align="left" valign='top'>

                    <?php
                    echo $this->Form->input('Company.vc_bank_supportive_doc', array('label' => false,
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
            <tr id='vc_uploaded_doc_name' <?php
			
			if((isset($this->data['Company']['vc_bank_supportive_doc']) && 
			$this->data['Company']['vc_bank_supportive_doc']!='')){
			
			}
			else{
			
			if($company['Company']['ch_status']=="STSTY05" && $currentUser['Profile']['vc_bank_supportive_doc']!=''){
			?>
			style="display:''"
			
			<?php
			}
			
			else{ ?>
			style="display:none"
			<?php }
			
			}?>
			
			>


                <td width="13%" align="left" valign='top'  ><label class="lab-inner">Upload Bank Doc. :</label>
				<br/>
				<?php	if($company['Company']['vc_bank_supportive_doc']!=''){


									
									$url =$this->webroot."profiles/download";
									?>
									<a href="<?php  echo $url;?>">Download Doc.</a>
									<?php 								 
									echo '<br>';

				}
				?>
				</td>
                <td colspan='5' align="left" valign='top'>
                    <?php
                    echo $this->Form->input('DocumentUpload.vc_uploaded_doc_name', array('label' => false,
                        'div' => false,
                        'type' => 'file',
                        'id' => 'vc_uploaded_doc_name',
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
                    echo $this->Form->input('Company.vc_address1', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'required' => 'required',
                        'maxlength' => 50,
                        'id' => 'vc_address1',
						'value' => @$company['Company']['vc_address1'],
                        'class' => 'round'));
                    ?>
                </td>
                <td width="13%" align="left" valign='top' ><label class="lab-inner">House No. :</label></td>
                <td width="18%" align="left" valign='top'>

                    <?php
                    echo $this->Form->input('Company.vc_address2', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_address2',
						'value' => @$company['Company']['vc_address2'],
                        'maxlength' => 50,
                        'class' => 'round'));
                    ?>
                </td>
                <td width="13%" align="left" valign='top' ><label class="lab-inner1" style="width:70px;">P.O Box :</label></td>
                <td width="18%" align="left" valign='top' >
                    <?php
                    echo $this->Form->input('Company.vc_address3', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'maxlength' => 20,
						'value' => @$company['Company']['vc_address3'],
                        'class' => 'round'));
                    ?>
                </td>
            </tr>
			
			<tr>
			  <td width="13%" align="left" valign='top' ><label class="lab-inner1">Town / City :</label></td>
                <td width="18%" align="left" valign='top' >
                    <?php
                    echo $this->Form->input('Company.vc_town', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'maxlength' => 20,
						'value' => @$company['Company']['vc_town'],
                        'class' => 'round'));
                    ?>
                </td>
               <td width="13%" align="left" valign='top' ><label class="lab-inner1">Town Municipal Bill  :</label>
			   <br/><?php
if($company['Company']['ch_municipal_type']=='Y'){	
$url = $this->webroot . 'profiles/download/M';?>
						<a href="<?php  echo $url;?>">Download Doc.</a><?php 
}

?>		   
			   </td>
                <td width="18%" align="left" valign='top' >
                    
				<table>
				<tr>
					
					<td>
                    <?php
                   	echo $this->Form->input('DocumentUpload.vc_municipal_doc_name', array('label' => false,
                        'div' => false,
                        'type' => 'file',						
                        //'id' => 'vc_uploaded_doc_name',
                        'class' => 'round_select')
                    );?>
                    
</td>
						</tr>
				</table>
				
				
                </td>
                <td width="13%" align="left" valign='top' ><label class="lab-inner" style="width:70px;">Email :</label></td>
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
						'value' => @$company['Company']['vc_tel_no'],
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
						'value' => @$company['Company']['vc_fax_no'],
                        'class' => 'round'));
                    ?>
                </td>
                <td width="13%" align="left" valign='top'  ><label class="lab-inner1" style="width:70px;">Mobile No. :</label></td>
                <td width="18%" align="left" valign='top' >
                    <?php
                    echo $this->Form->input('Company.vc_mobile_no', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'required' => 'required',
                        'id' => 'vc_mobile_no',
						'value' => @$company['Company']['vc_mobile_no'],
                        'maxlength' => 15,
                        'class' => 'round'));
                    ?>
					<input type="hidden" value="<?php  if(isset($company['Company']['ch_status']) && $company['Company']['ch_status']!='')echo $company['Company']['ch_status'];?>" name ="profilestatus" id="profilestatusid">
					<input type="hidden" value="<?php  if(isset($company['Company']['ch_municipal_type']) && $company['Company']['ch_municipal_type']!='')echo $company['Company']['ch_municipal_type'];?>" name ="chmunicipaltype" id="chmunicipaltype">
					<input type="hidden" value="<?php  if(isset($company['Company']['ch_business_type']) && $company['Company']['ch_business_type']!='')echo $company['Company']['ch_business_type'];?>" name ="chbusinesstype" id="chbusinesstype">
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
<?php  echo $this->Html->script('mdc/edit_company'); ?>
<?php  //echo $this->element('commonmessagepopup'); ?>
<?php //echo $this->element('commonbackproceesing'); ?>