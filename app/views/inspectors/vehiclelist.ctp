<!-- Start wrapper here-->
<div class="wrapper">
    <!-- Start breadcrumb here-->
    <div class="breadcrumb">
        <ul>
            <li class="first">
                <?php echo $this->Html->link('Home', array('controller' => 'inspectors', 'action' => 'index'), array('title' => 'Home', 'class' => 'vtip')) ?>
            </li>
            <li class="last">Vehicle History Report</li>        
        </ul>
    </div>
    <!-- end breadcrumb here-->
    <!-- Start mainbody here-->
    <div class="mainbody">

        <h1><?php echo $mdclocal;?></h1>

        <h3>Vehicle History Report</h3>

        <!-- Start innerbody here-->

        <div class="innerbody">
            <?php echo $this->Form->create('Inspector', array('url' => array('controller' => 'inspectors', 'action' => 'vehiclelist'))); ?>
            <table width="100%" border="0" cellpadding="3">
                <tr>
                    <td valign='top' width="13%"><label class="lab-inner">From Date :</label></td>
                    <td valign='top' width="20%">
                        <?php
                        $SearchfromDate = !empty($SearchfromDate) ? date('d M Y',strtotime($SearchfromDate)):'';
                        echo $this->Form->input('fromdate', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'id' => 'fromDate',
                            'value' => $SearchfromDate,
                            'class' => ' dateseclect round2'));
                        ?>
                    </td>
                    <td valign='top' width="13%"><label class="lab-inner">To Date :</label></td>
                    <td valign='top' width="15%"><?php
                    $SearchtoDate = !empty($SearchtoDate) ? date('d M Y',strtotime($SearchtoDate)):'';
                        echo $this->Form->input('todate', array(
                            'label' => false,
                            'div' => false,
                            'id' => 'toDate',
                            'type' => 'text',
                            'value' => $SearchtoDate,
                            'class' => 'dateseclect round2'));
                        ?>
                    </td>
                    <td valign='top' width="17%">Customer Name</td>
                    <td valign='top' width="18%">
                        <?php
                        echo $this->Form->input('vc_customer_name', array(
                            'label' => false,
                            'div' => false,
                            'type' => 'text',
                            'id' => 'vc_customer_name',
                            'maxlength' => 50,
                            'class' => 'round2'));
                        ?>
                    </td>


                    <td valign='top' width="15%" align="center">

                        <?php echo $this->Form->submit('Submit', array('class' => 'submit')); ?>

                    </td>

                </tr>    
