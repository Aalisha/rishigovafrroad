<?php $currentUser = $this->Session->read('Auth'); ?>
<script type="text/JavaScript">
function addrow1(){
	var request=$.ajax({
	type:"GET",
	url:<?php echo $this->webroot?>+"cbc/Vehicles/addRowintbl"
	});
	request.done(function(data){
	$("#tbl1").append(data);
	});
}
function RemoveRow(){
if ($("#tbl1 tr").length != 1) {
     $("#tbl1 tr:last").remove();
}

}
</script>
<div class="wrapper">
 <!-- Start breadcrumb here-->
    <div class="breadcrumb">
        <ul>
        <li class="first">
        <a title="Home" class="vtip" href="#">Home</a>
        </li>
        
        <li class="last">Vehicle Registration</li>        
        </ul>
   </div>
    <?php echo $this->Form->create('Vehicle',array('url'=>array('controller'=>'Vehicles','action'=>'index','cbc'=>true))); ?>
	
<!-- end breadcrumb here-->
<!-- Start mainbody here-->
    <div class="mainbody">
    <h1>Welcome to RFA CBC</h1>
    <h3>Vehicle Registration Details</h3>
    <!-- Start innerbody here-->
	
									<?php echo $this->Form->create(array('url' => array('controller' =>'vehicles' , 'action'=>'cbc_reg'), 'type'=>'file'));?>
	
    <div class="innerbody">
    <table width="100%" border="0" cellpadding="3">
      <tr>
        <td><label class="lab-inner">Customer Name :</label></td>
        <td>
		
									<?php echo $this->Form->input( 'vc_customer_name', array('label'=>false,
																					 'type' => 'text' ,
																					 'value' =>trim($currentUser['Customer']['vc_first_name']).' '.trim($currentUser['Customer']['vc_surname']),
																					 'disabled'=>'disabled',
																					 'class'=>'round')); ?>
								
		</td>
        <td><label class="lab-inner">Address 1 :</label></td>
        <td>
									<?php echo $this->Form->input( 'vc_address1', array('label'=>false,
																					 'type' => 'text' ,
																					 'value' =>trim($currentUser['Customer']['vc_address1']),
																					 'disabled'=>'disabled',
																					 'class'=>'round')); ?>
								
		</td>
        <td><label class="lab-inner">Address 2 :</label></td>
        <td>
									<?php echo $this->Form->input( 'vc_address2', array('label'=>false,
																					 'type' => 'text' ,
																					 'value' =>trim($currentUser['Customer']['vc_address2']),
																					 'disabled'=>'disabled',
																					 'class'=>'round')); ?>
								
		</td>
      </tr>
            <tr>
        <td><label class="lab-inner">Address 3 :</label></td>
        <td>
									<?php echo $this->Form->input( 'vc_address3', array('label'=>false,
																					 'type' => 'text' ,
																					 'value' =>trim($currentUser['Customer']['vc_address3']),
																					 'disabled'=>'disabled',
																					 'class'=>'round')); ?>
								
		</td>
        <td><label class="lab-inner">Telephone No. :</label></td>
        <td>
									<?php echo $this->Form->input( 'vc_tel_no', array('label'=>false,
																					 'type' => 'text' ,
																					  'value' =>trim($currentUser['Customer']['vc_tel_no']),
																					 'disabled'=>'disabled',
																					 'class'=>'round')); ?>
								
		</td>
        <td><label class="lab-inner">Fax No. :</label></td>
        <td>
									<?php echo $this->Form->input( 'vc_fax_no', array('label'=>false,
																					 'type' => 'text' ,
																					  'value' =>trim($currentUser['Customer']['vc_fax_no']),
																					 'disabled'=>'disabled',
																					 'class'=>'round')); ?>
								
		</td>
      </tr>
            <tr>
        <td><label class="lab-inner">Mobile No. :</label></td>
        <td>
									<?php echo $this->Form->input( 'vc_mobile_no', array('label'=>false,
																					 'type' => 'text' ,
																					  'value' =>trim($currentUser['Customer']['vc_mobile_no']),
																					 'disabled'=>'disabled',
																					 'class'=>'round')); ?>
								
		</td>
        <td><label class="lab-inner">Email :</label></td>
        <td>
		
									<?php echo $this->Form->input( 'vc_email', array('label'=>false,
																					 'type' => 'text' ,
																					 'value' =>trim($currentUser['Customer']['vc_email']),
																					 'disabled'=>'disabled',
																					 'class'=>'round')); ?>
								
		</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>
    </div>
     <!-- end innerbody here-->
     <h3>Vehicle</h3>
    <!-- Start innerbody here-->
    <div class="innerbody">
  <table width="99%" cellspacing="1" cellpadding="5" border="0" >
  <tr class="listhead">
    <td width="10%">Vehicle Type</td>
    <td width="8%">Vehicle Sr. No.</td>
    <td width="8%">Vehicle Reg. No.</td>
    <td width="10%">Type No.</td>
    <td width="8%">Vehicle Make</td>
    <td width="10%">No. of Axle</td>
    <td width="10%">Series Name</td>
    <td width="10%">Engine No.</td>
    <td width="10%">Chasis No.</td>
    <td width="10%">V Rating</td>
    <td width="14%">D/T Rating</td>
    <td width="12%">Vehicle Status</td>
    <td width="10%">Document Upload</td>
  </tr>
