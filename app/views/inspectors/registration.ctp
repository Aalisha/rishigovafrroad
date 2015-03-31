<!-- Start form-body here-->

<div class="form-body clearfix">

	<div class="form-body-heading">
		<div class="heading"> Inspector <?php echo strtoupper($selectedType);?> Registration  </div>  
	</div> 
	<!-- Start form-body-main here-->
	 
	<div class="form-body-main">
		
		<!-- Start form-body-mainbody here--> 
		
		<div class="form-body-mainbody">
		
			<?php echo $this->Form->create('Inspector',array('url' => array('controller' => 'inspectors', 'action' => 'registration',$selectedTypeID))); ?>
			
			<table width="100%" border="0">
				
				<tr>
					<td valign="top"><label class="lab-txt">FIRST NAME :</label></td>
					<td valign="top">
						<?php echo $this->Form->input( 'vc_user_firstname', array( 'label' =>false, 'required'=>'required', 'div'=>false, 'type' => 'text', 'id'=>'first_name' ,'class'=>'fiel')); ?>
					</td>	
				</tr>
				
				<tr>
					<td valign="top"><label class="lab-txt">LAST NAME :</label></td>
					<td valign="top">
						<?php echo $this->Form->input('vc_user_lastname', array( 'label' =>false, 'div'=>false, 'required'=>'required', 'type' => 'text', 'id'=>'last_name' , 'class'=>'fiel')); ?>
					</td>
				</tr>

				<tr>
					<td valign="top"><label class="lab-txt">EMAIL ID :</label></td>
					<td valign="top">
						<?php echo $this->Form->input('vc_email_id', array( 'label' =>false, 'required'=>'required','div'=>false, 'type' => 'text',  'id'=>'email' , 'class'=>'fiel')); ?>
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
																		'id'=>'vc_comp_code' ,
																		'required'=>'required',
																		'options'=>$FLA_TYPE ,																			
																		'default'=>$selectedTypeID ,
																		'class'=>'fiel'));
								
								
						
						?>
					</td>
				</tr>
				
				<tr>
					<td valign="top"><label class="lab-txt"></label></td>
					<td valign="top">
							<img id='captcha' alt="Captcha Code" src="<?php echo $this->Html->url(array('controller'=>'inspectors','action'=>'captcha_image'));?>" />
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
												'required'=>'required',												
												'id'=>'vc_captcha_code' ,
												'alt'=>' Enter Captcha Code',
												'class'=>'fiel')); ?>
					</td>
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
<?php echo $this->Html->script('inspector/inspector-registration'); ?>