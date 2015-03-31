<?php
if ($rowCount >= 1) {

    $mod = $rowCount % 2;
    $rowshow = $mod == 0 ? '1' : '';
    ?>		

    <tr class="cont<?php echo $rowshow; ?>">
        <td  valign='top' >
            <?php
            echo $this->Form->input("ClaimDetail.$rowCount.vc_outlet_code", array('div' => false,
                'label' => false,
                'type' => 'select',
                'default' => '',
                'options' => array('' => 'Select') + $flrFuelOutLet,
                'class' => 'round_select1'
            ));
            ?>

        </td>
        <td valign='top' >
            <?php
            echo $this->Form->input("ClaimDetail.$rowCount.vc_invoice_no", array('label' => false,
                'div' => false,
                'type' => 'text',
               'maxlength' => '15',
                'class' => 'round3',
                'style' => 'width:67px;',
            ));
            ?>

        </td>

        <td valign='top' >
            <?php
            echo $this->Form->input("ClaimDetail.$rowCount.dt_invoice_date", array('label' => false,
                'div' => false,
                'type' => 'text',
                'class' => 'round3',
                'style' => 'width:67px;',
                'readonly' => 'readonly',
            ));
            ?>
        </td>

        <td valign='top' >
            <?php
            echo $this->Form->input("ClaimDetail.$rowCount.nu_litres", array('label' => false,
                'div' => false,
                'type' => 'text',
                'maxlength' => '9',
                'class' => 'round3 number-right',
                'style' => 'width:67px;',
            ));
            ?>
        </td>
        <?php
        $effectiveDate = !empty($refundData['ClaimprocessData']['dt_effective_date']) ?
                date('d M Y', strtotime($refundData['ClaimprocessData']['dt_effective_date'])) :
                '';
        ?>

        <td valign='top' >
            <?php
            echo $this->Form->input("ClaimDetail.$rowCount.dt_effective_date", array('label' => false,
                'div' => false,
                'type' => 'text',
                'readonly' => true,
                'value' => $effectiveDate,
                'style' => 'width:67px;',
                'class' => 'round3 disabled-field'));
            ?>
        </td>

        <td valign='top' >
            <?php
            echo $this->Form->input("ClaimDetail.$rowCount.nu_refund_prcnt", array('label' => false,
                'div' => false,
                'type' => 'text',
                'maxlength' => '5',
                'value' => $refundData['ClaimprocessData']['nu_refund_prcnt'],
                'class' => 'round3 number-right disabled-field',
                'style' => "width:67px;",
                'readonly' => true,
            ));
            ?>
        </td>

        <td valign='top' >
            <?php
            echo $this->Form->input("ClaimDetail.$rowCount.nu_admin_fee_prcnt", array('label' => false,
                'div' => false,
                'type' => 'text',
                'readonly' => true,
                'value' => $refundData['ClaimprocessData']['nu_admin_fee'],
                'class' => 'round3 number-right disabled-field',
                'style' => "width:67px;",
            ));
            ?>
        </td>
        <td valign='top' >
            <?php
            echo $this->Form->input("ClaimDetail.$rowCount.nu_refund_rate", array('label' => false,
                'div' => false,
                'type' => 'text',
                'maxlength' => '12',
                'readonly' => true,
                'value' => $refundRateValue,
                'style' => 'width:67px;',
                'class' => 'round3 number-right disabled-field'));
            ?>
        </td>
        <td valign='top' >
            <?php
            echo $this->Form->input("ClaimDetail.$rowCount.nu_admin_fee", array('label' => false,
                'div' => false,
                'type' => 'text',
                'maxlength' => '12',
                'readonly' => true,
                'style' => 'width:67px;',
                'class' => 'round3 number-right disabled-field'));
            ?>
        </td>

        <td valign='top' >
            <?php
            echo $this->Form->input("ClaimDetail.$rowCount.nu_amount", array('label' => false,
                'div' => false,
                'type' => 'text',
                'maxlength' => '12',
                'readonly' => true,
                'style' => 'width:67px;',
                'class' => 'round3 number-right disabled-field'));
            ?>

        </td>
        <td valign='top'>
            <div id='ch_rejected_td_<?php echo $rowCount ?>'>

                <?php
                //$url = $this->webroot.'flr/claims/edit/'. base64_encode($claims['ClaimHeader']['vc_claim_no']);
                //echo $this->Html->image('with-check.jpg', array('alt' => '', )); 
                echo $this->Html->image('without-check.jpg', array('alt' => '',));
                ?>
                <?php
                /* 	 echo $this->Form->checkbox("ClaimDetail.$rowCount.ch_rejected", array('label' => false,
                  'div' => false,
                  'class' => 'round3 disabled-field',
                  'style'=>'width:67px;',
                  'disabled'=>true,'checked'=>true,


                  )); */
                ?></div>
        </td>
        <td valign='top'>
		<div>
		<div style="float:left;" id="<?php echo 'ClaimDetail'.$rowCount.'VcReasonsDiv';?>">
		</div>	
		<div>
            <?php
			if(isset($this->params['pass'][0]) && !empty($this->params['pass'][0]))
			$singlefileuploadid = $this->params['pass'][0];
			else
			$singlefileuploadid =0;
			//	echo 'sing=='.;			
            echo $this->Form->hidden("ClaimDetail.$rowCount.vc_reasons", array('label' => false,
                'div' => false,
                'readonly' => 'readonly',
                'style' => 'width:67px;',
                'class' => 'round3 disabled-field'));
				
            echo $this->Html->image('remarks.jpg', array('alt' => '', 'id' => "showreason_id_$rowCount"
                , 'title' => 'View Remarks',
                'name' => "showreason_$rowCount",
                'style' => ' cursor: pointer;display:none;'));
            ?>
		</div>
		</div>
        </td>
        <td align="center">
            <?php
			//pr($this->params);
            echo $this->Form->input('InvoiceClaimDoc.' . $rowCount, array('label' => false,
                'div' => false,
                'type' => 'file',
                'id' => "updoc$rowCount",
                'tabindex' => '10',
                'class' => 'uploadfile'));
            ?>
        </td><?php 
		if($singlefileuploadid==1){
		?><td></td>
		
		<?php }	
		?>
    </tr>


<?php } ?>
<?php
								

            echo $this->Form->input('hidden_call', array('label' => false,
                'div' => false,
                'type' => 'hidden',
                'id' => "hidden_call",
                'value' => $rowCount));
  ?>
