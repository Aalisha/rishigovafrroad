<!-- Start wrapper here-->
<div class="wrapper">
 <!-- Start breadcrumb here-->
    <div class="breadcrumb">
        <ul>
        <li class="first">
			 <?php echo $this->Html->link('Home', array('controller' => 'clients', 'action' => 'view','flr' =>true), array('title' => 'Home', 'class' => 'vtip')) ?>
        </li>
        
        <li class="last">Bank Details Changes</li>    <li class="last clientnoclass" style=""  >Client No.&nbsp;:&nbsp;<?php echo ltrim($this->Session->read('Auth.Client.vc_client_no'),'01');?></li>    
        </ul>
   </div>
<!-- end breadcrumb here-->
<!-- Start mainbody here-->
    <div class="mainbody">
    <h1>Welcome to RFA FLR</h1>
    <h3>Client Bank Details</h3>
    <!-- Start innerbody here-->
	<?php echo $this->Form->create(array('url' => array('controller' => 'clients', 'action' => 'bankdetailschanges','flr'=>true),'type' => 'file')); ?>
    <div class="innerbody">
      <table width="100%" border="0" cellpadding="3">
        <tr>
        <td width="15%" align="left" valign="top"><label class="lab-inner">Business Reg. Id :</label></td>
        <td width="18%" align="left" valign="top">
			<?php
				echo $this->Form->input(null, array('label' => false,
																	'div' => false,
																	'type' => 'text',
																	'name'=>false,
																	'id'=>false,
																	'value'=>$this->Session->read('Auth.Client.vc_id_no'),
																	'disabled'=>'disabled',
																	'class' => 'round'));
			?>
		</td>
        <td width="15%" align="left" valign="top"><label class="lab-inner">Client Name :</label></td>
        <td width="21%" align="left" valign="top">
			<?php
				echo $this->Form->input(null, array('label' => false,
																	'div' => false,
																	'type' => 'text',
																	'name'=>false,
																	'id'=>false,
																	'value'=>$this->Session->read('Auth.Client.vc_client_name'),
																	'disabled'=>'disabled',
																	'class' => 'round'));
			?>
		</td>
        <td width="16%" align="left" valign="top"><label class="lab-inner">Contact Person :</label></td>
        <td width="15%" align="left" valign="top">
			<?php
				echo $this->Form->input(null, array('label' => false,
																	'div' => false,
																	'type' => 'text',
																	'id'=>false,
																	'name'=>false,
																	'value'=>$this->Session->read('Auth.Client.vc_contact_person'),
																	'disabled'=>'disabled',
																	'class' => 'round'));
			?>
		</td>
      </tr>
        <tr>
          <td align="left" valign="top"><label class="lab-inner">Email Id :</label></td>
          <td align="left" valign="top">
			<?php
				echo $this->Form->input(null, array('label' => false,
																	'div' => false,
																	'type' => 'text',
																	'id'=>false,
																	'name'=>false,
																	'value'=>$this->Session->read('Auth.Client.vc_email'),
																	'disabled'=>'disabled',
																	'class' => 'round'));
			?>
		  </td>
          <td align="left" valign="top"><label class="lab-inner">Mobile Number :</label></td>
          <td align="left" valign="top">
			<?php
				echo $this->Form->input(null, array('label' => false,
																	'div' => false,
																	'type' => 'text',
																	'name'=>false,
																	'id'=>false,
																	'value'=>$this->Session->read('Auth.Client.vc_cell_no'),
																	'disabled'=>'disabled',
																	'class' => 'round'));
			?>
		  </td>
          <td align="left" valign="top"><!--Client No.-->&nbsp;</td>
          <td align="left" valign="top"><?php // echo $this->Session->read('Auth.Client.vc_client_no');?>&nbsp;</td>
        </tr>
     
      </table>
    <br>
      <table width="100%" border="0" cellpadding="3">
      <tr class="listhead">
        <td colspan="2" align="center">Current Bank Details</td>
        <td colspan="2" align="center">New Bank Details</td>
      </tr>
      <tr>
        <td width="20%">&nbsp;</td>
        <td width="30%">&nbsp;</td>
        <td width="20%">&nbsp;</td>
        <td width="30%">&nbsp;</td>
      </tr>
      <tr>
        <td><label class="lab-inner1">Account Holder Name :</label></td>
        <td>
			<?php
				echo $this->Form->input(null, array('label' => false,
																		'div' => false,
																		'type' => 'text',
																		'name'=>false,
																		'id'=>false,
																		'maxlength'=>100,
																		'value'=>$this->Session->read('Auth.ClientBank.vc_account_holder_name'),
																		'disabled'=>'disabled',
																		'class' => 'round'));
			?>
		</td>
        <td><label class="lab-inner1">Account Holder Name :</label></td>
        <td>
			<?php
				echo $this->Form->input('ClientBank.vc_account_holder_name', array('label' => false,
																		'div' => false,
																		'type' => 'text',
																		'maxlength'=>100,
																		'class' => 'round'));
			?>
		</td>
      </tr>
	  
      <tr>
        <td><label class="lab-inner1">Bank Account No. :</label></td>
        <td>
			<?php
				echo $this->Form->input(null, array('label' => false,
																	'div' => false,
																	'type' => 'text',
																	'name'=>false,
																	'id'=>false,
																	'maxlength'=>25,
																	'value'=>$this->Session->read('Auth.ClientBank.vc_bank_account_no'),
																	'disabled'=>'disabled',
																	'class' => 'round number-right'));
			?>
		</td>
        <td><label class="lab-inner1">Bank Account No. :</label></td>
        <td>
			<?php
				echo $this->Form->input('ClientBank.vc_bank_account_no', array('label' => false,
																	'div' => false,
																	'type' => 'text',
																	'maxlength'=>25,
																	'class' => 'round number-right'));
			?>
		</td>
      </tr>
	  
      <tr>
        <td><label class="lab-inner1">Account Type :</label></td>
        <td>
			<?php
				echo $this->Form->input(null, array('label' => false,
																	'div' => false,
																	'type' => 'text',
																	'name'=>false,
																	'id'=>false,
																	'maxlength'=>25,
																	'value'=>$this->Session->read('Auth.ClientBank.vc_account_type'),
																	'disabled'=>'disabled',
																	'class' => 'round'));
			?>
		</td>
        <td><label class="lab-inner1">Account Type :</label></td>
        <td>
			<?php
				echo $this->Form->input('ClientBank.vc_account_type', array('label' => false,
																'div' => false,
																'type' => 'select',
																'options' => array(''=>'Select')+$accountType,
																'class' => 'round_select'));
			?>
		</td>
      </tr>
	  
      <tr>
        <td><label class="lab-inner1">Bank Name :</label></td>
        <td>
			<?php
				echo $this->Form->input(null, array('label' => false,
																	'div' => false,
																	'type' => 'text',
																	'name'=>false,
																	'id'=>false,
																	'maxlength'=>100,
																	'value'=>$this->Session->read('Auth.ClientBank.vc_bank_name'),
																	'disabled'=>'disabled',
																	'class' => 'round'));
			?>
		</td>
        <td><label class="lab-inner1">Bank Name :</label></td>
        <td>
			<?php
				echo $this->Form->input('ClientBank.vc_bank_name', array('label' => false,
																'div' => false,
																'type' => 'select',
																'options' => array(''=>' Select ') + $flrBank,
																'class' => 'round_select'));
			?>
		</td>
      </tr>
    
      <tr>
        <td><label class="lab-inner1">Branch Name :</label></td>
        <td>
			<?php
				echo $this->Form->input(null, array('label' => false,
																	'div' => false,
																	'type' => 'text',
																	'name'=>false,
																	'id'=>false,
																	'maxlength'=>100,
																	'value'=>$this->Session->read('Auth.ClientBank.vc_bank_branch_name'),
																	'disabled'=>'disabled',
																	'class' => 'round'));
			?>
		</td>
        <td><label class="lab-inner1">Branch Name :</label></td>
        <td>
			<?php
				echo $this->Form->input('ClientBank.vc_bank_branch_name', array('label' => false,
																	'div' => false,
																	'type' => 'select',
																	'options' => array(''=>' Select Bank First '),
																	'class' => 'round_select'));
			?>
		</td>
      </tr>
	  
	    <tr>
        <td><label class="lab-inner1">Branch Code :</label></td>
        <td>
			<?php
				echo $this->Form->input(null, array('label' => false,
																	'div' => false,
																	'type' => 'text',
																	'name'=>false,
																	'id'=>false,
																	'maxlength'=>50,
																	'value'=>$this->Session->read('Auth.ClientBank.vc_branch_code'),
																	'disabled'=>'disabled',
																	'class' => 'round'));
			?>
		</td>
        <td><label class="lab-inner1">Branch Code :</label></td>
        <td>
			<?php
				echo $this->Form->input('ClientBank.vc_branch_code', array('label' => false,
																	'div' => false,
																	'type' => 'text',
																	'maxlength'=>50,
																	'readonly'=>'readonly',
																	'class' => 'round disabled-field'));
			?>
		</td>
      </tr>
	  
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><label class="lab-inner1">Upload Document :</label></td>
        <td>
			<?php
				echo $this->Form->input('ClientUploadDocs.bankdoc', array('label' => false,
																			'div' => false,
																			'type' => 'file',
																			'class' => 'uploadfile'));
																			?>
		</td>
      </tr>
      </table>
    </div>
     <!-- end innerbody here-->    
       
   
	
	<table  width="100%" border="0" cellpadding="3" >
		
		<tr>
			
			<td   width='50%' colspan='3' align="right" valign="top">
				<?php echo $this->Form->submit('Submit', array('div'=>false,'label'=>false,'type' => 'submit', 'class' => 'submit', 'value' => 'submit')); ?>
			</td>
			<td    width='50%'  colspan ='3' align="left" valign="top">
				<?php echo $this->Form->submit('Reset', array('div'=>false,'label'=>false,'type' => 'reset', 'class' => 'submit', 'value' => 'Reset')); ?>
			</td>
			
		 </tr>

	</table>
    
	
	
	<?php echo $this->Form->end(); ?>
    
	</div>
     <!-- end mainbody here-->    
</div>
<!-- end wrapper here-->
<?php echo $this->Html->script('flr/bankdetailschange'); ?>