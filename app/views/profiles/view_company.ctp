<?php $currentUser = $this->Session->read('Auth');?>
<!-- Start breadcrumb here-->
<div class="breadcrumb">
    <ul>
        <li class="first">

            <?php echo $this->Html->link('Home', array('controller' => 'profiles', 'action' => 'index'), array('title' => 'Home', 'class' => 'vtip')) ?>

        </li>
            <li class="last">View/Edit Company</li> 
    </ul>
</div>
<!-- end breadcrumb here-->

<!-- Start mainbody here-->
<div class="mainbody">

    <h1><?php echo $mdclocal; ?></h1>

    <h3>Company Details</h3>

    <!-- Start innerbody here-->
<div class="innerbody">

            <table width="100%" cellspacing="1" cellpadding="5" border="0">
                <tr class="listhead1">
                    <td width="4%" align="center">SI. No.</td>
                    <td width="10%" align="center">Company Name</td>
                    <td width="10%" align="center">Business Registration</td>
                    <td width="7%" align="center">Customer<br> Type</td>
                    <td width="15%" align="center">Bank Name</td>
                    <td width="10%" align="center">Account Number</td>
                    <td width="10%" align="center">Address</td>
                    <td width="10%" align="center">Mobile No.</td>
                    <td width="7%" align="center">Status</td>
                    <td width="7%" align="center">Action</td>
                </tr>
                <?php
                if (count($company) > 0) {

                    $i = 1;

                    foreach ($company as $val) {
					
						$sr = $i % 2 == 0 ? '' : '1';
                        ?>

                        <tr class="cont1">
                            <td align="center"><?php echo ((($pagecounter - 1) * ($limit)) + $i); ?></td>
							
							<td align="left">

                                <?php
                                echo $val['Company']['vc_company_name'];
                                ?>
                            </td>
							
							<td align="left">

                                <?php
                                echo $val['Company']['vc_business_reg'];
								//pr($val['Company']);
                                if($val['Company']['ch_business_type']=='Y'){

									//echo $globalParameterarray[$val['Company']['vc_bank_supportive_doc']];			

									echo '<br>';
									
									$url =$this->webroot."profiles/download/B";
									?>
									<a href="<?php  echo $url;?>">Download Doc.</a>
									<?php 								 
									echo '<br>';

									}
                                ?>
                            </td>
							
							<td align="left">

                                <?php
                                echo $globalParameterarray[$val['Company']['vc_cust_type']];
                                ?>
                            </td>
							
                            <td align="left">

                               
								 <?php
									
			                      echo $banks[$val['Company']['vc_bank_struct_code']];
								  
								  echo '<br/>';
                                
								if($val['Company']['vc_bank_supportive_doc']!=''){
									echo $globalParameterarray[$val['Company']['vc_bank_supportive_doc']];
									echo '<br/>';

								
									$url =$this->webroot."profiles/download";
									?>
									<a href="<?php  echo $url;?>">Download Doc.</a>
									<?php 		
									echo '<br/>';

									}
                                ?>
                            </td>
							
                            <td align="left">
                                <?php
                                echo $val['Company']['vc_account_no'];
                                ?>
                            </td>
							
                            <td align="left">

                                <?php
								
								$address = trim(ucfirst($val['Company']['vc_address1']));
		
								if(isset($val['Company']['vc_address2']) && !empty($val['Company']['vc_address2']))
								$address .= '</br>'.trim(ucfirst($val['Company']['vc_address2']));
								
								if(isset($val['Company']['vc_address3']) && !empty($val['Company']['vc_address3']))		
								$address .= '</br>'.trim(ucfirst($val['Company']['vc_address3']));
								
								if(isset($val['Company']['vc_town']) && !empty($val['Company']['vc_town']))		
								$address .= '</br>'.trim(ucfirst($val['Company']['vc_town']));


                                echo $address;
								
								//echo '<br>';
								if($val['Company']['ch_municipal_type']=='Y'){

									//echo $globalParameterarray[$val['Company']['vc_bank_supportive_doc']];			

									echo '<br>';
									
									$url =$this->webroot."profiles/download/M";
									?>
									<a href="<?php  echo $url;?>">Download Doc.</a>
									<?php 								 
									echo '<br>';

									}
                                ?>
                            </td>
							
							<td align="left">
                                <?php
                                echo $val['Company']['vc_mobile_no'];
                                ?>
                            </td>
							
							<td align="left">
                                <?php
                                echo $globalParameterarray[$val['Company']['ch_status']];
                                ?>
                            </td>
							
							<td style='text-align:center;'> 
                                <?php
								
								echo $this->Form->input(null, array('label' => false,
										'div' => false,
										'type' => 'hidden',
										'id'=>false,
										'name'=>false,
										'value'=>base64_encode($val['Company']['nu_company_id'])));	
										
								if ($val['Company']['ch_status'] == 'STSTY05') :

									$url = $this->webroot . 'profiles/edit_company/' . base64_encode($val['Company']['nu_company_id']);
								
									echo $this->Html->image('editbutton.png', array('alt' => '', 'title'=>'Edit Company Detail', 'onclick' => "javascript: window.location ='".$url."'", 'style'=>' cursor: pointer;'));

								else :
								
									echo 'N/A';
								
                                endif;?>
								</td>
							
					    </tr>
                        <?php
                        $i++;
                    }//end foreach
                } else {
                    ?>

                    <tr class="cont1" style='text-align: center'>

                        <td colspan='10'> No Record Found !! </td>

                    </tr>
                <?php } ?>
            </table>

            <?php echo $this->element('paginationfooter'); ?>
			
        </div>
</div>
<!-- end mainbody here--> 