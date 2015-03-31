<?php $currentUser = $this->Session->read('Auth'); ?>
<?php //pr($claimslist); die;       ?>
<!-- Start wrapper here-->
<div class="wrapper">
    <!-- Start breadcrumb here-->
    <div class="breadcrumb">
        <ul>
            <li class="first">
                <?php echo $this->Html->link('Home', array('controller' => 'clients', 'action' => 'view', 'flr' => true), array('title' => 'Home', 'class' => 'vtip')) ?>
            </li>
            <li class="last">Supplier Imported  data</li>    <li class="last clientnoclass" style=""  >Client No.&nbsp;:&nbsp;<?php echo ltrim($this->Session->read('Auth.Client.vc_client_no'),'01');?></li>      
        </ul>
    </div>
    <!-- end breadcrumb here-->
    <!-- Start mainbody here-->
    <div class="mainbody">
        <h1>Welcome to RFA FLR</h1>
        <h3>View Imported data</h3>
        <!-- Start innerbody here-->
        <?php echo $this->Form->create(null);
        ?>
          <!--<div class="innerbody">
          <table width="100%" border="0" cellpadding="3">
                <tr>
                    <td><label class="lab-inner1">Client Name :</label></td>
                    <td>
                        <?php
                        echo $this->Form->input('ClaimHeader.vc_client_name', array('label' => false,
                            'div' => false,
                            'disabled' => 'disabled',
                            'type' => 'text',
                            'value' => $currentUser['Client']['vc_client_name'],
                            'class' => 'round'));
                        ?>
                    </td>

                    <td valign="top"><label class="lab-inner">Branch Code :</label></td>
                    <td valign="top">
                        <?php
                        echo $this->Form->input('ClaimHeader.vc_branch_code', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'disabled' => 'disabled',
                            'value' => $currentUser['ClientBank']['vc_branch_code'],
                            'class' => 'round'
                        ));
                        ?>

                    </td>
                    <td valign="top"><label class="lab-inner">Bank A/C No :</label></td>
                    <td valign="top">
                        <?php
                        echo $this->Form->input('ClaimHeader.vc_account_number', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'disabled' => 'disabled',
                            'value' => $currentUser['ClientBank']['vc_bank_account_no'],
                            'class' => 'round'
                        ));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td valign="top"><label class="lab-inner">Mobile No :</label></td>
                    <td valign="top">
                        <?php
                        echo $this->Form->input('ClaimHeader.vc_cell_no', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'disabled' => 'disabled',
                            'value' => $currentUser['Client']['vc_cell_no'],
                            'class' => 'round'
                        ));
                        ?>
                    </td>
                    <td valign="top"><label class="lab-inner">A/C Holder Name :</label></td>
                    <td valign="top">
                        <?php
                        echo $this->Form->input('ClaimHeader.vc_account_holder', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'disabled' => 'disabled',
                            'value' => $currentUser['ClientBank']['vc_account_holder_name'],
                            'class' => 'round'
                        ));
                        ?>
                    </td>
                    <td><label class="lab-inner1">Email :</label></td>
                    <td>
                        <?php
                        echo $this->Form->input('ClaimHeader.email_id', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'disabled' => 'disabled',
                            'value' => $currentUser['Member']['vc_email_id'],
                            'class' => 'round'));
                        ?>
                    </td>


                </tr>
                <tr>
                    <td valign="top"><label class="lab-inner">Bank Name :</label></td>

                    <td valign="top">
                        <?php
                        echo $this->Form->input('ClaimHeader.vc_bank_name', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'disabled' => 'disabled',
                            'value' => $currentUser['ClientBank']['vc_bank_name'],
                            'class' => 'round'
                        ));
                        ?>
                    </td>

                    <td valign="top"><label class="lab-inner">Client Category :</label></td>
                    <td valign="top">
                        <?php
                        echo $this->Form->input('ClaimHeader.vc_cagegory', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'disabled' => 'disabled',
                            'value' => $currentUser['ClientHeader']['category'],
                            'class' => 'round'
                        ));
                        ?>   
                    </td>
                    <td valign="top"><label class="lab-inner">Client No.:</td>
                
                    <td valign="top"><?php echo ltrim($this->Session->read('Auth.Client.vc_client_no'),'01');?>
					</td>
                </tr>
            </table>
        </div>-->

        <div id='divnewajaxid' class="innerbody">
            <table width="100%" cellspacing="1" cellpadding="5" border="0">
                <tr class="listhead1">
                    <td width="5%" align="center">SI. No.</td>
                    <td width="11%" align="center">Supplier  No.</td>
                    <td width="12%" align="center">Sold To</td>
                    <td width="12%" align="center">Invoice No.</td>
                    <td width="12%" align="center">Invoice Date</td>
                    <td width="12%" align="center">Litres</td>
                    <td width="12%" align="center">Amount</td>
                    <td width="12%" align="center">Date</td>
                    
                </tr>
                <?php
                if (count($invoiceuploaded) > 0) {
                    $i = 1;

                    foreach ($invoiceuploaded as $index => $details) {
                        ?>
                        <tr class="cont1">
                            <td align="center"><?php echo $index + 1; ?></td>
                            <td align="left">
                                <?php echo $details['Supplier']['vc_supplier_no']; ?>
                            </td>
                            <td align="left">					
                                <?php
                                echo $details['Supplier']['vc_sold_to'];
                                ?>
                            </td>
                            <td align="left">
                                <?php
                                echo ucfirst($details['Supplier']['vc_invoice_no']);
                                ?></td>
                            <td align="left">
                                <?php
                              //  echo $details['Supplier']['dt_invoice_date'];
								echo date('d M Y', strtotime($details['Supplier']['dt_invoice_date']));
                                ?>
                            </td>


                            <td align="right">
                                <?php
                                 echo number_format($details['Supplier']['nu_liters'], 2, '.', ','); 
								
                                ?>
                            </td>
                           <td align="right">
                                <?php
								echo number_format($details['Supplier']['nu_amount'], 2, '.', ','); 
                                ?></td>
                            <td align="left"><?php
                               
                                    echo date('d M Y', strtotime($details['Supplier']['dt_created_date']));
                                ?></td>
                           
                        </tr>
                        <?php
                        $i++;
                    }
                } else {
                    ?>

                    <tr class="cont1" style='text-align: center'>
                        <td colspan='9'> No Record Found  </td>
                    </tr>
                    <?php
                }
                if (count($invoiceuploaded) > 0) {
                    echo $this->element('paginationfooter');
                }
                ?>

            </table>

        </div>
        <!-- end mainbody here-->  
    </div>
    <!-- end mainbody here-->    
</div>
<!-- end wrapper here-->

