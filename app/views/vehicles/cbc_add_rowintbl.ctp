<?php $str = $rowCount % 2 == 0 ? '' : '1'; ?>
<tr class="cont<?php echo $str;?>">
	
	<td valign='top'>

		<?php
		echo $this->Form->input("AddVehicle.$rowCount.vc_veh_type", array('label' => false,
			'type' => 'select',
			'required' => 'required',
			'options' => $CustType,
			'class' => 'round_select1'));
		?>

	</td>
	<td valign='top' >
		<?php 
		echo $this->Form->input("AddVehicle.$rowCount.vc_reg_no", array('label' => false,
			'div' => false,
			'type' => 'text',
			'required' => 'required',
			'value'=>'',
			'maxlength' => '30',
			'class' => 'round4'));
		?>

	</td>
	<td valign='top' >
		<?php 
		echo $this->Form->input("AddVehicle.$rowCount.vc_type_no", array('label' => false,
			'div' => false,
			'type' => 'select',
			'required' => 'required',
			'options' => $vehtype,
			'maxlength' => '30',
			'class' => 'round_select1')
		);
		?>

	</td>
	<td valign='top' >
		<?php
		echo $this->Form->input("AddVehicle.$rowCount.vc_make", array('label' => false,
			'div' => false,
			'type' => 'select',
			'required' => 'required',
			'options' => $vehtype3,
			'maxlength' => '30',
			'class' => 'round_select1')
		);
		?>

	</td>
	<td valign='top' >
		<?php
		echo $this->Form->input("AddVehicle.$rowCount.vc_axle_type", array('label' => false,
			'div' => false,
			'type' => 'select',
			'options' => $vehtype1,
			'required' => 'required',
			'maxlength' => '15',
			'class' => 'round_select1'));
		?>

	</td>
	<td valign='top'  >
		<?php
		echo $this->Form->input("AddVehicle.$rowCount.vc_series_name", array('label' => false,
			'div' => false,
			'type' => 'text',
			'value'=>'',
			'maxlength' => '15',
			'class' => 'round4'));
		?>

	</td>
	<td valign='top' >
		<?php
		echo $this->Form->input("AddVehicle.$rowCount.vc_engine_no", array('label' => false,
			'div' => false,
			'type' => 'text',
			'value'=>'',
			'maxlength' => '15',
			'class' => 'round4'));
		?>

	</td>
	<td valign='top' >
		<?php
		echo $this->Form->input("AddVehicle.$rowCount.vc_chasis_no", array('label' => false,
			'div' => false,
			'type' => 'text',
			'value'=>'',
			'maxlength' => '15',
			'class' => 'round4'));
		?>

	</td>
	<td valign='top' title = "The V-value is indicated on your licence disk is the TARRA (the Minimum capacity in Kg a certain truck is able to draw or carry; usually it’s the smaller number)" >
		<?php
		echo $this->Form->input("AddVehicle.$rowCount.nu_v_rating", array('label' => false,
			'div' => false,
			'type' => 'text',
			'value'=>'',
			'maxlength' => '15',
			'class' => 'number-right round4'));
		?>

	</td>
	<td valign='top' title = "The D-value is indicated on your licence disk (the Maximum capacity in Kg a certain truck or trailer is able to draw or carry; usually it’s a big number GVM)">
		<?php
		echo $this->Form->input("AddVehicle.$rowCount.nu_d_rating", array('label' => false,
			'div' => false,
			'type' => 'text',
			'value'=>'',
			'maxlength' => '15',
			'class' => 'number-right round4'));
		?>

	</td>
   
	</td>
	<td valign='top' align="center" >
		<?php
                        echo $this->Form->button('Upload', array('label' => false,
                            'div' => false,
                            'onclick' => "uploaddocs('uploadDocsvehicle$rowCount', $rowCount);",
                            'type' => 'button',
                            'class' => 'round3'));
                        ?>		
					
						<div id="uploadDocsvehicle<?php echo $rowCount; ?>" class="ontop">

        <div id="popup<?php echo $rowCount; ?>" class="popup2">

            <a href="javascript:void(0);" class="close" onClick='hidepop("uploadDocsvehicle<?php echo $rowCount; ?>");' >Close</a>   

           
            <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
                <tr>
                    <td valign ='top' colspan='2' align="left" class="content-area">
                        <div class="listhead-popup">Upload Document</div>
                    </td>

                   
                </tr>
				
				 <tr>
				 
                    <td colspan='2' valign ='top' align="left">
                        <div class="file-format" >Pdf, Png, Jpeg, Jpg File Could be uploaded.<strong>2 MB</strong> is the maximum size for upload </div>
                    </td>

                   

                </tr>

                <tr>
                    <td  valign ='top'  width="100%" align="left">
                        
						<div class="content-area-outer">

                            <div class="upload-button">



                            </div>

                            <div class="button-addmore">

                                <div class='add_row' > 
                                    <a  onclick="add_fields('uploadDocsvehicle<?php echo $rowCount; ?>', <?php echo $rowCount; ?>);">
                                        <?php echo $this->Html->image('add-more.png', array('width' => '24', 'height' => '24')); ?>
                                    </a>
                                    <a  onclick="add_fields('uploadDocsvehicle<?php echo $rowCount; ?>', <?php echo $rowCount; ?>);"> Add </a>
                                </div>	
                                							
                            </div>

                        </div>

	</td>
</tr>
<?php echo $this->Html->script('cbc/tooltip'); ?>