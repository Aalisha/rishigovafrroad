	<?php if ( count($vehicleList) > 0) : ?>

	<?php 
			$i = 0;
			
			foreach ($vehicleList as $key => $value) : 
			
			$str = $i % 2 == 0 ? '1' : '';
	?>

		<tr class="cont<?php echo $str ?>">

			<td width="10%" align="center">

				<input type='radio' name='vehiclelicno' value='<?php echo trim($value); ?>' />


			</td>

			<td width="60%" align="left"><?php echo trim($key); ?></td>

			<td width="30%"><?php echo trim($value); ?></td>

		</tr>

	<?php 
		
		endforeach;
		
		$i++;
	?>

<?php else : ?>

	<tr class="cont1" style='text-align:center;'>

		<td colspan='3'>No Records Found</td>

	</tr>

<?php endif; ?>		