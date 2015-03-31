<?php $profile = $this->Session->read('Auth'); ?>
<!-- Start breadcrumb here-->
<div class="breadcrumb">
    <ul>
        <li class="first">
            <?php echo $this->Html->link('Home', array('controller' => 'profiles', 'action' => 'index', $data['VehicleLogDetail']['vc_log_detail_id']), array('title' => 'Home', 'class' => 'vtip')) ?>
        </li>

        <li class="last">Vehicle Registration </li>        
    </ul>
</div>
<!-- end breadcrumb here-->

<!-- Start mainbody here-->
<div class="mainbody">
    <h1><?php echo $mdclocal;?></h1>
    <h3>Edit Vehicle Log Details</h3>
    <!-- Start innerbody here-->

    <div class="innerbody">

        <table width="100%" border="0" cellpadding="3">

            <tr>
                <td><label class="lab-inner">RFA Account no. :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('VehicleLogMaster.vc_customer_no', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_rfa_account_no',
                        'disabled' => 'disabled',
                        'value' => $profile['Profile']['vc_customer_no'],
                        'class' => 'round'));
                    ?>

                </td>
                <td><label class="lab-inner">Customer Id</label></td>
                <td>
                    <?php
                    echo $this->Form->input('VehicleLogMaster.vc_customer_id', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_customer_id',
                        'disabled' => 'disabled',
                        'value' => $profile['Profile']['vc_customer_id'],
                        'class' => 'round'));
                    ?>

                </td>
                <td><label class="lab-inner">Customer Name :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('VehicleLogMaster.vc_customer_name', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_customer_name',
                        'disabled' => 'disabled',
                        'value' => $profile['Profile']['vc_customer_name'],
                        'class' => 'round'));
                    ?>

                </td>

            </tr>
            <tr>
                <td><label class="lab-inner">Address1 :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('VehicleLogMaster.vc_address1', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_address1',
                        'disabled' => 'disabled',
                        'value' => $profile['Profile']['vc_address1'],
                        'class' => 'round'));
                    ?>
                    <!--<input type="text" class="round" />-->
                </td>
                <td><label class="lab-inner">Address2 :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('VehicleLogMaster.vc_address2', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_address2',
                        'disabled' => 'disabled',
                        'value' => $profile['Profile']['vc_address2'],
                        'class' => 'round'));
                    ?>
                    <!--<input type="text" class="round" />-->
                </td>
                <td><label class="lab-inner">P.O Box :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('VehicleLogMaster.vc_po_box', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_address3',
                        'disabled' => 'disabled',
                        'value' => $profile['Profile']['vc_po_box'],
                        'class' => 'round'));
                    ?>
                    <!--<input type="text" class="round" />-->
                </td>
            </tr>
            <tr>

                <td><label class="lab-inner">Telephone No :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('VehicleLogMaster.vc_tel_no', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_tel_no',
                        'disabled' => 'disabled',
                        'value' => $profile['Profile']['vc_tel_no'],
                        'class' => 'round'));
                    ?>
                    <!--<input type="text" class="round" />-->
                </td>
                <td><label class="lab-inner">Fax No :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('VehicleLogMaster.vc_fax_no', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_fax_no',
                        'disabled' => 'disabled',
                        'value' => $profile['Profile']['vc_fax_no'],
                        'class' => 'round'));
                    ?>
                    <!--<input type="text" class="round" />-->
                </td>
                <td><label class="lab-inner">Mobile No :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('VehicleLogMaster.vc_mobile_no', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_mobile_no',
                        'disabled' => 'disabled',
                        'value' => $profile['Profile']['vc_mobile_no'],
                        'class' => 'round'));
                    ?>
                    <!--<input type="text" class="round" />-->
                </td>
            </tr>
            <tr>

                <td><label class="lab-inner">Email :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('VehicleLogMaster.vc_email_id', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_email_id',
                        'disabled' => 'disabled',
                        'value' => $profile['Profile']['vc_email_id'],
                        'class' => 'round'));
                    ?>
                    <!--<input type="text" class="round" />-->
                </td>

                <td><label class="lab-inner">Customer Type :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('vc_cust_type', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_cust_type',
                        'required' => 'required',
                        'value' => $profile['VC_CUST_TYPE']['vc_prtype_name'],
                        'disabled' => 'disabled',
                        'class' => 'round'));
                    ?>
                    <!--<input type="text" class="round" />-->
                </td>
                <td><label class="lab-inner">Pay Frequency :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('vc_cust_type', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_cust_type',
                        'required' => 'required',
                        'value' => $data['PAYFREQUENCY']['vc_prtype_name'],
                        'readonly' => 'readonly',
                        'class' => 'round'));
                    ?>
                    <!--<input type="text" class="round" />-->
                </td>

            </tr>
            <tr>

                <td><label class="lab-inner">Vehicle Licence No :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('VehicleLogMaster.vc_vehicle_lic_no', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_vehicle_lic_no',
                        'required' => 'required',
                        'readonly' => 'readonly',
                        'value' => $data['VehicleLogDetail']['vc_vehicle_lic_no'],
                        'class' => 'round_select')
                    );
                    ?>

                </td>
                <td>Vehicle Registration No:</td>
                <td>
                    <?php
                    echo $this->Form->input('VehicleLogMaster.vc_vehicle_reg_no', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_vehicle_reg_no',
                        'required' => 'required',
                        'readonly' => 'readonly',
                        'value' => $data['VehicleLogDetail']['vc_vehicle_reg_no'],
                        'class' => 'round_select')
                    );
                    ?>
                </td>

            </tr>  

        </table>

    </div>
    <!-- end innerbody here-->
    <!-- end innerbody here-->
    <h3>Vehicle Details</h3>
    <!-- Start innerbody here-->
    <div class="innerbody">
        <table width="98%%" cellspacing="1" cellpadding="5" border="0" >
            <tr class="listhead">
                <td width="10%">Date</td>
                <td width="10%">Driver Name</td>
                <td width="10%">Start Odometer</td>
                <td width="10%">End Odometer</td>
                <td width="10%">Origin</td>
                <td width="10%">Destination</td>
                <td width="10%">KM Travel on Namibian Road Network</td>
            </tr>

        </table>
        <div class='listsr'>

            <?php echo $this->Form->create(array('url' => array('controller' => 'vehicles', 'action' => 'editlogdetail', $data['VehicleLogDetail']['vc_log_detail_id']))); ?>
            <table width="100%" cellspacing="1" cellpadding="5" border="0" >
                <tr class="cont1">
                    <td valign="top" class="align-left" width="10%">
                        <?php
                        echo $this->Form->input('VehicleLogDetail.0.dt_log_date', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'required' => 'required',
                            'disabled' => 'disabled',
                            'value' => date('d M Y', strtotime($data['VehicleLogDetail']['dt_log_date'])),
                            'class' => 'round3 addlog'));
                        ?>


                    </td>
                    <td valign="top"  class="align-left" width="10%">
                        <?php
                        echo $this->Form->input('VehicleLogDetail.0.vc_driver_name', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'required' => 'required',
                            'value' => $data['VehicleLogDetail']['vc_driver_name'],
                            'class' => 'round3'));
                        ?>
                        <!--<input type="text" class="round3" -->
                    </td>
                    <td valign="top"  class="align-left" width="10%">
                        <?php
                        echo $this->Form->input('VehicleLogDetail.0.nu_start_ometer', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'required' => 'required',
                            'disabled' => 'disabled',
                            'value' => $data['VehicleLogDetail']['nu_start_ometer'],
                            'class' => 'round3'));
                        ?>

                    </td>
                    <td valign="top"  class="align-left" width="10%">
                        <?php
                        echo $this->Form->input('VehicleLogDetail.0.nu_end_ometer', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'required' => 'required',
                            'disabled' => 'disabled',
                            'value' => $data['VehicleLogDetail']['nu_end_ometer'],
                            'class' => 'round3')
                        );
                        ?>

                    </td>
                    <td valign="top"  class="align-left" width="10%">
                        <?php
                        echo $this->Form->input('VehicleLogDetail.0.vc_orign', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'required' => 'required',
                            'value' => $data['VehicleLogDetail']['vc_orign'],
                            'class' => 'round3')
                        );
                        ?>
                        <!--<input type="text" class="round3" />-->
                    </td>
                    <td valign="top" class="align-left" width="10%">
                        <?php
                        echo $this->Form->input('VehicleLogDetail.0.vc_destination', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'required' => 'required',
                            'value' => $data['VehicleLogDetail']['vc_destination'],
                            'class' => 'round3')
                        );
                        ?>
                    </td>
                    <td valign="top" width="10%">
                        <?php
                        echo $this->Form->input('VehicleLogDetail.0.nu_km_traveled', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'required' => 'required',
                            'disabled' => 'disabled',
                            'value' => $data['VehicleLogDetail']['nu_km_traveled'],
                            'class' => 'round3')
                        );
                        ?>
                    </td>
                </tr>

            </table> 

        </div>

        <table width="100%" border="0">
            <tr>
                <td align="center" class="align-left" >
                    <?php
                    echo $this->Form->button('Submit', array('label' => false,
                        'div' => false,
                        'id' => 'submit',
                        'type' => 'submit',
                        'class' => 'submit'));
                    ?>			
                </td>
            </tr>
        </table>

    </div>
    <?php echo $this->Form->end(null); ?>

</div>
<!-- end mainbody here-->  
<?php echo $this->element('commonmessagepopup'); ?>
<?php echo $this->Html->script('mdc/editlogdetail'); ?>