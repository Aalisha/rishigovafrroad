<!-- Start breadcrumb here-->
<div class="breadcrumb">
    <ul>
       	<?php
			
			if ( trim($this->Session->read('Auth.Member.vc_cbc_customer_no')) == '') : ?>
			
				 <li class="first">

					<?php echo $this->Html->link('Home', array('controller' => 'customers', 'action' => 'view','cbc'=>true), array('title' => 'Home', 'class' => 'vtip')) ?>

				</li>
		   
				
	    
		<?php elseif ( trim($this->Session->read('Auth.Customer.ch_active')) == 'STSTY05' ) : ?>
		
				<li class="first">

					<?php echo $this->Html->link('Home', array('controller' => 'customers', 'action' => 'editprofile','cbc'=>true), array('title' => 'Home', 'class' => 'vtip')) ?>

				</li>
		
		
			
	    <?php else : ?>
			<li class="first">

					<?php echo $this->Html->link('Home', array('controller' => 'customers', 'action' => 'view','cbc'=>true), array('title' => 'Home', 'class' => 'vtip')) ?>

				</li>
		
		

		<?php endif; ?>	
		
        <li class="last">Change Password</li>    
		
    </ul>
</div>
<!-- end breadcrumb here-->

<!-- Start mainbody here-->
<div class="mainbody">

    <h1>Welcome to RFA CBC</h1>

    <h3> Change Password </h3>

    <!-- Start innerbody here-->

    <div class="innerbody">

        <?php echo $this->Form->create('Customer', array('url' => array('controller' => 'customers', 'action' => 'changepassword','cbc'=>true))); ?>

       <table width="100%" border="0">

            <tr>
                <td width="15%" align="left" valign="top"><label class="lab-txt">Old Password :</label></td>

                <td width="85%" align="left" valign="top" >
                    <?php echo $this->Form->input('vc_old_password', 
                            array('label' => false, 
                                'div' => false, 
                                'type' => 'password', 
								'maxlength' => 50,
                                'id' => 'password', 
                                'class' => 'fiel')); 
                    ?>
                </td>

   </tr>

            <tr>
                <td width="15%" align="left" valign="top"><label class="lab-txt">New Password :</label></td>
                <td width="85%" align="left" valign="top">
                    <?php echo $this->Form->input('vc_password', 
                            array('label' => false, 
                                'div' => false, 
                                'type' => 'password', 
								'maxlength' => 50,
                                'id' => 'new_password', 
                                'class' => 'fiel')); 
                    ?>
                </td>
   </tr>

            <tr>
                <td width="15%" align="left" valign="top"><label class="lab-txt">Confirm Password :</label></td>
                <td width="85%" align="left" valign="top">
                    <?php echo $this->Form->input('vc_confirm_password', 
                            array('label' => false, 
                                'div' => false, 
                                'type' => 'password', 
								'maxlength' => 50,
                                'id' => 'confirm_password', 
                                'class' => 'fiel')); 
                    ?>
                </td>
   </tr>

            <tr>
                <td width="15%" align="left" valign="top">&nbsp;</td>
                <td width="85%" align="left" valign="top">
                    <?php echo $this->Form->submit(NULL, 
                            array('label' => false, 
                                'div' => false, 
                                'id' => 'Login', 
                                'value' => 'Login', 
                                'class' => 'submit')); 
                    ?>
                </td>
   </tr>

</table>

        <?php echo $this->Form->end(); ?>
    </div>
</div>	
<?php echo $this->Html->script('cbc/change-password'); ?>