<?php $currentUser = $this->Session->read('Auth'); ?>
<?php //pr($FuelOutList); die;     ?>
<?php //pr($claimslist); die;     ?>
<!-- Start wrapper here-->
<div class="wrapper">
    <!-- Start breadcrumb here-->
    <div class="breadcrumb">
        <ul>
            <li class="first">
                <?php echo $this->Html->link('Home', array('controller' => 'clients', 'action' => 'view', 'flr' => true), array('title' => 'Home', 'class' => 'vtip')) ?>
            </li>
            <li class="last">Manage Fuel Outlets</li>  <li class="last clientnoclass" style=""  >Client No.&nbsp;:&nbsp;<?php echo ltrim($this->Session->read('Auth.Client.vc_client_no'),'01');?></li>        
        </ul>
    </div>
    <!-- end breadcrumb here-->
    <!-- Start mainbody here-->
    <div class="mainbody">
        <h1>Welcome to RFA FLR</h1>
        <h3>Manage Fuel Outlets</h3>
        <!-- Start innerbody here-->
        <?php echo $this->Form->create('Client', array('url' => array('controller' => 'clients', 'action' => 'managefueloutlets', 'flr' => true))); ?>

        <div class="innerbody">
            <table width="40%" border="0" cellpadding="3">

                <?php if (count($this->data['ClientFuelOutlet']['fueloutlets']) > 0) : ?>

                    <?php foreach ($this->data['ClientFuelOutlet']['fueloutlets'] as $key => $value) : ?>

                        <tr>
                            <td width="75%" align="left" valign="top">
                                <div class='outletslist'>	
                                    <?php echo $this->Form->input("ClientFuelOutlet.fueloutlets.$key", array('div' => false, 'label' => false, 'id' => false, 'class' => 'round_select5', 'type' => 'select', 'default' => trim($value['vc_fuel_outlet']), 'options' => array('' => 'Select') + $flrFuelOutLet)) ?>
                                </div>
                                <?php
                                if (trim($value['vc_fuel_outlet']) != ''): unset($flrFuelOutLet[$value['vc_fuel_outlet']]);
                                endif;
                                ?>
                            </td>
                            <td width="25%" align="left" valign="top">
                                <div class="button-addmore" style="float:left;">
                                    <?php if ($key == ( count($this->data['ClientFuelOutlet']['fueloutlets']) - 1 )) { ?>
                                        <a id="add">
                                            <?php echo $this->Html->image('add-more.png', array('width' => "24", "style" => "cursor:pointer", 'height' => '24')); ?>

                                        </a>
                                    <?php } ?>
                                    <a id="remove" >
                                        <?php echo $this->Html->image('icon_error.png', array('width' => "19", "style" => "cursor:pointer", 'height' => '20')); ?>

                                    </a>
                                </div>
                            </td>
							<td></td>		<td></td>
                        </tr>
                    <?php endforeach; ?>

                <?php else : ?>

                    <tr>
                        <td width="10%" align="left" valign="top">

                            <div class='outletslist' >	
                                <?php echo $this->Form->input('ClientFuelOutlet.fueloutlets.0', array('div' => false, 'label' => false, 'id' => false, 'class' => 'round_select5', 'type' => 'select', 'default' => '','style'=>'margin:0px !important', 'options' => array('' => 'Select') + $flrFuelOutLet)) ?>
                            </div>

                        </td>
                        <td width="10%" align="left" valign="top">
                            <div class="button-addmore" style="float:left;">
                                <a id="add">
                                    <?php echo $this->Html->image('add-more.png', array('width' => "24", "style" => "cursor:pointer", 'height' => '24')); ?>

                                </a>
                                <a id="remove" >
                                    <?php echo $this->Html->image('icon_error.png', array('width' => "19", "style" => "cursor:pointer", 'height' => '20')); ?>

                                </a>
                            </div>
                        </td>
						<td width="5%">&nbsp;</td>
							<td width="5%"><?php //echo $this->Session->read('Auth.Client.vc_client_no');?></td>

				
                    </tr>

                <?php endif; ?>


            </table>
            <table  width="100%" border="0" cellpadding="3" >

                <tr>

                    <td   width='1%' colspan='3' align="right" valign="top">
                        <?php echo $this->Form->submit('Submit', array('div' => false, 'label' => false, 'type' => 'submit', 'class' => 'submit', 'value' => 'submit')); ?>
                    </td>
                    <td    width='60%'  colspan ='3' align="left" valign="top">
                        <?php echo $this->Form->submit('Reset', array('div' => false, 'label' => false, 'type' => 'reset', 'class' => 'submit', 'value' => 'Reset')); ?>
                    </td>

						<td width="25%" align="right" valign="top"><!--Client No.&nbsp;:--></td>
							<td width="10%" align="left" valign="top"><?php //echo $this->Session->read('Auth.Client.vc_client_no');?></td>

                </tr>

            </table>
            </table>
        </div>

        <div class="innerbody">
            <table width="100%" cellspacing="1" cellpadding="5" border="0">
                <tr class="listhead1">
                    <td width="" align="center">SI. No.</td>
                    <td width="" align="center">Fuel Outlet</td>
                    <td width="" align="center">Status</td>

                </tr>
                <?php
                if ($FuelOutList > 0) {
                    $i = 1;

                    foreach ($FuelOutList as $index => $outlet) {
                        ?>
                        <tr class="cont1">
                            <td align="center"><?php echo ((($pagecounter - 1) * ($limit)) + $i); ?></td>
                            <td align="left">
                                <?php echo $outlet['ClientFuelOutlet']['vc_fuel_outlet']; ?>
                            </td>

                            <td align="center">
                                <?php echo $globalParameterarray[$outlet['ClientFuelOutlet']['vc_status']]; ?>

                            </td>
                        </tr>
                        <?php
                        $i++;
                    }
                } else {
                    ?>

                    <tr class="cont1" style='text-align: center'>
                        <td colspan='3'> No Record Found  </td>
                    </tr>
                <?php } ?>

                <?php echo $this->element('paginationfooter'); ?>
            </table>
        </div>
        <!-- end mainbody here-->  
    </div>
    <!-- end mainbody here-->    
</div>
<!-- end wrapper here-->
<?php echo $this->Html->script('flr/managefueloutlets'); ?>
<?php echo $this->element('commonmessagepopup'); ?>
<?php echo $this->element('commonbackproceesing'); ?>