<tr><td width="5%" valign="top"><label style="width:115px;" class="lab-inner">Vehicle Register No.</label></td>
                    <td width="15%" valign="top" colspan='6' class="align-left">
                        <?php
                      echo $this->Form->input('vehiclelicno', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'id' => 'vehiclelicnoid',
                            'readonly'=>'readonly',
							'style'=>'width:80px;',
                            'maxlength' => 20,
                            'value' => $vehiclelicno,
                            'class' => ' round2'));
							
							
                        ?>
						
						&nbsp;<?php echo $this->Form->button('Find', array('label' => false,'div' => false,
						'name'=>'search',
						'type' => 'button','id' => 'addshow'));?>
                    </td></tr>				
            </table>
            <?php echo $this->Form->end(null); ?>
        </div>
        <div id='ajaxdata' class="innerbody">

            <?php echo $this->Form->create('Inspector', array('url' => array('controller' => 'inspectors', 'action' => 'vehiclelistpdf'))); ?>

            <table width="100%" border="0" cellpadding="3" class ="customersInfo" style="">
                <tr>
                    <td width="10%"><label class="lab-inner"><?php if($vc_customer_name!=''){ ?>Customer Name :
					<?php }?>
					</label></td>
                    <td width="10%"><span class="valuetext"><?php echo $vc_customer_name; ?></span></td>
                    <td width="10%"><label class="lab-inner"><?php if($SearchfromDate!=''){ ?>From Date :
					<?php }?>
					</label></td>
                    <td width="10%"><span class="valuetext"><?php echo !empty($SearchfromDate) ? date('d M Y',strtotime($SearchfromDate)):''; ?></span>
                    </td>
                    <td width="10%"><label class="lab-inner"><?php if($SearchtoDate!=''){ ?>To Date :<?php }?></label></td>
                    <td width="10%"><span class="valuetext"><?php echo !empty($SearchtoDate) ? date('d M Y',strtotime($SearchtoDate)):''; ?></span></td>
                    <td width="10%"  align="right">
                        <?php
                        echo $this->Form->hidden('fromdate', array('value' => $SearchfromDate));
                        echo $this->Form->hidden('toDate', array('value' => $SearchtoDate));
                        echo $this->Form->hidden('vc_customer_name', array('value' => $vc_customer_name));
                        echo $this->Form->hidden('vehiclelicno', array('value' => $vehiclelicno));
						if (count($vehiclereport) > 0) :
							echo $this->Form->button('Print Report', array(
								'label' => false,
								'type' => 'submit',
								'div' => false,
								'class' => 'textbutton1 submit'));
						endif;		
                        ?>
                    </td>
                </tr>
				 <tr>
                    <td width="15%" nowrap="nowrap"><label class="lab-inner"><?php if($vehiclelicno!=''){ ?>Vehicle Register No.<?php }?>
					</label></td>
                    <td width="10%" colspan="6"><span class="valuetext"><?php echo $vehiclelicno; ?></span></td> </tr>
            </table>

            <?php echo $this->Form->end(null); ?>

            <br />

            <table width="100%" cellspacing="1" cellpadding="5" border="0" >

                <tr class="listhead1">
                    <td width="5%" align="center">SI. No.</td>
                    <td width="15%" align="center">Customer Name</td>
                    <td width="15%" align="center">Vehicle LIC No.</td>
                    <td width="15%" align="center">Vehicle Register No.</td>
                    <td width="10%" align="center">Registration Date</td>
                    <td width="10%" align="center">Vehicle Type</td>
                    <td width="10%" align="center">GVM Rating</td>
                    <td width="10%" align="center">D/T Rating</td>
                    <td width="10%" align="center">Rate(N$)</td>
                </tr>

                <?php if (count($vehiclereport) > 0) : ?>	
                    <?php $i = 1;
                    foreach ($vehiclereport as $showvehiclereport) : $sr = $i % 2 == 0 ? '' : '1'; ?>

                        <tr class="cont<?php echo $sr; ?>">
                            <td align="center"><?php echo $start; ?></td>
                            <td><?php echo $showvehiclereport['CustomerProfile']['vc_customer_name']; ?></td>
                            <td><?php echo $showvehiclereport['VehicleDetail']['vc_vehicle_lic_no']; ?></td>
                            <td><?php echo $showvehiclereport['VehicleDetail']['vc_vehicle_reg_no']; ?></td>
                            <?php
                                    $createdDate = !empty($showvehiclereport['VehicleDetail']['dt_created_date']) ?
                                                    date('d M Y', strtotime($showvehiclereport['VehicleDetail']['dt_created_date'])):
                                                    '';
                                ?>
                           <td><?php echo $createdDate ?></td>
                            <td><?php echo $showvehiclereport['VEHICLETYPE']['vc_prtype_name']; ?></td>
                            <td align="right">
                            <?php
                                $V_Rating = isset($showvehiclereport['VehicleDetail']['vc_v_rating']) ? 
                                $this->Number->format($showvehiclereport['VehicleDetail']['vc_v_rating'], array(
                                'places' => false,
                                'before' => false,
                                'escape' => false,
                                'decimals' => false,
                                'thousands' => ','
                                )):'';

                                echo $V_Rating; 
                            ?>    
                           </td>
                            <td align="right">
                            <?php
                                $D_T_Rating = isset($showvehiclereport['VehicleDetail']['vc_dt_rating']) ? 
                                $this->Number->format($showvehiclereport['VehicleDetail']['vc_dt_rating'], array(
                                'places' => false,
                                'before' => false,
                                'escape' => false,
                                'decimals' => false,
                                'thousands' => ','
                                )):'';

                                echo $D_T_Rating; 
                            ?>    
                            </td>
                            <td align="right">
                            <?php
                                $Rate = isset($showvehiclereport['VehicleDetail']['vc_rate']) ? 
                                $this->Number->format($showvehiclereport['VehicleDetail']['vc_rate'], array(
                                'places' => 2,
                                'before' => false,
                                'escape' => false,
                                'decimals' => '.',
                                'thousands' => ','
                                )):'';

                                echo $Rate; 
                            ?>
                            </td>
                        </tr>

                        <?php $i++;
						$start++;
                    endforeach; ?>
                <?php else : ?>
                    <tr class="cont1" style='text-align: center'>
                        <td colspan='9'> No Record Found </td>
                    </tr>
                <?php endif; ?> 
            </table>


            <?php
            $this->Paginator->options(array(
                'url' => array(
                    'fromDate' => $SearchfromDate,
                    'todate' => $SearchtoDate,
                    'vehiclelicno' => $vehiclelicno,
                    'vc_customer_name' => $vc_customer_name
                    )));
            ?>

            <?php echo $this->element('paginationfooter'); ?>



        </div>
        <!-- end innerbody here-->
    </div>
    <!-- end mainbody here-->
   <!-- start popup here-->
