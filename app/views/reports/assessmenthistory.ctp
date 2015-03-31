<?php $profile = $this->Session->read('Auth'); ?>
<!-- Start wrapper here-->
<div class="wrapper">
    <!-- Start breadcrumb here-->
    <div class="breadcrumb">
        <ul>
            <li class="first">
                <?php echo $this->Html->link('Home', array('controller' => 'profiles', 'action' => 'index'), array('title' => 'Home', 'class' => 'vtip')) ?>
            </li>

            <li class="last"> Vehicle  Assessment History Report </li>        
        </ul>
    </div>
    <!-- end breadcrumb here-->
    <!-- Start mainbody here-->
    <div class="mainbody">

        <h1><?php echo $mdclocal;?></h1>

        <h3> Vehicle Assessment History Report</h3>

        <!-- Start innerbody here-->

        <div class="innerbody">

            <?php echo $this->Form->create('Report', array('url' => array('controller' => 'reports', 'action' => 'assessmenthistory'))); ?>

            <table width="100%" border="0" cellpadding="3">
                <tr>
                    <td width="13%" valign="top"><label class="lab-inner">From Date :</label></td>
                    <td width="18%" valign="top" class="align-left">
                        <?php
                        $fromDate = !empty($fromdate) ? date('d M Y', strtotime($fromdate)) : '';
                        echo $this->Form->input('fromdate', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'readonly'=>'readonly',
                            'id' => 'fromDate',
                            'maxlength' => 12,
                            'value' => $fromDate,
                            'class' => 'round2'));
                        ?>
                    </td>
                    <td width="13%" valign="top"><label class="lab-inner">To Date :</label></td>
                    <td width="17%" valign="top" class="align-left"><?php
                        $toDate = !empty($todate) ? date('d M Y', strtotime($todate)) : '';
                        echo $this->Form->input('todate', array(
                            'label' => false,
                            'div' => false,
                            'type' => 'text',
                            'id' => 'toDate',
                            'readonly'=>'readonly',
                            'maxlength' => 12,
                            'value' => $toDate,
                            'class' => 'round2'));
                        ?>
                    </td>

                    <td width="17%" valign="top"><span class="">Vehicle Type</span></td>
                    <td width="18%" valign="top">
                        <?php
                        echo $this->Form->input('vehicletype', array(
                            'label' => false,
                            'div' => false,
                            'type' => 'select',
                            'id' => 'vehicleType',
                            'options' => $vehiclelist,
                            'default' => $vehicletypename,
                            'class' => 'round_select round2'));
                        ?>
                    </td>
                    <td width="15%" valign="top" align="center">
                        <?php echo $this->Form->submit('Submit', array('class' => 'submit')); ?>
                    </td>
                </tr>    
				<tr>
                <td align="left" valign="top">
				Company Name:</td>
				<td valign="top"><?php 
				//echo 'nu-company-id'.$nu_company_id;
                        echo $this->Form->input('nu_company_id', array('label' => false,
                            'div' => false,
                            'type' => 'select',
                            'options' => array('All') + $CompanyId,
                            'default' => $nu_company_id,
							'class' => 'round_select round2')
                        );
                        ?></td>
						
						<td valign="top">
						<label style="width:115px;" class="lab-inner">Vehicle Register No.:</label>						
						</td>
						<td colspan='4'>
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
						&nbsp;<?php echo $this->Form->button('Find', array('label' => false,'div' => false,'type' => 'button','id' => 'addshow',));?>
						</td>
                </tr>
            </tr>
            </table>
            <?php echo $this->Form->end(null); ?>
        </div>
        <div class="innerbody">

            <?php echo $this->Form->create('Report', array('url' => array('controller' => 'reports', 'action' => 'assessmenthistorypdf'))); ?>

            <table width="100%" border="0" cellpadding="3">
                <tr>
                    <td width="10%"><label class="lab-inner">RFA Account No. :</label></td>
                    <td width="20%"><span class="valuetext"><?php echo $profile['Profile']['vc_customer_no'];?></span></td>
                    <td width="10%">
                        <label class="lab-inner">
                            <?php if(!empty($fromdate)) { 
                                    $fromdate = date('d M Y',  strtotime($fromdate));
                            ?>
                            From Date :
                           <?php } ?>
                       </label>
                    </td>
                    <td  width="10%"><span class="valuetext"><?php echo $fromdate; ?></span></td>
                    <td width="10%">
                        <label class="lab-inner">
                           <?php if(!empty($vehicletypename)) { 
                                    
                            ?>
                            Vehicle Type :
                           <?php } ?>
                        </label>
                    </td>
                    <td  width="10%"><span class="valuetext"><?php echo $vehicletypename; ?></span></td>
                <td width="10%" nowrap="nowrap">
                        <label class="lab-inner">
                           <?php if(!empty($vehiclelicno)) { 
                                    
                            ?>
                           Vehicle Register No.
                           <?php } ?>
                        </label>
                    </td>
                    <td  width="10%"><span class="valuetext"><?php echo $vehiclelicno; ?></span></td>
				</tr> 
                
                  <tr>
                    <td width="10%"><label class="lab-inner">Customer Name :</label></td>
                    <td width="20%"><span class="valuetext"><?php echo ucfirst($profile['Profile']['vc_customer_name']);?></span></td>
                    <td width="10%" >
                        <label class="lab-inner">
                            <?php if(!empty($todate)) { 
                                    $todate = date('d M Y',  strtotime($todate));
                            ?>
                            To Date :
                           <?php } ?>
                        </label>
                    </td>
                    <td width="10%" align="left"><span class="valuetext"><?php echo $todate; ?></span></td>
                    <td width="10%">
                        <label class="lab-inner">
                           <?php if(!empty($nu_company_id)) {
                                    
                            ?>
                            Company Name :
                           <?php } ?>
                        </label>
                    </td>
                    <td  width="20%"><span class="valuetext"><?php echo wordwrap(ucfirst($company_name['Company']['vc_company_name']), 18, "<br>\n", true); ?></span></td>
                    <td colspan=3 width="20%"  align="right">
                        <?php
                        echo $this->Form->hidden('fromdate', array('value' => $fromdate));
                        echo $this->Form->hidden('todate', array('value' => $todate));
                        echo $this->Form->hidden('vehicletype', array('value' => $vehicletype));
                        echo $this->Form->hidden('nu_company_id', array('value' => $nu_company_id));
						echo $this->Form->hidden('vehiclelicno', array('value' => $vehiclelicno));
			if(  count( $assessmentreport  ) > 0 ) :
                        echo $this->Form->button('Print Report', array(
                            'label' => false,
                            'type' => 'submit',
                            'div' => false,
                            'class' => 'textbutton1 submit'));
			endif;	
                        ?>
                    </td>
                </tr>
            
            </table> 

            <?php echo $this->Form->end(null); ?>
            <br />

            <table width="100%" cellspacing="1" cellpadding="3" border="0" >
                <tr class="listhead1">
                    <td align="center">SI. No.</td>
					<?php if(empty($nu_company_id)) {?>
                                    <td align="center">Company name</td>
					<?php } ?>
                    <td align="center">Assessment Date</td>
                    <td align="center">Assessment No.</td>
                    <td align="center">Vehicle <br/>License No.</td>
                    <td align="center">Vehicle <br/>Register No.</td>
                    <td align="center">Vehicle Type</td>
                    <td align="center">Pay Frequency</td>
                    <td align="center">Prev. End OM</td>
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
                            <td align="center"><?php echo ((($pagecounter - 1) * ($limit)) + $i); ?></td>
							
							<?php if(empty($nu_company_id)) {?>
							
                                <td align="left"><?php echo ucfirst(wordwrap($CompanyId[$showassessmentreport['AssessmentVehicleMaster']['nu_company_id']], 10, "<br>\n", true)); ?></td>
                           
							<?php } ?>
							<?php
								$createdDate = !empty($showassessmentreport['AssessmentVehicleDetail']['dt_created_date']) ?
										date('d M Y', strtotime($showassessmentreport['AssessmentVehicleDetail']['dt_created_date'])) :
										'';
							?>
                            <td><?php echo $createdDate; ?></td>
                            <td><?php echo $showassessmentreport['AssessmentVehicleDetail']['vc_assessment_no']; ?></td>
                            <td><?php echo $showassessmentreport['AssessmentVehicleDetail']['vc_vehicle_lic_no']; ?></td>
                            <td><?php echo $showassessmentreport['AssessmentVehicleDetail']['vc_vehicle_reg_no']; ?></td>
                            <td><?php echo $showassessmentreport['VehicleDetail']['VEHICLETYPE']['vc_prtype_name']; ?></td>
                            <td><?php echo $showassessmentreport['AssessmentVehicleDetail']['vc_pay_frequency']; ?></td>
                            <td align="right">
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
                            <td align="right">
                              
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
                            <td align="right">
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
		         <td align="right">
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
                            <td align="right"> 
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

                        <?php $i++;
                    endforeach; ?>
                <?php else : ?>
				<?php if(empty($nu_company_id)) {?>
					<tr class="cont1" style='text-align:center;'>
                        <td colspan='14'> No Record Found </td>
                    </tr>				
				<?php }else{ ?>
					<tr class="cont1" style='text-align:center;'>
                        <td colspan='13'> No Record Found </td>
                    </tr>				
				<?php } ?>
                <?php endif; ?>
            </table>
            <?php 
            $this->Paginator->options(array(
                'url' => array(
                    'fromDate' => $fromdate,
                    'todate' => $todate,
                    'vehicletype' => $vehicletype,
					'nu_company_id' => $nu_company_id
                    )));
            ?>
            <?php echo $this->element('paginationfooter'); ?>

        </div>
        <!-- end innerbody here-->
    </div>
    <!-- end mainbody here-->

