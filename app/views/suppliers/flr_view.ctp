<!-- Start wrapper here -->
<div class="wrapper">
    <!-- Start breadcrumb here-->
    <div class="breadcrumb">
        <ul>
            <li class="first">
                <?php echo $this->Html->link('Home', array('controller' => 'suppliers', 'action' => 'view', 'flr' => true), array('title' => 'Home', 'class' => 'vtip'))
                ?>           
            </li>
            <li class="last">My Profile</li>               
        </ul>
    </div>
    <!-- end breadcrumb here-->
    <!-- Start mainbody here-->
    <div class="mainbody">
        <h1>Welcome to RFA FLR</h1>
        <h3>Wholesaler/Supplier Identification</h3>
        <!-- Start innerbody here-->
        <div class="innerbody">

            <?php echo $this->Form->create('Clientsupplier', array('url' => array('controller' => 'suppliers', 'action' => 'index'), 'type' => 'file')); ?>


            <table width="100%" border="0" cellpadding="3">
                <tr>
                    <td height="35" colspan="6" align="right" valign="middle">Account Status: <strong><?php echo $globalParameterarray[$this->Session->read('Auth.Client.ch_active_flag')]; ?></strong> </td>
                </tr>
                <tr>
                    <td width="15%" align="left" valign="top">
                        <label class="lab-inner">Supplier Name :</label>
                    </td>
                    <td width="19%" align="left" valign="top">
                        <?php
						//pr($this->Session->read('Auth.Client'));
                        echo $this->Form->input('Clientsupplier.vc_client_name', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'disabled' => 'disabled',
                            'class' => 'round',
                            'value' => $this->Session->read('Auth.Client.vc_client_name'),
                        ));
                        ?>
                    </td>
                    <td width="16%" align="left" valign="top">
                       <label class="lab-inner">Fuel Outlet Name  :</label>
                    </td>
                    <td width="17%" align="left" valign="top">
                        <?php
                      echo $this->Form->input('Clientsupplier.vc_fuel_outlet', array('label' => false,
                           'div' => false,
                            'disabled' => 'disabled',
                            'class' => 'round',
                           'value' => $this->Session->read('Auth.Client.vc_fuel_outlet'),
                                                  ));
                        ?>
                    </td>

                    <td width="15%" align="left" valign="top">
                        <!--    <label class="lab-inner">Business Reg. Id :</label>-->
                    </td>
                    <td width="20%" align="left" valign="top">
                    </td>
                </tr>

                <tr>
                    <td colspan="6" align="left" valign="top">&nbsp;</td>
                </tr>

                <tr>
                    <td width="15%" height="30" align="left" valign="top"><label class="lab-inner"><strong style="text-decoration:underline;">Postal Address</strong></label></td>
                    <td width="20%" align="left" valign="top">&nbsp;</td>
                    <td width="15%" align="left" valign="top">&nbsp;</td>
                    <td width="19%" align="left" valign="top">&nbsp;</td>
                    <td width="16%" align="left" valign="top">&nbsp;</td>
                    <td width="17%" align="left" valign="top">&nbsp;</td>
                </tr>

                <tr>
                    <td width="15%" align="left" valign="top"><label class="lab-inner">Address 1 :</label></td>
                    <td width="20%" align="left" valign="top">
                        <?php
                        echo $this->Form->input('Clientsupplier.vc_address1', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'disabled' => 'disabled',
                            'class' => 'round',
                            'value' => $this->Session->read('Auth.Client.vc_address1'),
                        ));
                        ?>

                    </td>
                    <td width="15%" align="left" valign="top"><label class="lab-inner">Address 2 :</label></td>
                    <td width="19%" align="left" valign="top">
                        <?php
                        echo $this->Form->input('Clientsupplier.vc_address2', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'disabled' => 'disabled',
                            'class' => 'round',
                            'value' => $this->Session->read('Auth.Client.vc_address2')
                        ));
                        ?>
                    </td>
                    <td width="16%" align="left" valign="top"><label class="lab-inner">Address 3 :</label></td>
                    <td width="17%" align="left" valign="top">
                        <?php
                        echo $this->Form->input('Clientsupplier.vc_address3', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'disabled' => 'disabled',
                            'class' => 'round',
                            'value' => $this->Session->read('Auth.Client.vc_address3'),
                        ));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td width="15%" align="left" valign="top"><label class="lab-inner">Postal Code :</label></td>
                    <td width="20%" align="left" valign="top">
                        <?php
                        echo $this->Form->input('Clientsupplier.vc_postal_code1', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'disabled' => 'disabled',
                            'class' => 'round',
                            'value' => $this->Session->read('Auth.Client.vc_postal_code1'),
                        ));
                        ?>
                    </td>
                    <td width="15%" align="left" valign="top"><label class="lab-inner">Tel. No. :</label></td>
                    <td width="19%" align="left" valign="top">
                        <?php
                        echo $this->Form->input('Clientsupplier.vc_tel_no', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'disabled' => 'disabled',
                            'class' => 'round',
                            'value' => $this->Session->read('Auth.Client.vc_tel_no')
                        ));
                        ?>
                    </td>
                    <td width="16%" align="left" valign="top"><label class="lab-inner">Mobile No. :</label></td>
                    <td width="17%" align="left" valign="top">
                        <?php
                        echo $this->Form->input('Clientsupplier.vc_cell_no', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'disabled' => 'disabled',
                            'class' => 'round',
                            'value' => $this->Session->read('Auth.Client.vc_cell_no'),
                        ));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td width="15%" align="left" valign="top"><label class="lab-inner">Fax No. :</label></td>
                    <td width="20%" align="left" valign="top">
                        <?php
                        echo $this->Form->input('Clientsupplier.vc_fax_no', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'disabled' => 'disabled',
                            'class' => 'round',
                            'value' => $this->Session->read('Auth.Client.vc_fax_no'),
                        ));
                        ?>

                    </td>
                    <td align="left" valign="top"><label class="lab-inner">Email :</label></td>
                    <td width="19%" align="left" valign="top">
                        <?php
                        echo $this->Form->input('Clientsupplier.vc_email', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'disabled' => 'disabled',
                            'value' => trim($this->Session->read('Auth.Member.vc_email_id')),
                            'class' => 'round'
                        ));
                        ?>

                    </td>
                    <!--
                    <td width="17%" align="left" valign="top"><label class="lab-inner">Download  Document :</label></td> -->
                    <td width="19%" align="left" valign="top">
                       Download  Document :&nbsp;
                    </td> 
                   
                    <td width="17%" align="left" valign="top"> <?php
                        $url = $this->Html->url(array('controller' => 'suppliers',
						'action' => 'downloadrefunddoc'));
                        echo $this->Form->button('Click Here', array(
                            'label' => false,
                            'div' => false,
                            'type' => 'button',
                            'onclick' => "window.location='" . $url . "'",
                            'class' => 'uploadfile'));
                        ?></td>
                    <td width="19%" align="left" valign="top">&nbsp;</td> 
                </tr>
                <tr>
                    <td width="15%" align="left" valign="top">&nbsp;</td>
                    <td width="20%" align="left" valign="top">&nbsp;</td>
                    <td width="15%" align="left" valign="top">&nbsp;</td>
                    <td width="19%" align="left" valign="top">&nbsp;</td>
                    <td width="16%" align="left" valign="top">&nbsp;</td>
                    <td width="17%" align="left" valign="top">&nbsp;</td>
                </tr>

            </table>
            <table width="100%" border="0" cellpadding="3">

               
                
                <tr>
                    <td colspan="6" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="30%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          
                         
                          <tr>
                            <td width="75%" height="30" align="left" valign="top">&nbsp;</td>
                            <td width="25%" height="30" align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr>
                            <td width="75%" height="30" align="left" valign="top">&nbsp;</td>
                            <td width="25%" height="30" align="left" valign="top">&nbsp;</td>
                          </tr>
                        </table></td>
                </tr>
            </table></td></tr></table>

            <?php echo $this->Form->end(null); ?>	
        </div>
        <!-- end innerbody here-->

    </div>
    <!-- end mainbody here-->    
</div>
