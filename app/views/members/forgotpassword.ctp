<!-- Start form-body here-->

<div class="form-body clearfix">

	<div class="form-body-heading">
		<div class="heading"><?php echo strtoupper($selectedType);?> Forgot Password</div>  
	</div> 
	<!-- Start form-body-main here-->
	 
	<div class="form-body-main">
		
		<!-- Start form-body-mainbody here--> 
		
		<div class="form-body-mainbody">
		
			<?php echo $this->Form->create('Member', array('url' => array('controller' => 'members', 'action' => 'forgotpassword',$selectedTypeID))); ?>
			
			<table width="100%" border="0">
				
				<tr>
					<td valign="top"><label class="lab-txt"> EMAIL ID :</label></td>
					<td valign="top">
						<?php echo $this->Form->input('vc_email_id_frgt', array( 'label' =>false, 'div'=>false, 'type' => 'text','maxlength' => 50,  'id'=>'email' , 'class'=>'fiel')); ?>
					</td>
				</tr>
				
				<tr>
					<td valign="top"><label class="lab-txt">Type :</label></td>
					<td valign="top">
						<?php  
								
									echo $this->Form->input('vc_comp_code', array(
																			'label' =>false, 
																			'div'=>false,
																			'type' => 'select',
																			'id'=>'account_type' ,
																			'options'=>$FLA_TYPE ,																			
																			'default'=>$selectedTypeID ,
																			'class'=>'fiel'));
								
								
						
						?>
					</td>
				</tr>
				
				<tr>
					<td>&nbsp;</td>
					<td>
					<?php echo $this->Form->submit(NULL, array( 'label' =>false, 'div'=>false, 'id'=>'Login','name'=>'forgot', 'value'=>'Login', 'class'=>'submit')); ?>
					</td>
				</tr>
				
		</table>
		
		<?php echo $this->Form->end(); ?>

		</div>  
		
		<!-- end form-body-mainbody here-->  
	
	</div>  

	<!-- end form-body-main here-->     
             
</div>  

<!-- end form-body here-->  
<?php echo $this->Html->script('forgotpassword'); ?>