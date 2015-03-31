<!-- Start form-body here-->

<div class="form-body clearfix">

	<div class="form-body-heading">
		<div class="heading"> Admin Login  </div>  
	</div> 
	<!-- Start form-body-main here-->
	 
	<div class="form-body-main">
		
		<!-- Start form-body-mainbody here--> 
		
		<div class="form-body-mainbody">
		
			<?php echo $this->Form->create('AccessLogin', array('url' => array('controller' => 'erpimports', 'action' => 'index'))); ?>
			
			<table width="100%" border="0">
				
				<tr>
					<td valign="top"><label class="lab-txt">Username :</label></td>
					<td valign="top">
						<?php echo $this->Form->input('username', array( 'label' =>false, 'div'=>false, 'type' => 'text','maxlength' => 30,'class'=>'fiel')); ?>
					</td>	
				</tr>
				
				<tr>
					<td valign="top"><label class="lab-txt">Password :</label></td>
					<td valign="top">
						<?php echo $this->Form->input('password', array( 'label' =>false, 'div'=>false, 'type' => 'password', 'maxlength' => 50, 'class'=>'fiel')); ?>
					</td>
				</tr>
								
				<tr>
					<td>&nbsp;</td>
					<td>
					<?php echo $this->Form->submit('Login', array( 'label' =>false, 'div'=>false, 'value'=>'Login', 'class'=>'submit')); ?>
					</td>
				</tr>
				
		</table>
		
		<?php echo $this->Form->end(null); ?>

		</div>  
		
		<!-- end form-body-mainbody here-->  
	
	</div>  

	<!-- end form-body-main here-->     
             
</div>  

<!-- end form-body here-->