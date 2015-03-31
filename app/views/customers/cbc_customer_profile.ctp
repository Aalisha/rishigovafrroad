<?php $currentUser = $this->Session->read('Auth.Member'); ?>

<!-- Start wrapper here-->
<div class="wrapper">
    <!-- Start breadcrumb here-->
    <div class="breadcrumb">
        <ul>
            <li class="first">
                <?php echo $this->Html->link('Home', array('controller' => 'customers', 'action' => 'view', 'cbc' => true), array('title' => 'Home', 'class' => 'vtip')) ?>
            </li>
            
            <li class="last">Add Profile</li>            
        </ul>
    </div>
    <!-- end breadcrumb here-->

    <!-- Start mainbody here-->


    <?php echo $this->Form->create('Customer', array('url' => array('controller' => 'customers', 'action' => 'cbc_customer_profile', 'cbc' => true),'type' => 'file')); ?>		


    <div class="mainbody">
        <h1>Welcome to RFA CBC</h1>
        <h3>Customer Identification</h3>
        <!-- Start innerbody here-->
        <div class="innerbody">
            <table width="100%" border="0" cellpadding="3">
                <tr>

                    <td width='15%' valign="top"><label class="lab-inner">Company Name :</label></td>
                    <td width='15%' valign="top">
                        <?php echo $this->Form->input('Customer.vc_company', array('label' => false, 
                            'id'=>'vc_company',
                            'type' => 'text', 
                            'maxlength'=>50,
                            'class' => 'round')); 
                        ?>
                    </td>


                    <td width='10%' valign="top"><label class="lab-inner">First Name :</label></td>
                    <td width='10%' valign="top">
                        <?php echo $this->Form->input('Customer.vc_first_name', array('label' => false, 
                            'type' => 'text', 
                            'class' => 'round', 
                            'id'=>'vc_first_name',
                            'value' => $currentUser['vc_user_firstname'], 
                            'maxlength'=>50)); 
                        
                        ?>

                    </td>


                    <td width='15%' valign="top"><label class="lab-inner">Surname :</label></td>
                    <td  width='15%' valign="top">
                        <?php echo $this->Form->input('Customer.vc_surname', 
                                array('label' => false, 
                                    'type' => 'text', 
                                    'class' => 'round', 
                                    'value' => $currentUser['vc_user_lastname'],
                                    'maxlength'=>50)); 
                        ?>

                    </td>
                </tr>

                <tr>

                    <td width='15%' valign="top"><label class="lab-inner">Contact Person :</label></td>
                    <td width='15%' valign="top">
                        <?php echo $this->Form->input('vc_cont_per', 
                                array('label' => false, 
                                    'type' => 'text', 
                                    'id'=>'vc_cont_per',
                                    'required' => 'required', 
                                    'maxlength'=>50,
                                    'class' => 'round')); 
                        ?>

                    </td>

                    <td width='10%' valign="top"><label class="lab-inner">Account Status :</label></td>
                    <td width='10%' valign="top"><span class="valuetext">Inactive</span></td>
						<td width='18%' valign="top"><label class="lab-inner">Upload Application <br/>Form :</label></td>
                        <td width='18%' valign="top">
                            <?php
								echo $this->Form->input('DocumentUploadCbc.vc_upload_doc_name', array('label' => false,
																			'div' => false,
																			'type' => 'file',
																			'required' => 'required',
																			'class' => 'uploadfile'));
                            ?>
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
                    <td width='15%' valign="top"><label class="lab-inner">Address 1 :</label></td>
                    <td width='15%' valign="top">

                        <?php echo $this->Form->input('vc_address1', array('label' => false, 
                                    'type' => 'text', 
                                     'id'=>'vc_address1',
                                     'maxlength'=>50,
                                    'required' => 'required',
                                    'class' => 'round')); 
                        ?>

                    </td>

                    <td width='10%' valign="top"><label class="lab-inner">Address 2 :</label></td>
                    <td width='10%' valign="top">

                        <?php echo $this->Form->input('vc_address2', array('label' => false, 
                            'type' => 'text', 
                            'maxlength'=>50,
                            'class' => 'round')); 
                        ?>

                    </td>

                    <td  width='18%' valign="top"><label class="lab-inner">Address 3 :</label></td>
                    <td width='18%' valign="top">

                        <?php echo $this->Form->input('vc_address3', array('label' => false, 
                            'type' => 'text', 
                            'maxlength'=>50,
                            'class' => 'round')); 
                        ?>


                    </td>
                </tr>


                <tr>

                    <td width='15%' valign="top"><label class="lab-inner">Telephone No. :</label></td>
                    <td width='15%' valign="top">

                        <?php echo $this->Form->input('vc_tel_no', array('label' => false,
                            'type' => 'text', 
                            'maxlength'=>15,
                            'class' => 'round')); 
                        ?>
                    </td>
                    <td width='10%' valign="top"><label class="lab-inner">Fax No. :</label></td>
                    <td width='10%' valign="top">

                        <?php echo $this->Form->input('vc_fax_no', array('label' => false, 
                            'type' => 'text', 
                            'maxlength'=>15,
                            'class' => 'round')); 
                        ?>


                    </td>

                    <td width='18%' valign="top"><label class="lab-inner">Mobile No. :</label></td>
                    <td width='18%' valign="top">

                        <?php echo $this->Form->input('vc_mobile_no', 
                                array('label' => false, 'type' => 'text', 
                                    'id'=>'vc_mobile_no',
                                    'maxlength'=>15,
                                    'required' => 'required', 
                                    'class' => 'round')); 
                        ?>


                    </td>
                </tr>

                <tr>
                    <td width='15%' valign="top"><label class="lab-inner">Email :</label></td>
                    <td width='15%' valign="top"><?php echo $this->Form->input('Customer.vc_email', 
                            array('label' => false, 'type' => 'text', 
                                'class' => 'round disabled-field', 
                                'value' => $currentUser['vc_email_id'], 
                                'readonly' => 'readonly')); 
                    ?>
                    </td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
                </tr>

            </table>

        </div>
        <!-- end innerbody here-->

        <h3>Alternative Contact Person Information</h3>

        <!-- Start innerbody here-->

        <div class="innerbody">

            <table width="100%" border="0" cellpadding="3">
                <tr>
                   <td width='15%' valign="top"><label class="lab-inner">Contact Person<br/> Name :</label></td>
                    <td width='15%'valign="top">
                        <?php echo $this->Form->input('vc_alter_cont_person',array('label' => false, 
																					'type' => 'text', 
																					'maxlength'=>50,
																					'class' => 'round')); 
                        ?>

                    </td>
                    <td width='10%' valign="top"><label class="lab-inner">Email ID :</label></td>
                    <td width='10%' valign="top">
					<?php 
						echo $this->Form->input('vc_alter_email', array('label' => false, 
																		'type' => 'text', 
																		'maxlength'=>50,
																		'class' => 'round')); 
                    ?>
                    </td>
					<td width='18%' valign="top"><label class="lab-inner">Phone No. :</label></td>
                    <td width='18%' valign="top">

                        <?php echo $this->Form->input('vc_alter_phone_no', array('label' => false, 
																				'type' => 'text',
																				'maxlength'=>15,
																				'class' => 'round')); 
                        ?>
                    </td>
                </tr>

            </table>

        </div>
        <!-- end innerbody here-->        

        <table width="100%" border="0">
            <tr>
				<td align="center">
				<?php echo $this->Form->submit('Submit', array('type' => 'submit', 'class' => 'submit', 'value' => 'submit',
				'id'=>'submitcustomerprofileid'
				)); ?>
				</td>
			</tr>
        </table>
		
		<?php echo $this->Form->end(); ?>

    </div>

    <!-- end mainbody here-->    

</div>
<?php echo $this->Html->script('cbc/addprofile'); ?>
<!-- end wrapper here-->

