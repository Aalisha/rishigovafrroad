<!-- Start wrapper here-->
<div class="wrapper">
 <!-- Start breadcrumb here-->
    <div class="breadcrumb">
        <ul>
        <li class="first">
        <a title="Home" class="vtip" href="<?php echo $this->Html->url('view') ?>">Home</a>
        </li>
        <li class="last">View Profile</li>               
        </ul>
   </div>
<!-- end breadcrumb here-->
<!-- Start mainbody here-->
    <div class="mainbody">
    <h1>Welcome to RFA FLR</h1>
    <h3>Client Identification</h3>
    <!-- Start innerbody here-->
    <div class="innerbody">
	
	 
    <table width="100%" cellspacing="1" cellpadding="5" border="0">
      <tr class="cont1">
	  
        <td height="35" colspan="6" align="right" valign="middle">Account Status: <strong><?php echo $this->Session->read('Auth.Status.vc_prtype_name'); ?></strong> </td>
			
           
	  </tr>
      
      <tr class="cont">
        <td width="15%" align="left" valign="top"><label class="lab-inner">Business Reg. Id :</label></td>.
        <td width="20%" align="left" valign="top"> <div class='' ><?php echo $this->Session->read('Auth.Client.vc_id_no'); ?> </div> </td>
        <td width="15%" align="left" valign="top"><label class="lab-inner">Client Name :</label></td>
        <td width="19%" align="left" valign="top"><div class='' ><?php echo $this->Session->read('Auth.Client.vc_client_name'); ?> </div> </td>
        <td width="16%" align="left" valign="top"><label class="lab-inner">Contact Person :</label></td>
        <td width="17%" align="left" valign="top"><div class='' ><?php echo $this->Session->read('Auth.Client.vc_contact_person'); ?> </div></td>
      </tr>
      
       <tr class="cont">
        <td colspan="6" align="left" valign="top">&nbsp;</td>
       </tr>
      
      <tr class="cont">
        <td width="15%" height="30" align="left" valign="top"><label class="lab-inner"><strong style="text-decoration:underline;">Postal Address</strong></label></td>
        <td width="20%" align="left" valign="top">&nbsp;</td>
        <td width="15%" align="left" valign="top">&nbsp;</td>
        <td width="19%" align="left" valign="top">&nbsp;</td>
        <td width="16%" align="left" valign="top">&nbsp;</td>
        <td width="17%" align="left" valign="top">&nbsp;</td>
      </tr>
      
      <tr class="cont">
        <td width="15%" align="left" valign="top"><label class="lab-inner">Address1 :</label></td>
        <td width="20%" align="left" valign="top"><div class='' ><?php echo $this->Session->read('Auth.Client.vc_address1'); ?> </div>          
            
        </td>
        <td width="15%" align="left" valign="top"><label class="lab-inner">Address2 :</label></td>
        <td width="19%" align="left" valign="top">
          <div class='' ><?php echo $this->Session->read('Auth.Client.vc_address2'); ?> </div>
        </td>
        <td width="16%" align="left" valign="top"><label class="lab-inner">Address3 :</label></td>
        <td width="17%" align="left" valign="top">
           <div class='' ><?php echo $this->Session->read('Auth.Client.vc_address3'); ?> </div>
        </td>
      </tr>
      <tr class="cont">
        <td width="15%" align="left" valign="top"><label class="lab-inner">Postal Code :</label></td>
        <td width="20%" align="left" valign="top">
          <div class='' ><?php echo $this->Session->read('Auth.Client.vc_postal_code1'); ?> </div>
        </td>
        <td width="15%" align="left" valign="top"><label class="lab-inner">Tel No :</label></td>
        <td width="19%" align="left" valign="top">
            <div class='' ><?php echo $this->Session->read('Auth.Client.vc_tel_no'); ?> </div>
       </td>
        <td align="left" valign="top"><label class="lab-inner">Mobile No :</label></td>
        <td align="left" valign="top">
           <div class='' ><?php echo $this->Session->read('Auth.Client.vc_cell_no'); ?> </div>
        </td>
        </tr>
     <tr class="cont">
        <td align="left" valign="top"><label class="lab-inner">Fax No :</label></td>
        <td align="left" valign="top">
           <div class='' ><?php echo $this->Session->read('Auth.Client.vc_fax_no'); ?> </div>

        </td>
        <td align="left" valign="top"><label class="lab-inner">Email :</label></td>
        <td align="left" valign="top">
           <div class='' ><?php echo $this->Session->read('Auth.Client.vc_email'); ?> </div>

        </td>
        <td width="16%" align="left" valign="top">&nbsp;</td>
        <td width="17%" align="left" valign="top">&nbsp;</td>
   </tr>
    <tr class="cont">
        <td width="15%" align="left" valign="top">&nbsp;</td>
        <td width="20%" align="left" valign="top">&nbsp;</td>
        <td width="15%" align="left" valign="top">&nbsp;</td>
        <td width="19%" align="left" valign="top">&nbsp;</td>
        <td width="16%" align="left" valign="top">&nbsp;</td>
        <td width="17%" align="left" valign="top">&nbsp;</td>
   </tr>
     <tr class="cont1">
        <td width="15%" height="30" align="left" valign="middle"><label class="lab-inner"><strong style="text-decoration:underline;">Business Address </strong></label></td>
        <td width="20%" align="left" valign="middle" style="font-size:11px;">&nbsp;</td>
        <td width="15%" align="left" valign="top">&nbsp;</td>
        <td width="19%" align="left" valign="top">&nbsp;</td>
        <td width="16%" align="left" valign="top">&nbsp;</td>
        <td width="17%" align="left" valign="top">&nbsp;</td>
      </tr>
     <tr class="cont">
        <td align="left" valign="top"><label class="lab-inner">Address1 :</label></td>
        <td align="left" valign="top">
            <div class='' ><?php echo $this->Session->read('Auth.Client.vc_address4'); ?> </div>
        </td>
        <td align="left" valign="top"><label class="lab-inner">Address2 :</label></td>
        <td align="left" valign="top">
           <div class='' ><?php echo $this->Session->read('Auth.Client.vc_address5'); ?> </div>
        </td>
        <td align="left" valign="top"><label class="lab-inner">Address3 :</label></td>
        <td align="left" valign="top">
           <div class='' ><?php echo $this->Session->read('Auth.Client.vc_address6'); ?> </div>
        </td>
      </tr>
      <tr class="cont">
        <td align="left" valign="top"><label class="lab-inner">Postal Code :</label></td>
        <td align="left" valign="top">
          <div class='' ><?php echo $this->Session->read('Auth.Client.vc_postal_code1'); ?> </div>
        </td>
        <td align="left" valign="top"><label class="lab-inner">Tel No :</label></td>
        <td align="left" valign="top">
           <div class='' ><?php echo $this->Session->read('Auth.Client.vc_tel_no'); ?> </div>
        </td>
        <td align="left" valign="top"><label class="lab-inner">Mobile No :</label></td>
        <td align="left" valign="top">
           <div class='' ><?php echo $this->Session->read('Auth.Client.vc_cell_no'); ?> </div>
        </td>
      </tr>
      <tr class="cont">
        <td align="left" valign="top"><label class="lab-inner">Fax No :</label></td>
        <td align="left" valign="top">
           <div class='' ><?php echo $this->Session->read('Auth.Client.vc_fax_no'); ?> </div>
            
        </td>
        <td align="left" valign="top"><label class="lab-inner">Email :</label></td>
        <td align="left" valign="top">
           <div class='' ><?php echo $this->Session->read('Auth.Client.vc_email2'); ?> </div>
        </td>
        <td align="left" valign="top">&nbsp;</td>
        <td align="left" valign="top">&nbsp;</td>
      </tr>
    </table>
    <table width="100%" border="0" cellpadding="3">
     <tr class="cont">
        <td width="15%" align="left" valign="top">&nbsp;</td>
        <td width="20%" align="left" valign="top">&nbsp;</td>
        <td width="15%" align="left" valign="top">&nbsp;</td>
        <td width="19%" align="left" valign="top">&nbsp;</td>
        <td width="16%" align="left" valign="top">&nbsp;</td>
        <td width="17%" align="left" valign="top">&nbsp;</td>
      </tr>
      <tr class="cont">
        <td align="left" valign="top"><label class="lab-inner">Client Category :</label></td>
        <td width="20%" align="left" valign="top"><div class='' ><?php echo $this->Session->read('Auth.ClientHeader.category'); ?> </div>
            
        </td>
        <td align="left" valign="top"><label class="lab-inner">Refund % :</label></td>
        <td align="left" valign="top"><div class='' ><?php echo $this->Session->read('Auth.ClientHeader.nu_refund'); ?> </div></td>
        <td align="left" valign="top">Fuel Usage Prev. Year  :</td>
        <td align="left" valign="top"><div class='' ><?php echo $this->Session->read('Auth.ClientHeader.nu_fuel_usage'); ?> </div></td>
        </tr>
      <tr class="cont">
        <td align="left" valign="top">Expected Usages Next Year  :</td>
        <td align="left" valign="top"><div class='' ><?php echo $this->Session->read('Auth.ClientHeader.nu_expected_usage'); ?> </div></td>
        <td align="left" valign="top">Off Road Usage Prev. Year :</td>
        <td align="left" valign="top"><div class='' ><?php echo $this->Session->read('Auth.ClientHeader.nu_off_road_usage'); ?> </div></td>
        <td align="left" valign="top">Off Road Usages Next Year :</td>
        <td align="left" valign="top"><div class='' ><?php echo $this->Session->read('Auth.ClientHeader.nu_off_expected_usage'); ?> </div></td>
        </tr>
     <tr class="cont">
        <td align="left" valign="top"><label class="lab-inner">Download Refund Document :</label></td>
        <td align="left" valign="top"><?php $url = $this->Html->url(array('controller'=>'clients','action'=>'downloadrefunddoc'));
                    echo $this->Form->button('Click Here', array(
						'label' => false,
						'div' => false,
						'type' => 'button',
						'onclick'=>"window.location='".$url."'",
						'class' => 'uploadfile')); ?></td>
        <td align="left" valign="top">&nbsp;</td>
        <td width="19%" align="left" valign="top">&nbsp;</td>
        <td width="16%" align="left" valign="top">&nbsp;</td>
        <td width="17%" align="left" valign="top">&nbsp;</td>
      </tr>
     <tr class="cont">
        <td align="left" valign="top">&nbsp;</td>
        <td width="18%" align="left" valign="top">&nbsp;</td>
        <td align="left" valign="top">&nbsp;</td>
        <td align="left" valign="top">&nbsp;</td>
        <td align="left" valign="top">&nbsp;</td>
        <td width="17%" align="left" valign="top">&nbsp;</td>
      </tr>
     <tr class="cont1">
        <td height="30" align="left" valign="top"><strong style="text-decoration:underline;">Fuel Outlets</strong></td>
        <td width="10%" align="right" valign="top" style="padding-right:20px;">&nbsp;</td>
        
        <td height="30" align="left" valign="top"><strong style="text-decoration:underline;">Bank Details</strong></td>
        <td width="19%" align="left" valign="top">&nbsp;</td>
        <td width="16%" align="left" valign="top">&nbsp;</td>
        <td width="17%" align="left" valign="top">&nbsp;</td>
      </tr>
     <tr class="cont">
        <td align="left" valign="top"> 
			
			<div class=''> 
					
					<?php Foreach ( $this->Session->read('Auth.ClientFuelOutlet') as $value) : ?>
					
						<div class='' > <?php echo $value['vc_fuel_outlet']; ?> </div>
						
						
					<?php endforeach; ?>
			</div>
			
		</td>
        <td width="18%" align="center" valign="top">&nbsp;</td>
        <td align="left" valign="top">Account Holder Name :</td>
        <td width="19%" align="left" valign="top"><div class='' ><?php echo $this->Session->read('Auth.ClientBank.vc_account_holder_name'); ?> </div></td>
        <td align="left" valign="top"><label class="lab-inner">Bank Account No :</label></td>
        <td align="left" valign="top"><div class='' ><?php echo $this->Session->read('Auth.ClientBank.vc_bank_account_no'); ?> </div></td>
        </tr>
     <tr class="cont">
        <td align="left" valign="top">&nbsp;</td>
        <td align="center" valign="top">&nbsp;</td>
        <td align="left" valign="top"><label class="lab-inner">Account Type :</label></td>
        <td align="left" valign="top"><div class='' ><?php echo $this->Session->read('Auth.ClientBank.vc_account_type'); ?> </div></td>
        <td align="left" valign="top"><label class="lab-inner">Bank Name :</label></td>
        <td align="left" valign="top"><div class='' ><?php echo $this->Session->read('Auth.ClientBank.vc_bank_name'); ?> </div>
            </td>
        </tr>
     <tr class="cont">
        <td align="left" valign="top">&nbsp;</td>
        <td align="center" valign="top">&nbsp;</td>
        <td align="left" valign="top"><label class="lab-inner">Branch Code :</label></td>
        <td align="left" valign="top"><div class='' ><?php echo $this->Session->read('Auth.ClientBank.vc_branch_code'); ?> </div></td>
        <td align="left" valign="top"><label class="lab-inner">Branch Name :</label></td>
        <td align="left" valign="top">
						<div class='' ><?php echo $this->Session->read('Auth.ClientBank.vc_bank_branch_name'); ?> </div></td>
        </tr>
     <tr class="cont">
        <td align="left" valign="top">&nbsp;</td>
        <td align="left" valign="top">&nbsp;</td>
        <td align="left" valign="top"><label class="lab-inner">Download Bank Document :</label></td>
        <td align="left" valign="top"><?php
			
				$url = $this->Html->url(array('controller'=>'clients','action'=>'downloadbankdoc'));
                    echo $this->Form->button('Click Here', array(
						'label' => false,
						'div' => false,
						'type' => 'button',
						'onclick'=>"window.location='".$url."'",
						'class' => 'uploadfile'));
           ?></td>
        <td align="left" valign="top">&nbsp;</td>
        <td align="left" valign="top">&nbsp;</td>
      </tr>
     <tr class="cont">
        <td align="left" valign="top">&nbsp;</td>
        <td align="left" valign="top">&nbsp;</td>
        <td align="left" valign="top">&nbsp;</td>
        <td align="left" valign="top">&nbsp;</td>
        <td align="left" valign="top">&nbsp;</td>
        <td align="left" valign="top">&nbsp;</td>
      </tr>
     
    </table>
	
	</div>
     <!-- end innerbody here-->
                
       

    </div>
     <!-- end mainbody here-->    
</div>