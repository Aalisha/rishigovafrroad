<!-- Start breadcrumb here-->
<div class="breadcrumb">
    <ul>
        <li class="first">
<?php
					if (isset($loggedIn) &&  !empty($loggedIn)):

						if ($this->Session->read('Auth.Member.vc_flr_customer_no') == '') :

							$url = array('controller' => 'suppliers', 'action' => 'index', 'flr' => true);

						elseif ($this->Session->read('Auth.Client.ch_active_flag') == 'STSTY05'):

							$url = array('controller' => 'suppliers', 'action' => 'index', 'flr' => true);

						else:

							$url = array('controller' => 'suppliers', 'action' => 'view', 'flr' => true);

						endif;

					else :

						$url = array('controller' => 'members', 'action' => 'login');

					endif;
            ?>
            <?php echo $this->Html->link('Home', $url, array('title' => 'Home', 'class' => 'vtip')) ?>

        </li>
        <li class="last">Change Password</li>        
    </ul>
</div>
<!-- end breadcrumb here-->

<!-- Start mainbody here-->
<div class="mainbody">

    <h1>Welcome to RFA FLR</h1>

    <h3> Change Password </h3>

    <!-- Start innerbody here-->

    <div class="innerbody">

       <?php echo $this->Form->create('Clientsupplier',array('url' => array('controller' => 'suppliers', 'action' => 'changepassword'))); ?>

       <table width="100%" border="0">

            <tr>
                <td width="15%" align="left" valign="top"><label class="lab-txt">Old Password :</label></td>

                <td width="85%" align="left" valign="top" >
                    <?php echo $this->Form->input('vc_old_password', 
                            array('label' => false, 
                                'div' => false, 
                                'type' => 'password', 
                                'id' => 'password', 
                                'class' => 'fiel')); 
                    ?>
                </td>

   </tr>

            <tr>
                <td width="15%" align="left" valign="top"><label class="lab-txt">
				New Password :</label></td>
                <td width="85%" align="left" valign="top">
                    <?php echo $this->Form->input('vc_password', 
                            array('label' => false, 
                                'div' => false, 
                                'type' => 'password', 
                                'id' => 'new_password', 
                                'class' => 'fiel')); 
                    ?>
                </td>
   </tr>

            <tr>
                <td width="15%" align="left" valign="top"><label class="lab-txt">
				Confirm Password :</label></td>
                <td width="85%" align="left" valign="top">
                    <?php echo $this->Form->input('vc_confirm_password', 
                            array('label' => false, 
                                'div' => false, 
                                'type' => 'password', 
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
<?php echo $this->Html->script('flr/change-password-supplier'); ?>