</table>
<div class="listsr">
 
   <table width="100%" cellspacing="1" cellpadding="5" border="0" id="tbl1" >
                <tr class="cont1">
                    <td width="1%">
                        
                        <?php $opt = array(''=>'- Select -','1'=>'Select 1','2'=>'Select 2');
                         echo $this->Form->input('VehicleDetail.0.vc_vehicle_status', array('label' => false,
                            'type' => 'select',
                            'required' => 'required',
                            'options' => $opt,
							'class' => 'round_select4'));
                        ?>

                    </td>
                    <td width="1%">
                        <?php
                        echo $this->Form->input('VehicleDetail.0.vc_vehicle_lic_no', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'id' => 'vc_vehicle_lic_no',
                            'required' => 'required',
                            'maxlength'=>'15',
                            'class' => 'round6'));
                        ?>

                    </td>
                    <td width="1%">
                        <?php
                        echo $this->Form->input('VehicleDetail.0.vc_vehicle_reg_no', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'id' => 'vc_vehicle_reg_no',
                            'required' => 'required',
                            'maxlength'=>'30',
                            'class' => 'round6'));
                        ?>

                    </td>
                    <td width="1%">
                        <?php $opt = array(''=>'- Select -','1'=>'Select 1','2'=>'Select 2');
                        echo $this->Form->input('VehicleDetail.0.vc_pay_frequency', array('label' => false,
                            'div' => false,
                            'type' => 'select',
                            'id' => 'vc_pay_frequency',
                            'required' => 'required',
                            'options' => $opt,
                            'maxlength'=>'30',
                            'class' => 'round_select4')
                        );
                        ?>

                    </td>
                    <td width="1%">
                        <?php $opt = array(''=>'- Select -','1'=>'Select 1','2'=>'Select 2');
                        echo $this->Form->input('VehicleDetail.0.vc_vehicle_type', array('label' => false,
                            'div' => false,
                            'type' => 'select',
                            'required' => 'required',
                            'id' => 'vc_vehicle_type',
                            'options' =>$opt,
                            'maxlength'=>'15',
                            'class' => 'round_select4')
                        );
                        ?>

                    </td>
                    <td width="1%">
                        <?php
                        echo $this->Form->input('VehicleDetail.0.vc_start_ometer', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'id' => 'vc_start_ometer',
                            'required' => 'required',
                            'value' => '',
                            'maxlength'=>'15',
                            'class' => 'round6'));
                        ?>

                    </td>
                    <td width="1%">
                        <?php
                        echo $this->Form->input('VehicleDetail.0.vc_oper_est_km', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'id' => 'vc_oper_est_km',
                            'required' => 'required',
                            'value' => '',
                            'maxlength'=>'15',
                            'class' => 'round6'));
                        ?>

                    </td>
                    <td width="1%">
                        <?php
                        echo $this->Form->input('VehicleDetail.0.vc_v_rating', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'id' => 'vc_v_rating',
                            'required' => 'required',
                            'value' => '',
                            'maxlength'=>'15',
                            'class' => 'round6'));
                        ?>

                    </td>
                    <td width="1%">
                        <?php
                        echo $this->Form->input('VehicleDetail.0.vc_dt_rating', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'id' => 'vc_dt_rating',
                            'required' => 'required',
                            'value' => '',
                            'maxlength'=>'15',
                            'class' => 'round6'));
                        ?>

                    </td>
                    <td width="1%">
                        <?php
                        echo $this->Form->input('VehicleDetail.0.vc_predefine_route', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'id' => 'vc_predefine_route',
                            'required' => 'required',
                            'value' => '',
                            'maxlength'=>'15',
                            'class' => 'round6'));
                        ?>

                    </td>
					
					<td width="1%">
                        <?php
                        echo $this->Form->input('VehicleDetail.0.vc_predefine_route', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'id' => 'vc_predefine_route',
                            'required' => 'required',
                            'value' => '',
                            'maxlength'=>'15',
                            'class' => 'round6'));
                        ?>

                    </td>
                    
					
					<td width="1%">
                        <?php
                        echo $this->Form->input('VehicleDetail.0.vc_predefine_route', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'id' => 'vc_predefine_route',
                            'required' => 'required',
                            'value' => '',
                            'maxlength'=>'15',
                            'class' => 'round6'));
                        ?>

                    </td>
					
					
                   <td width="1%" align="center" style="font-size:18px">
						
						<?php 
							echo $this->Form->button('upload',array('label' => false,
                                'div' => false,
                                'id' => 'updoc0',
								'onclick'=>'uploaddocs(\'uploadDocsvehicle\',0);',
								'type'=>'button',
                                'class' => 'round6')); ?>		
			
						
					</td>
					
					
					
                </tr>

            </table> 
 
