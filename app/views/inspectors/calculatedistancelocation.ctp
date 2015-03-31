<?php if( isset( $k) ) : ?>
	
	<input type='hidden' value='<?php echo $result ?>' name='data[VehicleLogDetail][<?php echo $k; ?>][eprkmtrl]' />
	
<?php else : ?>
	
	<input type='hidden' value='<?php echo $result ?>' name='data[CustomerInactiveVehicleLog][eprkmtrl]' />

<?php endif; ?>