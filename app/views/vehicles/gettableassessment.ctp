<?php
if ($rowCount >= 1) {

    $mod = $rowCount % 2;
    $rowshow = $mod == 0 ? '1' : '';
    ?>		
    <tr class="cont<?php echo $rowshow; ?>">
        <td>

            <?php
            echo $this->Form->input("AssessmentVehicleDetail.$rowCount.vc_vehicle_lic_no", array('label' => false,
                'div' => false,
                'type' => 'select',
                'id' => 'vc_vehicle_lic_no_'.$rowCount,
                'options' => @$vehiclelist,
                'required' => 'required',
                'rel' => 'license',
                'maxlength' => 15,
                'class' => 'round_select2')
            );
            ?>

        </td>
        <td>
            <?php
            echo $this->Form->input("ssessmentVehicleDetail.$rowCount.vc_vehicle_reg_no", array('label' => false,
                'div' => false,
                'type' => 'select',
                'id' => 'vc_vehicle_reg_no_'.$rowCount,
                'options' => @$vehicleReg,
                'required' => 'required',
                'rel' => 'registration',
                'maxlength' => 15,
                'class' => 'round_select2')
            );
            ?>

        </td>
        <td>
            <?php
            echo $this->Form->input("AssessmentVehicleDetail.$rowCount.vc_pay_frequency", array('label' => false,
                'div' => false,
                'type' => 'text',
                'id' => 'vc_pay_frequency_'.$rowCount,
                'readonly' => 'readonly',
                'maxlength' => 30,
                'class' => 'round2'));
            ?>

        </td>
        <td>
            <?php
            echo $this->Form->input("AssessmentVehicleDetail.$rowCount.vc_prev_end_om", array('label' => false,
                'div' => false,
                'type' => 'text',
                'id' => 'vc_prev_end_om_'.$rowCount,
                'required' => 'required',
                'maxlength' => 15,
                'class' => 'round2'));
            ?>

        </td>
        <td>
            <?php
            echo $this->Form->input("AssessmentVehicleDetail.$rowCount.vc_end_om", array('label' => false,
                'div' => false,
                'type' => 'text',
                'id' => 'vc_end_om_'.$rowCount,
                'required' => 'required',
                'maxlength' => 15,
                'class' => 'round2'));
            ?>

        </td>
        <td>
            <?php
            echo $this->Form->input("AssessmentVehicleDetail.$rowCount.vc_km_travelled", array('label' => false,
                'div' => false,
                'type' => 'text',
                'id' => 'vc_km_travelled_'.$rowCount,
                'required' => 'required',
                'maxlength' => 15,
                'class' => 'round2'));
            ?>

        </td>
        <td>
            <?php
            echo $this->Form->input("AssessmentVehicleDetail.$rowCount.vc_rate", array('label' => false,
                'div' => false,
                'type' => 'text',
                'id' => 'vc_rate_'.$rowCount,
                'required' => 'required',
                'maxlength' => 15,
                'class' => 'round2'));
            ?>

        </td>

        <td>
            <?php
            echo $this->Form->input("AssessmentVehicleDetail.$rowCount.vc_payable", array('label' => false,
                'div' => false,
                'type' => 'text',
                'id' => 'vc_payable_'.$rowCount,
                'maxlength' => 15,
                'required' => 'required',
                'class' => 'round2'));
            ?>

        </td>

        <td>
            <?php
            echo $this->Form->input("AssessmentVehicleDetail.$rowCount.vc_remarks", array('label' => false,
                'div' => false,
                'type' => 'text',
                'id' => 'vc_remarks_'.$rowCount,
                'maxlength' => 100,
                'class' => 'round2'));
            ?>

        </td>
        <td align="center">
            <?php
            echo $this->Form->button('Log', array(
                'label' => false,
                'type' => 'button',
                'div' => false,
                'rel' => "addlog$rowCount",
                'class' => 'round5'));
            ?>
<!--<input type="text" value="<?php echo $rowCount;?>" name="logbuttonid" id="logbuttonid">-->
        </td>
    </tr>


    <?php
}
?>