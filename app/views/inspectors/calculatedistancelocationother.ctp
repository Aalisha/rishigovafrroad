<?php if( isset( $k) ) : ?>

	<input type='hidden' value='<?php echo $result ?>' name='data[VehicleLogDetail][<?php echo $k; ?>][oteprkmtrl]' />
	
<?php else : ?>
	
	<input type='hidden' value='<?php echo $result ?>' name='data[CustomerInactiveVehicleLog][oteprkmtrl]' />

<?php endif; ?>