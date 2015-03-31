<?php $profile = $this->Session->read('Auth'); ?>
<!-- Start wrapper here-->
<div class="wrapper">
    <!-- Start breadcrumb here-->
    <div class="breadcrumb">
        <ul>
            <li class="first">
                <?php echo $this->Html->link('Home', array('controller' => 'profiles', 'action' => 'index'), array('title' => 'Home', 'class' => 'vtip')) ?>
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
            <?php echo $this->Form->create('Report', array('url' => array('controller' => 'reports', 'action' => 'vehiclelist'))); ?>
            <table width="100%" border="0" cellpadding="3">
                <tr>
                    <td width="5%" valign="top"><label style="width:70px;" class="lab-inner">From Date :</label></td>
                    <td width="7%" valign="top" class="align-left">
                        <?php
                        $SearchfromDate = !empty($SearchfromDate) ? date('d M Y', strtotime($SearchfromDate)) : '';
                        echo $this->Form->input('fromdate', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'id' => 'fromDate',
                            'readonly'=>'readonly',
                            'maxlength' => 12,
                            'value' => $SearchfromDate,
                            'class' => ' round2'));
                        ?>
                    </td>
                    <td width="5%" valign="top"><label style="width:70px;" class="lab-inner">To Date :</label></td>
                    <td width="7%" valign="top" class="align-left"><?php
                        $SearchtoDate = !empty($SearchtoDate) ? date('d M Y', strtotime($SearchtoDate)) : '';
                        echo $this->Form->input('todate', array(
                            'label' => false,
                            'div' => false,
                            'id' => 'toDate',
                            'readonly'=>'readonly',
                            'type' => 'text',
                            'maxlength' => 12,
                            'value' => $SearchtoDate,
                            'class' => 'round2'));
                        ?>
                    </td>

                    <td width="10%" valign="top"><span class="">Vehicle Type :</span></td>
                    <td width="15%"  valign="top" align="left" class="align-left">
                        <?php
                        echo $this->Form->input('vehicletype', array(
                            'label' => false,
                            'div' => false,
                            'type' => 'select',
                            'id' => 'vehicleType',
                            'options' => $vehiclelist,
                            'default' => $vehicletype,
                            'class' => 'round_select round2'));
                        ?>

                    </td>
					<td width="15%"  valign="top" align="center">Company Name :
					</td>
					<td width="15%"  valign="top" align="left"><?php 
					echo $this->Form->input('nu_company_id', array('label' => false,
                            'div' => false,
                            'type' => 'select',
                            'options' => array('All') + $CompanyId,
                            'default' => $nu_company_id,
							'class' => 'round_select round2')
                        );?></td>
                    <td width="5%"  valign="top" align="center">
                        <?php echo $this->Form->submit('Submit', array('class' => 'submit')); ?>
                    </td>

                </tr> 
				<tr>
                    <td width="15%"  valign="top"><label style="width:120px;" class="lab-inner">Vehicle Register No.</label></td>
                    <td width="15%" valign="top" colspan='7' class="align-left">
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
                    
                   
					<td width="15%"  valign="top" align="left"></td>
                  

                </tr> 				
            </table>
            <?php echo $this->Form->end(null); ?>
        </div>
        <div id='ajaxdata' class="innerbody">

            <?php echo $this->Form->create('Report', array('url' => array('controller' => 'reports', 'action' => 'vehiclelistpdf'))); ?>

            <table width="100%" border="0" cellpadding="3" class ="customersInfo" style="">

                <tr>
                    <td width="10%"><label class="lab-inner">RFA Account No. :</label></td>
                    <td width="10%"><span class="valuetext"><?php echo $profile['Profile']['vc_customer_no']; ?></span></td>
                    <td width="2%">
                    <label class="lab-inner"><?php
                            if (!empty($SearchfromDate)) {
                                $SearchfromDate = date('d M Y', strtotime($SearchfromDate));
                                ?>
                                From Date :
                            <?php } ?>
                        </label>
                    </td>
                    <td  width="10%"><span class="valuetext"><?php echo $SearchfromDate; ?></span></td>
                    <td width="10%">
                        <label class="lab-inner">
                            <?php if (!empty($vehicletypename)) { ?>
                                Vehicle Type :
                            <?php } ?>
                        </label>
                    </td>
                    <td  width="15%" align ="left"><span class="valuetext"><?php echo $vehicletypename;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					</td>
					<td>
					<span style="text-align:right;padding-left:135px;">

