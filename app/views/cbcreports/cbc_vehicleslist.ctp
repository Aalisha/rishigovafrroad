<?php
$currentUser = $this->Session->read('Auth');
?>

<!-- Start wrapper here-->
<div class="wrapper">
    <!-- Start breadcrumb here-->
    <div class="breadcrumb">
        <ul>
            <li class="first">
                <?php echo $this->Html->link('Home', array('controller' => 'customers', 'action' => 'view', 'cbc' => true), array('title' => 'Home', 'class' => 'vtip')) ?>
            </li>

            <li class="last">Vehicle List Reports</li>        
        </ul>
    </div>

    <!-- end breadcrumb here-->
    <!-- Start mainbody here-->
    <div class="mainbody">
        <h1>Welcome to RFA CBC</h1>
        <h3>Vehicle Details Report</h3>
        <!-- Start innerbody here-->

        

        <div class="innerbody">
		<?php echo $this->Form->create('Cbcreport', array('url' => array('controller' => 'cbcreports', 'action' => 'cbc_vehicleslist'))); ?>
            <table width="100%" border="0" cellpadding="3">
                <tr>
                    <td><label class="lab-inner">Customer Name :</label></td>
                    <td>

                        <?php
                        echo $this->Form->input('', array('label' => false,
                            'type' => 'text',
                            'disabled' => 'disabled',
                            'value' => $currentUser['Customer']['vc_first_name'] . ' ' . $currentUser['Customer']['vc_surname'],
                            'class' => 'round'));
                        ?>

                    </td>


                    <td><label class="lab-inner">Address 1 :</label></td>
                    <td>

                        <?php
                        echo $this->Form->input('Customer.vc_address1', array('label' => false,
                            'type' => 'text',
                            'disabled' => 'disabled',
                            'value' => $currentUser['Customer']['vc_address1'],
                            'class' => 'round'));
                        ?>


                    </td>


                    <td><label class="lab-inner">Address 2 :</label></td>
                    <td>

                        <?php
                        echo $this->Form->input('Customer.vc_address2', array('label' => false,
                            'type' => 'text',
                            'disabled' => 'disabled',
                            'value' => $currentUser['Customer']['vc_address2'],
                            'class' => 'round'));
                        ?>
                    </td>
                </tr>

                <tr>
                    <td><label class="lab-inner">Address 3 :</label></td>
                    <td>
                        <?php
                        echo $this->Form->input('Customer.vc_address3', array('label' => false,
                            'type' => 'text',
                            'disabled' => 'disabled',
                            'value' => $currentUser['Customer']['vc_address3'],
                            'class' => 'round'));
                        ?>
                    </td>

                    <td><label class="lab-inner">Telephone No. :</label></td>
                    <td>

                        <?php
                        echo $this->Form->input('', array('label' => false,
                            'type' => 'text',
                            'disabled' => 'disabled',
                            'value' => $currentUser['Customer']['vc_tel_no'],
                            'class' => 'round'));
                        ?>
                    </td>

                    <td><label class="lab-inner">Fax No. :</label></td>
                    <td>

                        <?php
                        echo $this->Form->input('', array('label' => false,
                            'type' => 'text',
                            'disabled' => 'disabled',
                            'value' => $currentUser['Customer']['vc_fax_no'],
                            'class' => 'round'));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><label class="lab-inner">Mobile No. :</label></td>
                    <td>

                        <?php
                        echo $this->Form->input('', array('label' => false,
                            'type' => 'text',
                            'disabled' => 'disabled',
                            'value' => $currentUser['Customer']['vc_mobile_no'],
                            'class' => 'round'));
                        ?>

                    </td>
                    <td><label class="lab-inner">Email :</label></td>
                    <td>				

                        <?php
                        echo $this->Form->input('', array('label' => false,
                            'type' => 'text',
                            'disabled' => 'disabled',
                            'value' => $currentUser['Customer']['vc_email'],
                            'class' => 'round'));
                        ?>

                    </td>
                <tr>

                <tr>

                    <td><label class="lab-inner">Vehicle Type :</label></td>
                    <td>
                        <?php
                        $options = array("01" => "All", "02" => "Specific");
                        echo $this->Form->input('vehicletype', array(
                            'label' => false,
                            'type' => 'select',
                            'options' => $vehiclelist,
                            'default' => $vehicletype,
                            'class' => "round_select",
                            'id' => "vtype",
                        ));
                        ?>
                    </td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>



                    <td label class="lab-inner" align="right">
                        <?php echo $this->Form->submit('Submit', array('class' => 'submit')); ?>

                    </td>

                </tr>
            </table>
            <?php echo $this->Form->end(null); ?>
        </div>
        <div id='ajaxdata' class="innerbody">

            <?php echo $this->Form->create('Cbcreport', array('url' => array('controller' => 'cbcreports', 'action' => 'cbc_vehicleslist_pdf'))); ?>

            <table width="100%" border="0" cellpadding="3" class ="customersInfo">
                <tr>
                    <td width="10%"><label class="lab-inner">Customer Name :</label></td>
                    <td width="10%"><span class="valuetext"><?php echo ucfirst($customername); ?></span></td>
                    <td width="10%">
                        <label class="lab-inner">
                            <?php if (!empty($vehicletypename)) { ?>
                                Vehicle Type :
                            <?php } ?>
                        </label>
                    </td>
                    <td  width="8%"><span class="valuetext"><?php echo $vehicletypename; ?></span></td>

                    <td align="right">
                        <?php
                        echo $this->Form->hidden('vehicletype', array('value' => $vehicletype));
                        if (count($vehiclereport) > 0):
                            echo $this->Form->button('Print Report', array(
                                'label' => false,
                                'type' => 'submit',
                                'div' => false,
                                'class' => 'submit'));
                        endif;
                        ?>

                    </td>
                </tr>
            </table>

            <?php echo $this->Form->end(null); ?>



            <table width="100%" border="0" cellpadding="3">
                <tr class="listhead1">

                    <td width=6%" align="center">SI. No.</td>
                    <td width="9%" align="center">Vehicle <br/>Type</td>
                    <td width="11%" align="center">Vehicle <br/>Reg. No.</td>
                    <td width="9%" align="center">Type No.</td>
                    <td width="9%" align="center">Vehicle Make</td>
                    <td width="9%" align="center">No. of Axles</td>
                    <td width="11%" align="center">Series Name</td>
                    <td width="9%" align="center">Engine No.</td>
                    <td width="9%" align="center">Chassis No.</td>
                    <td width="9%" align="center">V <br/>Rating</td>
                    <td width="9%" align="center">D/T <br/>Rating</td>
                </tr>
                <?php if (count($vehiclereport) > 0) : ?>
                    <?php
                    $i = 0;
                    foreach ($vehiclereport as $val) {
                        ?>


                        <tr class="cont1" align="left">
                            <td align="right">

                                <?php
                                echo $start;
                                ?>
                            </td>
                            <td align="left">

                                <?php
								if(isset($val['AddVehicle']['vc_veh_type']) && !empty($val['AddVehicle']['vc_veh_type']))
                                echo $globalParameterarray[$val['AddVehicle']['vc_veh_type']];
                                ?>
                            </td>
                            <td align="left">

                                <?php
                                echo $val['AddVehicle']['vc_reg_no'];
                                ?>
                            </td>
                            <td align="left">

                                <?php
									if(isset($val['AddVehicle']['vc_type_no']) && !empty($val['AddVehicle']['vc_type_no']))
                                echo $globalParameterarray[$val['AddVehicle']['vc_type_no']];
                                ?>
                            </td>
                            <td align="left">

                                <?php
								if(isset($val['AddVehicle']['vc_make']) && !empty($val['AddVehicle']['vc_make']))
                                echo $globalParameterarray[$val['AddVehicle']['vc_make']];
                                ?>
                            </td>
                            <td align="left">

                           <?php
								if(isset($val['AddVehicle']['vc_axle_type']) && !empty($val['AddVehicle']['vc_axle_type']))
                                echo wordwrap($globalParameterarray[$val['AddVehicle']['vc_axle_type']], 12, "<br>\n", true);
                            ?>
                            </td>
                            <td align="left">

                                <?php
                                echo wordwrap($val['AddVehicle']['vc_series_name'], 12, "<br>\n", true);
                                ?>
                            </td>
                            <td align="left">

                                <?php
                                echo wordwrap($val['AddVehicle']['vc_engine_no'], 12, "<br>\n", true);
                                ?>
                            </td>
                            <td align="left">

                                <?php
                                echo wordwrap($val['AddVehicle']['vc_chasis_no'], 12, "<br>\n", true);
                                ?>
                            </td>
                            <td align="right">

                                <?php
                                echo number_format($val['AddVehicle']['nu_v_rating']);
                                ?>
                            </td>
                            <td align="right">

                                <?php
                                echo number_format($val['AddVehicle']['nu_d_rating']);
                                ?>
                            </td>
                        </tr>	
                        <?php
                        $i++;
                        $start++;
                    }
                    ?>
                <?php else : ?>
                    <tr class="cont1" style='text-align:center;'>
                        <td colspan='14'> No Record Found </td>
                    </tr>
                <?php endif; ?> 


            </table>

        </div>
        <!-- end innerbody here-->       

        <table width="100%" border="0">
            <tr>
                <td align="center">


        </table>


        <!-- end innerbody here-->       

        <table width="100%" border="0" style="display:none;">
            <tr>
                <td align="center">





                </td>
            </tr>
        </table>
        <?php echo $this->Form->end(); ?>
    </div>

    <!-- end mainbody here-->    

</div>

<?php
$this->Paginator->options(array(
    'url' => array(
        'Specific' => $options,
        'vehicletype' => $vehicletype
        )));
?>


<!-- end wrapper here-->

<?php echo $this->element('cbc/paginationfooter'); ?>
</table>
<?php echo $this->Html->script('cbc/cbc_reports'); ?>
   