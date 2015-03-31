<?php
/**
 *
 * Error Message
 * 
 */
?>
<!-- Start error message here-->
<div class="error-common">
    <div class="message-area">
				<div class="box"> 
					<div class="box1"> 	
					<?php echo $this->Html->image('icon_error.png', array('width'=>"18",'onclick'=>'$(".error-common").remove();', 'height'=>"20", 'align'=>"middle") ); ?>
					<?php printf("<strong>{$message}</strong> "); ?>
				</div>
                </div>
	</div>
   <div class="button-close">
		<?php echo $this->Html->image('close-small-button.png', array('width'=>"20",'onclick'=>'$(".error-common").remove();', 'height'=>"20", 'align'=>"close-small-button") ); ?>
   </div>
</div>
<!-- End error message here-->