<div id="popDiv3" class="ontop">
        <div id="popup" class="popup3">

            <a href="javascript:void(0);" class="close" >Close</a>            
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td align="left" class="content-area"><div class="listhead-popup">Insert Vehicle Lic. No. /  Vehicle Reg. No.</div></td>
                </tr>
                <tr>
                    <td width="100%" align="center" class="content-area">
                        <div class="content-area-outer">
                            <table width="100%" border="0">
                                <tr>
                                    <td> 
                                        <input type="text" class="tftextinput" name="search" size="21" maxlength="50">
                                        <input type="button" value="search" class="tfbutton"></td>
                                </tr>
                                <tr>
                                    <td>
                                        <table width="100%" cellspacing="1" cellpadding="5" border="0" >
                                            <tr class="listhead1">

                                                <td width="10%" align="left"></td>

                                                <td width="60%" align="left">Vehicle Lic. No.</td>

                                                <td width="30%"> Vehicle Reg. No. </td>

                                            </tr>
                                        </table>
									<table id='ajaxshow' width="100%" cellspacing="1" cellpadding="5" border="0" >		
                                            
											<?php if (isset($vehiclelistall) &&  count($vehiclelistall) > 0) : ?>

                                                <?php 
														$i = 0;
														
														foreach ($vehiclelistall as $key => $value) {
														
														$str = $i % 2 == 0 ? '1' : '';
												?>

                                                    <tr class="cont<?php echo $str ?>">

                                                        <td width="10%" align="center">

                                                            <input type='radio' name='vehiclelicno' value='<?php echo trim($key); ?>' />


                                                        </td>

                                                        <td width="60%" align="left"><?php echo trim($key); ?></td>

                                                        <td width="30%"><?php echo trim($value); ?></td>

                                                    </tr>

                                                <?php 
													
												
													$i++;
													}
												?>

                                            <?php   else : ?>

                                                <tr class="cont1" style='text-align:center;'>

                                                    <td colspan='3'>No Records Found</td>

                                                </tr>

                                            <?php  endif; ?>		

                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </div>

                    </td>
                </tr>
            </table>

        </div>
    </div>   
<!--popup end here-->	    
</div>
<!-- end wrapper here-->
<?php echo $this->Html->script('inspector/insp-vehiclelist'); ?>