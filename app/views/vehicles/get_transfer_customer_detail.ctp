 <table width="100%" border="0" cellpadding="3">
            <tr>
                <td><label class="lab-inner">Company Name</label></td>
                <td colspan="2">
                    <?php
                    echo $this->Form->input('VehicleAmendment.to_vc_customer_name', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'to_vc_customer_name',
                        'readonly'=>'readonly',
                        'value' => !empty($data['Company']['vc_company_name'])?$data['Company']['vc_company_name']:'',
                        'class' => 'round'));
                    ?>
                   <?php echo $this->Form->button('Find',array('label'=>false, 'onclick'=>"pop('VehicleTransferFormCustomerSearchPop');", 'div'=>false,'type'=>'button', 'style'=>'margin-left:4px; margin-top:0px;', 'class'=> 'round5'));  ?>
				   </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td><label class="lab-inner">Street Name :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('VehicleAmendment.to_vc_address1', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'to_vc_address1',
						'disabled'=>'disabled',
                        'value' =>  !empty($data['Company']['vc_address1'])?$data['Company']['vc_address1']:'',
                        'class' => 'round'));
                    ?>
                </td>
                <td><label class="lab-inner">House No. :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('VehicleAmendment.to_vc_address2', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'to_vc_address2',
			'disabled'=>'disabled',
                        'value' =>  !empty($data['Company']['vc_address2'])?$data['Company']['vc_address2']:'',
                        'class' => 'round'));
                    ?>
					
		<?php
                    echo $this->Form->input('VehicleAmendment.vc_to_customer_no', array('label' => false,
                        'div' => false,
                        'type' => 'hidden',
                        'value' => !empty($data['Company']['vc_customer_no'])?$data['Company']['vc_customer_no']:'',
                        'class' => 'round'));
						    echo $this->Form->input('VehicleAmendment.nu_company_id_to', array('label' => false,
                        'div' => false,
                        'type' => 'hidden',
                        'value' => !empty($data['Company']['nu_company_id'])?$data['Company']['nu_company_id']:'',
                        'class' => 'round'));
                    ?>

                </td>
                <td><label class="lab-inner">P.O .Box :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('VehicleAmendment.to_new_vc_po_box', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'to_new_vc_po_box',
						'disabled'=>'disabled',
                        'value' =>  !empty($data['Company']['vc_address3'])?$data['Company']['vc_address3']:'',
                        'class' => 'round'));
                    ?>
                </td>
            </tr>
            <tr>
			<td><label class="lab-inner">Town/City :</label></td>
				<td>
				 <?php
                    echo $this->Form->input('VehicleAmendment.vc_town', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_town',
                             'disabled'=>'disabled',
                        'value' =>  !empty($data['Company']['vc_town'])?$data['Company']['vc_town']:'',
                        'class' => 'round'));
                    ?>
				</td>
                <td><label class="lab-inner">Telephone No. :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('VehicleAmendment.to_vc_telephone_no', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'to_vc_telephone_no',
							  'disabled'=>'disabled',
                        'value' =>  !empty($data['Company']['vc_tel_no'])?$data['Company']['vc_tel_no']:'',
                        'class' => 'round'));
                    ?>
                </td>
                <td><label class="lab-inner">Fax No. :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('VehicleAmendment.to_vc_fax_no', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'to_vc_fax_no',
			'disabled'=>'disabled',
                        'value' =>  !empty($data['Company']['vc_fax_no'])?$data['Company']['vc_fax_no']:'',
                        'class' => 'round'));
                    ?>
                </td>
               
            </tr>
            
            <tr>
                <td><label class="lab-inner">Mobile No. :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('VehicleAmendment.to_vc_mobile_no', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_mobile_no',
                        'disabled' => 'disabled',
                        'value' => !empty($data['Company']['vc_mobile_no'])?$data['Company']['vc_mobile_no']:'',
                        'class' => 'round'));
                    ?>
                </td>
                
                
                <td><label class="lab-inner">Transfer Date :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('VehicleAmendment.dt_amend_date', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'dt_amend_date',
			'readonly'=>'readonly',
                        'value' => date('d-M-Y'),
                        'class' => 'round'));
                    ?>
                </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                
            </tr>
            

        </table>
		
		