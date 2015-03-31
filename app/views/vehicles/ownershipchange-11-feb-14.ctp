<!-- Start breadcrumb here-->
<div class="breadcrumb">
    <ul>
        <li class="first">
            <?php echo $this->Html->link('Home', array('controller' => 'profiles', 'action' => 'index'), array('title' => 'Home', 'class' => 'vtip')) ?>
        </li>
        <li class="last">Change of Ownership</li>
    </ul>
</div>
<!-- end breadcrumb here-->

<div class="mainbody">
    <h1><?php echo $mdclocal;?></h1>
    <h3>Customer Detail</h3>
		<div class="innerbodyHeader">

	<?php 
	echo $this->Form->create('VehicleRegistrationCompany', array('url' => array('controller' => 'vehicles', 'action' => 'companysubmit'), 'type' => 'file','enctype'=>'multipart/form-data')); ?>
           <table> <tr>
                <td align="left">
				Company Name&nbsp;:&nbsp;<?php
                        echo $this->Form->input('VehicleDetail.nu_company_id', array('label' => false,'div' => false,
                            'type' => 'select',
                            'tabindex'=>'3',
							'required' => 'required',
                            'options' => $CompanyId,
                            'default' => $nu_company_id,
                            'onchange' => "formsubmit('VehicleRegistrationCompanyOwnershipchangeForm');",
                            'maxlength' => 30,
                            'class' => 'round_select4')
                        );
                        ?></td>
            </tr></table>
			<?php echo $this->Form->end(); ?>
