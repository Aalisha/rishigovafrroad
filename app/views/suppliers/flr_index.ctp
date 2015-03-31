<!-- Start wrapper here-->
<?php 
//pr($this->Session->read('Auth')); die;
?>
<div class="wrapper">
    <!-- Start breadcrumb here-->
    <div class="breadcrumb">
        <ul>
            <li class="first">
                <a title="Home" class="vtip" href="#">Home</a>
            </li>
            <li class="last">My Profile</li>               
        </ul>
    </div>
    <!-- end breadcrumb here-->
    <!-- Start mainbody here-->
    <div class="mainbody">
        <h1>Welcome to RFA FLR</h1>
        <h3>Wholesaler/Supplier Identification</h3>
        <!-- Start innerbody here-->
        <div class="innerbody">

            <?php echo $this->Form->create('Clientsupplier', array('url' => array('controller' => 'suppliers', 'action' => 'index'), 'type' => 'file')); ?>


            <table width="100%" border="0" cellpadding="3">
                <tr>

                    <td height="35" colspan="6" align="right" valign="middle">Account Status: <strong>Inactive</strong>

                        <?php
                        echo $this->Form->input('Clientsupplier.encemid', array('label' => false,
                            'div' => false,
                            'type' => 'hidden',
                            'value' => base64_encode(trim($this->Session->read('Auth.Member.vc_email_id')))
                        ));
                              echo $this->Form->input('Clientsupplier.vc_user_no', array('label' => false,
                            'div' => false,
                            'type' => 'hidden',
                            'value' => base64_encode(trim($this->Session->read('Auth.Member.vc_user_no')))
                        ));

					   ?>

                    </td>

                </tr>

                <tr>
                    <td width="15%" align="left" valign="top"><label class="lab-inner">Supplier Name :</label></td>
                    <td width="19%" align="left" valign="top">
                        <?php
                        echo $this->Form->input('Clientsupplier.vc_client_name', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'maxlength' => 200,
                            'readonly'=>'reaonly',
                            'value'=> $this->Session->read('Auth.Member.vc_user_firstname')." ".$this->Session->read('Auth.Member.vc_user_lastname'),
                            'class' => 'round disabled-field'
                        ));
                        ?>
                    </td>
                    <td width="16%" align="left" valign="top"><label class="lab-inner">Fuel Outlet Name :</label></td>
                    <td width="17%" align="left" valign="top">
                        <?php
                        echo $this->Form->input('Clientsupplier.vc_fuel_outlet', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'maxlength' => 100,
                            'class' => 'round'
                        ));
                        ?>
                    </td>
                    <td width="15%" align="left" valign="top"><label class="lab-inner"><!--Business Reg. Id :--></label></td>
                    <td width="20%" align="left" valign="top">
                        <?php
                        /* echo $this->Form->input('Client.vc_id_no', array('label' => false,
                          'div' => false,
                          'type' => 'text',
                          'maxlength' => 50,
                          'class' => 'round'
                          )); */
                        ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="6" align="left" valign="top">&nbsp;</td>
                </tr>
                <tr>
                    <td width="15%" height="30" align="left" valign="top"><label class="lab-inner"><strong style="text-decoration:underline;">Postal Address</strong></label></td>
                    <td width="20%" align="left" valign="top">&nbsp;</td>
                    <td width="15%" align="left" valign="top">&nbsp;</td>
                    <td width="19%" align="left" valign="top">&nbsp;</td>
                    <td width="16%" align="left" valign="top">&nbsp;</td>
                    <td width="17" align="left" valign="top">&nbsp;</td>
                </tr>
                <tr>
                    <td width="15%" align="left" valign="top"><label class="lab-inner">Address 1 :</label></td>
                    <td width="20%" align="left" valign="top">
                        <?php
                        echo $this->Form->input('Clientsupplier.vc_address1', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'maxlength' => 100,
                            'class' => 'round'));
                        ?>
                    </td>
                    <td width="15%" align="left" valign="top"><label class="lab-inner">Address 2 :</label></td>
                    <td width="19%" align="left" valign="top">
                        <?php
                        echo $this->Form->input('Clientsupplier.vc_address2', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'maxlength' => 50,
                            'class' => 'round'));
                        ?>
                    </td>
                    <td width="16%" align="left" valign="top"><label class="lab-inner">Address 3 :</label></td>
                    <td width="17" align="left" valign="top">
                        <?php
                        echo $this->Form->input('Clientsupplier.vc_address3', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'maxlength' => 50,
                            'class' => 'round'));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td width="15%" align="left" valign="top"><label class="lab-inner">Postal Code :</label></td>
                    <td width="20%" align="left" valign="top">
                        <?php
                        echo $this->Form->input('Clientsupplier.vc_postal_code1', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'maxlength' => 25,
                            'class' => 'round'));
                        ?>
                    </td>
                    <td width="15%" align="left" valign="top"><label class="lab-inner">Tel. No. :</label></td>
                    <td width="19%" align="left" valign="top">
                        <?php
                        echo $this->Form->input('Clientsupplier.vc_tel_no', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'maxlength' => 15,
                            'class' => 'round'));
                        ?>
                    </td>
                    <td width="16%" align="left" valign="top"><label class="lab-inner">Mobile No. :</label></td>
                    <td width="17" align="left" valign="top">
                        <?php
                        echo $this->Form->input('Clientsupplier.vc_cell_no', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'maxlength' => 15,
                            'class' => 'round'));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td width="15%" align="left" valign="top"><label class="lab-inner">Fax No. :</label></td>
                    <td width="20%" align="left" valign="top">
                        <?php
                        echo $this->Form->input('Clientsupplier.vc_fax_no', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'maxlength' => 15,
                            'class' => 'round'));
                        ?>

                    </td>
                    <td width="15%" align="left" valign="top"><label class="lab-inner">Email :</label></td>
                    <td width="19%" align="left" valign="top">
                        <?php
                        echo $this->Form->input('Clientsupplier.vc_email', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'maxlength' => 50,
                            'disabled' => 'disabled',
                            'value' => trim($this->Session->read('Auth.Member.vc_email_id')),
                            'class' => 'round disabled-field'));
                        ?>

                    </td>
                    <td width="16%" align="left" valign="top">&nbsp;</td>
                    <td width="17" align="left" valign="top">&nbsp;</td>
                </tr>
               

            </table>
            <table width="100%" border="0" cellpadding="3">
                

                <tr>
                     <td width="15%" align="left" valign="top"><label class="lab-inner">Upload Document :</label></td>
                        <td width="20%" align="left" valign="top"><?php
                    echo $this->Form->input('ClientUploadDocs.fuelusagedoc', array('label' => false,
                        'div' => false,
                        'type' => 'file',
                        'class' => 'uploadfile'));
                    ?>
                    </td>
                    
                    <td width="15%" align="left" valign="top">&nbsp;</td>
                    <td width="19%" align="left" valign="top">&nbsp;</td>
                    <td width="16%" align="left" valign="top">&nbsp;</td>
                    <td width="17%" align="left" valign="top">&nbsp;</td>
                </tr>
                
                <tr>
                    <td colspan="6" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td width="23%" height="30" align="left" valign="top">&nbsp;</td>
                                <td width="28%" height="30" align="left" valign="top">&nbsp;</td>
                                <td width="24%" height="30" align="left" valign="top">&nbsp;</td>
                                <td width="25%" height="30" align="left" valign="top">&nbsp;</td>
                            </tr>
                        </table></td>
                </tr>
            </table></td>
            </tr>
            </table>
            <table  width="100%" border="0" cellpadding="3" >

                <tr>

                    <td   width='50%' colspan='3' align="right" valign="top">
                        <?php echo $this->Form->submit('Submit', array('div' => false, 'label' => false, 'type' => 'submit', 'class' => 'submit', 'value' => 'submit')); ?>
                    </td>
                    <td    width='50%'  colspan ='3' align="left" valign="top">
                        <?php echo $this->Form->submit('Reset', array('div' => false, 'label' => false, 'type' => 'reset', 'class' => 'submit', 'value' => 'Reset')); ?>
                    </td>

                </tr>

            </table>


            <?php echo $this->Form->end(null); ?>	
        </div>
        <!-- end innerbody here-->

    </div>
    <!-- end mainbody here-->    
</div>
<?php echo $this->Html->script('flr/supplier_index'); ?>
<?php //echo $this->element('commonmessagepopup'); ?>
<?php //echo $this->element('commonbackproceesing'); ?>