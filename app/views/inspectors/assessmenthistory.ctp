<!-- Start wrapper here-->
<?php //pr($assessmentreport); die;?>
<div class="wrapper">
    <!-- Start breadcrumb here-->
    <div class="breadcrumb">
        <ul>
            <li class="first">
                <?php echo $this->Html->link('Home', array('controller' => 'inspectors', 'action' => 'index'), array('title' => 'Home', 'class' => 'vtip')) ?>
            </li>

            <li class="last"> Customer Assessment History Report </li>        
        </ul>
    </div>
    <!-- end breadcrumb here-->
    <!-- Start mainbody here-->
    <div class="mainbody">
        <h1><?php echo $mdclocal;?></h1>
        <h3> Customer Assessment History Report</h3>
        <!-- Start innerbody here-->
        <div class="innerbody">
            <?php echo $this->Form->create('Inspector', array('url' => array('controller' => 'inspectors', 'action' => 'assessmenthistory'))); ?>

            <table width="100%" border="0" cellpadding="3">
                <tr>
                    <td valign='top'  width="13%"><label class="lab-inner">From Date :</label></td>
                    <td  valign='top' width="20%">
                        <?php
                        echo $this->Form->input('fromdate', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'id' => 'fromDate',
                            'class' => ' round2'));
                        ?>
                    </td>
                    <td valign='top' width="13%"><label class="lab-inner">To Date :</label></td>
                    <td  valign='top' width="15%"><?php
                        echo $this->Form->input('todate', array(
                            'label' => false,
                            'div' => false,
                            'type' => 'text',
                            'id' => 'toDate',
                             'class' => 'round2'));
                        ?>
                    </td>
                    <td valign='top' width="17%"><span class="valuetext">Customer Name</span></td>
                    <td  valign='top' width="18%">
                        <?php
                        echo $this->Form->input('vc_customer_name', array(
                            'label' => false,
                            'div' => false,
                            'type' => 'text',
                            'id' => 'vc_customer_name',
                            'value' => $vc_customer_name,
                            'maxlength' => 100,
                            'class' => 'round2'));
                        ?>
                    </td>
                    <td valign='top'  width="15%" align="center">
                        <?php echo $this->Form->submit('Submit', array('class' => 'submit')); ?>
                    </td>
                </tr>   
 	<tr>
                    <td valign='top' width="13%" nowrap="nowrap"><label class="lab-inner">Vehicle Register No.</label></td>
                    <td  valign='top' width="20%">
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
                    </td>
                    <td valign='top' width="13%"><label class="lab-inner"></label></td>
                    <td valign='top' width="15%">
                    </td>

                    <td valign='top' width="17%"><span class="valuetext"></span></td>
                    <td valign='top' width="18%">
                      
                    </td>
                    <td  valign='top' width="15%" align="center">
                        
                    </td>
                </tr>   				
            </table>
            <?php echo $this->Form->end(null); ?>
        </div>
        <div class="innerbody">
            <?php echo $this->Form->create('Inspector', array('url' => array('controller' => 'inspectors', 'action' => 'assessmenthistorypdf'))); ?>

            <table width="100%" border="0" cellpadding="3" class ="customersInfo" style="">
                <tr>
                    <td width="10%"><label class="lab-inner"><?php if($vc_customer_name!=''){ ?>Customer Name :<?php }?></label></td>
                    <td width="10%"><span class="valuetext"><?php echo $vc_customer_name; ?></span></td>
                    <td width="5%"><label class="lab-inner"><?php if($fromdate!=''){ ?>From Date :<?php }?></label></td>
                    <td width="10%"><span class="valuetext"><?php echo $fromdate; ?></span>
                    </td>
                    <td width="5%"><label class="lab-inner"><?php if($todate!=''){ ?>To Date : <?php }?></label></td>
                    <td width="10%"><span class="valuetext"><?php echo $todate; ?></span></td>
					<!-- <td width="5%"><label class="lab-inner"><?php if(isset($vehiclelicno) && $vehiclelicno!=''){ ?>Vehicle Lic No. :<?php }?></label></td>
                    <td width="10%"><span class="valuetext"><?php if(isset($vehiclelicno) && $vehiclelicno!=''){ echo $vehiclelicno; } ?></span></td>-->
                    <td width="10%"  align="right">
                        <?php
                        echo $this->Form->hidden('fromdate', array('value' => $fromdate));
                        echo $this->Form->hidden('todate', array('value' => $todate));
						echo $this->Form->hidden('vehiclelicno', array('value' => $vehiclelicno));
                        echo $this->Form->hidden('vc_customer_name', array('value' => $vc_customer_name));
						if (count($assessmentreport) > 0) :
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
                    
					 <td width="10%" nowrap="nowrap"><label class="lab-inner"><?php if(isset($vehiclelicno) && $vehiclelicno!=''){ ?>Vehicle Register No. :<?php }?></label></td>
                    <td width="30%" colspan="6"	><span class="valuetext"><?php if(isset($vehiclelicno) && $vehiclelicno!=''){ echo $vehiclelicno; } ?></span></td>
                   
                </tr>
            </table>

            <?php echo $this->Form->end(null); ?>
            <br />

            <table width="100%" cellspacing="1" cellpadding="5" border="0" >
                <tr class="listhead1">
                    <td align="center">SI. No.</td>
                    <td align="center">Customer Name</td>      
                    <td align="center">Assessment Date</td>
                    <td align="center">Assessment No.</td>
                    <td align="center">Vehicle <br/>LIC. No.</td>
                    <td align="center">Vehicle <br/>Register No.</td>
                    <td align="center">Vehicle Type</td>
                    <td align="center">Pay Frequency</td>
                    <td align="center">Prev. <br/>End OM</td>
                    <td align="center">End OM</td>
                    <td align="center">KM Travel on Namibian <br/>Road Network</td>
                    <td align="center">Rate(N$)</td>
                    <td align="center">Payable(N$)</td>
                    <td align="center">Status</td>
                </tr>
                <?php
                if (count($assessmentreport) > 0) :
                    $i = 1;
                    foreach ($assessmentreport as $showassessmentreport) : $sr = $i % 2 == 0 ? '' : '1';
                        ?>
                        <tr class="cont<?php echo $sr; ?>">
                            <td align="center"><?php echo $start; ?></td>
                            <td><?php echo ucfirst($showassessmentreport['AssessmentVehicleMaster']['vc_customer_name']); ?></td>
                            <?php 
                                    $created_date = !empty($showassessmentreport['AssessmentVehicleDetail']['dt_created_date']) ?
                                                    date('d M Y', strtotime($showassessmentreport['AssessmentVehicleDetail']['dt_created_date'])):
                                                    '';
                            ?>
                            <td ><?php echo $created_date; ?></td>
                            <td><?php echo $showassessmentreport['AssessmentVehicleDetail']['vc_assessment_no']; ?></td>
                            <td><?php echo $showassessmentreport['AssessmentVehicleDetail']['vc_vehicle_lic_no']; ?></td>
                            <td><?php echo $showassessmentreport['AssessmentVehicleDetail']['vc_vehicle_reg_no']; ?></td>
                            <td><?php echo $showassessmentreport['VehicleDetail']['VEHICLETYPE']['vc_prtype_name']; ?></td>
                            <td><?php echo $showassessmentreport['AssessmentVehicleDetail']['vc_pay_frequency']; ?></td>
                            <td style="text-align:right;">
                            
                            <?php
                                $PrevEndOm = isset($showassessmentreport['AssessmentVehicleDetail']['vc_prev_end_om']) ? 
                                $this->Number->format($showassessmentreport['AssessmentVehicleDetail']['vc_prev_end_om'], array(
                                'places' => false,
                                'before' => false,
                                'escape' => false,
                                'decimals' => false,
                                'thousands' => ','
                                )):'';

                                echo $PrevEndOm; 
                               ?>
                            </td>
                            <td style="text-align:right;">
                                
                                <?php
                                $EndOm = isset($showassessmentreport['AssessmentVehicleDetail']['vc_end_om']) ? 
                                $this->Number->format($showassessmentreport['AssessmentVehicleDetail']['vc_end_om'], array(
                                'places' => false,
                                'before' => false,
                                'escape' => false,
                                'decimals' => false,
                                'thousands' => ','
                                )):'';

                                echo $EndOm; 
                               ?>
                                
                           </td>
                            <td style="text-align:right;">

                                <?php
                                $KMTravld = isset($showassessmentreport['AssessmentVehicleDetail']['vc_km_travelled']) ? 
                                $this->Number->format($showassessmentreport['AssessmentVehicleDetail']['vc_km_travelled'], array(
                                'places' => false,
                                'before' => false,
                                'escape' => false,
                                'decimals' => false,
                                'thousands' => ','
                                )):'';

                                echo $KMTravld; 
                               ?>
                            </td>
		
                            <td style="text-align:right;">
                                <?php
                                $Rate = isset($showassessmentreport['AssessmentVehicleDetail']['vc_rate']) ? 
                                $this->Number->format($showassessmentreport['AssessmentVehicleDetail']['vc_rate'], array(
                                'places' => 2,
                                'before' => false,
                                'escape' => false,
                                'decimals' => '.',
                                'thousands' => ','
                                )):'';

                                echo $Rate; 
                               ?>
                                
                                
                                
                                </td>
                            <td style="text-align:right;">
                                <?php
                                $Payable = isset($showassessmentreport['AssessmentVehicleDetail']['vc_payable']) ? 
                                $this->Number->format($showassessmentreport['AssessmentVehicleDetail']['vc_payable'], array(
                                'places' => 2,
                                'before' => false,
                                'escape' => false,
                                'decimals' => '.',
                                'thousands' => ','
                                )):'';

                                echo $Payable; 
                               ?>
                                
                            </td>
                             <td align="left"> 
                               <?php echo $globalParameterarray[$showassessmentreport['AssessmentVehicleMaster']['vc_status']];?>
                            </td>
                            
                        </tr>

                        <?php $i++;$start++;
                    endforeach; ?>
                <?php else : ?>
                    <tr class="cont1" style='text-align:center;'>
                        <td colspan='12'> No Record Found </td>
                    </tr>
                <?php endif; ?>

            </table>

            <?php
            $this->Paginator->options(array(
                'url' => array(
                    'fromdate' => $fromdate,
                    'todate' => $todate,
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
                    <td align="left" class="content-area"><div class="listhead-popup">Insert Vehicle Lic. No. /  Vehicle Register No.</div></td>
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

                                                <td width="30%"> Vehicle Register No. </td>

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
<?php echo $this->Html->script('inspector/insp-assessmenthistory'); ?>
