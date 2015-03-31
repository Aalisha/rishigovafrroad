<?php $currentUser = $this->Session->read('Auth'); ?>
<!-- Start wrapper here-->
<div class="wrapper">
    <!-- Start breadcrumb here-->
    <div class="breadcrumb">
        <ul>
            <li class="first">
                <?php echo $this->Html->link('Home', array('controller' => 'clients', 'action' => 'view', 'flr' => true), array('title' => 'Home', 'class' => 'vtip')) ?>
            </li>
            <li class="last">Claim Summary</li>
			 <li class="last clientnoclass" style=""  >Client No.&nbsp;:&nbsp;<?php echo ltrim($this->Session->read('Auth.Client.vc_client_no'),'01');?></li> 
        </ul>
    </div>
    <!-- end breadcrumb here-->
    <!-- Start mainbody here-->
    <div class="mainbody">
        <h1>Welcome to RFA FLR</h1>
        <h3>Claim Summary Report</h3>
        <!-- Start innerbody here-->
       
        <div class="innerbody">
            
			<table width="100%" border="0" cellpadding="3">
                <tr>
                    <td><label class="lab-inner">Client No. :</label></td>
                    <td>	
                        <?php
                        echo $this->Form->input(null, array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'disabled' => 'disabled',
                            'value' => ltrim($this->Session->read('Auth.Client.vc_client_no'),'01'),
                            'class' => 'round'));
                        ?>
                    </td>
                    <td><label class="lab-inner">Client Name :</label></td>
                    <td>	
                        <?php
                        echo $this->Form->input(null, array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'disabled' => 'disabled',
                            'value' => $currentUser['Client']['vc_client_name'],
                            'class' => 'round'));
                        ?>
                    </td>
                    <td><label class="lab-inner">Address 1 :</label></td>
                    <td>
                        <?php
                        echo $this->Form->input(null, array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'value' => $currentUser['Client']['vc_address1'],
                            'disabled' => 'disabled',
                            'class' => 'round'));
                        ?>
                    </td>

                </tr>
                <tr>
                    <td><label class="lab-inner">Address 2 :</label></td>
                    <td>
                        <?php
                        echo $this->Form->input(null, array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'value' => $currentUser['Client']['vc_address2'],
                            'disabled' => 'disabled',
                            'class' => 'round'));
                        ?>
                    </td>
                    <td><label class="lab-inner">Address 3 :</label></td>
                    <td>
                        <?php
                        echo $this->Form->input(null, array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'value' => $currentUser['Client']['vc_address3'],
                            'disabled' => 'disabled',
                            'class' => 'round'));
                        ?>
                    </td>
                    <td><label class="lab-inner">Tel. No. :</label></td>
                    <td>
                        <?php
                        echo $this->Form->input(null, array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'value' => $currentUser['Client']['vc_tel_no'],
                            'disabled' => 'disabled',
                            'class' => 'round'));
                        ?>
                    </td>
                </tr>

                <tr>
                    <td><label class="lab-inner">Fax No. :</label></td>
                    <td>
                        <?php
                        echo $this->Form->input(null, array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'value' => $currentUser['Client']['vc_fax_no'],
                            'disabled' => 'disabled',
                            'class' => 'round'));
                        ?>
                    </td>
                    <td><label class="lab-inner">Mobile No. :</label></td>
                    <td>
                        <?php
                        echo $this->Form->input(null, array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'value' => $currentUser['Client']['vc_cell_no'],
                            'disabled' => 'disabled',
                            'class' => 'round'));
                        ?>
                    </td>
                    <td><label class="lab-inner">Email :</label></td>
                    <td>
                        <?php
                        echo $this->Form->input(null, array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'value' => $currentUser['Client']['vc_email'],
                            'disabled' => 'disabled',
                            'class' => 'round'));
                        ?>

                    </td>

                </tr>

                <tr>
                    <td><label class="lab-inner">Refund % :</label></td>
                    <td>
                        <?php
                        echo $this->Form->input(null, array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'value' => $this->Session->read('Auth.ClientHeader.nu_refund'),
                            'disabled' => 'disabled',
                            'class' => 'round number-right'));
                        ?>
                    </td>
                    <td><label class="lab-inner">Contact Person :</label></td>
                    <td>
                        <?php
                        echo $this->Form->input(null, array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'value' => $currentUser['Client']['vc_contact_person'],
                            'disabled' => 'disabled',
                            'class' => 'round'));
                        ?>
                    </td>
                    <td><label class="lab-inner">Category :</label></td>
                    <td>
                        <?php
                        echo $this->Form->input(null, array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'value' => $currentUser['ClientHeader']['category'],
                            'disabled' => 'disabled',
                            'class' => 'round'));
                        ?>

                    </td>

                </tr>
            </table></div>
			<br/><br/>
			
		<h3>Search filter</h3>
		<div class="innerbody">
		<?php
        echo $this->Form->create('Report', array('url' => array('controller' => 'flrreports', 'action' => 'claimsummarys', 'flr' => true)));
        ?>
			<table width="100%" border="0" cellpadding="3">
			<tr>
                    <td width='14%'><label class="lab-inner">Claim From :</label></td>
                    <td width='20%'><span class="valuetext">
                            <?php
                            $fromDate = !empty($fromDate) ? date('d M Y', strtotime($fromDate)) : '';
                            echo $this->Form->input('Claimsummaryreport.fromDate', array('label' => false,
                                'div' => false,
                                'type' => 'text',
                                'readonly' => 'readonly',
                                'value' => $fromDate,
                                'class' => 'round'));
                            ?>
                        </span>
                    </td>
                    <td  width='14%'><label class="lab-inner">Claim To :</label></td>
                    <td><span class="valuetext">
                            <?php
                            $toDate = !empty($toDate) ? date('d M Y', strtotime($toDate)) : '';
                            echo $this->Form->input('Claimsummaryreport.toDate', array('label' => false,
                                'div' => false,
                                'type' => 'text',
                                'readonly' => 'readonly',
                                'value' => $toDate,
                                'class' => 'round'));
                            ?>
                        </span></td>
                    <td>&nbsp;</td>
                    <td label class="lab-inner" align="right" style="padding-right:25px;">
                        <?php echo $this->Form->submit('Submit', array('class' => 'submit', 'div' => false)); ?>

                    </td>

                </tr>
			</table>
			 <?php echo $this->Form->end(null); ?>
	</div>
            <br/><br/>
  <div class="innerbody">
            <?php echo $this->Form->create(array('url' => array('controller' => 'flrreports', 'action' => 'claimsummaryspdf', 'flr' => true))); ?>

            <table width="100%" border="0" cellpadding="3" class ="customersInfo">
                <tr>
                    <td width="10%"><label class="lab-inner">Client Name :</label></td>
                    <td width="10%">
                        <span class="valuetext">
                         <?php
                            echo wordwrap(ucfirst($currentUser['Client']['vc_client_name']), 25, "<br>\n", true);
                         ?>
                        </span>
                    </td>
                    <td width="10%"><label class="lab-inner">

                            <?php
                            if ($fromDate !== '' && !empty($fromDate)) {

                                $fromDate = date('d M Y', strtotime($fromDate));
                                ?>
                                Claim From :
                            <?php } ?>
                        </label>
                    </td>
                    <td width="10%"><span class="valuetext"><?php echo $fromDate; ?></span></td>
                    <td width="10%"><label class="lab-inner">
                            <?php
                            if ($toDate !== '' && !empty($toDate)) {

                                $toDate = date('d M Y', strtotime($toDate));
                                ?>
                                Claim To :
                            <?php } ?>
                        </label>
                    </td>
                    <td width="10%"><span class="valuetext"><?php echo $toDate; ?></span></td>
                    <td width="10%"  align="right" style="padding-right:25px;">
                        <?php
                        echo $this->Form->hidden('Claimsummaryreportpdf.fromDate', array('value' => $fromDate));
                        echo $this->Form->hidden('Claimsummaryreportpdf.toDate', array('value' => $toDate));
                        if (count($claimsummaryreport) > 0):
                            echo $this->Form->submit('Print Report', array(
                                'label' => false,
                                'type' => 'submit',
                                'div' => false,
                                'class' => 'submit'));
                        endif;
                        ?>
                    </td>
                </tr>
            </table>

            <?php echo $this->Form->end(null); ?>
			</div>
            <br />
			  <div class="innerbody">
            <table width="100%" cellspacing="1" cellpadding="5" border="0">
                <tr class="listhead1">
                    <td width="5%" align="center">SI. No.</td>
                    <td width="11%" align="center">System Claim No.</td>
                    <td width="11%" align="center"> Claim No.</td>
                    <td width="12%" align="center">Claim Date</td>
                    <td width="18%" align="center" colspan="2">Claim Period <br/>From - To</td>
                    <td width="10%" align="center">No. of invoice</td>
                    <td width="14%" align="center">Fuel Claimed (ltrs)</td>
                    <td width="10%" align="center">Claim Status</td>
                    <td width="18%" align="center">Amount (N$)</td>
                </tr>
                <?php
                $total_amount = 0;
                if (count($claimsummaryreport) > 0) {
                    $i = 1;
                    foreach ($claimsummaryreport as $val) {
                        ?>
                        <tr class="cont1">
                            <td align="center"><?php echo ((($pagecounter - 1) * ($limit)) + $i); ?></td>
                            <td align="left"><?php echo $val['ClaimHeader']['vc_claim_no']; ?></td>
                            <td align="left"><?php echo $val['ClaimHeader']['vc_party_claim_no']; ?></td>
                            <td align="left">
                                <?php
                                $claim_date = !empty($val['ClaimHeader']['dt_entry_date']) ?
                                        date('d M Y', strtotime($val['ClaimHeader']['dt_entry_date'])) : '';

                                echo $claim_date;
                                ?>
                            </td>
                            <td align="left">
                                <?php
                                $claim_from = !empty($val['ClaimHeader']['dt_claim_from']) ?
                                        date('d M Y', strtotime($val['ClaimHeader']['dt_claim_from'])) : '';

                                $claim_to = !empty($val['ClaimHeader']['dt_claim_to']) ?
                                        date('d M Y', strtotime($val['ClaimHeader']['dt_claim_to'])) : '';

                                echo $claim_from;
                                ?>

                            <td align="left">
                                <?php
                                $claim_from = !empty($val['ClaimHeader']['dt_claim_from']) ?
                                        date('d M Y', strtotime($val['ClaimHeader']['dt_claim_from'])) : '';

                                $claim_to = !empty($val['ClaimHeader']['dt_claim_to']) ?
                                        date('d M Y', strtotime($val['ClaimHeader']['dt_claim_to'])) : '';

                                echo $claim_to;
                                ?>
                            </td>
                            <td align="right"><?php echo count($val['ClaimDetail']); ?></td>
                            <td align="right">
                                <?php
                                $fuelcalimed = 0;
                                foreach($val['ClaimDetail'] as $key) {
                                    if($key['vc_status']!='STSTY05')
                                    $fuelcalimed = $fuelcalimed+$key['nu_litres'];
                                }
                                
                                //$fuelLiters = !empty($val['ClaimHeader']['nu_tot_litres'])? number_format($val['ClaimHeader']['nu_tot_litres'],'2','.',',') : number_format(0);
                               
                                $fuelLiters = !empty($fuelcalimed)? number_format($fuelcalimed,2,'.',',') : number_format(0,2,'.',',');
                                echo $fuelLiters;
                                ?>
                            </td>
                            <td align="left"><?php echo $globalParameterarray[$val['ClaimHeader']['vc_status']]; ?></td>
                            <td align="right">
                                <?php
                                if($val['ClaimHeader']['vc_status']!='STSTY05') {
                                    $Amount = !empty($val['ClaimHeader']['nu_tot_amount']) ?
                                        number_format($val['ClaimHeader']['nu_tot_amount'], '2', '.', ',') : number_format(0, '2', '.', '');
                                        echo $Amount;
                                } else {
                                    echo "0.00";
                                }
                                ?>
                            </td>
                        </tr>
                        <?php
                       if($val['ClaimHeader']['vc_status']!='STSTY05') {
                            $total_amount = $total_amount + $val['ClaimHeader']['nu_tot_amount'];
                        }
                        $i++;
                    }
                    
                    ?>

                    <tr style="background-color:#eee;">
                        <td colspan="9" style="text-align:right;" ><b>Total</b></td>
                        <td  style="text-align:right;"><b>
                            <?php
                            $sum = !empty($total_amount) ? number_format($total_amount, 2, '.', ',') : number_format(0, 2, '.', ',');
                            echo $sum;
                            ?></b>
                        </td>
                    </tr>
                <?php } else { ?>
                    <tr class="cont1" style='text-align: center;'>
                        <td colspan='10'> No Record Found !! </td>
                    </tr>
                <?php } ?>
            </table>
            <?php
            $this->Paginator->options(array(
                'url' => array(
                    'fromDate' => $fromDate,
                    'toDate' => $toDate
            )));

            if (count($claimsummaryreport) > 0) {

                echo $this->element('paginationfooter');
            }
            ?>


        </div>

        <!-- end mainbody here-->    

    </div>
</div>
    <!-- end wrapper here-->
    <?php echo $this->Html->script('flr/claimsummary'); ?>