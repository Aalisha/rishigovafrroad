<div class="wrapper">
    <!-- Start breadcrumb here-->
    <div class="breadcrumb">
        <ul>
            <li class="first">
                <?php echo $this->Html->link('Home',array('controller'=>'profiles','action'=>'index'),array('title'=>'Home', 'class'=>'vtip')) ?>
            </li>

            <li class="last">Customer Feedback Form</li>        
        </ul>
    </div>
    <!-- end breadcrumb here-->

    <!-- Start mainbody here-->
    <div class="mainbody">
        <h1>Welcome to RFA MDC</h1>
        <h3>Customer Detail </h3>
		<?php echo $this->Form->create(array('url' => array('controller' => 'inspectors', 'action' => 'feedbackform'))); ?>
        <!-- Start innerbody here-->
        <div class="innerbody">

			<table width="100%" border="0" cellpadding="3">
                <tr>
                    <td><label class="lab-inner">RFA Account No. :</label></td>
                    <td>
                        <?php
                        echo $this->Form->input('VehicleLogMaster.vc_customer_no', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'id' => 'vc_rfa_account_no',
                            'disabled' => 'disabled',
                            'class' => 'round'));
							
						 echo $this->Form->button('Add', array('label' => false,
                            'div' => false,
                            'type' => 'button',
							'id'=>'addshow',
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
                            'class' => 'round'));
                        ?>
                      
                    </td>

                </tr>
                <tr>
                    <td><label class="lab-inner">Address 1 :</label></td>
                    <td>
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
                    <td><label class="lab-inner">Address 2 :</label></td>
                    <td>
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
                    <td><label class="lab-inner">Address 3 :</label></td>
                    <td>
                        <?php
                        echo $this->Form->input('VehicleLogMaster.vc_address3', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'id' => 'vc_address3',
                            'disabled' => 'disabled',
                            'class' => 'round'));
                        ?>
                        <!--<input type="text" class="round" />-->
                    </td>
                </tr>
                <tr>

                    <td><label class="lab-inner">Telephone No. :</label></td>
                    <td>
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
                    <td><label class="lab-inner">Fax No. :</label></td>
                    <td>
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
                    <td><label class="lab-inner">Mobile No. :</label></td>
                    <td>
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
						'required'=>'required',
                        'disabled' => 'disabled',
                        'class' => 'round'));
                    ?>
                        <!--<input type="text" class="round" />-->
                    </td>

					
					<td>&nbsp;</td>
                    
					<td>&nbsp;</td>
                    
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    
					<td>&nbsp;</td>
					
					<td>&nbsp;</td>
                    
					<td>&nbsp;</td>
					
					<td>&nbsp;</td>
                    
					<td>&nbsp;</td>
					
                </tr>
            </table>

        </div>
        <!-- end innerbody here-->
        <h3>Vehicle Assessment Details</h3>
        <!-- Start innerbody here-->
        <div class="innerbody">
            <table width="98%" cellspacing="1" cellpadding="5" border="0" >
                <tr class="listhead">
                    <td width="20%">Assessment No.</td>
                    <td width="20%">From Date</td>
                    <td width="20%">To Date</td>
                    <td width="15%">Payable Amount</td>
                    <td width="10%">Status</td>
                    <td width="15%">Show Log </td>
                   
                </tr>
            </table>
            <div class="listsr1">
                <table width="100%" cellspacing="1" cellpadding="5" border="0" >
                    <tr class="cont1">

						<td valign="top" style='text-align:center;' colspan='8' width="100%">
							
							No Records Found
							
						</td>
						
                    </tr>
                   
                </table>
            </div>

	
        </div>
        <!-- end innerbody here-->    
		<?php echo $this->Form->end(null); ?>
    </div>
    <!-- end mainbody here--> 
	
	<div id="popDiv3" class="ontop">
		<div id="popup" class="popup3">
			<a href="javascript:void(0);" class="close" onClick="$('#popDiv3').css('display', 'none');">Close</a>            
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td align="left" class="content-area"><div class="listhead-popup">Insert Customer Name / RFA Account No.</div></td>
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
											
											<td width="50%" align="left">Customer Name</td>
											
											<td width="40%"> RFA Account No </td>
											
										</tr>	
										<?php if( ($users) > 0 ) : ?>
										
											<?php foreach ( $users as $key => $value ) :  $str = $key%2 == 0 ? '1' : ''; ?>
												
												<tr class="cont<?php echo $str?>">
													
													<td width="10%" align="center">
													   
													    <input type='radio' name='username' value='<?php echo trim($value['Profile']['vc_customer_no']); ?>' />
														
													
													</td>
													
													<td width="50%" align="left"><?php echo $value['Profile']['vc_customer_name']; ?></td>
													
													<td width="40%"><?php echo $value['Profile']['vc_customer_no']; ?></td>
													
												</tr>
											
											<?php endforeach; ?>
											
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
	<?php echo $this->element('commonmessagepopup'); ?>
	
	<?php echo $this->Html->script('inspector/getassessmentlist'); ?>