<?php $profile = $this->Session->read('Auth'); ?>
<?php $rowCount = count($vehiclereport); ?>
<!-- Start wrapper here-->
<div class="wrapper">
    <!-- Start breadcrumb here-->
    <div class="breadcrumb">
        <ul>
            <li class="first">
                <?php echo $this->Html->link('Home', array('controller' => 'profiles', 'action' => 'index'), array('title' => 'Home', 'class' => 'vtip')) ?>
            </li>
            <li class="last">Report Vehicle List</li>        
        </ul>
    </div>
    <!-- end breadcrumb here-->
    <!-- Start mainbody here-->
    <div class="mainbody">
        <h1><?php echo $mdclocal;?></h1>
        <h3>Customer Vehicle History Report</h3>
        <?php echo $this->Session->flash(); ?>
        <!-- Start innerbody here-->


        <div class="innerbody">
         <?php echo $this->Form->create('Inspector',array('url' => array('controller' => 'inspectors', 'action' => 'vehiclelist'))); ?>
              <table width="100%" border="0" cellpadding="3">
                <tr>
                    <td width="13%"><label class="lab-inner">From Date :</label></td>
                    <td width="20%">
                        <?php
                        echo $this->Form->input('fromdate', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'id' => 'fromDate',
                            'required' => 'required',
                            'class' => ' dateseclect round2'));
                        ?>
                    </td>
                    <td width="13%"><label class="lab-inner">To Date :</label></td>
                    <td width="15%"><?php
                        echo $this->Form->input('todate', array(
                            'label' => false,
                            'div' => false,
                            'id' => 'toDate',
                            'type' => 'text',
                            'required' => 'required',
                            'class' => 'dateseclect round2'));
                        ?>
                    </td>
                    <td width="17%"><span class="valuetext">Customer Name</span></td>
                    <td width="18%">
                        <?php
                        echo $this->Form->input('vc_customer_name', array(
                            'label' => false,
                            'div' => false,
                            'type' => 'text',
                            'id' => 'vc_customer_name',
                            'maxlength'=>100,
                            'class' => 'round2'));
                        
                        ?>
                  </td>
                  <td width="15%" align="center">
                       <?php echo $this->Form->submit('Submit', array('class' => 'submit')); ?>
                   </td>
                </tr>      
            </table>
            <?php echo $this->Form->end(null); ?>
        </div>
        <div id='ajaxdata' class="innerbody">

            <table width="100%" border="0" cellpadding="3" class ="customersInfo" style="">
                <tr>
                    <td width="10%"><label class="lab-inner">Customer Name :</label></td>
                    <td width="10%"><span class="valuetext"><?php echo $profile['Profile']['vc_customer_name']; ?></span></td>
                    <td width="10%"><label class="lab-inner">From Date :</label></td>
                    <td width="10%">
                        <span class="valuetext">
                            <?php $rowCount = count($vehiclereport); 
                            $fromDate = (!empty($vehiclereport[$rowCount - 1]['VehicleDetail']['dt_created_date'])) ? $vehiclereport[$rowCount - 1]['VehicleDetail']['dt_created_date']:'';
                            $toDate = (!empty($vehiclereport[0]['VehicleDetail']['dt_created_date'])) ? $vehiclereport[0]['VehicleDetail']['dt_created_date'] :'';
                            
                         ?>
                            <?php echo date('d M Y', strtotime($fromDate)); ?>  
                        </span>
                    </td>
                    <td width="10%"><label class="lab-inner">To Date :</label></td>
                    <td width="10%"><span class="valuetext"><?php echo date('d M Y', strtotime($toDate)); ?></span></td>
                    <td width="10%"  align="right">
                    <?php
                            echo $this->Html->link('Print Report', array('controller' => 'inspectors', 'action' => 'vehiclelistpdf'), array('class' => 'textbutton1'))
                    ?>
                    </td>
                </tr>
            </table>
            <br />

            <table width="100%" cellspacing="1" cellpadding="5" border="0" >

                <tr class="listhead1">
                    <td width="6%" align="center">S. No.</td>
                    <td width="17%">Vehicle LIC. No.</td>
                    <td width="17%">Vehicle Reg. No.</td>
                    <td width="15%">Vehicle Type</td>
                    <td width="15%">V Rating</td>
                    <td width="15%">D/T Rating</td>
                    <td width="15%">Rate</td>
                </tr>

                <?php if (count($vehiclereport) > 0) : ?>	
                    <?php $i = 1;
                    foreach ($vehiclereport as $showvehiclereport) : $sr = $i % 2 == 0 ? '' : '1'; ?>

                        <tr class="<?php echo $sr; ?>">
                            <td align="center"><?php echo $i; ?></td>
                            <td><?php echo $showvehiclereport['VehicleDetail']['vc_vehicle_lic_no']; ?></td>
                            <td><?php echo $showvehiclereport['VehicleDetail']['vc_registration_no']; ?></td>
                            <td><?php echo $showvehiclereport['VEHICLETYPE']['vc_prtype_name']; ?></td>
                            <td>
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
                            <td>
                                
                                <?php
                                $DT_Rating = isset($showvehiclereport['VehicleDetail']['vc_dt_rating']) ? 
                                $this->Number->format($showvehiclereport['VehicleDetail']['vc_dt_rating'], array(
                                'places' => false,
                                'before' => false,
                                'escape' => false,
                                'decimals' => false,
                                'thousands' => ','
                                )):'';

                                echo $DT_Rating; 
                               ?>
                                
                               
                            </td>
                            <td align="right">
                                <?php echo $showvehiclereport['VehicleDetail']['vc_rate']; ?>
                                
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
                    endforeach; ?>
                <?php else : ?>
                    <tr class="cont1" style='text-align: center'>
                        <td colspan='7'> No Record Found </td>
                    </tr>
                <?php endif; ?> 
            </table>

            <?php echo $this->element('paginationfooter'); ?>
        </div>



        <!-- end innerbody here-->

    </div>
    <!-- end mainbody here-->    
</div>
<!-- end wrapper here-->

<?php echo $this->Html->script('inspector/reports'); ?>