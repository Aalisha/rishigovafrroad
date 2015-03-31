<?php
/**
 *
 * Info Message
 * 
 */
?>

<!-- Start Info message here-->
<div class="info-message">
	<div class="message-area">
		<div class="box">
        <div class="box1"> 
			<?php echo $this->Html->image('icon_info.png', array('width'=>"19", 'height'=>"19", 'align'=>"middle") ); ?>
			
				<?php printf("<strong>{$message}</strong>"); ?>
			
            </div>
		</div>
	</div>
<div class="button-close">
	<?php echo $this->Html->image('close-small-button.png', array('width'=>"20",'onclick'=>'$(".info-message").remove();', 'height'=>"20", 'align'=>"close-small-button") ); ?>
</div>
</div>
<!-- End Info message here-->