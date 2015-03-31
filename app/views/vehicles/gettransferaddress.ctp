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
                        'disabled'=>'disabled',
						'maxlength' => '50',
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
                        'disabled'=>'disabled',
                        'maxlength' => '50',
                        'value' => $data['Profile']['vc_address1'],
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
						'disabled'=>'disabled',
                        'maxlength' => '30',
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
						'required' => 'required',
						'disabled'=>'disabled',
                        'maxlength' => '30',
                        'value' => $data['Profile']['vc_address2'],
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
						'disabled'=>'disabled',
                        'maxlength' => '30',
                        'value' => $this->Session->read('Auth.Profile.vc_address3'),
                        'class' => 'round'));
                    ?>
                </td>
                <td width="13%">&nbsp;</td>
                <td width="37%">
                    <?php
                    echo $this->Form->input(null, array('label' => false,
                        'div' => false,
                        'type' => 'text',
						'disabled'=>'disabled',
						'required' => 'required',
                        'maxlength' => '30',
                        'value' => $data['Profile']['vc_address3'],
                        'class' => 'round'));
                    ?>
                  
                </td>
            </tr>
            <tr>
                <td width="13%"><label class="lab-inner">Telephone No :</label></td>
                <td width="37%">
                    <?php
                    echo $this->Form->input(null, array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'disabled'=>'disabled',
                        'maxlength' => '30',
                        'value' => $this->Session->read('Auth.Profile.vc_tel_no'),
                        'class' => 'round'));
                    ?>
                    <!--<input type="text" class="round" />-->
                </td>
                <td width="13%"><label class="lab-inner">Telephone No :</label></td>
                <td width="37%">
                    <?php
                    echo $this->Form->input(null, array('label' => false,
                        'div' => false,
                        'type' => 'text',
						'disabled'=>'disabled',
                        'maxlength' => '30',
                        'value' => $data['Profile']['vc_tel_no'],
                        'class' => 'round'));
                    ?>
                 
                </td>
            </tr>
            <tr>
                <td width="13%"><label class="lab-inner">Cell No :</label></td>
                <td width="37%">
                    <?php
                    echo $this->Form->input(null, array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'disabled'=>'disabled',
                        'maxlength' => '30',
                        'value' => $this->Session->read('Auth.Profile.vc_mobile_no'),
                        'class' => 'round'));
                    ?>
                    <!--<input type="text" class="round" />-->
                </td>
                <td width="13%"><label class="lab-inner">Cell No :</label></td>
                <td width="37%">
                    <?php
                    echo $this->Form->input(null, array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'new_vc_mobile_no',
						'required' => 'required',
						'disabled'=>'disabled',
                        'maxlength' => '30',
                        'value' => $data['Profile']['vc_mobile_no'],
                        'class' => 'round'));
                    ?>
				</td>
            </tr>
            <tr>
                <td width="13%"><label class="lab-inner">Fax No :</label></td>
                <td width="37%">
                    <?php
                    echo $this->Form->input(null, array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'disabled'=>'disabled',
                        'maxlength' => '30',
                        'value' => $this->Session->read('Auth.Profile.vc_fax_no'),
                        'class' => 'round'));
                    ?>
                </td>
                <td width="13%"><label class="lab-inner">Fax No :</label></td>
                <td width="37%">
                    <?php
                    echo $this->Form->input(null, array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'disabled'=>'disabled',
                        'maxlength' => '30',
                        'value' => $data['Profile']['vc_fax_no'],
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
                        'disabled'=>'disabled',
                        'maxlength' => '30',
                        'value' =>$this->Session->read('Auth.Profile.vc_email_id'),
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
                        'disabled'=>'disabled',
                        'maxlength' => '30',
                        'value' => $data['Profile']['vc_email_id'],
                        'class' => 'round'));
                    ?>
                    
                </td>
            </tr>