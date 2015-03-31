<?php 
$message =  $this->Session->check('Message.flash.message') ? trim($this->Session->read('Message.flash.message')) : '';
if( $this->Session->check('Message.flash.element') && strtolower(trim($this->Session->read('Message.flash.element'))) == 'error' ) :
?>

<!-- Start error message here-->
<div class="errorexist">
    <div class="message-area">
				<div class="box"> 
		
	<?php echo $this->Html->image('icon_error.png', array('width'=>"18", 'height'=>"20", 'align'=>"middle") ); ?>				
						<span><?php printf("<strong>{$message}</strong>"); ?></span>
				</div>
	</div>
   <div class="button-close">
		<?php echo $this->Html->image('close-small-button.png', array('width'=>"20",'onclick'=>'$(".errorexist").remove();', 'height'=>"20", 'align'=>"close-small-button") ); ?>
   </div>
</div>
<!-- End error message here-->

<?php
elseif( $this->Session->check('Message.flash.element') && strtolower(trim($this->Session->read('Message.flash.element'))) == 'success'  ) :
?>


<!-- Start Sucess message here-->

<div class="success-message1">
    
	<div class="message-area">
		<div class="box">
			
			<?php echo $this->Html->image('icon_success.png', array('width'=>"19", 'height'=>"20", 'align'=>"middle") ); ?>
		
			<span>
				<?php printf("<strong>{$message}</strong>"); ?>
			</span>
		</div>
	</div>
	
	<div class="button-close">
		
		<?php echo $this->Html->image('close-small-button.png', array('width'=>"20",'onclick'=>'$(".success-message").remove();', 'height'=>"20", 'align'=>"close-small-button") ); ?>
		
	</div>
	
</div>

<!-- End Sucess message here-->


<?php
elseif( $this->Session->check('Message.flash.element') && strtolower(trim($this->Session->read('Message.flash.element'))) == 'info' ):
?>


<!-- Start Info message here-->
<div class="info-message1">
	<div class="message-area">
		<div class="box">
			<?php echo $this->Html->image('icon_info.png', array('width'=>"19", 'height'=>"19", 'align'=>"middle") ); ?>
			<span>
				<?php printf("<strong>{$message}</strong>"); ?>
			</span>
		</div>
	</div>
<div class="button-close">
	<?php echo $this->Html->image('close-small-button.png', array('width'=>"20",'onclick'=>'$(".info-message").remove();', 'height'=>"20", 'align'=>"close-small-button") ); ?>
</div>
</div>
<!-- End Info message here-->

<?php
else :
 
 //pr($this->Session->read());

endif;
?>