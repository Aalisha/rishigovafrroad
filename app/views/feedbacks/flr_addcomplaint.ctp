<?php $currentUser = $this->Session->read('Auth'); ?>
<?php //pr($currentUser); ?>

<!-- Start wrapper here-->
<div class="wrapper">
    <!-- Start breadcrumb here-->
    <div class="breadcrumb">
        <ul>
            <li class="first">
                <?php echo $this->Html->link('Home', array('controller' => 'Clients', 'action' => 'view', 'flr' => true), array('title' => 'Home', 'class' => 'vtip')) ?>
            </li>
            <li class="last">Client Complaint and Feedback</li>   
 <li class="last clientnoclass" style=""  >Client No.&nbsp;:&nbsp;<?php echo ltrim($this->Session->read('Auth.Client.vc_client_no'),'01');?></li> 			
        </ul>
    </div>
    <!-- end breadcrumb here-->
    <!-- Start mainbody here-->
    <div class="mainbody">
        <h1>Welcome to RFA FLR</h1>
        <h3>Client Complaint and Feedback</h3>
        <!-- Start innerbody here-->
        <?php
        echo $this->Form->create(array('url' => array('controller' => 'feedbacks',
                'action' => 'flr_addcomplaint', 'flr' => true),'type'=>'file'));
        ?>
        <div class="innerbody">
            <table width="100%" border="0" cellpadding="3" >
                <tr>
                    <td valign="top"><label class="lab-inner1">Client Name :</label></td>
                    <td valign="top">
                        <?php
                        echo $this->Form->input('ClientFeedback.vc_client_name', array('label' => false,
                            'div' => false,
                            'disabled' => 'disabled',
                            'type' => 'text',
                            'value' => $currentUser['Client']['vc_client_name'],
                            'class' => 'round'));
                        ?>
                    </td>
                    <td valign="top"><label class="lab-inner1">Address 1 :</label></td>
                    <td>
                        <?php
                        echo $this->Form->input('ClientFeedback.vc_address1', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'disabled' => 'disabled',
                            'value' => $currentUser['Client']['vc_address1'],
                            'class' => 'round'));
                        ?>
                    </td>
                    <td valign="top"><label class="lab-inner">Address 2 :</label></td>
                    <td valign="top">
                        <?php
                        echo $this->Form->input('ClientFeedback.vc_address2', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'value' => $currentUser['Client']['vc_address2'],
                            'disabled' => 'disabled',
                            'class' => 'round'));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td valign="top"><label class="lab-inner1">Address 3 :</label></td>
                    <td valign="top">
                        <?php
                        echo $this->Form->input('ClientFeedback.vc_address3', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'disabled' => 'disabled',
                            'value' => $currentUser['Client']['vc_address3'],
                            'class' => 'round'));
                        ?>
                    </td>
                    <td valign="top"><label class="lab-inner1">Telephone No. :</label></td>
                    <td valign="top">
                        <?php
                        echo $this->Form->input('ClientFeedback.vc_tel_no', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'disabled' => 'disabled',
                            'value' => $currentUser['Client']['vc_tel_no'],
                            'class' => 'round'));
                        ?>
                    </td>
                    <td valign="top"><label class="lab-inner">Fax No. :</label></td>
                    <td valign="top">
                        <?php
                        echo $this->Form->input('ClientFeedback.vc_fax_no', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'disabled' => 'disabled',
                            'value' => $currentUser['Client']['vc_fax_no'],
                            'class' => 'round'));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td valign="top"><label class="lab-inner1">Email :</label></td>
                    <td valign="top">
                        <?php
                        echo $this->Form->input('ClientFeedback.email_id', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'disabled' => 'disabled',
                            'value' => $currentUser['Client']['vc_email'],
                            'class' => 'round'));
                        ?>
                    </td>
                    <td valign="top"><label class="lab-inner1">Mobile No. :</label></td>
                    <td valign="top">
                        <?php
                        echo $this->Form->input('ClientFeedback.vc_cell_no', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'disabled' => 'disabled',
                            'value' => $currentUser['Client']['vc_cell_no'],
                            'class' => 'round'));
                        ?>
                    </td>
                    <td valign="top"><label class="lab-inner1">Complaint Date :</label></td>
                    <td valign="top">
                        <?php
                        echo $this->Form->input('ClientFeedback.dt_created', array('label' => false,
                            'div' => false,
                            'id' => 'dt_created',
                            'value' => date('d M Y'),
                            'type' => 'text',
                            'readonly' => 'readonly',
                            'class' => 'round disabled-field'));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td valign="top"><label class="lab-inner1">Complaint Type :</label></td>
                    <td valign="top">
                        <?php
                        echo $this->Form->input('ClientFeedback.complaint_type', array('label' => false,
                            'div' => false,
                            'id' => 'complaint_type',
                            'type' => 'select',
                            'options' => $complaintType,
                            'class' => 'round_select'));
                        ?>
                    </td>
                    <td valign="top"><label class="lab-inner1">Complaint Lodged by :</label></td>
                    <td colspan="1" valign="top">
                        <?php
                        echo $this->Form->input('ClientFeedback.logged_by', array('label' => false,
                            'div' => false,
                            'id' => 'logged_by',
                            'type' => 'text',
                            'maxlength' => 100,
                            'class' => 'round'));
                        ?>
                    </td>
                    <td valign="top" align="left"><label class="lab-inner"><!--Client No.&nbsp;:--></label></td>
				<td valign="top"><?php // echo $this->Session->read('Auth.Client.vc_client_no');?>&nbsp;</td>

                </tr>

                <tr>
                    <td valign="top"><label class="lab-inner1">Priority :</label></td>
                    <td valign="top">
                        <?php
                        echo $this->Form->input('ClientFeedback.priority_type', array('label' => false,
                            'div' => false,
                            'id' => 'priority_type',
                            'type' => 'select',
                            'options' => $priorityType,
                            'class' => 'round_select'));
                        ?>
                    </td>
                    <td valign="top"><label class="lab-inner1">Contact number :</label></td>
                    <td colspan="3" valign="top">
                        <?php
                        echo $this->Form->input('ClientFeedback.contact_no', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'maxlength' => 15,
                            'class' => 'round'));
                        ?>
                    </td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td valign="top"> <label class="lab-inner1">Complaint Description :</label></td>
                    <td colspan='5' valign="top">
                        <?php
                        echo $this->Form->input('ClientFeedback.complaint_description', array('label' => false,
                            'div' => false,
                            'id' => 'complaint_desc',
                            'type' => 'textarea',
                            'rows' => 6,
                            'cols' => 56
                        ));
                        ?>
                    </td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td><label class="lab-inner1">Attach Screen shot :</label></td>

                    <td colspan="5" valign="top">
                        <?php
                        echo $this->Form->input('ClientUploadDocs.complaint_doc', array('label' => false,
                            'div' => false,
                            'type' => 'file',
                            'class' => 'uploadfile'));
                        ?>
                    </td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>

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
        <?php echo $this->Form->end(null); ?>
    </div>
    <!-- end mainbody here--> 

</div>
<?php echo $this->Html->script('flr/addcomplaint'); ?>
