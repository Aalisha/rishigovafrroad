<?php
if ($rowCount >= 1) {

    $mod = $rowCount % 2;
    $rowshow = $mod == 0 ? '1' : '';
    ?>		
    <tr class="cont<?php echo $rowshow; ?>">
     
		
		 <td width="6%" valign='middle' align='center'>
						<strong >
                        <?php
						 echo current($status);
						
                       
                        ?>
						</strong >
                    </td>
					
					
					<?php
					
                       /* <td width="8%" valign='middle' align='center'>echo $this->Form->input("VehicleDetail.$rowCount.nu_company_id", array('label' => false,
                            'div' => false,
                            'type' => 'select',
                            'tabindex'=>($rowCount*10+1),							
							'required' => 'required',
                            'options' => $CompanyId,
                            'maxlength' => 30,
                            'class' => 'round_select4')
                        );  </td>*/
                        ?>
                  
					
		
        <td valign='top' width="8%">
            <?php
            echo $this->Form->input("VehicleDetail.$rowCount.vc_vehicle_lic_no", array('label' => false,
                'div' => false,
                'type' => 'text',
                'tabindex'=>($rowCount*10+2),
                'maxlength' => 15,
                'required' => 'required',
                'class' => 'round4'));
            ?>

        </td>
        <td  valign='top' width="8%">
            <?php
            echo $this->Form->input("VehicleDetail.$rowCount.vc_vehicle_reg_no", array('label' => false,
                'div' => false,
                'type' => 'text',
                'tabindex'=>($rowCount*10+3),
                'maxlength' => 15,
                'required' => 'required',
                'class' => 'round4'));
            ?>

        </td>
        <td valign='top' width="8%">
            <?php
            echo $this->Form->input("VehicleDetail.$rowCount.vc_pay_frequency", array('label' => false,
                'div' => false,
                'type' => 'select',
                'tabindex'=>($rowCount*10+4),
                'maxlength' => 30,
                'options' => $payfrequency,
                'class' => 'round_select4')
            );
            ?>
        </td>
        <td valign='top' width="8%">
            <?php
            echo $this->Form->input("VehicleDetail.$rowCount.vc_vehicle_type", array('label' => false,
                'div' => false,
                'type' => 'select',
                'tabindex'=>($rowCount*10+5),
                'required' => 'required',
                'maxlength' => 15,
                'options' => $vehiclelist,
                'class' => 'round_select4')
            );
            ?>

        </td>
        <td valign='top'  width="8%">
            <?php
            echo $this->Form->input("VehicleDetail.$rowCount.vc_start_ometer", array('label' => false,
                'div' => false,
                'type' => 'text',
                'tabindex'=>($rowCount*10+6),
                'maxlength' => 15,
                'required' => 'required',
                'class' => 'round4 number-right'));
            ?>

        </td>
        <td valign='top' width="9%">
            <?php
            echo $this->Form->input("VehicleDetail.$rowCount.vc_oper_est_km", array('label' => false,
                'div' => false,
                'type' => 'text',
                'tabindex'=>($rowCount*10+7),
                'maxlength' => 15,
                'required' => 'required',
                'class' => 'round4 number-right'));
            ?>

        </td>
        <td valign='top' width="9%">
            <?php
            echo $this->Form->input("VehicleDetail.$rowCount.vc_v_rating", array('label' => false,
                'div' => false,
                'type' => 'text',
                'tabindex'=>($rowCount*10+8),
                'maxlength' => 15,
                'class' => 'round1 number-right'));
            ?>

        </td>
        <td valign='top'  width="9%">
            <?php
            echo $this->Form->input("VehicleDetail.$rowCount.vc_dt_rating", array('label' => false,
                'div' => false,
                'type' => 'text',
                'tabindex'=>($rowCount*10+9),
                'maxlength' => 15,
                'class' => 'round1 number-right'));
            ?>

        </td>
        <td  valign='top' width="10%">
            <?php
            echo $this->Form->input("VehicleDetail.$rowCount.vc_predefine_route", array('label' => false,
                'div' => false,
                'type' => 'text',
                'tabindex'=>($rowCount*10+10),
                'maxlength' => 50,
                'class' => 'round1'));
            ?>

        </td>
        <td valign='top' width="7%" align="center">
            <?php
            echo $this->Form->button('Upload', array('label' => false,
                'div' => false,
                'id' => "updoc$rowCount",
                'type' => 'button',
                'tabindex'=>($rowCount*10+11),
                'onclick' => "uploaddocs('uploadDocsvehicle{$rowCount}', $rowCount);",
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
            </table>       

        </div>
    </div>
				
				
			
		</td>
    </tr>

<?php } ?>