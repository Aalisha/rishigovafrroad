<?php $currentUser = $this->Session->read('Auth'); ?>

        <div class="wrapper">
         <!-- Start breadcrumb here-->
            <div class="breadcrumb">
                <ul>
                <li class="first">
                 <?php echo $this->Html->link('Home', array('controller' =>
        'customers', 'action' => 'view','cbc' =>true), array('title' => 'Home',
        'class' => 'vtip')) ?>

                </li>

                <li class="last">Refund Request</li>
                </ul>
           </div>
        <!-- Start mainbody here-->
            <div class="mainbody">
            <h1>Welcome to RFA CBC</h1>
            <h3>Refund Request</h3>
            <!-- Start innerbody here-->

            <div class="innerbody">
            <table width="100%" border="0" cellpadding="3">
              <tr>
                <td width="15%" align="left" valign="top"><label class="lab-inner">Customer Name :</label></td>

               <td width="20%" align="left" valign="top">
                        <?php echo $this->Form->input('vc_customer_name',
        array('label' =>false,
             'div'=>false,
             'value' =>$currentUser['Customer']['vc_first_name'] . ' ' .
        $currentUser['Customer']['vc_surname'],
             'type' => 'text',
             'disabled'=>'disabled',
             'class'=>'round'));
                        ?>
                    </td>

                <td width="15%" align="left" valign="top"><label class="lab-inner">Address 1 :</label></td>
                <td width="20%" align="left" valign="top">
                        <?php echo $this->Form->input('vc_address1',
        array('label' =>false,
        'div'=>false,
        'type' => 'text',
        'value' => $res['Customer']['vc_address1'],
        'disabled'=>'disabled',
        'class'=>'round'));
                        ?>
                    </td>

                <td width="15%" align="left" valign="top"><label class="lab-inner">Address 2 :</label></td>
                <td width="15%" align="left" valign="top">
                        <?php echo $this->Form->input('vc_address2',
        array('label' =>false,
        'div'=>false,
        'type' => 'text',
        'value' =>$res['Customer']['vc_address2'],
        'disabled'=>'disabled',
        'class'=>'round'));
                        ?>
                    </td>

                </tr>
                <tr>
                <td width="15%" align="left" valign="top"><label class="lab-inner">Address 3 :</label></td>

                <td width="20%" align="left" valign="top">
                        <?php echo $this->Form->input('vc_address3',
        array('label' =>false,
        'div'=>false,
        'type' => 'text',
        'value' =>$res['Customer']['vc_address3'],
        'disabled'=>'disabled',
        'class'=>'round'));
                        ?>
                    </td>


                <td width="15%" align="left" valign="top"><label class="lab-inner">Telephone No. :</label></td>

                <td width="20%" align="left" valign="top">
                        <?php echo $this->Form->input('vc_tel_no',
        array('label' =>false,
        'div'=>false,
        'type' => 'text',
        'value' => $res['Customer']['vc_tel_no'],
        'disabled'=>'disabled',
        'class'=>'round'));
                        ?>
                    </td>

                <td width="15%" align="left" valign="top"><label class="lab-inner">Fax No. :</label></td>
                <td width="15%" align="left" valign="top">
                        <?php echo $this->Form->input('vc_fax_no',
        array('label' =>false,
        'div'=>false,
        'type' => 'text',
        'value' =>$res['Customer']['vc_fax_no'],
        'disabled'=>'disabled',
        'class'=>'round'));
                        ?>
                    </td>
                    </tr>
                    <tr>
                      <td width="15%" align="left" valign="top"><label class="lab-inner">Email :</label></td>

                        <td width="20%" align="left" valign="top">
                        <?php echo $this->Form->input('vc_email_id',
        array('label' =>false,
        'div'=>false,
        'type' => 'text',
        'value' =>$currentUser['Customer']['vc_email'],
        'disabled'=>'disabled',
        'class'=>'round'));
                        ?>
                    </td>


                      <td width="15%" align="left" valign="top"><label class="lab-inner">Mobile No. :</label></td>

                   <td width="20%" align="left" valign="top">
                        <?php echo $this->Form->input('vc_mobile_no',
        array('label' =>false,
        'div'=>false,
        'type' => 'text',
         'value' => $res['Customer']['vc_mobile_no'],
        'disabled'=>'disabled',
        'class'=>'round'));
                        ?>
                    </td>

                      <td width="15%" align="left" valign="top"><label class="lab-inner">Account Balance.(N$) :</label></td>
                      <td width="15%" align="left" valign="top">
                        <?php
                        echo $this->Form->input('vc_account_balance',
        array('label' =>false,
               'div'=>false,
               'type' => 'text',
               'value' =>number_format($accountbalance, 2, '.', ','),
               'disabled'=>'disabled',
               'class'=>'number-right round'));
                        ?>
                    </td>
                    </tr>
                    <tr>
                      <td width="15%" align="left" valign="top">&nbsp;</td>
                      <td width="20%" align="left" valign="top">&nbsp;</td>
                      <td width="15%" align="left" valign="top">&nbsp;</td>
                      <td width="20%" align="left" valign="top">&nbsp;</td>
                      <td width="15%" align="left" valign="top">&nbsp;</td>
                      <td width="15%" align="left" valign="top">&nbsp;</td>
                    </tr>
            </table>

            <table width="100%" border="0" cellpadding="0">
              <tr>
                <td width="34%" align="left" valign="top">
                 <?php echo $this->Form->create('CardRefund',array('url' =>array('controller' => 'cards','action' =>'refund_request','cbc'=>true))); ?>
                    <table width="100%" border="0" cellspacing="1" cellpadding="3">
                  <tr class="listhead">
                    <td colspan="2" align="center">Refund</td>
                    </tr>
                  <tr>
                    <td width="43%" align="left" valign="top"><label
        class="lab-inner">Refund :</label></td>

                    <td width="57%" align="left" valign="top">
                        <?php echo $this->Form->input('vc_refund',array('label' =>false,
     'div'=>false,
     'type' => 'text',
     'value' =>'Refund',
     'disabled'=>'disabled',
     'required'=>'required',
     'class'=>'round'));
                        ?>
                        <?php echo $this->Form->input('ch_type', array('label'=>false,
     'div'=>false,
     'type' => 'hidden',
     'value'=>'refund'));
                        ?>
                    </td>
                    </tr>
                  <tr>
                    <td width="43%" align="left" valign="top"><label class="lab-inner">Account Balance(N$):</label></td>
                    <td width="57%" align="left" valign="top">
                        <?php echo $this->Form->input('vc_account_balance',array('label' =>false,
               'div'=>false,
               'type' => 'text',
               'disabled'=>'disabled',
               'value'=> $accountbalance,
               'required'=>'required',
               'class'=>'number-right round'));
                        ?>
                    </td>
                    </tr>
                  <tr>
                    <td width="43%" align="left" valign="top"><label class="lab-inner">Refund Charges(N$):</label></td>
                    <td width="57%" align="left" valign="top">
                        <?php echo $this->Form->input('vc_refund_charges',
						array('label' =>false,
						'div'=>false,
						'type' => 'text',
						'disabled'=>'disabled',
						'required'=>'required',
						'value'=>number_format($globalParameterarray['CBCADMINFEE'], 2, '.', ','),
						'class'=>'number-right round'));
                        ?>
                    </td>
                    </tr>
                  <tr>
                    <td  width="43%" align="left" valign="top"><label class="lab-inner">Net Refundable(N$):</label></td>
                  <td width="57%" align="left" valign="top">
                  <?php
                  if(empty($accountbalance)){
                  ?>

                  <?php echo $this->Form->input('vc_net_refundable',array('label' =>false,
       'div'=>false,
       'type' => 'text',
	   'disabled'=>'disabled',
       'required'=>'required',
       'value'=>number_format($accountbalance, 2, '.', ','),
       'class'=>'number-right round'));

                  }
                  else{

                  ?>
                        <?php echo $this->Form->input('vc_net_refundable',array('label' =>false,
             'div'=>false,
             'type' => 'text',
             'disabled'=>'disabled',
             'required'=>'required',
             'value'=>number_format($accountbalance - $globalParameterarray['CBCADMINFEE'], 2, '.', ','),

              'class'=>'number-right round' ));
                    }    ?>
                    </td>
                    </tr>
                    <tr>
                    <td width="43%" align="left" valign="top">&nbsp;</td>
                    <td width="57%" align="left" valign="top">
                </tr>
                <tr>
                <td width="43%" align="left" valign="top">&nbsp;</td>
                    <td width="57%" align="left" valign="top">
                </tr>
                <tr>
                    <td width="43%" align="left" valign="top">&nbsp;</td>
                    <td width="57%" align="left" valign="top">


                                <?php echo
 $this->Form->submit('Submit',array('type'=>'submit',
	'id'=>'accountrefundID',
 'class'=>'submit','value'=>'submit'));
        ?>


                       </td>
                  </tr>
                </table>
              <?php echo $this->Form->end(); ?>
                </td>
                <td width="34%" align="left" valign="top">

           <?php echo
 $this->Form->create('CbcRefund',array('url'=>array('controller'=>'cards','action'=>'refund_request','cbc'=>true)));
        ?>

                   <table width="100%" border="0" cellspacing="1" cellpadding="3">
                  <tr class="listhead">
                    <td colspan="2" align="center">CBC Refund</td>
                  </tr>
                  <tr>
                    <td width="44%" height='21px' align="left" valign="top"><label class="lab-inner">CBC Permit No.:</label></td>
                    <td width="56%" height=' 21px' align="left" valign="top" >
                        <?php echo $this->Form->input('vc_permit_no',array('label' =>false,
          'div'=>false,
          'type' => 'text',
          'maxlength'=>20,
          'class'=>'round'));
                        ?>
                        <?php echo $this->Form->input('ch_type', array('label'=>false,
      'div'=>false,
      'type' => 'hidden',
      'value'=>'cbc'));
                        ?>
                    </td>
                  </tr>
                  <tr>
                    <td width="44%" height='21px' align="left" valign="top" ><label class="lab-inner">CBC Amount(N$)
        :</label></td>
                    <td width="56%" height='21px' align="left" valign="top" >
                        <?php echo $this->Form->input('nu_permit_amt',array('label' =>false,
         'div'=>false,
         'maxlength'=>12,
         'type' => 'text',
         'class'=>'number-right round'));
                        ?>
            </td>
                  </tr>
                  <tr>
                    <td width="44%" height='21px' align="left" valign="top" ><label class="lab-inner">Reason :</label></td>
                  <td width="56%" height='21px' align="left" valign="top" >
                        <?php echo $this->Form->input('vc_reason',array('label' =>false,
     'div'=>false,
     'type' => 'text',
     'maxlength'=>150,
     'class'=>'round'));
                        ?>
                    </td>
                  </tr>
                  <tr>
                    <td width="44%" height='21px' align="left" valign="top" ><label class="lab-inner">Status :</label></td>
                        <td width="56%" height='21px' align="left" valign="top" >
                        <?php echo $this->Form->input('vc_cbc_status',array('label' =>false,
         'div'=>false,
         'type' => 'text',
         'value' => $globalParameterarray['STSTY03'],
         'disabled' => 'disabled',
         'class'=>'round'));
                        ?>
                    </td>

                  </tr>
                  <tr>
                    <td width="44%" align="left" valign="top">&nbsp;</td>
                    <td width="56%" align="left" valign="top">
                </tr>
                 <tr>
                    <td width="44%" align="left" valign="top">&nbsp;</td>
                    <td width="56%" align="left" valign="top">
                </tr>
                <tr>
                    <td width="44%" align="left" valign="top">&nbsp;</td>
                    <td width="56%" align="left" valign="top">
                </tr>
                <tr>
                <td width="44%" align="left" valign="top">&nbsp;</td>
                    <td width="56%" align="left" valign="top">

                <?php echo
 $this->Form->submit('Submit',array('type'=>'submit',
 'id'=>'cbcrefundID',
 'class'=>'submit','value'=>'submit'));
        ?>

                    </td>
                  </tr>
                </table>
              <?php echo $this->Form->end(); ?>
                </td>
                <td width="32%" align="left" valign="top">

         <?php echo $this->Form->create('MdcRefund',array('url'=>array('controller'=>'cards','action'=>'refund_request','cbc'=>true),'type' => 'file'));
            ?>

                    <table width="100%" border="0" cellspacing="1" cellpadding="3">
                  <tr class="listhead">
                    <td colspan="2" align="center">MDC Foreign Refund</td>
                  </tr>
                  <tr>
                    <td width="48%" height = '23px' align="left" valign="top" ><label class="lab-inner">MDC Permit No.:</label></td>
                   <td width="52%" height = '23px' align="left" valign="top" >
                        <?php echo $this->Form->input('vc_permit_no',array('label' =>false,
              'div'=>false,
              'type' => 'text',
              'maxlength'=>20,
              'class'=>'round'));
                        ?>

                        <?php echo $this->Form->input('ch_type', array('label'=>false,
     'div'=>false,
     'type' => 'hidden',
     'value'=>'mdc',
     ));
                        ?>
                    </td>

                  </tr>
                  <tr>
                    <td width="48%" height = '23px' align="left" valign="top"><label class="lab-inner">MDC Amount(N$)
        :</label></td>
                    <td width="52%" height = '23px' align="left" valign="top" >
                        <?php echo $this->Form->input('nu_permit_amt',
        array('label' =>false,
        'div'=>false,
        'type' => 'text',
        'maxlength'=>12,
        'class'=>'number-right round'));
                        ?>
                    </td>
                    </tr>
                  <tr>
                    <td width="48%" height = '23px' align="left" valign="top" ><label class="lab-inner">Reason :</label></td>
                   <td width="52%" height = '23px' align="left" valign="top" >
                        <?php echo $this->Form->input('vc_reason',array('label' =>false,
     'div'=>false,
     'type' => 'text',
     'maxlength'=>150,
     'class'=>'round'));
                        ?>
                    </td>
                  </tr>
                  <tr>
                    <td width="48%" height = '22px' align="left" valign="top" ><label class="lab-inner">Status :</label></td>
                   <td width="52%" height = '22px' align="left" valign="top" >
                        <?php echo $this->Form->input('vc_cbc_status',array('label' =>false,
         'div'=>false,
         'type' => 'text',
         'value' => $globalParameterarray['STSTY03'],
         'disabled' => 'disabled',
         'class'=>'round'));
                        ?>
                    </td>
                  </tr>
                    <tr>
                    <td width="48%" height = '22x' align="left" valign="top" ><label class="lab-inner">Destination :</label></td>
                   <td width="52%" height = '22px' align="left" valign="top">
                        <?php echo $this->Form->input('vc_destination',array('label' =>false,
         'div'=>false,
         'type' => 'text',
         'required' => 'required',
         'maxlength' => 50,
         'class'=>'round'));
                        ?>
                    </td>
                  </tr>
                  <tr>
                    <td width="48%" height = '22px' align="left" valign="top"><label class="lab-inner">Upload Doc. :</label></td>
                    <td height = '22px' colspan="2" align="left" valign="top">

                       <?php echo $this->Form->input('DocumentUploadCbc.vc_upload_doc_name', array('label' => false,
     'div' => false,
     'type' => 'file',
     'required' => 'required',
     'class' => 'uploadfile'));
                            ?>
                        </td>
                        </tr>



                  <tr>
                    <td width="48%" height = '22px' align="left" valign="top" >&nbsp;</td>
                    <td width="52%" height = '22px' align="left" valign="top">

                        <?php echo
 $this->Form->submit('Submit',array('type'=>'submit',
 'name'=>'mdcrefund',
 'id'=>'mdcrefundID',
 'class'=>'submit','value'=>'submit'));
        ?>

                </td>
                  </tr>
                </table>
                <?php echo $this->Form->end(); ?>
                </td>
                </tr>
              </table>
            </div>

            </div>
             <!-- end mainbody here-->
        </div>
		<?php echo $this->element('commonmessagepopup'); ?>
        <?php echo $this->Html->script('cbc/cbcrefund'); ?>
        <?php echo $this->Html->script('cbc/mdcrefund') ; ?>
        <?php echo $this->Html->script('cbc/accountrefund'); ?>
        
        <!-- end wrapper here--> 