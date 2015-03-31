<!-- Start form-body here-->

<div class="form-body clearfix">

    <div class="form-body-heading">
        <div class="heading"><?php echo strtoupper($selectedType); ?> Registration  </div>  
    </div> 
    <!-- Start form-body-main here-->

    <div class="form-body-main">

        <!-- Start form-body-mainbody here--> 

        <div class="form-body-mainbody">

            <?php echo $this->Form->create('Member', array('url' => array('controller' => 'members', 'action' => 'registration', $selectedTypeID))); ?>

            <table width="100%"  border="0">
                <tr id="wholesaler" style="display:none;">
                    <td valign="top" align="right">&nbsp; </td>
                    <td valign="top" height="25px"> <?php
                        echo $this->Form->checkbox('Member.wholesaler_supplier', array('label' => false,
                            'div' => false,
                            'value' => '1',
							
                        ));
                        ?> 
                  <span style="color:#cd0000; margin-left: 5px; margin-bottom: 10px;">Wholesaler / Supplier</span></td>
                </tr>

				<tr id='row_allname_id' 
					<?php if($this->data['Member']['wholesaler_supplier']==1){}else{?>
				style="display:none;" <?php } ?>>
                    <td valign="top"><label class="lab-txt">Wholesaler NAME :</label></td>
                    <td valign="top">
                        <?php echo $this->Form->input('vc_user_firstname1', array('label' => false, 'div' => false, 'type' => 'text', 'maxlength' => 100, 'id' => 'all_name_supplier', 'class' => 'fiel')); ?>
                    </td>	
                </tr>
                <tr id='row_first_id' <?php if($this->data['Member']['wholesaler_supplier']==1){ ?> style="display:none;"  <?php }?>>
                    <td valign="top"><label class="lab-txt">FIRST NAME :</label></td>
                    <td valign="top">
                        <?php echo $this->Form->input('vc_user_firstname', array('label' => false, 'div' => false, 'type' => 'text', 'maxlength' => 50, 'id' => 'first_name', 'class' => 'fiel')); ?>
                    </td>	
                </tr>
			

                <tr id='row_last_id'  <?php if($this->data['Member']['wholesaler_supplier']==1){ ?> style="display:none;"  <?php }?> >
                    <td valign="top"><label class="lab-txt">LAST NAME :</label></td>
                    <td valign="top">
                        <?php echo $this->Form->input('vc_user_lastname', array('label' => false, 'div' => false, 'type' => 'text', 'maxlength' => 50, 'id' => 'last_name', 'class' => 'fiel')); ?>
                    </td>
                </tr>

                <tr>
                    <td valign="top"><label class="lab-txt">EMAIL ID :</label></td>
                    <td valign="top">
                        <?php echo $this->Form->input('vc_email_id', array('label' => false, 'div' => false, 'type' => 'text', 'maxlength' => 50, 'id' => 'email', 'class' => 'fiel')); ?>
                    </td>
                </tr>

                <tr>
                    <td valign="top"><label class="lab-txt">Type :</label></td>
                    <td valign="top">
                        <?php
                        echo $this->Form->input('vc_comp_code', array(
                            'label' => false,
                            'div' => false,
                            'type' => 'select',
                            'id' => 'vc_comp_code',
                            'options' => $FLA_TYPE,
                            'default' => $selectedTypeID,
                            'class' => 'fiel'));
                        ?>
                    </td>
                </tr>

                
                <tr>
                    <td valign="top"><label class="lab-txt"></label></td>
                    <td valign="top">
                        <img id='captcha' alt="Captcha Code" src="<?php echo $this->Html->url(array('controller' => 'members', 'action' => 'captcha_image')); ?>" />
                        <a id='reset' href="javascript:void(0);" >Reset</a>
                    </td>
                </tr>

                <tr>
                    <td valign="top"><label class="lab-txt">Enter Code :</label></td>
                    <td valign="top" height="25px">
                        <?php
                        echo $this->Form->input('vc_captcha_code', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'id' => 'vc_captcha_code',
                            'alt' => ' Enter Captcha Code',
                            'class' => 'fiel'));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>
                        <?php echo $this->Form->submit(NULL, array('label' => false, 'div' => false, 'id' => 'Login', 'value' => 'Login', 'class' => 'submit')); ?>
                    </td>
                </tr>

            </table>

            <?php echo $this->Form->end(); ?>

        </div>  

        <!-- end form-body-mainbody here-->  

    </div>  

    <!-- end form-body-main here-->     

</div>  

<?php echo $this->Html->script('registration-module'); ?>

<!-- end form-body here--> 