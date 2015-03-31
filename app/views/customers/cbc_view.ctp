<?php $currentUser = $this->Session->read('Auth');?>
<!-- Start wrapper here-->
<div class="wrapper">

 <!-- Start breadcrumb here-->
 
 <div class="breadcrumb">
 
    <ul>
			<li class="first">

				<?php echo $this->Html->link('Home', array('controller' => 'customers', 'action' => 'view','cbc'=>true), array('title' => 'Home', 'class' => 'vtip')) ?>

			</li>
		
			<li class="last">View Profile</li> 

		
		
    </ul>
</div>
<!-- end breadcrumb here-->

<!-- Start mainbody here-->

    <div class="mainbody">
    <h1>Welcome to RFA CBC</h1>
    <h3>Customer Identification</h3>
    <!-- Start innerbody here-->
    <div class="innerbody">
    <table width="100%" border="0" cellpadding="3">
		<tr>
	  
        <td><label class="lab-inner">Company Name :</label></td>
        <td>
					<?php echo $this->Form->input( 'Customer.vc_company', array('label'=>false,'disabled'=> 'disabled','type' => 'text','class'=>'round','value'=>trim($currentUser['Customer']['vc_company']))); ?>
		</td>
		
		
        <td><label class="lab-inner">First Name :</label></td>
        <td>
					<?php echo $this->Form->input( 'Customer.vc_first_name', array('label'=>false,'disabled'=> 'disabled','type' => 'text', 'class'=>'round','value'=>trim($currentUser['Customer']['vc_first_name']))); ?>
					
		</td>
		
		
        <td><label class="lab-inner">Surname :</label></td>
        <td>
		
			<?php echo $this->Form->input( 'Customer.vc_surname', array('label'=>false,'disabled'=> 'disabled','type' => 'text', 'id'=>'' ,'class'=>'round','value'=>trim($currentUser['Customer']['vc_surname']))); ?>
		
		</td>
		</tr>
	  
		<tr>
	  
        <td><label class="lab-inner">Contact Person :</label></td>
		<td>
	   	<?php echo $this->Form->input( 'Customer.vc_cont_per', array('label'=>false,'value'=>trim($currentUser['Customer']['vc_cont_per']),'disabled'=> 'disabled','type' => 'text','class'=>'round')); ?>
	   
		</td>
	   
        <td><label class="lab-inner">Account Status :</label></td>
        <td><span class="valuetext"><?php echo trim($globalParameterarray[$currentUser['Customer']['ch_active']]);?></span></td>
        <td><label class="lab-inner">Download Doc. :</label></td>
        <td>
			<?php
                    $url = $this->webroot . 'cbc/customers/download';

                    echo $this->Form->button('Click Here ', array('label' => false,
                        'div' => false,
                        'type' => 'button',
                        'onclick' => "javascript:window.location='$url'",
                        'class' => 'round')
                    );
			?>
		</td>
		</tr>
		
    </table>

    </div>
	
     <!-- end innerbody here--> 
	 
     <h3>Customer Communication</h3>
    
	<!-- Start innerbody here-->
    
	<div class="innerbody">
    
	<table width="100%" border="0" cellpadding="3">
		<tr>
        <td><label class="lab-inner">Address 1 :</label></td>
        <td>
		
					<?php echo $this->Form->input( 'Customer.vc_address1', array('label'=>false,'value'=>trim($currentUser['Customer']['vc_address1']),'disabled'=> 'disabled','type' => 'text','class'=>'round')); ?>
		
		</td>
		
        <td><label class="lab-inner">Address 2 :</label></td>
        <td>
		
					<?php echo $this->Form->input( 'Customer.vc_address2', array('label'=>false,'value'=>trim($currentUser['Customer']['vc_address2']),'disabled'=> 'disabled','type' => 'text', 'class'=>'round')); ?>
					
		</td>
		
        <td><label class="lab-inner">Address 3 :</label></td>
        <td>
		
					<?php echo $this->Form->input( 'Customer.vc_address3', array('label'=>false,'value'=>trim($currentUser['Customer']['vc_address3']),'disabled'=> 'disabled','type' => 'text','class'=>'round')); ?>
		
		
		</td>
		</tr>
		
		
		<tr>
		
        <td><label class="lab-inner">Telephone No. :</label></td>
        <td>
		
					<?php echo $this->Form->input( 'Customer.vc_tel_no', array('label'=>false,'value'=>trim($currentUser['Customer']['vc_tel_no']),'disabled'=> 'disabled',
					'maxlength'=>15,
					
					'type' => 'text','class'=>'round')); ?>
		</td>
        <td><label class="lab-inner">Fax No. :</label></td>
        <td>
		
					<?php echo $this->Form->input( 'Customer.vc_fax_no', array('label'=>false,'value'=>trim($currentUser['Customer']['vc_fax_no']),  'disabled'=> 'disabled',
					'maxlength'=>15,
					'type' => 'text', 'id'=>'' ,'class'=>'round')); ?>
		
		
		</td>
		
        <td><label class="lab-inner">Mobile No. :</label></td>
        <td>
					
					<?php echo $this->Form->input( 'Customer.vc_mobile_no', array('label'=>false,'value'=>trim($currentUser['Customer']['vc_mobile_no']),
					'disabled'=> 'disabled','type' => 'text', 'id'=>'' ,'class'=>'round')); ?>
		
		
		</td>
		</tr>
		
		<tr>
        <td><label class="lab-inner">Email :</label></td>
        <td><?php
		
		echo $this->Form->input( 'Customer.vc_email', array('label'=>false,'type' => 'text', 'id'=>'' ,'class'=>'round','value'=>trim($currentUser['Member']['vc_email_id']), 'disabled' =>'disabled')); ?>
		</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
		</tr>
		
    </table>

    </div>
     <!-- end innerbody here-->   

			<h3>Alternative Contact Person Information</h3>

        <!-- Start innerbody here-->

        <div class="innerbody">
			<?php echo $this->Form->create('Customer',array('url'=>array('controller'=>'customers','action'=>'view','cbc'=>true),'type' => 'file'));
			?>

            <table width="100%" border="0" cellpadding="3">
                <tr>
                   <td valign="top"><label class="lab-inner">Contact Person<br/> Name :</label></td>
                    <td valign="top">
                        <?php 
					$vc_alter_cont_person = (isset($this->data['Customer']['vc_alter_cont_person']) && !empty($this->data['Customer']['vc_alter_cont_person']))?$this->data['Customer']['vc_alter_cont_person']:$currentUser['Customer']['vc_alter_cont_person'];
						echo $this->Form->input('vc_alter_cont_person',array('label' => false, 
																					'type' => 'text',
																					'value' =>trim($vc_alter_cont_person),
																					//'disabled'=> 'disabled',
																					'class' => 'round')); 
                        ?>
						<?php
								echo $this->Form->input('Customer.editvalue', array('label' => false,
									'div' => false,
									'type' => 'hidden',
									'value' => 'edit',
									));
                        ?>
                    </td>
                    <td valign="top"><label class="lab-inner">Email ID :</label></td>
                    <td valign="top">
					<?php 
					
					if(isset($this->data['Customer']['vc_alter_email']) && !empty($this->data['Customer']['vc_alter_email'])){
						$alteremail= $this->data['Customer']['vc_alter_email'];
		
					}else{
						$alteremail= trim($currentUser['Customer']['vc_alter_email']);
		
					}
						echo $this->Form->input('vc_alter_email', array('label' => false, 
																		'type' => 'text',
																		'value' =>trim($alteremail),
																		'class' => 'round')); 
                    ?>
                    </td>
					<td valign="top"><label class="lab-inner">Phone No. :</label></td>
                    <td valign="top">

                        <?php echo $this->Form->input('vc_alter_phone_no', array('label' => false,
																				'type' => 'text',
																				'value' =>trim($currentUser['Customer']['vc_alter_phone_no']),
																				'maxlength' =>15,
																				'class' => 'round')); 
                        ?>
                    </td>
					<tr>
					<td colspan='6'> &nbsp;</td></tr>
					<tr>
					
					<td  height = '22px' align='left'  colspan='3'>

						

				</td>
				<td height = '22px' align='left'  colspan='3'>

						<?php echo
								$this->Form->submit('Submit',array('type'=>'submit','class'=>'submit','value'=>'submit'));
						?>

				</td>
				  </tr>
                </tr>

            </table>

        </div>
        <!-- end innerbody here-->        
             
    </div>
<?php echo $this->Html->script('cbc/view'); ?>
	<!-- end mainbody here-->    

	</div>

	<!-- end wrapper here-->

