<?php $currentUser = $this->Session->read('Auth'); ?>

<!-- Start wrapper here-->
<div class="wrapper">


    <!-- Start breadcrumb here-->

    <div class="breadcrumb">

        <ul>
            <li class="first">

                <?php echo $this->Html->link('Home', array('controller' => 'customers', 'action' => 'editprofile', 'cbc' => true), array('title' => 'Home', 'class' => 'vtip')) ?>

            </li>
            <li>

            <li class="last">Edit Profile</li> 


            </li>
        </ul>
    </div>
    <!-- end breadcrumb here-->

    <!-- Start mainbody here-->

    <?php echo $this->Form->create(array('url' => array('controller' => 'customers', 'action' => 'editprofile', 'cbc' => true), 'type' => 'file')); ?>		

    <div class="mainbody">
        <h1>Welcome to RFA CBC</h1>
        <h3>Customer Identification</h3>
        <!-- Start innerbody here-->
        <div class="innerbody">
            <table width="100%" border="0" cellpadding="3">
			<tr><td colspan='5' width='90%' align="right" height="10">
			<label class="lab-inner"><b>Account Status :</b></label>
			&nbsp;</td><td height="10" valign='top'><span style="font-size:12px;color:#ff0000;"><?php echo trim($globalParameterarray[$currentUser['Customer']['ch_active']]); ?></span>
			</td></tr>
			

			<tr><td colspan='5' width='90%' align="right" height="10">
			<label class="lab-inner" ><b>Remarks :</b></label>
			&nbsp;</td><td height="10" style="color:#ff0000;"valign='top'>
			<span style="color:#ff0000;">
			<?php echo $currentUser['Customer']['vc_remarks']; ?>
			</span>
			</td></tr>
			<tr>

                    <td width='15%' valign="top"><label class="lab-inner">Company Name :</label></td>
                    <td width='15%' valign="top">
                        <?php echo $this->Form->input('Customer.vc_company', array('label' => false, 'type' => 'text', 'maxlength' => 50, 'class' => 'round disabled-field', 'readonly' => 'readonly', 'value' => trim($currentUser['Customer']['vc_company']))); ?>
                    </td>


                    <td width='15%' valign="top"><label class="lab-inner">First Name :</label></td>
                    <td width='15%' valign="top">
                        <?php
                        echo $this->Form->input('Customer.nu_cust_vehicle_card_id', array('label' => false, 'type' => 'hidden', 'maxlength' => 50, 'class' => 'round', 'value' => trim($currentUser['Customer']['nu_cust_vehicle_card_id'])));


                        echo $this->Form->input('Customer.vc_first_name', array('label' => false, 'type' => 'text', 'class' => 'round', 'value' => trim($currentUser['Customer']['vc_first_name'])));
                        ?>

                    </td>


                    <td width='15%' valign="top"><label class="lab-inner">Surname :</label></td>
                    <td width='15%' valign="top">
                        <?php echo $this->Form->input('Customer.vc_surname', array('label' => false, 'type' => 'text', 'maxlength' => 50, 'class' => 'round', 'value' => trim($currentUser['Customer']['vc_surname']))); ?>

                    </td>
                </tr>

                <tr>

                    <td width='15%' valign="top"><label class="lab-inner">Contact Person :</label></td>
                    <td valign="top">
                        <?php echo $this->Form->input('Customer.vc_cont_per', array('label' => false, 'value' => trim($currentUser['Customer']['vc_cont_per']), 'type' => 'text', 'maxlength' => 50, 'class' => 'round')); ?>

                    </td>

                    <td valign="top"><label class="lab-inner">Upload Application Form :</label></td>
                    <td valign="top"><span class="valuetext"> <?php
                        echo $this->Form->input('DocumentUploadCbc.vc_upload_doc_name', array('label' => false,
                            'div' => false,
                            'type' => 'file',
                            'required' => 'required',
                            'class' => 'uploadfile'));
                        ?></span></td>
                    
                   
                    <td width="" align="left" valign='top' >
					<!--Remarks :--> </td>
                    <td width="" align="left"  valign='top'><?php
                     /*   echo $this->Form->input(null, array('label' => false,
                            'div' => false,
                            'rows' => "2",
                            'class' => "remarks",
                            'value' => $currentUser['Customer']['vc_remarks'],
                            'cols' => "16",
                            'style'=>"color:#FF0000;",
                            'disabled' => true,
                            'type' => 'textarea'));
                       */ ?></td>
                    
                    
                    
                    <!--
                    <td valign="top" width='15%'><label class="lab-inner">Upload Application <br/>Form :</label></td>
                    
                    <td colspan="2" valign="top">
                       

                       

                    </td>
                    --> <?php
                        echo $this->Form->input('Customer.editvalue', array('label' => false,
                            'div' => false,
                            'type' => 'hidden',
                            'value' => 'edit',
                        ));
                        ?>
                </tr>
                
                <tr>
                        
                    
                    <td valign="top"></td>
                    
                    <td colspan="" valign="top">
                       

                        <?php
                        echo $this->Form->input('Customer.editvalue', array('label' => false,
                            'div' => false,
                            'type' => 'hidden',
                            'value' => 'edit',
                        ));
                        ?>

                    </td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    
                </tr>

            </table>
            

        </div>

        <!-- end innerbody here--> 

        <h3>Customer Communication</h3>

        <!-- Start innerbody here-->

        <div class="innerbody">

            <table width="100%" border="0" cellpadding="3">
                <tr>
                    <td width='15%' valign="top"> <label class="lab-inner">Address 1 :</label></td>
                    <td width='15%' valign="top">

                        <?php echo $this->Form->input('Customer.vc_address1', array('label' => false, 'value' => trim($currentUser['Customer']['vc_address1']), 'type' => 'text', 'maxlength' => 50, 'class' => 'round')); ?>

                    </td>

                    <td width='15%' valign="top"><label class="lab-inner">Address 2 :</label></td>
                    <td width='15%' valign="top">

                        <?php echo $this->Form->input('Customer.vc_address2', array('label' => false, 'value' => trim($currentUser['Customer']['vc_address2']), 'type' => 'text', 'maxlength' => 50, 'class' => 'round')); ?>

                    </td>

                    <td width='15%' valign="top"><label class="lab-inner">Address 3 :</label></td>
                    <td width='15%' valign="top">


                        <?php echo $this->Form->input('Customer.vc_address3', array('label' => false, 'value' => trim($currentUser['Customer']['vc_address3']), 'type' => 'text', 'maxlength' => 50, 'class' => 'round')); ?>


                    </td>
                </tr>


                <tr>

                    <td width='15%' valign="top"><label class="lab-inner">Telephone No. :</label></td>
                    <td width='15%' valign="top">

                        <?php echo $this->Form->input('Customer.vc_tel_no', array('label' => false, 'value' => $currentUser['Customer']['vc_tel_no'], 'type' => 'text', 'maxlength' => 15, 'class' => 'round')); ?>

                    </td>
                    <td width='15%' valign="top"><label class="lab-inner">Fax No. :</label></td>
                    <td width='15%' valign="top">

                        <?php echo $this->Form->input('Customer.vc_fax_no', array('label' => false, 'value' => trim($currentUser['Customer']['vc_fax_no']), 'type' => 'text', 'maxlength' => 15, 'class' => 'round')); ?>


                    </td>

                    <td width='15%' valign="top"><label class="lab-inner">Mobile No. :</label></td>
                    <td width='15%' valign="top">


                        <?php echo $this->Form->input('Customer.vc_mobile_no', array('label' => false, 'value' => trim($currentUser['Customer']['vc_mobile_no']), 'type' => 'text', 'maxlength' => 15, 'class' => 'round')); ?>


                    </td>
                </tr>

                <tr>
                    <td width='15%' valign="top"><label class="lab-inner">Email :</label></td>
                    <td>

                        <?php echo $this->Form->input('Customer.vc_email', array('label' => false, 'type' => 'text', 'maxlength' => 50, 'readonly' => 'readonly', 'class' => 'round disabled-field', 'value' => trim($currentUser['Customer']['vc_email']))); ?>

                    </td>
                   
                    <!--
                    <td width='15%' valign="top"><label class="lab-inner">Remarks :</label></td>
                    <td>

                        <?php echo (trim($currentUser['Customer']['vc_remarks'])); ?>

                    </td>
                    -->

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
                        <?php
                        echo $this->Form->input('Customer.vc_alter_cont_person', array('label' => false,
                            'type' => 'text',
                            'maxlength' => 50,
                            'value' => trim($currentUser['Customer']['vc_alter_cont_person']),
                            'class' => 'round'));
                        ?>

                    </td>
                    <td width='15%' valign="top"><label class="lab-inner">Email ID :</label></td>
                    <td width='15%' valign="top">
                        <?php
                        echo $this->Form->input('Customer.vc_alter_email', array('label' => false,
                            'type' => 'text',
                            'value' => trim($currentUser['Customer']['vc_alter_email']),
                            'maxlength' => 50,
                            'class' => 'round'));
                        ?>
                    </td>
                    <td width='15%' valign="top"><label class="lab-inner">Phone No. :</label></td>
                    <td width='15%' valign="top">

                        <?php
                        echo $this->Form->input('Customer.vc_alter_phone_no', array('label' => false,
                            'type' => 'text',
                            'maxlength' => 15,
                            'value' => trim($currentUser['Customer']['vc_alter_phone_no']),
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
                    <?php echo $this->Form->submit('Submit', array('type' => 'submit', 'class' => 'submit', 'value' => 'submit')); ?>
                </td>

            </tr>
        </table>

    </div>

    <!-- end mainbody here-->    

</div>
<?php echo $this->Html->script('cbc/edit_profile'); ?>
<!-- end wrapper here-->