</div>
    <!-- Start innerbody here-->
    <div class="innerbody">
     <?php //echo $this->Form->create(array('url' => '/vehicles/ownershipchange', 'type' => 'file')); ?>
        
        <table width="100%" border="0" cellpadding="3">
            <tr>
                <td valign='top' >
                    <?php
                    $options = array('1' => 'Name Change', '2' => 'Ownership Change');
                    $attributes = array('legend' => false, 'value' => 'CUSTAMDTYP01');
                    echo $this->Form->radio('CustomerAmendment.vc_amend_type', $CUSTAMDTYP, $attributes);
                    echo $this->Form->hidden('vc_customer_no', array('value' => $this->Session->read('Auth.Profile.vc_customer_no')))
                    ?>
                </td>

            </tr>
        </table>

        <table width="100%" border="0" cellpadding="3">
            <tr>
                <td valign='top' width="17%"><label class="lab-inner1">Customer No. :</label></td>
                <td  valign='top' width="25%">
                    <?php
                    echo $this->Form->input('CustomerAmendment.vc_customer_no', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_customer_no',
                        'disabled' => 'disabled',
                        'value' => $this->Session->read('Auth.Profile.vc_customer_no'),
                        'maxlength' => '30',
                        'class' => 'round'));
                    ?>

                </td>
                <td  valign='top' width="17%"><label class="lab-inner1">Customer Name :</label></td>
                <td valign='top'  width="25%">
                    <?php
                    echo $this->Form->input('CustomerAmendment.vc_new_customer_name', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'required' => 'required',
                        'id' => 'vc_new_customer_name',
                        'maxlength' => 100,
                        'class' => 'round'));
                    ?>

                </td>
                <td valign='top' width="13%" ><label class="lab-inner1">ID No./Reg. No. :</label></td>
                <td valign='top' width="37%" >
                    <?php
                    echo $this->Form->input('CustomerAmendment.vc_new_cust_no', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'required' => 'required',
                        'maxlength' => 30,
                        'id' => 'vc_new_cust_no',
                        'class' => 'round'));
                    ?>

                </td>
            </tr>
            <tr>
                <td valign='top' ><label class="lab-inner">Upload Document :</label></td>
                <td  valign='top' colspan="2"><?php
                    echo $this->Form->input('DocumentUpload.vc_uploaded_doc_name', array('label' => false,
                        'div' => false,
                        'type' => 'file',
						'required'=>false,
                        'id' => 'vc_uploaded_doc_name',
                        'class' => 'round_select')
                    );
                    ?></td>

                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>

            <tr>
                <td valign='top'><label class="lab-inner">Old Name :</label></td>
                <td valign='top'>
                    <?php
                    echo $this->Form->input('CustomerAmendment.vc_customer_name', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_customer_name',
                        'disabled' => 'disabled',
                        'value' => $this->Session->read('Auth.Profile.vc_customer_name'),
                        'class' => 'round'));
                    ?>

                </td>
                <td valign='top'><label class="lab-inner">Old ID :</label></td>
                <td valign='top'>
                    <?php
                    echo $this->Form->input('CustomerAmendment.vc_customer_id', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'disabled' => 'disabled',
                        'id' => 'vc_customer_id',
                        'value' => $this->Session->read('Auth.Profile.vc_customer_id'),
                        'class' => 'round'));
                    ?>

                </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>

        </table>
        <br>
        <table width="100%" border="0" cellpadding="3" class="changeaddress" id="changeaddress">
            <tr class="listhead">
                <td colspan="2" align="center">Old Address</td>
                <td colspan="2" align="center">New Address</td>
            </tr>
            <tr>
                <td width="13%"><label class="lab-inner">Address :</label></td>
                <td width="37%">
                    <?php
                    echo $this->Form->input(null, array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'disabled' => 'disabled',
                        'id' => null,
                        'value' => $this->Session->read('Auth.Profile.vc_address1'),
                        'class' => 'round'));
                    ?>

                </td>
                <td width="13%"><label class="lab-inner">Address :</label></td>
                <td width="37%">
                    <?php
                    echo $this->Form->input(null, array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => null,
                        'disabled' => 'disabled',
                        'value' => $this->Session->read('Auth.Profile.vc_address1'),
                        'class' => 'round'));
                    ?>

                </td>
            </tr>
            <tr>
                <td width="13%">&nbsp;</td>
                <td width="37%">
                    <?php
                    echo $this->Form->input(null, array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'disabled' => 'disabled',
                        'id' => null,
                        'value' => $this->Session->read('Auth.Profile.vc_address2'),
                        'class' => 'round'));
                    ?>

                </td>
                <td width="13%">&nbsp;</td>
                <td width="37%">
                    <?php
                    echo $this->Form->input(null, array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'disabled' => 'disabled',
                        'id' => null,
                        'value' => $this->Session->read('Auth.Profile.vc_address2'),
                        'class' => 'round'));
                    ?>

                </td>
            </tr>
            <tr>
                <td width="13%">&nbsp;</td>
                <td width="37%">
                    <?php
                    echo $this->Form->input(null, array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'disabled' => 'disabled',
                        'id' => null,
                        'value' => $this->Session->read('Auth.Profile.vc_po_box'),
                        'class' => 'round'));
                    ?>
                </td>
                <td width="13%">&nbsp;</td>
                <td width="37%">
                    <?php
                    echo $this->Form->input(null, array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'disabled' => 'disabled',
                        'id' => null,
                        'value' => $this->Session->read('Auth.Profile.vc_po_box'),
                        'class' => 'round'));
                    ?>

                </td>
            </tr>
            <tr>
                <td width="13%"><label class="lab-inner">Telephone No. :</label></td>
                <td width="37%">
                    <?php
                    echo $this->Form->input(null, array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'disabled' => 'disabled',
                        'id' => null,
                        'value' => $this->Session->read('Auth.Profile.vc_tel_no'),
                        'class' => 'round'));
                    ?>
                    <!--<input type="text" class="round" />-->
                </td>
                <td width="13%"><label class="lab-inner">Telephone No. :</label></td>
                <td width="37%">
                    <?php
                    echo $this->Form->input(null, array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'disabled' => 'disabled',
                        'id' => null,
                        'value' => $this->Session->read('Auth.Profile.vc_tel_no'),
                        'class' => 'round'));
                    ?>

                </td>
            </tr>
            <tr>
                <td width="13%"><label class="lab-inner">Mobile No. :</label></td>
                <td width="37%">
                    <?php
                    echo $this->Form->input(null, array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'disabled' => 'disabled',
                        'id' => null,
                        'value' => $this->Session->read('Auth.Profile.vc_mobile_no'),
                        'class' => 'round'));
                    ?>
                    <!--<input type="text" class="round" />-->
                </td>
                <td width="13%"><label class="lab-inner">Mobile No. :</label></td>
                <td width="37%">
                    <?php
                    echo $this->Form->input(null, array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'new_vc_mobile_no',
                        'disabled' => 'disabled',
                        'id' => null,
                        'value' => $this->Session->read('Auth.Profile.vc_mobile_no'),
                        'class' => 'round'));
                    ?>
                </td>
            </tr>
            <tr>
                <td width="13%"><label class="lab-inner">Fax No. :</label></td>
                <td width="37%">
                    <?php
                    echo $this->Form->input(null, array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'disabled' => 'disabled',
                        'id' => null,
                        'value' => $this->Session->read('Auth.Profile.vc_fax_no'),
                        'class' => 'round'));
                    ?>
                </td>
                <td width="13%"><label class="lab-inner">Fax No. :</label></td>
                <td width="37%">
                    <?php
                    echo $this->Form->input(null, array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'disabled' => 'disabled',
                        'id' => null,
                        'value' => $this->Session->read('Auth.Profile.vc_fax_no'),
                        'class' => 'round'));
                    ?>
                    <!--<input type="text" class="round" />-->
                </td>
            </tr>
            <tr>
                <td width="13%"><label class="lab-inner">Email :</label></td>
                <td width="37%">
                    <?php
                    echo $this->Form->input(null, array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'disabled' => 'disabled',
                        'id' => null,
                        'value' => $this->Session->read('Auth.Profile.vc_email_id'),
                        'class' => 'round'));
                    ?>
                    <!--<input type="text" class="round" />-->
                </td>
                <td width="13%"><label class="lab-inner">Email :</label></td>
                <td width="37%">
                    <?php
                    echo $this->Form->input(null, array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'disabled' => 'disabled',
                        'id' => null,
                        'value' => $this->Session->read('Auth.Profile.vc_email_id'),
                        'class' => 'round'));
                    ?>

                </td>
            </tr>

        </table>

    </div>
    <!-- end innerbody here-->    

    <table width="100%" border="0">
        <tr>
            <td align="center">
                <?php echo $this->Form->submit('Submit', array('type' => 'submit', 'class' => 'submit', 'value' => 'submit')); ?>
            </td>
        </tr>
    </table>

    <?php echo $this->Form->end(); ?>
