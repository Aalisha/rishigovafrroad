<!-- Start breadcrumb here-->
<div class="breadcrumb">
    <ul>
        <li class="first">
            <?php echo $this->Html->link('Home', array('controller' => 'erpimports', 'action' => 'dashboard'), array('title' => 'Home', 'class' => 'vtip')) ?>
        </li>

        <li class="last"> Password Generate </li>        
    </ul>
</div>
<!-- Start mainbody here-->
<div class="mainbody">

    <h3><?php __('Password Generate '); ?></h3>

    <!-- Start innerbody here-->

    <?php echo $this->Form->create('Generatepassword',array('url'=>array('controller'=>'erpimports', 'action'=>'generatetemporarypassword'))); ?>
	
	<fieldset style="height:auto;padding: 25px;"> <!-- remove this from your view (CTP) file -->
		
		
		<?php if( isset($encry_password) &&  !empty($encry_password) ) { ?>
			<div class='encry_password' >
				<?php  echo " <div class='encry_title' > New Encrypt Password : </div> <div class='new_enr_pwd' > " . $encry_password  ."</div>"; ?>
			</div>
			
		<?php } ?>
        
		<?php
		echo $this->Form->input('password',array('type'=>'password','div'=>array('class'=>'enter-password'),'label'=>'Enter Password <span class="mandatory" > * </span>'));
		?>
		<?php
			echo $this->Form->input('confirmpassword',array('type'=>'password', 'div'=>array('class'=>'inter-password'), 'label'=>' Confirm Password <span class="mandatory"> * </span> '));
		?>
		<div class="pwdsubmit" > 
		<?php
			echo $this->Form->button('Generate',array('class'=>'submit', "type"=>'submit'));
		?>
        </div>
	</fieldset>

<?php echo $this->Form->end(null); ?>
<?php /*echo $this->Html->script('generate_password'); */?>
	
	
	
</div>