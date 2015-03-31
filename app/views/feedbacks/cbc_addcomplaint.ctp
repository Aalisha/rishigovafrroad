<?php $currentUser = $this->Session->read('Auth');?>


<!-- Start wrapper here-->
<div class="wrapper">
    <!-- Start breadcrumb here-->
    <div class="breadcrumb">
        <ul>
            <li class="first">
                <?php echo $this->Html->link('Home', array('controller' => 'customers', 'action' => 'view', 'cbc' => true), array('title' => 'Home', 'class' => 'vtip')) ?>

            </li>

            <li class="last">Customer Complaint and Feedback</li>        
        </ul>
    </div>
    <!-- end breadcrumb here-->
    <!-- Start mainbody here-->
    <div class="mainbody">
        <h1>Welcome to RFA CBC</h1>
        <h3>Customer Complaint and Feedback</h3>
        <!-- Start innerbody here-->
        <?php echo $this->Form->create(array('url' => array('controller' => 'feedbacks',
                'action' => 'cbc_addcomplaint', 'cbc' => true), 'type' => 'file', 'enctype=multipart/form-data')); ?>
        <div class="innerbody">
            <table width="100%" border="0" cellpadding="3" >
                <tr>
                    <td><label class="lab-inner1">Customer Name :</label></td>
                    <td>
                        <?php
                        echo $this->Form->input('Customer.vc_customer_name', array('label' => false,
                            'div' => false,
                            'disabled' => 'disabled',
                            'type' => 'text',
                            'value' => $currentUser['Customer']['vc_first_name'] . ' ' . $currentUser['Customer']['vc_surname'],
                            'class' => 'round'));
                        ?>
                    </td>
                    <td><label class="lab-inner1">Address 1 :</label></td>
                    <td>
                        <?php
                        echo $this->Form->input('Customer.vc_address1', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'disabled' => 'disabled',
                            'value' => $customer['Customer']['vc_address1'],
                            'class' => 'round'));
                        ?>
                    </td>
                    <td><label class="lab-inner">Address 2 :</label></td>
                    <td>
                        <?php
                        echo $this->Form->input('Customer.vc_address2', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'value' => $customer['Customer']['vc_address2'],
                            'disabled' => 'disabled',
                            'class' => 'round'));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><label class="lab-inner1">Address 3 :</label></td>
                    <td>
                        <?php
                        echo $this->Form->input('Customer.vc_address3', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'disabled' => 'disabled',
                            'value' => $customer['Customer']['vc_address3'],
                            'class' => 'round'));
                        ?>
                    </td>
                    <td><label class="lab-inner1">Telephone No. :</label></td>
                    <td>
                        <?php
                        echo $this->Form->input('Customer.vc_tel_no', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'disabled' => 'disabled',
                            'value' => $customer['Customer']['vc_tel_no'],
                            'class' => 'round'));
                        ?>
                    </td>
                    <td><label class="lab-inner">Fax No. :</label></td>
                    <td>
                        <?php
                        echo $this->Form->input('Customer.vc_fax_n', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'disabled' => 'disabled',
                            'value' => $customer['Customer']['vc_fax_no'],
                            'class' => 'round'));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><label class="lab-inner1">Email :</label></td>
                    <td>
                        <?php
                        echo $this->Form->input('Customer.vc_email_id', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'disabled' => 'disabled',
                            'value' => $currentUser['Customer']['vc_email'],
                            'class' => 'round'));
                        ?>
                    </td>
                    <td><label class="lab-inner1">Mobile No. :</label></td>
                    <td>
                        <?php
                        echo $this->Form->input('Customer.vc_mobile_no', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'disabled' => 'disabled',
                            'value' => $customer['Customer']['vc_mobile_no'],
                            'class' => 'round'));
                        ?>
                    </td>
                    <td><label class="lab-inner1">Complaint Date :</label></td>
                    <td>
                        <?php
                        echo $this->Form->input('FeedbackData.dt_created', array('label' => false,
                            'div' => false,
                            'value'=>date('d-M-Y'),
                            'type' => 'text',
                            'readonly' => 'readonly',
							'class' => 'round disabled-field'));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><label class="lab-inner1">Complaint Type :</label></td>
                    <td>
                        <?php
                        echo $this->Form->input('FeedbackData.complaint_type', array('label' => false,
                            'div' => false,
                            'type' => 'select',
                            'required' => 'required',
                            'options' => $vehtype1,
                            'style' => 'width:130px;',
                            'class' => 'round_select1'));
                        ?>
                    </td>
                    <td><label class="lab-inner1">Complaint Lodged by :</label></td>
                    <td colspan="3">
                        <?php
                        echo $this->Form->input('FeedbackData.logged_by', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'maxlength' => 100,
                            'required' => 'required',
                            'class' => 'round'));
                        ?>
                    </td>

                </tr>


                </tr>
                <tr>
                    <td><label class="lab-inner1">Priority :</label></td>
                    <td>
                        <?php
                        echo $this->Form->input('FeedbackData.priority_type', array('label' => false,
                            'div' => false,
                            'type' => 'select',
                            'required' => 'required',
                            'options' => $vehtype,
                            'class' => 'round_select1'));
                        ?>
                    </td>
                    <td><label class="lab-inner1">Contact number :</label></td>
                    <td colspan="3">
                        <?php
                        echo $this->Form->input('FeedbackData.contact_no', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'maxlength' => 15,
                            'required' => 'required',
                            'class' => 'round'));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><label class="lab-inner1">Complaint Description :</label></td>

                    <td colspan='5'>

                        <?php
                        echo $this->Form->input('FeedbackData.complaint_description', array('label' => false,
                            'div' => false,
                            'type' => 'textarea',
							'rows'=>"6",
							'cols'=>"56",
                            'required' => 'required',
                            'id'=>'complaint_desc',
                            ));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><label class="lab-inner1">Attach Screen shot :</label></td>

                    <td colspan="5">
                        <?php
                        echo $this->Form->input('FeedbackData.upload_doc', array('label' => false,
                            'div' => false,
                            'type' => 'file',
                            'id' => 'FeedbackDataUploadDoc1',
                            'class' => 'uploadfile'));
                        ?>
                    </td>

                </tr>

                <td>&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
              
                <tr>

                <table width="100%" border="0">
                    <tr>
                        <td align="center">
                            <?php echo $this->Form->submit('Submit', array('type' => 'submit', 'class' => 'submit', 'value' => 'submit')); ?>
                    </tr>
                </table>


                <!-- end mainbody here--> 

            </table>	 
        </div>
        </div>
        </div>
        <?php echo $this->Html->script('cbc/addcomplaint'); ?>
