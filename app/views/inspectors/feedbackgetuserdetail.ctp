<table width="100%" border="0" cellpadding="3">
	 <tr>
	 <td>
	 	 </td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	 </tr>
	 <tr>
		<td valign='top'><label class="lab-inner">Vehicle Lic. No. :</label></td>
		<td valign='top'>
			
			<?php
		//pr($data);
			
			echo $this->Form->input('vc_vehicle_lic_no', array('label' => false,
				'div' => false,
				'type' => 'text',
				'id' => 'vc_vehicle_lic_no',
						'style'=>'width:90px;',
				'readonly'=>true,
				'value'=>trim($data['VehicleDetail']['vc_vehicle_lic_no']),
				'required' => 'required',
				'class' => 'round_select')
			);
				echo $this->Form->button('Find', array('label' => false,
				'div' => false,
				'type' => 'button',
				'id' => 'addshow',
				'style'=>'marhin-left:20px;',
				'class' => 'round '));
			?>

		</td>

		<td valign='top' width ="10"><label class="lab-inner">Vehicle Reg. . :</label></td>
		<td valign='top'>
			<?php
			
			
			echo $this->Form->input('vc_vehicle_reg_no', array('label' => false,
				'div' => false,
				'type' => 'text',
						'style'=>'width:90px;',
				'id' => 'vc_vehicle_reg_no',
				'readonly'=>true,
				'required' => 'required',
				'value'=>trim($data['VehicleDetail']['vc_vehicle_reg_no']),
				'class' => 'round_select')
			);
			
			echo $this->Form->button('Find', array('label' => false,
				'div' => false,
				'type' => 'button',
				'id' => 'addshow',
				'style'=>'marhin-left:20px;',
				'class' => 'round'));
			?>

		</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
	</tr>
	
	<tr>
		<td valign='top'><label class="lab-inner">RFA Account No. :</label></td>
		<td valign='top'>
			<?php
			echo $this->Form->input('vc_customer_no', array('label' => false,
				'div' => false,
				'type' => 'text',
				'readonly'=>'readonly',
				'id' => 'vc_rfa_account_no',
				'value'=>trim($data['CustomerProfile']['vc_customer_no']),
				'required'=>true,
				'class' => 'round disabled-field'));

			
			?>

		</td>
		<td valign='top'><label class="lab-inner">Customer Id</label></td>
		<td valign='top' >
			<?php
			echo $this->Form->input('vc_customer_id', array('label' => false,
				'div' => false,
				'type' => 'text',
				'id' => 'vc_customer_id',
				'value'=>trim($data['CustomerProfile']['vc_customer_id']),
				'class' => 'round disabled-field'));
			?>

		</td>
		<td valign='top' ><label class="lab-inner">Customer Name :</label></td>
		<td valign='top' >
			<?php
			echo $this->Form->input('vc_customer_name', array('label' => false,
				'div' => false,
				'type' => 'text',
				'id' => 'vc_customer_name',
				'value'=>trim($data['CustomerProfile']['vc_customer_name']),
				'class' => 'round disabled-field'));
			?>

		</td>

	</tr>
	<tr>
		<td valign='top' ><label class="lab-inner">Street Name :</label></td>
		<td valign='top' >
			<?php
			echo $this->Form->input('vc_address1', array('label' => false,
				'div' => false,
				'type' => 'text',
				'id' => 'vc_address1',
				'value'=>trim($data['CustomerProfile']['vc_address1']),
				'class' => 'round disabled-field'));
			?>
			<!--<input type="text" class="round" />-->
		</td>
		<td valign='top' ><label class="lab-inner">House No. :</label></td>
		<td valign='top' >
			<?php
			echo $this->Form->input('vc_address2', array('label' => false,
				'div' => false,
				'type' => 'text',
				'id' => 'vc_address2',
				'value'=>trim($data['CustomerProfile']['vc_address2']),
				'class' => 'round disabled-field'));
			?>
			<!--<input type="text" class="round" />-->
		</td>
		<td valign='top' ><label class="lab-inner">P.O .Box :</label></td>
		<td valign='top' >
			<?php
			echo $this->Form->input('vc_po_box', array('label' => false,
				'div' => false,
				'type' => 'text',
				'id' => 'vc_po_box',
				'value'=>trim($data['CustomerProfile']['vc_address3']),
				'class' => 'round disabled-field'));
			?>
			<!--<input type="text" class="round" />-->
		</td>
	</tr>
	<tr>
	<td><label class="lab-inner">Town/City :</label></td>
				<td>
				<?php
                    echo $this->Form->input('vc_town', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_town',                       
                       'value'=>trim($data['CustomerProfile']['vc_town']),
				'class' => 'round disabled-field'));
                    ?>
				</td>
		<td valign='top' ><label class="lab-inner">Telephone No. :</label></td>
		<td valign='top' >
			<?php
			echo $this->Form->input('vc_tel_no', array('label' => false,
				'div' => false,
				'type' => 'text',
				'id' => 'vc_tel_no',
				'value'=>trim($data['CustomerProfile']['vc_tel_no']),
				'class' => 'round disabled-field'));
			?>
			<!--<input type="text" class="round" />-->
		</td>
		<td valign='top' ><label class="lab-inner">Fax No. :</label></td>
		<td valign='top' >
			<?php
			echo $this->Form->input('vc_fax_no', array('label' => false,
				'div' => false,
				'type' => 'text',
				'id' => 'vc_fax_no',
				'value'=>trim($data['CustomerProfile']['vc_fax_no']),
				'class' => 'round disabled-field'));
			?>
			<!--<input type="text" class="round" />-->
		</td>
		
	</tr>
	<tr>
