<!-- Start wrapper here-->
<div class="wrapper">
    <!-- Start breadcrumb here-->
    <div class="breadcrumb">
        <ul>
            <li class="first">
                <?php echo $this->Html->link('Home', array('controller' => 'clients', 'action' => 'view', 'flr' => true), array('title' => 'Home', 'class' => 'vtip')) ?>
            </li>

            <li class="last">Change of Ownership</li> <li class="last clientnoclass" style=""  >Client No.&nbsp;:&nbsp;<?php echo ltrim($this->Session->read('Auth.Client.vc_client_no'),'01');?></li>         
        </ul>
    </div>
    <!-- end breadcrumb here-->
    <!-- Start mainbody here-->
    <div class="mainbody">
        <h1>Welcome to RFA FLR</h1>
        <h3>Change of Ownership</h3>
        <!-- Start innerbody here-->
        <?php echo $this->Form->create(array('url' => array('controller' => 'clients', 'action' => 'changeofownership', 'flr' => true), 'type' => 'file')); ?>
        <div class="innerbody">
            <table width="100%" border="0" cellpadding="3">
                <tr>
                    <td width="10%" align="left" valign="top"><label class="lab-inner">Business Reg. Id :</label></td>
                    <td width="10%" align="left" valign="top">
                        <?php
                        echo $this->Form->input('Client.vc_id_no', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'value' => $this->Session->read('Auth.Client.vc_id_no'),
                            'disabled' => 'disabled',
                            'class' => 'round'));
                        ?>
                    </td>
                    <td width="10%" align="left" valign="top"><label class="lab-inner">Client No. / Name :</label></td>
                    <td width="35%" align="left" valign="top">
                        <?php
                        echo $this->Form->input('Client.vc_client_no', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'value' =>ltrim($this->Session->read('Auth.Client.vc_client_no'),'01'),
                            'disabled' => 'disabled',
                            'class' => 'round4'));
                        ?>
                        &nbsp; 
                        <?php
                        echo $this->Form->input('Client.vc_client_name', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'value' => $this->Session->read('Auth.Client.vc_client_name'),
                            'disabled' => true,
                            'readonly' => true,
                            'class' => 'round'));
                        ?>
                        &nbsp; </td>
                    <td width="10%" align="left" valign="top"><label class="lab-inner">Contact Person :</label></td>
                    <td width="25%" align="left" valign="top">
                        <?php
                        echo $this->Form->input('Client.vc_contact_person', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'disabled' => true,
                            'readonly' => true,
                            'value' => $this->Session->read('Auth.Client.vc_contact_person'),
                            'class' => 'round'));
                        ?>
                    </td>
                </tr>

            </table>
            <br>
            <table width="100%" border="0" cellpadding="3">
                <tr class="listhead">
                    <td colspan ='2' align="center">Postal Address</td>
                    <td colspan ='2' align="center">Business Address</td>
                </tr>
                <tr >
                    <td colspan ='4' align="center"><?php
                        $checked = array();
                        if (trim($this->Session->read('Auth.Client.vc_cp_address')) == 'Y') :
                            $checked +=array('checked' => true);
                        endif;
                        echo $this->Form->checkbox('ClientChangeHistory.vc_cp_address', $checked);
                        ?>
                        Copy Postal Address</td>

                </tr>
                <tr>
                    <td width="15%"><label class="lab-inner">Address 1 :</label></td>
                    <td width="35%">
                        <?php
                        echo $this->Form->input('ClientChangeHistory.vc_address1', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'maxlength' => 100,
                            'value' => $this->Session->read('Auth.Client.vc_address1'),
                            'class' => 'round'));
                        ?>
                    </td>
                    <td width="15%"><label class="lab-inner">Address 1:</label></td>
                    <td width="35%">
                        <?php
                        echo $this->Form->input('ClientChangeHistory.vc_address4', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'maxlength' => 100,
                            'value' => $this->Session->read('Auth.Client.vc_address4'),
                            'class' => 'round'));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td width="13%"><label class="lab-inner">Address 2 :</label></td>
                    <td width="37%">
                        <?php
                        echo $this->Form->input('ClientChangeHistory.vc_address2', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'maxlength' => 50,
                            'value' => $this->Session->read('Auth.Client.vc_address2'),
                            'class' => 'round'));
                        ?>
                    </td>
                    <td width="13%"><label class="lab-inner">Address 2 :</label></td>
                    <td width="37%">
                        <?php
                        echo $this->Form->input('ClientChangeHistory.vc_address5', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'maxlength' => 50,
                            'value' => $this->Session->read('Auth.Client.vc_address5'),
                            'class' => 'round'));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td width="13%"><label class="lab-inner">Address 3 :</label></td>
                    <td width="37%">
                        <?php
                        echo $this->Form->input('ClientChangeHistory.vc_address3', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'maxlength' => 50,
                            'value' => $this->Session->read('Auth.Client.vc_address3'),
                            'class' => 'round'));
                        ?>
                    </td>
                    <td width="13%"><label class="lab-inner">Address 3 :</label></td>
                    <td width="37%">
                        <?php
                        echo $this->Form->input('ClientChangeHistory.vc_address6', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'maxlength' => 50,
                            'value' => $this->Session->read('Auth.Client.vc_address6'),
                            'class' => 'round'));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td width="13%"><label class="lab-inner">Postal Code :</label></td>
                    <td width="37%">
                        <?php
                        echo $this->Form->input('ClientChangeHistory.vc_postal_code1', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'maxlength' => 25,
                            'value' => $this->Session->read('Auth.Client.vc_postal_code1'),
                            'class' => 'round'));
                        ?>
                    </td>
                    <td width="13%"><label class="lab-inner">Postal Code :</label></td>
                    <td width="37%">
                        <?php
                        echo $this->Form->input('ClientChangeHistory.vc_postal_code2', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'maxlength' => 25,
                            'value' => $this->Session->read('Auth.Client.vc_postal_code2'),
                            'class' => 'round'));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><label class="lab-inner">Telephone No. :</label></td>
                    <td>
                        <?php
                        echo $this->Form->input('ClientChangeHistory.vc_tel_no', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'maxlength' => 15,
                            'value' => $this->Session->read('Auth.Client.vc_tel_no'),
                            'class' => 'round'));
                        ?>
                    </td>
                    <td><label class="lab-inner">Telephone No. :</label></td>
                    <td>
                        <?php
                        echo $this->Form->input('ClientChangeHistory.vc_tel_no2', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'maxlength' => 15,
                            'value' => $this->Session->read('Auth.Client.vc_tel_no2'),
                            'class' => 'round'));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><label class="lab-inner">Mobile No. :</label></td>
                    <td>
                        <?php
                        echo $this->Form->input('ClientChangeHistory.vc_cell_no', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'maxlength' => 15,
                            'value' => $this->Session->read('Auth.Client.vc_cell_no'),
                            'class' => 'round'));
                        ?>
                    </td>
                    <td><label class="lab-inner">Mobile No. :</label></td>
                    <td>
                        <?php
                        echo $this->Form->input('ClientChangeHistory.vc_cell_no2', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'maxlength' => 15,
                            'value' => $this->Session->read('Auth.Client.vc_cell_no2'),
                            'class' => 'round'));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><label class="lab-inner">Fax No. :</label></td>
                    <td>
                        <?php
                        echo $this->Form->input('ClientChangeHistory.vc_fax_no', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'maxlength' => 15,
                            'value' => $this->Session->read('Auth.Client.vc_fax_no'),
                            'class' => 'round'));
                        ?>
                    </td>
                    <td><label class="lab-inner">Fax No. :</label></td>
                    <td>
                        <?php
                        echo $this->Form->input('ClientChangeHistory.vc_fax_no2', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'maxlength' => 15,
                            'value' => $this->Session->read('Auth.Client.vc_fax_no2'),
                            'class' => 'round'));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><label class="lab-inner">Email :</label></td>
                    <td>
                        <?php
                        echo $this->Form->input('ClientChangeHistory.vc_email', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'disabled' => 'disabled',
                            'maxlength' => 50,
                            'value' => $this->Session->read('Auth.Client.vc_email'),
                            'class' => 'round'));
                        ?>
                    </td>
                    <td><label class="lab-inner">Email :</label></td>
                    <td>
                        <?php
                        echo $this->Form->input('ClientChangeHistory.vc_email2', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'disabled' => 'disabled',
                            'maxlength' => 50,
                            'value' => $this->Session->read('Auth.Client.vc_email2'),
                            'class' => 'round'));
                        ?>
                    </td>
                </tr>
            </table>
            <br />
            <table width="100%" border="0" cellpadding="3">

                <tr>
                    <td width="100%">
                        <?php
                        $options = array('1' => 'Client Name', '2' => 'Ownership Change');
                        $attributes = array('legend' => false, 'value' => 1);
                        echo $this->Form->radio('ClientChangeHistory.type', $options, $attributes);
                        ?>
                    </td>

                </tr>
            </table>
            <br/>
            <table width="100%" border="0" cellpadding="3">
                <tr>
                    <td align="left" valign="top"><label class="lab-inner">Name :</label></td>
                    <td align="left" valign="top">
                        <?php
                        echo $this->Form->input('ClientChangeHistory.vc_client_name', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'maxlength' => 200,
                            'class' => 'round'));
                        ?>
                    </td>
                    <td align="left" valign="top"><label class="lab-inner">Contact Person :</label></td>
                    <td align="left" valign="top">
                        <?php
                        echo $this->Form->input('ClientChangeHistory.vc_contact_person', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'maxlength' => 200,
                            'class' => 'round'));
                        ?>
                    </td>
                    <td width="15%" align="left" valign="top"><label class="lab-inner">Business Reg. Id :</label></td>
                    <td width="16%" align="left" valign="top">
                        <?php
                        echo $this->Form->input('ClientChangeHistory.vc_id_no', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'maxlength' => 50,
                            'class' => 'round'));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><label class="lab-inner"> Upload Document  :</label></td>
                    <td>
                        <?php
                        echo $this->Form->input('ClientUploadDocs.ownershipchange', array('label' => false,
                            'div' => false,
                            'type' => 'file',
                            'class' => 'uploadfile'));
                        ?>
                    </td>
                    <td align="left" valign="top"><label class="lab-inner">Status :</label></td>
                    <td align="left" valign="top"> <strong> Pending </strong>

                    </td>
                    <td align="left" valign="top">&nbsp;</td>
                    <td align="left" valign="top">&nbsp;</td>
                </tr>
            </table>
        </div>
        <!-- end innerbody here-->    


        <table width="100%" border="0">

            <tr>

                <td   width='50%' colspan='3' align="right" valign="top">
<?php echo $this->Form->submit('Submit', array('div' => false, 'label' => false, 'type' => 'submit', 'class' => 'submit', 'value' => 'submit')); ?>
                </td>
                <td    width='50%'  colspan ='3' align="left" valign="top">
<?php echo $this->Form->submit('Reset', array('div' => false, 'label' => false, 'type' => 'reset', 'class' => 'submit', 'value' => 'Reset')); ?>
                </td>

            </tr>

        </table>
<?php echo $this->Form->end(); ?>
    </div>
    <!-- end mainbody here-->    
</div>
<!-- end wrapper here-->
<?php echo $this->Html->script('flr/changeofownership'); ?>