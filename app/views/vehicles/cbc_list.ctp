<!-- Start wrapper here-->
	<div class="wrapper">
 <!-- Start breadcrumb here-->
    <div class="breadcrumb">
        <ul>
        <li class="first">
        <a title="Home" class="vtip" href="#">Home</a>
        </li>
        
        <li class="last">Vehicle List Reports</li>        
        </ul>
	</div>
   
<!-- end breadcrumb here-->
<!-- Start mainbody here-->
    <div class="mainbody">
    <h1>Welcome to RFA CBC</h1>
    <h3>Vehicle Deactivation Request</h3>
    <!-- Start innerbody here-->
	
					<?php echo $this->Form->create(array('url' => array('controller' =>'vehicles' , 'action'=>'cbc_list'), 'type'=>'file'));?>
	
    <div class="innerbody">
	<table width="100%" border="0" cellpadding="3">
        <tr>
        <td><label class="lab-inner">Customer Name :</label></td>
        <td>
		
							<?php echo $this->Form->input( '', array('label'=>false,'type' => 'text', 'id'=>'' ,'class'=>'round')); ?>
		
		</td>
		
        
		<td><label class="lab-inner">Address 1 :</label></td>
        <td>
		
							<?php echo $this->Form->input( '', array('label'=>false,'type' => 'text', 'id'=>'' ,'class'=>'round')); ?>
		
		</td>
		
        <td><label class="lab-inner">Address 2 :</label></td>
        <td>
		
							<?php echo $this->Form->input( '', array('label'=>false,'type' => 'text', 'id'=>'' ,'class'=>'round')); ?>
		
		</td>
		</tr>
        
		<tr>
        <td><label class="lab-inner">Address 3 :</label></td>
        <td>
							<?php echo $this->Form->input( '', array('label'=>false,'type' => 'text', 'id'=>'' ,'class'=>'round')); ?>
		
		</td>
		
        <td><label class="lab-inner">Telephone No. :</label></td>
        <td>
				
							<?php echo $this->Form->input( '', array('label'=>false,'type' => 'text', 'id'=>'' ,'class'=>'round')); ?>
		
		</td>
		
        <td><label class="lab-inner">Fax No. :</label></td>
        <td>
		
							<?php echo $this->Form->input( '', array('label'=>false,'type' => 'text', 'id'=>'' ,'class'=>'round')); ?>
		
		</td>
		</tr>
        <tr>
        <td><label class="lab-inner">Mobile No. :</label></td>
        <td>
							
							<?php echo $this->Form->input( '', array('label'=>false,'type' => 'text', 'id'=>'' ,'class'=>'round')); ?>
		
		
		</td>
        <td><label class="lab-inner">Email :</label></td>
        <td>				
							
							<?php echo $this->Form->input( '', array('label'=>false,'type' => 'text', 'id'=>'' ,'class'=>'round')); ?>
		
		
		</td>
        <td><label class="lab-inner">Vehicle Type :</label></td>
        <td><select name="select" class="round_select">
		<option value="01" selected="selected">All</option>
		<option value="02">Specific</option>
		</select></td>
        </tr>
	
	</table>
    <br />
	<table width="100%" cellspacing="1" cellpadding="5" border="0" >
		<tr class="listhead1">
		<td width="10%" align="center">Vehicle Type</td>
		<td width="10%" align="center">Vehicle Sr. No.</td>
		<td width="11%" align="center">Vehicle Reg. No.</td>
		<td width="8%" align="center">Type No.</td>
		<td width="10%" align="center">Vehicle Make</td>
		<td width="9%" align="center">No. of Axle</td>
		<td width="10%" align="center">Series Name</td>
		<td width="8%" align="center">Engine No.</td>
		<td width="8%" align="center">Chassis No.</td>
		<td width="8%" align="center">V Rating</td>
		<td width="8%" align="center">D/T Rating</td>
		</tr>
		<tr class="cont1">
		<td align="center">ABC</td>
		<td align="left">123456</td>
		<td>789123</td>
		<td align="right">1472</td>
		<td>xzy</td>
		<td align="right">2</td>
		<td>example</td>
		<td align="right">77654</td>
		<td align="right">88943</td>
		<td align="right">23</td>
		<td align="right">23</td>
		</tr>
		
		<tr class="cont">
		<td align="center">XYZ</td>
		<td align="left">123456</td>
		<td>789123</td>
		<td align="right">1472</td>
		<td>xzy</td>
		<td align="right">3</td>
		<td>example</td>
		<td align="right">77654</td>
		<td align="right">88943</td>
		<td align="right">23</td>
		<td align="right">23</td>
		</tr>
		
		<tr class="cont1">
		<td align="center">ABC</td>
		<td align="left">123456</td>
		<td>789123</td>
		<td align="right">1472</td>
		<td>xzy</td>
		<td align="right">4</td>
		<td>example</td>
		<td align="right">77654</td>
		<td align="right">88943</td>
		<td align="right">23</td>
		<td align="right">23</td>
		</tr>
		
		<tr class="cont">
		<td align="center">XYZ</td>
		<td align="left">123456</td>
		<td>789123</td>
		<td align="right">1472</td>
		<td>xzy</td>
		<td align="right">5</td>
		<td>example</td>
		<td align="right">77654</td>
		<td align="right">88943</td>
		<td align="right">23</td>
		<td align="right">23</td>
		</tr>
		
		<tr class="cont1">
		<td align="center">ABC</td>
		<td align="left">123456</td>
		<td>789123</td>
		<td align="right">1472</td>
		<td>xzy</td>
		<td align="right">6</td>
		<td>example</td>
		<td align="right">77654</td>
		<td align="right">88943</td>
		<td align="right">23</td>
		<td align="right">23</td>
		</tr>

	</table>

    </div>
     <!-- end innerbody here-->       
             
    <table width="100%" border="0">
		<tr>
		<td align="center">
	
	
							<?php echo $this->Form->submit(NULL, array('label'=>false,'id'=>'','value'=>'submit', 'class'=>'submit')); ?>
	
	
		</td>
		</tr>
	</table>
					<?php echo $this->Form->end(); ?>
    </div>
    
	<!-- end mainbody here-->    

	</div>
-
	<!-- end wrapper here-->

		
	</table>
   