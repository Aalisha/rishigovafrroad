<div class="wrapper">
    <!-- Start breadcrumb here-->
    <!-- end breadcrumb here-->
    <!-- Start mainbody here-->
    <div class="mainbody">

        <h3>Customer Complaint and Feedback</h3>
        <!-- Start innerbody here-->
        <?php echo $this->Form->create('AllFeedback', array('url' => array('controller' => 'feedbacks',
                'action' => 'userfeedback'), 'type' => 'file', 'enctype=multipart/form-data'));
        ?>
        <div class="innerbody">
            <table width="100%" border="0" cellpadding="3" >
                <tr>
                    <td valign="top"><label class="lab-inner1">Customer Name :</label></td>
                    <td valign="top">
                        <?php
                        echo $this->Form->input('vc_customer_name', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'maxlength' => 50,
                            'class' => 'round'));
                        ?>
                    </td>
                    <td valign="top"><label class="lab-inner1">Address 1 :</label></td>
                    <td valign="top">
                        <?php
                        echo $this->Form->input('vc_address1', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'maxlength' => 50,
                            'class' => 'round'));
                        ?>
                    </td>
                    <td valign="top"><label class="lab-inner">Address 2 :</label></td>
                    <td valign="top">
                        <?php
                        echo $this->Form->input('vc_address2', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'maxlength' => 50,
                            'class' => 'round'));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td valign="top"><label class="lab-inner1">Address 3 :</label></td>
                    <td valign="top">
                        <?php
                        echo $this->Form->input('vc_address3', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'maxlength' => 50,
                            'class' => 'round'));
                        ?>
                    </td>
                    <td valign="top"><label class="lab-inner1">Telephone No. :</label></td>
                    <td valign="top">
                        <?php
                        echo $this->Form->input('vc_tel_no', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'maxlength' => 15,
                            'class' => 'round'));
                        ?>
                    </td>
                    <td valign="top"><label class="lab-inner">Fax No. :</label></td>
                    <td valign="top">
                        <?php
                        echo $this->Form->input('vc_fax_n', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'maxlength' => 15,
                            'class' => 'round'));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td valign="top"><label class="lab-inner1">Email :</label></td>
                    <td valign="top">
                        <?php
                        echo $this->Form->input('vc_email_id', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'maxlength' => 50,
                            'class' => 'round'));
                        ?>
                    </td>
                    <td valign="top"><label class="lab-inner1">Mobile No. :</label></td>
                    <td valign="top">
                        <?php
                        echo $this->Form->input('vc_mobile_no', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'maxlength' => 15,
                            'class' => 'round'));
                        ?>
                    </td>
                    <td valign="top"><label class="lab-inner1">Complaint Date :</label></td>
                    <td valign="top">
                        <?php
                        echo $this->Form->input('dt_created', array('label' => false,
                            'div' => false,
                            'value' => date('d-M-Y'),
                            'type' => 'text',
                            'readonly' => 'readonly',
                            'class' => 'round disabled-field'));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td valign="top"><label class="lab-inner1">Type :</label></td>
                    <td valign="top">
                        <?php
                        echo $this->Form->input('customer_type', array('label' => false,
                            'div' => false,
                            'type' => 'select',
                            'required' => 'required',
                            'options' => $FLA_TYPE,
                            'style' => 'width:130px;',
                            'class' => 'round_select1'));
                        ?>
                    </td>
                    <td valign="top"><label class="lab-inner1">Complaint Type :</label></td>
                    <td valign="top">
                        <?php
                        echo $this->Form->input('complaint_type', array('label' => false,
                            'div' => false,
                            'type' => 'select',
                            'required' => 'required',
                            'options' => $vehtype1,
                            'style' => 'width:130px;',
                            'class' => 'round_select1'));
                        ?>
                    </td>
                    <td valign="top"><label class="lab-inner1">Complaint Lodged by :</label></td>
                    <td colspan="3" valign="top">
                        <?php
                        echo $this->Form->input('logged_by', array('label' => false,
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
                    <td valign="top"><label class="lab-inner1">Priority :</label></td>
                    <td valign="top">
                        <?php
                        echo $this->Form->input('priority_type', array('label' => false,
                            'div' => false,
                            'type' => 'select',
                            'required' => 'required',
                            'style' => 'width:130px;',
                            'options' => $vehtype,
                            'class' => 'round_select1'));
                        ?>
                    </td>
                    <td valign="top"><label class="lab-inner1">Contact number :</label></td>
                    <td colspan="3" valign="top">
                        <?php
                        echo $this->Form->input('contact_no', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'maxlength' => 15,
                            'required' => 'required',
                            'class' => 'round'));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td valign="top"><label class="lab-inner1">Complaint Description :</label></td>

                    <td colspan='5' valign="top">

                        <?php
                        echo $this->Form->input('complaint_description', array('label' => false,
                            'div' => false,
                            'type' => 'textarea',
                            'rows' => "6",
                            'cols' => "56",
                            'required' => 'required',
                            'id' => 'complaint_desc',
                        ));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td valign="top"><label class="lab-inner1">Attach Screen shot :</label></td>

                    <td colspan="5" valign="top">
                        <?php
                        echo $this->Form->input('upload_doc', array('label' => false,
                            'div' => false,
                            'type' => 'file',
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


<?php echo $this->Form->end(null); ?>
                <!-- end mainbody here--> 

            </table>	 
        </div>
    </div>
</div>
<?php echo $this->Html->script('userfeedback'); ?>