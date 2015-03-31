<div class="wrapper">
    <!-- Start breadcrumb here-->
    <div class="breadcrumb">
        <ul>
            <li class="first">
                <?php echo $this->Html->link('Home', array('controller' => 'inspectors', 'action' => 'index'), array('title' => 'Home', 'class' => 'vtip')) ?>
            </li>

            <li class="last">Customer Payment Detail</li>        
        </ul>
    </div>
    <!-- end breadcrumb here-->
<?php echo $this->Form->create(array('type'=>'file', 'name' => 'insp')); ?>
    <!-- Start mainbody here-->
    <div class="mainbody" style='width:93% !important;'>
        <h1><?php echo $mdclocal;?></h1>
        <h3>Customer Detail </h3>
       
       
		
        <!-- Start innerbody here-->
        <div class="innerbody">

            <table width="100%" border="0" cellpadding="3">
                 
				 <tr>
                    <td valign='top'  ><label class="lab-inner">Vehicle Lic. No. :</label></td>
                    <td valign='top'>
                        
						<?php
                     
						echo $this->Form->input('VehicleLogMaster.vc_vehicle_lic_no', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'id' => 'vc_vehicle_lic_no',
							'readonly'=>'readonly',
							'style'=>'width:90px;',
                            'required' => 'required',
                            'class' => 'round_select')
                        );
						   echo $this->Form->button('Find', array('label' => false,
                            'div' => false,
                            'type' => 'button',
							'style'=>'marhin-left:20px;',
                            'id' => 'addshow',
							'class' => 'round '));
						
                        ?>

                    </td>

                    <td valign='top' nowrap="nowrap" ><label class="lab-inner">Vehicle Register No. :</label></td>
                    <td valign='top'>
                        <?php
						
						
                        echo $this->Form->input('VehicleLogMaster.vc_vehicle_reg_no', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'id' => 'vc_vehicle_reg_no',
							'style'=>'width:90px;',
                            'required' => 'required',
							'readonly'=>'readonly',
                            'class' => 'round_select')
                        );
						echo $this->Form->button('Find', array('label' => false,
                            'div' => false,
                            'type' => 'button',
							'style'=>'marhin-left:20px;',
                            'id' => 'addshow',
							'class' => 'round '));
                        ?>

                    </td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
                </tr>
				<tr>
                    <td valign='top'><label class="lab-inner">RFA Account No. :</label></td>
                    <td valign='top'>
                        <?php
						echo $this->Form->input('VehicleLogMaster.vc_customer_no', array('label' => false,
                            'div' => false,
                            'type' => 'text',
							'readonly'=>'readonly',
                            'id' => 'vc_rfa_account_no',
							'disabled' => 'disabled',
							'class' => 'round'));

                        
                        ?>

                    </td>
                    <td valign='top'><label class="lab-inner">Customer Id</label></td>
                    <td valign='top' >
                        <?php
                        echo $this->Form->input('VehicleLogMaster.vc_customer_id', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'id' => 'vc_customer_id',
                            'disabled' => 'disabled',
                            'class' => 'round'));
                        ?>

                    </td>
                    <td valign='top' ><label class="lab-inner">Customer Name :</label></td>
                    <td valign='top' >
                        <?php
                        echo $this->Form->input('VehicleLogMaster.vc_customer_name', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'id' => 'vc_customer_name',
                            'disabled' => 'disabled',
                            'class' => 'round'));
                        ?>

                    </td>

                </tr>
                <tr>
                    <td valign='top' ><label class="lab-inner">Street Name :</label></td>
                    <td valign='top' >
                        <?php
                        echo $this->Form->input('VehicleLogMaster.vc_address1', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'id' => 'vc_address1',
                            'disabled' => 'disabled',
                            'class' => 'round'));
                        ?>
                        <!--<input type="text" class="round" />-->
                    </td>
                    <td valign='top' ><label class="lab-inner">House No. :</label></td>
                    <td valign='top' >
                        <?php
                        echo $this->Form->input('VehicleLogMaster.vc_address2', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'id' => 'vc_address2',
                            'disabled' => 'disabled',
                            'class' => 'round'));
                        ?>
                        <!--<input type="text" class="round" />-->
                    </td>
                    <td valign='top' ><label class="lab-inner">P.O .Box :</label></td>
                    <td valign='top' >
                        <?php
                        echo $this->Form->input('VehicleLogMaster.vc_po_box', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'id' => 'vc_po_box',
                            'disabled' => 'disabled',
                            'class' => 'round'));
                        ?>
                        <!--<input type="text" class="round" />-->
                    </td>
                </tr>
                <tr>
					<td><label class="lab-inner">Town/City :</label></td>
					<td>
					<?php
						echo $this->Form->input('VehicleLogMaster.vc_town', array('label' => false,
							'div' => false,
							'type' => 'text',
							'id' => 'vc_town',
							'disabled' => 'disabled',
						   
							'class' => 'round'));
						?>
					</td>
                    <td valign='top' ><label class="lab-inner">Telephone No. :</label></td>
                    <td valign='top' >
                        <?php
                        echo $this->Form->input('VehicleLogMaster.vc_tel_no', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'id' => 'vc_tel_no',
                            'disabled' => 'disabled',
                            'class' => 'round'));
                        ?>
                        <!--<input type="text" class="round" />-->
                    </td>
                    <td valign='top' ><label class="lab-inner">Fax No. :</label></td>
                    <td valign='top' >
                        <?php
                        echo $this->Form->input('VehicleLogMaster.vc_fax_no', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'id' => 'vc_fax_no',
                            'disabled' => 'disabled',
                            'class' => 'round'));
                        ?>
                        <!--<input type="text" class="round" />-->
                    </td>
                    
                </tr>
                <tr>
				<td valign='top' ><label class="lab-inner">Mobile No. :</label></td>
                    <td valign='top' >
                        <?php
                        echo $this->Form->input('VehicleLogMaster.vc_mobile_no', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'id' => 'vc_mobile_no',
                            'disabled' => 'disabled',
                            'class' => 'round'));
                        ?>
                        <!--<input type="text" class="round" />-->
                    </td>

                    <td valign='top' ><label class="lab-inner">Email :</label></td>
                    <td valign='top' >
                        <?php
                        echo $this->Form->input('VehicleLogMaster.vc_email_id', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'id' => 'vc_email_id',
                            'disabled' => 'disabled',
                            'class' => 'round'));
                        ?>
                        <!--<input type="text" class="round" />-->
                    </td>
                    <td valign='top' ><label class="lab-inner">Pay Frequency :</label></td>
                    <td valign='top' >
                        <?php
                        echo $this->Form->input('VehicleLogMaster.vc_pay_frequency', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'readonly' => 'readonly',
                            'class' => 'round disabled-field'));
                        ?>
                        <!--<input type="text" class="round" />-->
                    </td>
                   

                </tr>
				<tr>
				 <td valign='top' ><label class="lab-inner">Customer Type :</label></td>
                    <td valign='top' colspan='5' >
                        <?php
                        echo $this->Form->input('vc_cust_type', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'id' => 'vc_cust_type',
                           'disabled' => 'disabled',
                            'class' => 'round'));
                        ?>
                        <!--<input type="text" class="round" />-->
                    </td>
					
					</tr>
                
            </table>

        </div>
        <!-- end innerbody here-->
        <h3>Customer Payment Detail </h3>
        <!-- Start innerbody here-->
        <div class="innerbody  listsr1"  style='overflow-y: visible !important;' >
            <table width="100%" cellspacing="1" cellpadding="5" border="0" >
               <thead> 
					<tr class="listhead ">
						<td width="8%">SI No.</td>
						<td width="8%" >Assessment No.</td>
						<td width="8%" >Last Assessment</td>
						<td width="10%" >Payable Amount(N$</td>
						<td width="10%" >Paid Amount(N$)</td>
						<td width="10%" >Outstanding Amount(N$)</td>
						<td width="8%" >Log Date</td>
						<td width="8%" >Assessment date</td>
						<td width="10%">Total Payable Amount </td>
						<td width="10%" >Total Paid Amount</td>
						<td width="10%" >Total Outstanding</td>
					</tr>
				</thead>
				
				<tbody>
								
					<tr class="cont1">

						<td valign="top" style='text-align:center;' colspan='12' width="100%">

							Please Select Vehicle License No. / Registration No.

						</td>

					</tr>
				
				</tbody>
				
				
			</table>	
           
        </div>
        
		 <table width="100%" border="0">
                <tr>
                    <td align="center">

                        <?php
                      /*  echo $this->Form->button('Add', array('label' => false,
                            'div' => false,
                            'id' => 'addrow',
                            'type' => 'button',
                            'class' => 'submit')); */
                        ?>

                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <?php
                       /*  echo $this->Form->button('Remove', array('label' => false,
                            'div' => false,
                            'id' => 'rmrow',
                            'type' => 'button',
                            'class' => 'submit')); */
                        ?>

                        &nbsp;&nbsp;&nbsp;&nbsp;			
                        <?php
                        /* echo $this->Form->button('Submit', array('label' => false,
                            'div' => false,
                            'id' => 'submit',
                            'type' => 'submit',
                            'class' => 'submit'));*/
                        ?>			
                    </td>

                </tr>
            </table>
		<!-- end innerbody here-->    
        
    </div>
	<?php echo $this->Form->end(null); ?>
    <!-- end mainbody here--> 

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
                                            
											<?php if ( count($vehicleList) > 0) : ?>

                                                <?php 
														$i = 0;
														
														foreach ($vehicleList as $key => $value) : 
														
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

</div>
	
<?php echo $this->element('commonmessagepopup'); ?>

<?php echo $this->element('commonbackproceesing'); ?>

<?php echo $this->Html->script('inspector/natis-viewdetail'); ?>
<script type = "text/javascript">

function callaction(num){
	//alert(num);
	if(num == 'payproof'){
		
		$('form').get(0).setAttribute('action', 'downloadPayProof'); //this works
		
		$('#InspectorViewvehicledetailForm').submit();
	
	}else if(num == 'statement'){
		
		$('form').get(0).setAttribute('action', 'downloadPaymentReceipt'); //this works
		
		$('#InspectorViewvehicledetailForm').submit();
	
	}

}

</script>