<!--*///////////-->
	
	
<div id="popDiv3" class="ontop">
        <div id="popup" class="popup3">

            <a href="javascript:void(0);" class="close" >Close</a>            
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td align="left" class="content-area"><div class="listhead-popup">Insert Vehicle Lic. No. /  Vehicle Register. No.</div></td>
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
                                            
											<?php if ( count($vehiclelistall) > 0) : ?>

                                                <?php 
														$i = 0;
														
														foreach ($vehiclelistall as $key => $value) : 
														
														$str = $i % 2 == 0 ? '1' : '';
												?>

                                                    <tr class="cont<?php echo $str ?>">

                                                        <td width="10%" align="center">

                                                            <input type='radio' name='vehiclelicno' value='<?php echo trim($value); ?>' />


                                                        </td>

                                                        <td width="60%" align="left"><?php echo trim($key); ?></td>

                                                        <td width="30%"><?php echo trim($value); ?></td>

                                                    </tr>

                                                <?php 
													
													endforeach;
													
													$i++;
												?>

                                            <?php else : ?>

                                                <tr class="cont1" style='text-align:center;'>

                                                    <td colspan='3'>No Records Found</td>

                                                </tr>

                                            <?php endif; ?>		

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
	<!--*----->
    
</div>
<!-- end wrapper here-->
<?php echo $this->Html->script('mdc/assessments-report'); ?>
