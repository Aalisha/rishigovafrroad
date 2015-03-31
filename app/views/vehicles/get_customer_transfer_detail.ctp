<table width="100%" cellspacing="1" cellpadding="5" border="0" >

    <?php 
	if (count($data) > 0) : ?>

        <?php
        $i = 0;
        foreach ($data as $values) :

            $i++;

            $str = ( $i % 2 == 0 ) ? '' : '1';
            ?>

            <tr class="cont<?php echo $str ?>"> 

                <td  width="10%" > <input type='radio' name='getCustomerTransfer' value='<?php echo trim($values['Company']['nu_company_id']); ?>' /> </td>

                <td width="50%" align="left"><?php echo trim($values['Company']['vc_customer_name']); ?></td>

                <td width="30%"><?php echo trim($values['Company']['vc_customer_no']); ?></td>
                <td width="30%"><?php echo trim($values['Company']['vc_company_name']); ?></td>

            </tr>



        <?php endforeach; ?>

    <?php else : ?>

        <tr class="cont1">

            <td width="100%" colspan='3' align="center"> No Record Found </td>

        </tr>

    <?php endif; ?>

</table>