<?php
if ($rowCount >= 1) {

    $mod = $rowCount % 2;
    $rowshow = $mod == 0 ? '1' : '';
    ?>		
    <tr class="cont<?php echo $rowshow; ?>">
         <td valign='top' width="9%">&nbsp;</td>
         <td valign='top' width="9%">&nbsp;</td>
         <td valign='top' width="9%">&nbsp;</td>
		
		 <td width="24%" align="left" valign='top' >
                    <?php
                    echo $this->Form->input("Profile.$rowCount.vc_company_type", array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'required' => 'required',
                        'maxlength' => 50,
                        'id' => 'vc_company_type',
                        'class' => 'round'));
                    ?>
                </td>
	</tr>
					
<?php } ?>