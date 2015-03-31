<?php $currentUser = $this->Session->read('Auth');?>
<!-- Start wrapper here-->
<div class="wrapper">
 <!-- Start breadcrumb here-->
    <div class="breadcrumb">
        <ul>
        <li class="first">
        <?php echo $this->Html->link('Home', array('controller' => 'customers', 'action' => 'view','cbc' =>true), array('title' => 'Home', 'class' => 'vtip')) ?>

        </li>
        
        <li class="last">Activation/Deactivation Card</li>   
        </ul>
   </div>
<!-- end breadcrumb here-->
<!-- Start mainbody here-->
    <div class="mainbody">
    <h1>Welcome to RFA CBC</h1>
    <h3>Prepaid Card Activation/Deactivation</h3>
    <!-- Start innerbody here-->
	<div class="innerbody">
    <table width="100%" border="0" cellpadding="3">
		<tr>
			<td align="right">
			<?php  
				if( count($card) > 0 ){
				$url = $this->Html->url(array('controller' => 'cards', 'action' => 'card_list_pdf','cbc' => true));
				echo $this->Form->submit('Print Card List', array(
                            'label' => false,
                            'type' => 'button',
							'onclick'=>'window.location="'.$url.'"',
                            'div' => false,
                            'class' => 'submit',
							)); 
				}			
				?>
			</td>
		</tr>
	</table>

	
	<table width="100%" border="0" cellpadding="3">
		<tr>
			<td><label class="lab-inner">Customer Name :</label></td>
			<td>
				<?php echo $this->Form->input('Customer.vc_customer_name', array('label' =>false,
																		'div'=>false, 
																		'type' => 'text',
																		'value'=> $currentUser['Customer']['vc_first_name'] . ' ' . $currentUser['Customer']['vc_surname'],
																		'disabled' => 'disabled',
																		'class'=>'round')); 
				?>
			</td>
			<td><label class="lab-inner">Address 1 :</label></td>
			<td>
				<?php echo $this->Form->input('Customer.vc_address1', array('label' =>false,
                                                                   'div'=>false, 
                                                                   'type' => 'text',
																   'value'=>$currentUser['Customer']['vc_address1'],
																   'disabled' => 'disabled',
                                                                   'class'=>'round')); 
				?>
			</td>
			<td><label class="lab-inner">Address 2 :</label></td>
			<td>
				<?php echo $this->Form->input('Customer.vc_address2', array('label' =>false,
                                                                   'div'=>false, 
                                                                   'type' => 'text',
																   'value'=>$currentUser['Customer']['vc_address2'],
																   'disabled' => 'disabled',
                                                                   'class'=>'round')); 
																   
				?>
			</td>
		</tr>
        <tr>
			<td><label class="lab-inner">Address 3 :</label></td>
			<td>
				<?php echo $this->Form->input('Customer.vc_address3', array('label' =>false,
                                                                   'div'=>false, 
                                                                   'type' => 'text',
																   'value'=>$currentUser['Customer']['vc_address3'],
																   'disabled' => 'disabled',
                                                                   'class'=>'round')); 
																   
				?>
			</td>
			<td><label class="lab-inner">Telephone No. :</label></td>
			<td>
				<?php echo $this->Form->input('Customer.vc_tel_no', array('label' =>false,
                                                                 'div'=>false, 
																 'type' => 'text',
																 'value'=>$currentUser['Customer']['vc_tel_no'],
																 'disabled' => 'disabled',
																 'class'=>'round')); 
				?>
			</td>
			<td><label class="lab-inner">Fax No. :</label></td>
			<td>
				<?php echo $this->Form->input('Customer.vc_fax_no', array('label' =>false,
                                                                 'div'=>false, 
                                                                 'type' => 'text',
																 'value'=>$currentUser['Customer']['vc_fax_no'],
																 'disabled' => 'disabled',
                                                                 'class'=>'round')); 
				?>
			</td>
		</tr>
        <tr>
            <td><label class="lab-inner">Mobile No. :</label></td>
            <td>
				<?php echo $this->Form->input('Customer.vc_mobile_no', array('label' =>false,
                                                                    'div'=>false, 
                                                                    'type' => 'text',
																	'value'=>$currentUser['Customer']['vc_mobile_no'],
																	'disabled' => 'disabled',
                                                                    'class'=>'round')); 
				?>
			</td>
            <td><label class="lab-inner">Email :</label></td>
            <td>
				<?php echo $this->Form->input('Customer.vc_email', array('label' =>false,
                                                                   'div'=>false, 
                                                                   'type' => 'text',
																   'value'=>$currentUser['Customer']['vc_email'],
																   'disabled' => 'disabled',
                                                                   'class'=>'round')); 
				?>
			</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td><label class="lab-inner">Total Card Issued :</label></td>
			<td>
				<?php echo $this->Form->input('vc_total_card_issued', array('label' =>false,
																			'div'=>false, 
																			'type' => 'text',
																			'value'=>number_format($total_cards),
																			'disabled' => 'disabled',
																			'class'=>'round number-right')); 
				?>
			</td>
            <td><label class="lab-inne1">Inactive Card :</label></td>
            <td>
				<?php echo $this->Form->input('vc_inactive_card', array('label'=>false,
																		'div' => false,
																		'type' => 'text',
																		'value' => number_format($inactive_cards),
																		'disabled' => 'disabled',
																		'class'=>'round number-right'
																		));
				?>

			</td>
            <td><label class="lab-inner">Active Card :</label></td>
            <td>
				<?php echo $this->Form->input('vc_inactive_card', array('label'=>false,
																		'div' => false,
																		'type' => 'text',
																		'value' => number_format($active_cards),
																		'disabled' => 'disabled',
																		'class'=>'round number-right'
																		));
				?>
			</td>
        </tr>
    </table>
		<br />
		
	<?php echo $this->Form->create(array('url' => array('controller' => 'cards', 'action' => 'cbc_activationdeactivation','cbc' => true),'type'=>'file')); ?>
		
	<table width="100%" cellspacing="1" cellpadding="5" border="0" >
		<tr class="listhead1">
			<td width="20%" align="center">Card No.</td>
			<td width="20%" align="center">Issue Date</td>
			<td width="20%" align="center">Current Status</td>
			<td width="20%" align="center">Requested</td>
			<td width="20%" align="center">Reason</td>
		</tr>
		
			
			<?php 
			
				if( count($card) > 0 ){
			
				foreach( $card as $key => $val ) { 
						
						$str = $key % 2 == 0 ? '' : '1';
						
					
			?>
		
				<tr class="cont<?php echo $str; ?>" align="left">

				<td align="right">
					<?php 
						echo wordwrap($val['ActivationDeactivationCard']['vc_card_no'], 16, "<br>\n", true);
					?>
				</td>
				<td align="left">
					<?php echo !empty($val['ActivationDeactivationCard']['dt_issue_date']) ?
														  date('d-M-Y', strtotime($val['ActivationDeactivationCard']['dt_issue_date'])):
														  '';
					?>
				</td>
				<td align="left">
					<?php
						
						echo $globalParameterarray[$val['ActivationDeactivationCard']['vc_card_flag']];
						 
						echo $this->Form->input('Card.'.$key.'.vc_card_no', array('label' =>false,
																	   'div'=>false, 
																	   'type' => 'hidden',
																	   'value'=>$val['ActivationDeactivationCard']['vc_card_no'],
																	   'readonly' => 'readonly',
																	   'class'=>'round')); 
					?>
				</td>
				<td align="left">
					<?php	if($val['ActivationDeactivationCard']['vc_card_flag'] == 'STSTY01' ){
	
								echo $this->Form->input('Card.'.$key.'.vc_card_flag', array('label' => false, 
																		  'div' => false, 
																		  'type' => 'select',
																		  'options' =>array(''=>'Select','STSTY02'=>'Deactivate'),
																		  'class' => 'round_select'));
							}
							
							elseif ($val['ActivationDeactivationCard']['vc_card_flag']=='STSTY02'){
							
								echo $this->Form->input('Card.'.$key.'.vc_card_flag', array('label' => false, 
																		  'div' => false, 
																		  'type' => 'select',
																		   'options' =>array(''=>'Select','STSTY01'=>'Active'),
																		  'class' => 'round_select'));
							}
					?>
					</td>
					<td align="center" valign='top'>
						<?php	
							if($val['ActivationDeactivationCard']['vc_card_flag'] == 'STSTY01' ){
						
								echo $this->Form->input('Card.'.$key.'.vc_reason', array('label' => false,
																			'div' => false,
																			'rows'=>"1",
																			'class'=>"remarks",
																			'cols'=>"19",
																			'maxlength'	=>'250',																		
																			'type'=>'textarea'));
									
							}		
						if($val['ActivationDeactivationCard']['vc_card_flag'] == 'STSTY05' ){	
						echo $val['ActivationDeactivationCard']['vc_remarks'];
						}						
						?>
					</td>
				</tr>
		
			<?php
				
				}
			                   
			} else {
			
			?>
			<tr> <td colspan='5' align="center" > No record found !!</td> </tr>
				<?php } ?>
	</table>
	
	 <!-- end innerbody here-->       
     <?php if( count($card) > 0 ) { ?>    
	 
    <table width="100%" border="0">
		<tr>
			<td align="center">
				<?php echo $this->Form->submit('Submit',array('type'=>'submit','class'=>'submit','value'=>'submit','name'=>'data[submitbtn]')); ?>
			</td>
		</tr>
	
	</table>
				
	<?php 
		}
		echo $this->Form->end();

	?>		
	
    </div>
    	
    </div>
     <!-- end mainbody here-->    
</div>
<!-- end wrapper here-->
		<?php	echo $this->element('cbc/commonmessagepopup'); ?>

		<?php 
			if( count($card) > 0 ) {
		
				echo $this->element('cbc/paginationfooter'); 
			}
		?>
		<?php echo $this->Html->script('cbc/activationdeactivationcard'); ?>