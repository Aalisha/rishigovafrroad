<!-- Start form-body here-->

<div class="form-body clearfix">

	<div class="form-body-heading">
		<div class="heading"><?php echo strtoupper($selectedType);?> Login  </div>  
	</div> 
	<!-- Start form-body-main here-->
	 
	<div class="form-body-main">
		
		<!-- Start form-body-mainbody here--> 
		
		<div class="form-body-mainbody">
		
			<?php echo $this->Form->create('Member', array('url' => array('controller' => 'members', 'action' => 'login',$selectedTypeID))); ?>
			
			<table width="100%" border="0">
				
				<tr>
					<td valign="top"><label class="lab-txt">Username :</label></td>
					<td valign="top">
						<?php echo $this->Form->input('vc_username', array( 'label' =>false, 'div'=>false, 'type' => 'text', 	'id'=>'vc_username' ,'maxlength' => 30,'class'=>'fiel')); ?>
					</td>	
				</tr>
				
				<tr>
					<td valign="top"><label class="lab-txt">Password :</label></td>
					<td valign="top">
						<?php echo $this->Form->input('vc_password', array( 'label' =>false, 'div'=>false, 'type' => 'password', 'id'=>'vc_password' ,'maxlength' => 50, 'class'=>'fiel')); ?>
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
					<td valign="top"><label class="lab-txt"></label></td>
					<td valign="top">
							<img id='captcha' alt="Captcha Code" src="<?php echo $this->Html->url(array('controller'=>'members','action'=>'captcha_image'));?>" />
							<a id='reset' href="javascript:void(0);" >Reset</a>
					</td>
				</tr>
				
				<tr>
					<td valign="top"><label class="lab-txt">Enter Code :</label></td>
					<td valign="top">
						<?php 
						 echo $this->Form->input('vc_captcha_code', 
										array( 'label' =>false,
												'div'=>false, 
												'type' => 'text', 
												'id'=>'vc_captcha_code' ,
												'alt'=>' Enter Captcha Code',
												'class'=>'fiel')); ?>
					</td>
				</tr>

				<tr>                     
					<td>&nbsp;</td>
					<td><?php echo $this->Html->link(' Forgot Password ? ', array('controller'=>'members', 'action'=>'forgotpassword', $selectedTypeID)); ?></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td><?php echo $this->Html->link(' New User ? Register Now ! ', array('controller'=>'members', 'action'=>'registration', $selectedTypeID)); ?></td>
			</tr>
				
				
				<tr>
					<td>&nbsp;</td>
					<td>
					<?php echo $this->Form->submit(NULL, array( 'label' =>false, 'div'=>false, 'id'=>'Login', 'value'=>'Login', 'class'=>'submit')); ?>
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

<?php echo $this->Html->script('login'); ?>