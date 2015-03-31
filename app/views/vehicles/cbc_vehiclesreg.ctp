<?php $currentUser = $this->Session->read('Auth'); ?>
<div class="wrapper">
    <!-- Start breadcrumb here-->
    <div class="breadcrumb">
        <ul>
            <li class="first">
                <?php echo $this->Html->link('Home', array('controller' => 'customers', 'action' => 'view', 'cbc' => true), array('title' => 'Home', 'class' => 'vtip')) ?>
            </li>

            <li class="last">Vehicle Registration</li>        
        </ul>
    </div>
    <?php echo $this->Form->create('Vehicle', array('url' => array('controller' => 'Vehicles', 'action' => 'cbc_vehiclesreg', 'cbc' => true), 'type' => 'file')); ?>

    <!-- end breadcrumb here-->
    <!-- Start mainbody here-->
    <div class="mainbody">
        <h1>Welcome to RFA CBC</h1>
        <h3>Vehicle Registration Details</h3>
        <!-- Start innerbody here-->

        <?php //echo $this->Form->create(array('url' => array('controller' =>'vehicles' , 'action'=>'cbc_vehiclesreg'), 'type'=>'file'));?>

        <div class="innerbody">
            <table width="100%" border="0" cellpadding="3">
                <tr>
                    <td><label class="lab-inner">Customer Name :</label></td>
                    <td>

                        <?php
                        echo $this->Form->input('vc_customer_name', array('label' => false,
                            'type' => 'text',
                            'value' => trim($currentUser['Customer']['vc_first_name']) . ' ' . trim($currentUser['Customer']['vc_surname']),
                            'disabled' => 'disabled',
                            'class' => 'round'));
                        ?>

                    </td>
                    <td><label class="lab-inner">Address 1 :</label></td>
                    <td>
                        <?php
                        echo $this->Form->input('vc_address1', array('label' => false,
                            'type' => 'text',
                            'value' => trim($currentUser['Customer']['vc_address1']),
                            'disabled' => 'disabled',
                            'class' => 'round'));
                        ?>

                    </td>
                    <td><label class="lab-inner">Address 2 :</label></td>
                    <td>
                        <?php
                        echo $this->Form->input('vc_address2', array('label' => false,
                            'type' => 'text',
                            'value' => trim($currentUser['Customer']['vc_address2']),
                            'disabled' => 'disabled',
                            'class' => 'round'));
                        ?>

                    </td>
                </tr>
                <tr>
                    <td><label class="lab-inner">Address 3 :</label></td>
                    <td>
                        <?php
                        echo $this->Form->input('vc_address3', array('label' => false,
                            'type' => 'text',
                            'value' => trim($currentUser['Customer']['vc_address3']),
                            'disabled' => 'disabled',
                            'class' => 'round'));
                        ?>

                    </td>
                    <td><label class="lab-inner">Telephone No. :</label></td>
                    <td>
                        <?php
                        echo $this->Form->input('vc_tel_no', array('label' => false,
                            'type' => 'text',
                            'value' => trim($currentUser['Customer']['vc_tel_no']),
                            'disabled' => 'disabled',
                            'class' => 'round'));
                        ?>

                    </td>
                    <td><label class="lab-inner">Fax No. :</label></td>
                    <td>
                        <?php
                        echo $this->Form->input('vc_fax_no', array('label' => false,
                            'type' => 'text',
                            'value' => trim($currentUser['Customer']['vc_fax_no']),
                            'disabled' => 'disabled',
                            'class' => 'round'));
                        ?>

                    </td>
                </tr>
                <tr>
                    <td><label class="lab-inner">Mobile No. :</label></td>
                    <td>
                        <?php
                        echo $this->Form->input('vc_mobile_no', array('label' => false,
                            'type' => 'text',
                            'value' => trim($currentUser['Customer']['vc_mobile_no']),
                            'disabled' => 'disabled',
                            'class' => 'round'));
                        ?>

                    </td>
                    <td><label class="lab-inner">Email :</label></td>
                    <td>

                        <?php
                        echo $this->Form->input('vc_email', array('label' => false,
                            'type' => 'text',
                            'value' => trim($currentUser['Customer']['vc_email']),
                            'disabled' => 'disabled',
                            'class' => 'round'));
                        ?>

                    </td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </div>
        <!-- end innerbody here-->
        <h3>Vehicle</h3>
        <!-- Start innerbody here-->
        <div class="innerbody" id="tooltip">

            <table width="100%" cellspacing="1" cellpadding="5" border="0" >

                <thead>	
                    <tr class="listhead">
                        <td  width="9%">Vehicle Type</td>
                        <td width="9%">Vehicle Reg. No.</td>
                        <td width="9%">Type No.</td>
                        <td width="9%">Vehicle Make</td>
                        <td width="9%">No. of Axles</td>
                        <td width="9%">Series Name</td>
                        <td width="9%">Engine No.</td>
                        <td width="9%">Chassis No.</td> 
                        <td width="9%">V Rating</td>
                        <td width="9%">D/T Rating</td>
                        <td width="9%">Upload Document</td>
                    </tr>

                </thead>

                <tbody>	

                    <tr class="cont1">

                        <td valign='top'>

                            <?php
                            echo $this->Form->input('AddVehicle.0.vc_veh_type', array('label' => false,
                                'type' => 'select',
                                'required' => 'required',
                                'options' => $CustType,
                                'class' => 'round_select1'));
                            ?>

                        </td>
						<td valign='top' >
                            <?php
                            echo $this->Form->input('AddVehicle.0.vc_reg_no', array('label' => false,
                                'div' => false,
                                'type' => 'text',
                                'id' => 'vc_reg_no',
                                'required' => 'required',
                                'maxlength' => '15',
                                'class' => 'round4'));
                            ?>

                        </td>
                        <td valign='top'>
                            <?php
                            echo $this->Form->input('AddVehicle.0.vc_type_no', array('label' => false,
                                //'div' => false,
                                'type' => 'select',
                                'required' => 'required',
                                'options' => $vehtype,
                                'maxlength' => '30',
                                'class' => 'round_select1')
                            );
                            ?>

                        </td>
                        <td valign='top' >
                            <?php
                            echo $this->Form->input('AddVehicle.0.vc_make', array('label' => false,
                                'div' => false,
                                'type' => 'select',
                                'required' => 'required',
                                'id' => 'vc_make',
                                'options' => $vehtype3,
                                'maxlength' => '25',
                                'class' => 'round_select1')
                            );
                            ?>

                        </td>
                        <td valign='top' >
                            <?php
                            echo $this->Form->input('AddVehicle.0.vc_axle_type', array('label' => false,
                                'div' => false,
                                'type' => 'select',
                                'id' => 'vc_axle_no',
                                'options' => $vehtype1,
                                'required' => 'required',
                                'value' => '',
                                'maxlength' => '25',
                                'class' => 'round_select1'));
                            ?>

                        </td>
                        <td valign='top'  >
                            <?php
                            echo $this->Form->input('AddVehicle.0.vc_series_name', array('label' => false,
                                'div' => false,
                                'type' => 'text',
                                'id' => 'vc_series_name',
                                'value' => '',
                                'maxlength' => '25',
                                'class' => 'round4'));
                            ?>

                        </td>
                        <td valign='top' >
                            <?php
                            echo $this->Form->input('AddVehicle.0.vc_engine_no', array('label' => false,
                                'div' => false,
                                'type' => 'text',
                                'id' => 'vc_engine_no',
                                'value' => '',
                                'maxlength' => '25',
                                'class' => 'round4'));
                            ?>

                        </td>
                        <td valign='top' >
                            <?php
                            echo $this->Form->input('AddVehicle.0.vc_chasis_no', array('label' => false,
                                'div' => false,
                                'type' => 'text',
                                'id' => 'vc_chasis_no',
                                'value' => '',
                                'maxlength' => '25',
                                'class' => 'round4'));
                            ?>

                        </td>
                        <td valign='top' title = "The V-value is indicated on your licence disk is the TARRA (the Minimum capacity in Kg a certain truck is able to draw or carry; usually it’s the smaller number)">
                            <?php
                            echo $this->Form->input('AddVehicle.0.nu_v_rating', array('label' => false,
                                'div' => false,
                                'type' => 'text',
                                'id' => 'nu_v_rating',
                                'value' => '',
                                'maxlength' => '15',
                                'class' => 'number-right round4'));
                            ?>

                        </td>
                        <td valign='top' title = "The D-value is indicated on your licence disk (the Maximum capacity in Kg a certain truck or trailer is able to draw or carry; usually it’s a big number GVM)">
                            <?php
                            echo $this->Form->input('AddVehicle.0.nu_d_rating', array('label' => false,
                                'div' => false,
                                'type' => 'text',
                                'id' => 'nu_d_rating',
                                'value' => '',
                                'maxlength' => '15',
                                'class' => 'number-right round4'));
                            ?>

                        </td>

                        </td>
                        <td valign='top'   align="center" ><input type='hidden' value='' name='nouploadvalue'
						id='nouploadvalueid'>
                            <?php
                        echo $this->Form->button('Upload', array('label' => false,
                            'div' => false,
                            'id' => 'updoc0',
                            'tabindex'=>'10',
                            'onclick' => 'uploaddocs(\'uploadDocsvehicle0\',0);',
                            'type' => 'button',
                            'class' => 'round3'));
							
							
                        ?>		
					
						<div id="uploadDocsvehicle0" class="ontop">

        <div id="popup0" class="popup2">

            <a href="javascript:void(0);" class="close" onClick='hidepop("uploadDocsvehicle0");' >Close</a>   

           
            <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
				
				<tr>
					
					<td valign ='top' colspan='2' align="left" class="content-area">
						<div class="listhead-popup">Upload Document</div>
					</td>

				</tr>

				<tr>

					<td colspan='2' valign ='top' align="left">
						<div class="file-format" >Pdf, Png, Jpeg, Jpg File Could be uploaded.<strong>2 MB</strong> is the maximum size for upload </div>
					</td>

				</tr>

                <tr>
                    <td  valign ='top'  width="100%" align="left">
                        <div class="content-area-outer">

                            <div class="upload-button">



                            </div>

                            <div class="button-addmore">

                                <div class='add_row' > 
                                    <a  onclick="add_fields('uploadDocsvehicle0', 0);">
                                        <?php echo $this->Html->image('add-more.png', array('width' => '24', 'height' => '24')); ?>
                                    </a>
                                    <a  onclick="add_fields('uploadDocsvehicle0', 0);"> Add </a>
                                </div>	
                                							
                            </div>

                        </div>
                    </td>
                </tr>
            </table>       

        </div>
    </div>	

                        </td>
                    </tr>
                </tbody>	

            </table>
            <table width="100%" border="0">
                <tr>
                    <td align="center">

                        <?php
                        echo $this->Form->button('Add', array('label' => false,
                            'div' => false,
                            'id' => 'addrow',
                            'type' => 'button',
                            'class' => 'round3 submit'));
                        ?>

                        &nbsp;&nbsp;&nbsp;&nbsp;

                        <?php
                        echo $this->Form->button('Remove', array('label' => false,
                            'div' => false,
                            'id' => 'rmrow',
                            'type' => 'button',
                            'class' => 'round3 submit'));
                        ?>


                        &nbsp;&nbsp;&nbsp;&nbsp;			
                        <?php
                        echo $this->Form->button('Submit', array('label' => false,
                            'div' => false,
                            'id' => 'submit',
                            'type' => 'submit',
                            'class' => 'round3 submit'));
                        ?>			
                    </td>

                </tr>
            </table>

        </div>
        <!-- end innerbody here-->    

        <?php echo $this->Form->end(null); ?>



    </div>
    <!-- end mainbody here-->   
    <!-- end mainbody here-->    
</div>
<!-- end wrapper here-->
<?php echo $this->element('cbc/commonmessagepopup'); ?>
<?php echo $this->Html->script('cbc/vehicle'); ?>
<?php echo $this->Html->script('cbc/tooltip'); ?>
<!-- end mainbody here-->   