</div>
<table width="100%" border="0">
            <tr>
                <td align="center">
					
					<?php echo $this->Form->button('Add',array('label' => false,
                                'div' => false,
                                'id' => 'addrow',
								'type'=>'button',
								'onclick'=> 'addrow1();',
                                'class' => 'round3 submit')); ?>
					
					&nbsp;&nbsp;&nbsp;&nbsp;
					
					<?php echo $this->Form->button('Remove',array('label' => false,
                                'div' => false,
                                'id' => 'rmrow',
								'type'=>'button',
								'onclick' => 'RemoveRow(this.form)',
                                'class' => 'round3 submit')); ?>
								
					
					&nbsp;&nbsp;&nbsp;&nbsp;			
					<?php echo $this->Form->button('Submit',array('label' => false,
                                'div' => false,
                                'id' => 'submit',
								'type'=>'submit',
                                'class' => 'round3 submit')); ?>			
				</td>
				
            </tr>
        </table>

    </div>
     <!-- end innerbody here-->    
	
<div id="uploadDocsvehicle" class="ontop">
	
	<div id="popup" class="popup2">
	
	<a href="javascript:void(0);" class="close" onClick='hidepop("uploadDocsvehicle");' >Close</a>   
	
	<?php echo $this->Form->input(null,array('label' => false,
                        'div' => false,
                        'type' => 'hidden',
						'id'=>'slctrow',
						'value'=>'0',
						'name'=>'getrowcount'
                        )); ?>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
		<tr>
			<td align="left" class="content-area">
					<div class="listhead-popup">Upload Document</div>
			</td>
		</tr>
		      <td align="left"  class="content-area">
					<div  id='errorshow' class="error-message"></div>
			</td>
		<tr> 
		
		<tr>
		<tr>
			<td width="100%" align="left">
				<div class="content-area-outer">
				
				<div id="upload-button">
						
						
				
				</div>

				<div class="button-addmore">
						
						<a id="more_fields" onclick="add_fields('uploadDocsvehicle', 'upload-button');">
							<img src="img/add-more.png" width="24" height="24" />
						</a>
						<a id="more_fields" onclick="add_fields('uploadDocsvehicle', 'upload-button');"> Add </a>
						<?php echo $this->Form->button('Upload',array('label' => false,
                                'div' => false,
                                'id' => 'rmrow',
								'type'=>'button',
								'onclick'=>'javascript: uploadfiles();',
                                'class' => 'round3 submit')); ?>
				</div>
				
				</div>
			</td>
		</tr>
	</table>       

	</div>
</div>
	
	
	<?php echo $this->Form->end(null); ?>
	
 
           
</div>
<!-- end mainbody here-->   
     <!-- end mainbody here-->    
</div>
<!-- end wrapper here-->