<td valign='top' ><label class="lab-inner">Mobile No. :</label></td>
		<td valign='top' >
			<?php
			echo $this->Form->input('vc_mobile_no', array('label' => false,
				'div' => false,
				'type' => 'text',
				'id' => 'vc_mobile_no',
				'value'=>trim($data['CustomerProfile']['vc_mobile_no']),
				'class' => 'round disabled-field'));
			?>
			<!--<input type="text" class="round" />-->
		</td>
		<td valign='top' ><label class="lab-inner">Email :</label></td>
		<td valign='top' >
			<?php
			echo $this->Form->input('vc_email_id', array('label' => false,
				'div' => false,
				'type' => 'text',
				'id' => 'vc_email_id',
				'value'=>trim($data['CustomerProfile']['vc_email_id']),
				'class' => 'round disabled-field'));
			?>
			<!--<input type="text" class="round" />-->
		</td>
		
		<td valign='top' ><label class="lab-inner">Customer Type :</label></td>
		<td valign='top' >
			<?php
			//pr($globalParameterarray);
			echo $this->Form->input('vc_cust_type', array('label' => false,
				'div' => false,
				'type' => 'text',
				'id' => 'vc_cust_type',
			    'value'=> (isset($data['CustomerProfile']['vc_cust_type']) && $data['CustomerProfile']['vc_cust_type']!='')? trim($globalParameterarray[$data['CustomerProfile']['vc_cust_type']]):'',
				'class' => 'round disabled-field'));
			?>
			<!--<input type="text" class="round" />-->
		</td>

	</tr>
	<tr>
	
	<td valign='top' ><label class="lab-inner">Pay Frequency :</label></td>
		<td valign='top' colspan="5" >
			<?php
			echo $this->Form->input('vc_pay_frequency', array('label' => false,
				'div' => false,
				'type' => 'text',
				'readonly' => 'readonly',
				'value'=>trim($data['PAYFREQUENCY']['vc_prtype_name']),
				'class' => 'round disabled-field'));
			?>
			<!--<input type="text" class="round" />-->
		</td>
		
		</tr>
	
</table>

