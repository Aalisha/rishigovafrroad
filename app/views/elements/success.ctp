<?php
/**
 *
 * Success Message
 * 
 */
?>

<!-- Start Sucess message here-->

<div class="success-message">
    
	<div class="message-area">
		<div class="box">
        <div class="box1">
			
			<?php echo $this->Html->image('icon_success.png', array('width'=>"19", 'height'=>"20", 'align'=>"middle") ); ?>
		
		
				<?php printf("<strong>{$message}</strong>"); ?>

            </div>
		</div>
	</div>
	
	<div class="button-close">
		
		<?php echo $this->Html->image('close-small-button.png', array('width'=>"20",'onclick'=>'$(".success-message").remove();', 'height'=>"20", 'align'=>"close-small-button") ); ?>
		
	</div>
	
</div>

<!-- End Sucess message here-->