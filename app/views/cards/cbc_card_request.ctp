<?php
$currentUser = $this->Session->read('Auth');
?>
<style>
    #disread {
        background-color: #F2F2F2;
        color: #6D6D6D;
        border-color: #AAAAAA;
        cursor: default;
    }
</style>
<!-- Start wrapper here-->
<div class="wrapper">
    <!-- Start breadcrumb here-->
    <div class="breadcrumb">
        <ul>
            <li class="first">
                <?php echo $this->Html->link('Home', array('controller' => 'customers', 'action' => 'view', 'cbc' => true), array('title' => 'Home', 'class' => 'vtip')) ?>

            </li>

            <li class="last">Prepaid Card Request</li>        
        </ul>
    </div>
    <!-- end breadcrumb here-->
    <!-- Start mainbody here-->
    <div class="mainbody">
        <h1>Welcome to RFA CBC</h1>
        <h3>Prepaid Card Request</h3>
        <!-- Start innerbody here-->
        <?php
        echo $this->Form->create('RequestCard', array('url' => array('controller' => 'cards',
                'action' => 'cbc_card_request')));
        ?>
        <div class="innerbody">
            <table width="100%" border="0" cellpadding="3">
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
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td><label class="lab-inner1">Total Cards Issued :</label></td>
                    <td>
                        <?php
                        echo $this->Form->input('vc_total_card_issued', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'value' => $total_cards,
                            'disabled' => 'disabled',
                            'class' => 'number-right round'));
                        ?>
                    </td>
                    <td><label class="lab-inner1">Inactive Cards :</label></td>
                    <td>
                        <?php
                        echo $this->Form->input('vc_inactive_card', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'value' => $inactive_cards,
                            'disabled' => 'disabled',
                            'class' => 'number-right round'));
                        ?>
                    </td>
                    <td><label class="lab-inner">Active Cards :</label></td>
                    <td>
                        <?php
                        echo $this->Form->input('vc_active_card', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'value' => $active_cards,
                            'disabled' => 'disabled',
                            'class' => 'number-right round'));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><label class="lab-inner1">Account Balance(N$) :</label></td>
                    <td>
                        <?php
                        echo $this->Form->input('vc_account_balance', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'value' => $customer['Customer']['nu_account_balance'],
                            'readonly' => 'readonly',
                            'class' => 'number-right round',
                            'id' => 'disread'
                        ));
                        ?>
                    </td>
                    <td><label class="lab-inner1">Card Issue Charges(N$) :</label></td>
                    <td>
                        <?php
                        echo $this->Form->input('vc_card_issue_charges', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'value' => number_format($globalParameterarray['CBCADMINFEE'], 2, '.', ','),
                            'disabled' => 'disabled',
                            'class' => 'number-right round'));
                        ?>
                    </td>
                    <td><label class="lab-inner">Card RequestDate :</label></td>
                    <td>
                        <?php
                        echo $this->Form->input('dt_created', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'value' => date('d-M-Y'),
                            'disabled' => 'disabled',
                            'class' => 'round'));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><label class="lab-inner1">No. of Cards Required :</label></td>
                    <td>
                        <?php
                        echo $this->Form->input('vc_no_of_cards', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'maxlength' => 15,
                            'class' => 'number-right round'));
                        ?>
                    </td>
                    <td><label class="lab-inner1">Total Charges (N$):</label></td>
                    <td>
                        <?php
                        echo $this->Form->input('nu_total_charges', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'readonly' => 'readonly',
                            'class' => 'number-right round'));
                        ?>
                    </td>
                    <td><label class="lab-inner">Request Satus :</label></td>
                    <td>
                        <?php
                        echo $this->Form->input('vc_status', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'value' => $globalParameterarray['STSTY03'],
                            'disabled' => 'disabled',
                            'class' => 'round'));
							   echo $this->Form->hidden('pendingCards', array('label' => false,
                            'div' => false,
                            'value' => $pendingCards,
                            
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
                    <?php
                    echo $this->Form->submit('Submit', array('type' => 'submit',
                        'class' => 'submit',
                        'value' => 'submit'));
                    ?>
                </td>
            </tr>
        </table>
        <?php echo $this->Form->end(); ?>
    </div>
    <!-- end mainbody here-->    
</div>
<!-- end wrapper here-->
<?php echo $this->element('cbc/commonmessagepopup'); ?>
<?php echo $this->Html->script('cbc/cardrequest'); ?>