</div>
<!-- end mainbody here-->


<div id="CustomerOwnerShipChangeForm" class="ontop">
    <div id="popup" class="popup3">
        <?php echo $this->Html->link('Close', 'javascript:void(0);', array('class' => 'close', 'onClick' => 'hide("CustomerOwnerShipChangeForm");')); ?>
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td align="left" class="content-area"><div class="listhead-popup">Select Customer Name / RFA No.</div></td>
            </tr>
            <tr>
                <td width="100%" align="center" class="content-area">
                    <div class="content-area-outer">
                        <table width="100%" border="0">
                            <tr>
                                <td> 

                                    <?php echo $this->Form->input('search', array('div' => false, 'type' => 'text', 'size' => '21', 'label' => false, 'class' => 'tftextinput', 'maxlength' => '30')); ?>
                                    <?php echo $this->Form->button('search', array('div' => false, 'label' => false, 'type' => 'button', 'value' => 'Search', 'class' => 'tfbutton')); ?>

                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table width="100%" cellspacing="1" cellpadding="5" border="0" >

                                        <tr class="listhead1">
                                            <td width="10%"> &nbsp; </td>
                                            <td width="50%" align="left">Customer Name</td>
                                            <td width="30%"> RFA Customer No. </td>

                                        </tr>
                                    </table>

                                    <div id='data' class='' >			

                                        <table width="100%" cellspacing="1" cellpadding="5" border="0" >

                                            <?php if (count($profileData) > 0) : ?>

                                                <?php
                                                $i = 0;
                                                foreach ($profileData as $values) :

                                                    $i++;

                                                    $str = ( $i % 2 == 0 ) ? '' : '1';
                                                    ?>

                                                    <tr  class="cont<?php echo $str ?> <?php if( strtolower(trim($values['Member']['vc_user_login_type'])) == strtolower('USRLOGIN_INCUST')): echo 'inactcust'; endif; ?>"> 

                                                        <td  width="10%" > <input type='radio' name='getCustomerTransfer' value='<?php echo $values['Profile']['vc_user_no']; ?>' /> </td>

                                                        <td width="50%" align="left"><?php echo $values['Profile']['vc_customer_name']; ?></td>

                                                        <td width="30%"><?php echo $values['Profile']['vc_customer_no']; ?></td>

                                                    </tr>



                                                <?php endforeach; ?>

                                            <?php else : ?>

                                                <tr class="cont1">

                                                    <td width="100%" colspan='3' align="center"> No Record Found </td>

                                                </tr>

                                            <?php endif; ?>

                                        </table>

                                    </div>

                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</div>

<?php //echo $this->Html->script('mdc/ownershipchange'); ?>