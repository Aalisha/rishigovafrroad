<?php $currentUser = $this->Session->read('Auth'); ?>
<!-- Start wrapper here-->
<div class="wrapper">
    <!-- Start breadcrumb here-->
    <div class="breadcrumb">
        <ul>
            <li class="first">
                <?php echo $this->Html->link('Home', array('controller' => 'customers', 'action' => 'view', 'cbc' => true), array('title' => 'Home', 'class' => 'vtip')) ?>

            </li>

            <li class="last">Activation Deactivation Vehicle</li>        
        </ul>
    </div>
    <!-- end breadcrumb here-->
    <!-- Start mainbody here-->
    <div class="mainbody">
        <h1>Welcome to RFA CBC</h1>
        <h3>Vehicle Deactivation Request</h3>
        <!-- Start innerbody here-->
        <div class="innerbody">
            <table width="100%" border="0" cellpadding="3">
                <tr>
                    <td align="right">
                        <?php
                        if (count($vehicle) > 0) {
                            $url = $this->Html->url(array('controller' => 'vehicles', 'action' => 'vehicle_list_pdf', 'cbc' => true));
                            echo $this->Form->submit('Print Vehicle List', array(
                                'label' => false,
                                'type' => 'button',
                                'onclick' => 'window.location="' . $url . '"',
                                'div' => false,
                                'class' => 'submit',
                            ));
                        }
                        ?>
                    </td>
                </tr>
            </table>

            <table width="100%" border="0" cellpadding="3">
                <tr>
                    <td><label class="lab-inner">Customer Name :</label></td>
                    <td>
                        <?php
                        echo $this->Form->input('Customer.vc_customer_name', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'value' => $currentUser['Customer']['vc_first_name'] . ' ' . $currentUser['Customer']['vc_surname'],
                            'disabled' => 'disabled',
                            'class' => 'round'));
                        ?>
                    </td>
                    <td><label class="lab-inner">Address 1 :</label></td>
                    <td>
                        <?php
                        echo $this->Form->input('Customer.vc_address1', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'value' => $currentUser['Customer']['vc_address1'],
                            'disabled' => 'disabled',
                            'class' => 'round'));
                        ?>
                    </td>
                    <td><label class="lab-inner">Address 2 :</label></td>
                    <td>
                        <?php
                        echo $this->Form->input('Customer.vc_address2', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'value' => $currentUser['Customer']['vc_address2'],
                            'disabled' => 'disabled',
                            'class' => 'round'));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><label class="lab-inner">Address 3 :</label></td>
                    <td>
                        <?php
                        echo $this->Form->input('Customer.vc_address3', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'value' => $currentUser['Customer']['vc_address3'],
                            'disabled' => 'disabled',
                            'class' => 'round'));
                        ?>
                    </td>
                    <td><label class="lab-inner">Telephone No. :</label></td>
                    <td>
                        <?php
                        echo $this->Form->input('Customer.vc_tel_no', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'value' => $currentUser['Customer']['vc_tel_no'],
                            'disabled' => 'disabled',
                            'class' => 'round'));
                        ?>
                    </td>
                    <td><label class="lab-inner">Fax No. :</label></td>
                    <td>
                        <?php
                        echo $this->Form->input('Customer.vc_fax_no', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'value' => $currentUser['Customer']['vc_fax_no'],
                            'disabled' => 'disabled',
                            'class' => 'round'));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><label class="lab-inner">Mobile No. :</label></td>
                    <td>
                        <?php
                        echo $this->Form->input('Customer.vc_mobile_no', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'value' => $currentUser['Customer']['vc_mobile_no'],
                            'disabled' => 'disabled',
                            'class' => 'round'));
                        ?>
                    </td>
                    <td><label class="lab-inner">Email :</label></td>
                    <td>
                        <?php
                        echo $this->Form->input('Customer.vc_email_id', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'value' => $currentUser['Customer']['vc_email'],
                            'disabled' => 'disabled',
                            'class' => 'round'));
                        ?>
                    </td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td><label class="lab-inner">Total Vehicle Reg. :</label></td>
                    <td>
                        <?php
                        echo $this->Form->input('vc_total_vehicle_registered', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'value' => number_format($total_vehicles),
                            'disabled' => 'disabled',
                            'class' => 'round number-right'));
                        ?>
                    </td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            </table>
            <br />

            <?php echo $this->Form->create('Vehicle', array('url' => array('controller' => 'vehicles', 'action' => 'activationdeactivation', 'cbc' => true), 'type' => 'file')); ?>

            <table width="100%" cellspacing="1" cellpadding="5" border="0" >
                <tr class="listhead1">
                    <td width="20%" align="center">Vehicle Reg. No.</td>
                    <td width="20%" align="center">Vehicle Chassis No.</td>
                    <td width="20%" align="center">Vehicle Type</td>
                    <td width="20%" align="center">Current Status</td>
                    <td width="20%" align="center">Requested</td>
                </tr>

                <?php
                if (count($vehicle) > 0) {

                    foreach ($vehicle as $key => $val) {

                        $str = $key % 2 == 0 ? '' : '1';
                        ?>

                        <tr class="cont<?php echo $str ?>">
                            <td align="left">
                                <?php
                                echo wordwrap($val['ActivationDeactivationVehicle']['vc_reg_no'], 16, "<br>\n", true);
                                ?>
                            </td>
                            <td align="left">
                                <?php
                                echo wordwrap($val['ActivationDeactivationVehicle']['vc_chasis_no'], 16, "<br>\n", true);
                                ?>
                            </td>
                            <td align="left">
                                <?php
                                echo $globalParameterarray[$val['ActivationDeactivationVehicle']['vc_veh_type']];
                                ?>
                            </td>
                            <td align="left">
                                <?php
                                echo $globalParameterarray[$val['ActivationDeactivationVehicle']['vc_status']];

                                echo $this->Form->input('Vehicle.' . $key . '.nu_vehicle_id', array('label' => false,
                                    'div' => false,
                                    'type' => 'hidden',
                                    'value' => $val['ActivationDeactivationVehicle']['nu_vehicle_id'],
                                    'readonly' => 'readonly',
                                    'class' => 'round'));
                                ?>
                            </td>
                            <td align="left">
                                <?php
                                echo $this->Form->input('Vehicle.' . $key . '.vc_status', array('label' => false,
                                    'div' => false,
                                    'type' => 'select',
                                    'options' => array('' => 'Select', 'STSTY02' => 'Deactivate'),
                                    'class' => 'round_select'));
                                ?>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <tr align="center"> <td colspan='5' style='align:center;' > No record found !!</td> </tr>
                <?php } ?>
            </table>


            <?php
            if (count($vehicle) > 0) {
                ?>
                <table width="100%" border="0">
                    <tr>
                        <td align="center"><?php echo $this->Form->submit('Submit', array('type' => 'submit', 'class' => 'submit', 'value' => 'submit', 'name' => 'data[submitbtn]')); ?>
                        </td>
                    </tr>
                </table>

            <?php } ?>
            <?php echo $this->Form->end(); ?>

        </div>
        <!-- end innerbody here-->       
    </div>
    <!-- end mainbody here-->    
</div>


<!-- end wrapper here-->

<?php echo $this->element('cbc/commonmessagepopup'); ?>

<?php
if (count($vehicle) > 0) {
    echo $this->element('cbc/paginationfooter');
}
?>

<?php echo $this->Html->script('cbc/activationdeactivationvehicle'); ?>
