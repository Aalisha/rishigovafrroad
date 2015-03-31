<?php $currentUser = $this->Session->read('Auth'); ?>
<?php //pr($this->Session->read('Auth')); die;  ?> 
<?php //pr($claimdetailreport); die;   ?>
<!-- Start wrapper here-->
<div class="wrapper">
    <!-- Start breadcrumb here-->
    <div class="breadcrumb">
        <ul>
            <li class="first">
                <?php echo $this->Html->link('Home', array('controller' => 'clients', 'action' => 'view', 'flr' => true), array('title' => 'Home', 'class' => 'vtip')) ?>
            </li>
            <li class="last">Claim Detail</li>   
 <li class="last clientnoclass" style=""  >Client No.&nbsp;:&nbsp;<?php echo ltrim($this->Session->read('Auth.Client.vc_client_no'),'01');?></li> 			
        </ul>
    </div>
    <!-- end breadcrumb here-->
    <!-- Start mainbody here-->
    <div class="mainbody">
        <h1>Welcome to RFA FLR</h1>
        <h3>Claim Detail Report</h3>
        <!-- Start innerbody here-->
        <?php
        echo $this->Form->create('Report', array('url' => array('controller' => 'flrreports', 'action' => 'claimdetails', 'flr' => true)));
        ?>
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
                            'value' =>  ltrim($this->Session->read('Auth.Client.vc_client_no'),'01'),
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
                        echo $this->Form->input('Claimdetailsreport.nu_refund', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'value' => $this->Session->read('Auth.ClientHeader.nu_refund'),
                            'disabled' => 'disabled',
                            'class' => 'round disabled-field number-right'));
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
			</table>
		</div>
		<h3>Search filter</h3>
		<div class="innerbody">
		<table width="100%" border="0" cellpadding="3">
                <tr>
                    <td><label class="lab-inner">Claim No. :</label></td>
                    <td>
                        <?php
                        echo $this->Form->input('Claimdetailsreport.vc_claim_no', array('label' => false,
                            'div' => false,
                            'type' => 'select',
                            'options' => array('' => 'Select') + $claimNumber,
                            'default' => $claimNo,
                            'class' => 'round_select'));
                        ?>
                    </td>
                    <td><label class="lab-inner">Claim Date :</label></td>
                    <td>
                        <?php

                        echo $this->Form->input('Claimdetailsreport.dt_entry_date', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'value' => $calaim_date,
                            'readonly' => 'readonly',
                            'class' => 'round disabled-field'));
                        ?>
                    </td>
                    <td><label class="lab-inner">Claim Status :</label></td>
                    <td>
                        <?php
                        echo $this->Form->input('Claimdetailsreport.vc_status', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'value' => $claim_status,
                            'readonly' => 'readonly',
                            'class' => 'round disabled-field'));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><label class="lab-inner">Claim From :</label></td>
                    <td><span class="valuetext">
                            <?php
                            $fromDate = !empty($fromDate) ? date('d M Y', strtotime($fromDate)) : '';
                            echo $this->Form->input('Claimdetailsreport.fromDate', array('label' => false,
                                'div' => false,
                                'type' => 'text',
                                'readonly' => 'readonly',
                                'value' => $fromDate,
                                'class' => 'round'));
                            ?>
                        </span>
                    </td>
                    <td><label class="lab-inner">Claim To :</label></td>
                    <td><span class="valuetext">
                            <?php
                            $toDate = !empty($toDate) ? date('d M Y', strtotime($toDate)) : '';
                            echo $this->Form->input('Claimdetailsreport.toDate', array('label' => false,
                                'div' => false,
                                'type' => 'text',
                                'readonly' => 'readonly',
                                'value' => $toDate,
                                'class' => 'round'));
                            ?>
                        </span></td>
                    <td>&nbsp;</td>
                    <td label class="lab-inner" align="left" style="padding-right:25px;">
                        <?php echo $this->Form->submit('Submit', array('class' => 'submit','div'=>false)); ?>
                    </td>
                </tr>
            </table>		
            <?php echo $this->Form->end(null); ?>
            <br/><br/><!--<br/><br/><br/>-->
            <?php echo $this->Form->create(array('url' => array('controller' => 'flrreports', 'action' => 'claimdetailspdf', 'flr' => true))); ?>
            <table width="100%" border="0" cellpadding="0" class ="customersInfo">
                <tr>
                    <td width="10%"><label class="lab-inner">Client Name :</label></td>
                    <td width="10%"><span class="valuetext">
                        <?php
                        echo wordwrap(ucfirst($currentUser['Client']['vc_client_name']), 25, "<br>\n", true);
                        ?>
                        </span></td>
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
                    <td width="7%"><span class="valuetext"><?php echo $toDate; ?></span></td>
                    <td width="13%"  align="left" style="padding-right:25px;">
                        <?php
                        echo $this->Form->hidden('Claimdetailsreportpdf.fromDate', array('value' => $fromDate));
                        echo $this->Form->hidden('Claimdetailsreportpdf.toDate', array('value' => $toDate));
                        echo $this->Form->hidden('Claimdetailsreportpdf.claimNo', array('value' => $claimNo));
                        if (count($claimdetailreport) > 0):
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
		<div class="innerbody">
            <table width="100%" cellspacing="1" cellpadding="5" border="0">
                <tr class="listhead1">
                    <td width="5%" align="center">SI. No.</td>
                    <td width="9%" align="center">System Claim No.</td>
                    <td width="9%" align="center"> Claim No.</td>
                    <td width="9%" align="center">Invoice No.</td>
                    <td width="9%" align="center">Invoice Date</td>
                    <td width="9%" align="center">Fuel Outlet</td>
                    <td width="9%" align="center">Fuel Volume (ltrs)</td>
                    <td width="9%" align="center">Refund Rate</td>
                    <td width="9%" align="center">Invoice Status</td>
                    <td width="9%" align="center">Reason for <br/>rejection</td>
                    <td width="9%" align="center">Amount (N$)</td>
					<!--<td width="9%" align="center">Erp Claim No.</td>-->
					
					
                </tr>
                <?php
											//	pr($claimdetailreport);

                $total_amount = 0;
				$total_liters = 0;
                if (count($claimdetailreport) > 0) {
                    $i = 1;
                    foreach ($claimdetailreport as $claims) {
                        ?>
                        <tr class="cont1">
                            <td align="center"><?php echo ((($pagecounter - 1) * ($limit)) + $i); ?></td>
                            <td align="left"><?php echo $claims['ClaimHeader']['vc_claim_no'] ?></td>
                            <td align="left"><?php echo $claims['ClaimHeader']['vc_party_claim_no']; ?></td>
                            <td align="left"><?php echo $claims['ClaimDetail']['vc_invoice_no'] ?></td>
                            <td align="left">
                                <?php
                                $invoice_date = !empty($claims['ClaimDetail']['dt_invoice_date']) ?
                                        date('d M Y', strtotime($claims['ClaimDetail']['dt_invoice_date'])) :
                                        '';
                                echo $invoice_date;
                                ?>
                            </td>
                            <td align="left">
                                <?php echo $claims['ClaimDetail']['vc_outlet_code']; ?>
                            </td>
                            <td align="right"><?php echo number_format($claims['ClaimDetail']['nu_litres'],2,'.',','); ?></td>
                            <td align="right"><?php echo number_format($claims['ClaimDetail']['nu_refund_rate'], 3); ?></td>
                            <td align="left"><?php echo $globalParameterarray[$claims['ClaimDetail']['vc_status']]; ?></td>
                            <td align="left"><?php echo $claims['ClaimDetail']['vc_reasons']; ?></td>

                            <td align="right"><?php echo number_format($claims['ClaimDetail']['nu_amount'], 2, '.', ','); ?></td>
							<!--<td align="left"><?php echo $claims['ClaimHeader']['vc_claim_no_erp'] ?></td>-->
                        </tr>
                        <?php
                        $total_amount = $total_amount + $claims['ClaimDetail']['nu_amount'];
                        $i++;
						$total_liters= $total_liters + $claims['ClaimDetail']['nu_litres'];
						
                    }
                    ?>
					
                    <tr style="background-color:#eee;">
                        <td colspan="6" style="text-align:right;" ><b>Total Litres</b></td>
						<td  style="text-align:right;">  
                            <b><?php
                            $sum1 = !empty($total_liters) ? number_format($total_liters, 2, '.', ',') : number_format(0, 2, '.', ',');
                            echo $sum1;
                            ?></b>
                        </td>
					  <td  style="text-align:right;" >&nbsp;</td>
                  	
						<td colspan="2" style="text-align:right;" ><b>Total</b></td>
                        <td colspan="1" style="text-align:right;">  <b>
                            <?php
                            $sum = !empty($total_amount) ? number_format($total_amount, 2, '.', ',') : number_format(0, 2, '.', ',');
                            echo $sum;
                            ?></b>
                        </td>
                       
					</tr>

                <?php } else { ?>
                    <tr class="cont1" style='text-align: center'>
                        <td colspan='11'> No Record Found!!  </td>
                    </tr>
                <?php } ?>
            </table>
            <?php
            $this->Paginator->options(array(
                'url' => array(
                    'fromDate' => $fromDate,
                    'toDate' => $toDate,
                    'toDate' => $toDate,
					'claim_status'=>$claim_status,
					'calaim_date'=>$calaim_date,
					'claimNo'=>$claimNo,
            )));

            if (count($claimdetailreport) > 0) {
                echo $this->element('paginationfooter');
            }
            ?>

        </div>
        <!-- end mainbody here-->    
    </div>
</div>
<!-- end wrapper here-->
<?php echo $this->Html->script('flr/claimdetails'); ?>