<?php					if (count($vehiclereport) > 0):
                            echo $this->Form->button('Print Report', array(
                                'label' => false,
                                'type' => 'submit',
								'style'=>"text-align:right;",
                                'div' => false,
                                'class' => 'textbutton1 submit'));
                        endif;?></span></td>
                </tr> 

                <tr>
                    <td width="10%"><label class="lab-inner">Customer Name :</label></td>
                    <td width="10%"><span class="valuetext"><?php
					echo wordwrap(ucfirst($profile['Profile']['vc_customer_name']),30,"<br>\n",TRUE);
					?></span></td>
                    <td width="2%">
                        <label class="lab-inner">
                            <?php
                            if (!empty($SearchtoDate)) {
                                $SearchtoDate = date('d M Y', strtotime($SearchtoDate));
                                ?>
                                To Date :
                            <?php } ?>
                        </label>
                    </td>
                    <td width="10%"><span class="valuetext"><?php echo $SearchtoDate; ?></span></td>

                    <td  width="10%"  align="left">
					<label class="lab-inner" align="left">
                            <?php if (!empty($nu_company_id)) { ?>
                               Company Name :
                            <?php } ?></label>
                        
                    </td> <td  width="15%"  align="left">
                            <?php if (!empty($nu_company_id)) { ?>
							<span class="valuetext"><?php
					echo wordwrap(ucfirst($CompanyId[$nu_company_id]),30,"<br>\n",TRUE);
					?></span>
                               
                            <?php } ?>
							<?php
                        echo $this->Form->hidden('fromdate', array('value' => $SearchfromDate));
                        echo $this->Form->hidden('todate', array('value' => $SearchtoDate));
                        echo $this->Form->hidden('vehicletype', array('value' => $vehicletype));
                        echo $this->Form->hidden('nu_company_id', array('value' => $nu_company_id));
                        echo $this->Form->hidden('vehiclelicno', array('value' => $vehiclelicno));
						
                        ?>
                        
                    </td><td>
					<?php if(isset($vehiclelicno) && $vehiclelicno!=''){?>
				Vehicle Register No.&nbsp;:
				&nbsp;<b><?php echo $vehiclelicno; 
				
				}?></b>
					</td>
					
                </tr>
            </table>

            <?php echo $this->Form->end(null); ?>

            <br />

            <table width="100%" cellspacing="1" cellpadding="5" border="0" >
			<?php if (empty($nu_company_id)) { ?>
                    
                <tr class="listhead1">
                    <td width="5%" align="center">SI. No.</td>
                    <td width="15%" align="center">Vehicle LIC. No.</td>					
					<td width="15%" align="center">Company <br/>Name</td>					
					<td width="15%" align="center">Vehicle Register No.</td>
                    <td width="10%" align="center">Registration Date</td>
                    <td width="10%" align="center">Vehicle Type</td>
                    <td width="10%" align="center">GVM Rating</td>
                    <td width="10%" align="center">D/T Rating</td>
                    <td width="10%" align="center">Rate (N$)</td>
                 </tr>
			<?php }else{?>
                        <tr class="listhead1">
                    <td width="5%" align="center">SI. No.</td>
                    <td width="15%" align="center">Vehicle LIC. No.</td>				
					<td width="15%" align="center">Vehicle Register No.</td>
                    <td width="10%" align="center">Registration Date</td>
                    <td width="10%" align="center">Vehicle Type</td>
                    <td width="10%" align="center">GVM Rating</td>
                    <td width="10%" align="center">D/T Rating</td>
                    <td width="10%" align="center">Rate (N$)</td>
                 </tr>
                <?php
               }
				if (count($vehiclereport) > 0) : ?>	
                    <?php
                    $i = 1;
                    foreach ($vehiclereport as $showvehiclereport) :
                        $sr = $i % 2 == 0 ? '' : '1';
                        ?>

                        <tr class="cont<?php echo $sr; ?>">
                            <td  width="5%" align="center"><?php echo ((($pagecounter - 1) * ($limit)) + $i); ?></td>
                           
                            <td  width="15%"><?php echo $showvehiclereport['VehicleDetail']['vc_vehicle_lic_no']; ?></td>
                           <?php   if (empty($nu_company_id)) {

						   ?>
							<td width="15%"><?php 
							//echo ucfirst($CompanyId[$nu_company_id]);
							echo wordwrap(ucfirst($CompanyId[$showvehiclereport['VehicleDetail']['nu_company_id']]), 30, "\n", true);
							 ?></td>
                            
                            <?php
							}?>
							<td width="15%"><?php echo $showvehiclereport['VehicleDetail']['vc_vehicle_reg_no']; ?></td>
                            
                            <?php
							
                            $createdDate = !empty($showvehiclereport['VehicleDetail']['dt_created_date']) ?
                                    date('d M Y', strtotime($showvehiclereport['VehicleDetail']['dt_created_date'])) :
                                    '';
                            ?>
                            <td width="10%" ><?php echo $createdDate; ?></td>
                            <td width="10%" ><?php echo $showvehiclereport['VEHICLETYPE']['vc_prtype_name']; ?></td>
                            <td width="10%" align="right">
                            <?php 
                          
                            echo $V_Rating = isset($showvehiclereport['VehicleDetail']['vc_v_rating'])?
                                    $this->Number->format($showvehiclereport['VehicleDetail']['vc_v_rating'], array(
                                    'places' => false,
                                    'before' => false,
                                    'escape' => false,
                                    'decimals' => false,
                                    'thousands' => ','
                                )) : '';
                         ?>  
                            </td>
                            <td  width="10%"  align="right"><?php
                        echo isset($showvehiclereport['VehicleDetail']['vc_dt_rating']) ?
                                $this->Number->format($showvehiclereport['VehicleDetail']['vc_dt_rating'], array(
                                    'places' => false,
                                    'before' => false,
                                    'escape' => false,
                                    'decimals' => false,
                                    'thousands' => ','
                                )) : '';
                        ?>
                            </td>
                            <td  width="10%"  align="right"><?php
                    // pr($showvehiclereport['VehicleDetail']['vc_vehicle_status']);
				if($showvehiclereport['VehicleDetail']['vc_vehicle_status']=='STSTY04'){
				
					 echo isset($showvehiclereport['VehicleDetail']['vc_rate']) ?
                                $this->Number->format($showvehiclereport['VehicleDetail']['vc_rate'], array(
                                    'places' => 2,
                                    'before' => false,
                                    'escape' => false,
                                    'decimals' => '.',
                                    'thousands' => ','
                                )) : 'N/A';
 
				}else{

					echo "N/A";
					}					 
				                       ?></td>
                        </tr>

                        <?php $i++;
                    endforeach; ?>
                <?php else : ?>
                    <?php if(empty($nu_company_id)) {?>
					<tr class="cont1" style='text-align:center;'>
                        <td colspan='9'> No Record Found </td>
                    </tr>				
				<?php }else{ ?>
					<tr class="cont1" style='text-align:center;'>
                        <td colspan='8'> No Record Found </td>
                    </tr>				
				<?php } ?>
                <?php endif; ?> 
            </table>


            <?php
            $this->Paginator->options(array(
                'url' => array(
                    'fromDate' => $SearchfromDate,
                    'todate' => $SearchtoDate,
                    'vehicletype' => $vehicletype,
                    'vehiclelicno' => $vehiclelicno,
                    'nu_company_id' => $nu_company_id
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
<!--popup end here-->	

</div>
<!-- end wrapper here-->

<?php echo $this->Html->script('mdc/vehicles-report'); ?>