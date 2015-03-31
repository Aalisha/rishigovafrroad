<!-- Start breadcrumb here-->
<div class="breadcrumb">
    <ul>
        <li class="first">

            <?php echo $this->Html->link('Home', array('controller' => 'profiles', 'action' => 'index'), array('title' => 'Home', 'class' => 'vtip')) ?>

        </li>
        <li class="last">Change Password</li>        
    </ul>
</div>
<!-- end breadcrumb here-->

<!-- Start mainbody here-->
<div class="mainbody">

    <h1><?php echo $mdclocal;?></h1>

    <h3> Change Password </h3>

    <!-- Start innerbody here-->

    <div class="innerbody">

        <?php echo $this->Form->create('Profile', array('url' => array('controller' => 'profiles', 'action' => 'changepassword'))); ?>

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
                <td width="15%" align="left" valign="top"><label class="lab-txt">New Password :</label></td>
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
                <td width="15%" align="left" valign="top"><label class="lab-txt">Confirm Password :</label></td>
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
<?php echo $this->Html->script('mdc/change-password'); ?>